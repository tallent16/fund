<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use DateTime;
use DateInterval;
use Log;

	  
class AdminDashboardModel extends TranWrapper {
	
	public	$loanNotFullySubscribed 	= 	array();
	public 	$defaultingLoans			= 	array();
	public 	$commissionsEarned			= 	array();
	public 	$penaltiesLevies			= 	array();
	
	public function getDashboardDetails() {
		
		$this->getLoanNotFullySubscribed();
		$this->getDefaultingLoans();
		$this->getCommissionsEarned();
		$this->getPenaltiesLevies();

	}
	
	public function getLoanNotFullySubscribed() {
		
		$loanNotSubscribedSql		=	"	SELECT 	ln.loan_reference_number,
													ln.loan_id,
													(	SELECT business_name
														FROM	borrowers
														WHERE	borrower_id = ln.borrower_id
													) borrower_name,
													ROUND(ln.apply_amount,2) loan_amount,
													ROUND(xx.bid_amt,2) bid_amt,
													date_format(ln.bid_close_date,'%d-%m-%Y') bid_close_date,
													ln.bid_type,
													ln.target_interest,
													ln.repayment_type
											FROM 	loans ln,
													(	SELECT 		sum(bid_amount) bid_amt,
																	loan_id
														FROM		loan_bids
														WHERE		bid_status	=	:bid_status_param
														GROUP BY	loan_id
													) xx 
											WHERE	xx.loan_id	=	ln.loan_id
											AND		xx.bid_amt < ln.apply_amount";
		
		$dataArrayLoan		=	[
									"bid_status_param" => LOAN_BIDS_STATUS_OPEN
								];
									
		$loanNotSubscribed_rs			=	$this->dbFetchWithParam($loanNotSubscribedSql, $dataArrayLoan);
		
		
		if (!$loanNotSubscribed_rs) {
			return -1;
		}
		$this->loanNotFullySubscribed	=	$loanNotSubscribed_rs;

	}
	
	public function getDefaultingLoans() {
		
		$defaultLoanSql		=	"SELECT 	(	SELECT 	loan_reference_number
														FROM	loans
														WHERE	loan_id	=	bor_rep_sch.loan_id
													) loan_reference_number,
													bor_rep_sch.loan_id,
													(	SELECT business_name
														FROM	borrowers
														WHERE	borrower_id = bor_rep_sch.borrower_id
													) borrower_name,
													date_format(repayment_schedule_date,'%d-%m-%Y') due_date,
													round(repayment_scheduled_amount,2) inst_amount
											FROM 	borrower_repayment_schedule bor_rep_sch
											WHERE	repayment_schedule_date < CURDATE()
											AND		repayment_status	=	:repay_status_param";
		
		$dataArrayLoan		=	[
									"repay_status_param" => BORROWER_REPAYMENT_STATUS_UNPAID
								];
									
		$defaultLoan_rs		=	$this->dbFetchWithParam($defaultLoanSql, $dataArrayLoan);
		
		
		if (!$defaultLoan_rs) {
			return -1;
		}
		$this->defaultingLoans	=	$defaultLoan_rs;

	}
	
	public function getCommissionsEarned() {
		
		$commEarnedSql		=	"	SELECT CONCAT(DATE_FORMAT(loan_process_date,'%b'),'/',year(loan_process_date)) 
												month_year,
												ROUND(SUM(trans_fees),2) commission_earned
									FROM 		loans
									WHERE		status	IN (:disbursed_param,:repaid_param)
									GROUP BY	year(loan_process_date),MONTH(loan_process_date) ";
		
		$dataArrayLoan		=	[
									"disbursed_param" => LOAN_STATUS_DISBURSED,
									"repaid_param" => LOAN_STATUS_LOAN_REPAID
								];
									
		$commEarned_rs		=	$this->dbFetchWithParam($commEarnedSql, $dataArrayLoan);
		
		if (!$commEarned_rs) {
			return -1;
		}
		$this->commissionsEarned	=	$commEarned_rs;

	}
						
	public function getPenaltiesLevies() {
		
		$penaltiesLeviesSql		=	"SELECT 
											concat(DATE_FORMAT(repayment_actual_date,'%b'),'/',
															year(repayment_actual_date)) month_year,
												ROUND(SUM(repayment_penalty_interest),2) penalty_interest,
												ROUND(SUM(repayment_penalty_charges),2) penalty_charges
										FROM 		moneymatch_new.borrower_repayment_schedule
										WHERE		repayment_status	=	:repaid_param
										GROUP BY	
												year(repayment_actual_date),MONTH(repayment_actual_date)";
		
		$dataArrayLoan		=	[
									"repaid_param" => BORROWER_REPAYMENT_STATUS_PAID
								];
									
		$penaltiesLevies_rs		=	$this->dbFetchWithParam($penaltiesLeviesSql, $dataArrayLoan);
		
	
		if (!$penaltiesLevies_rs) {
			return -1;
		}
		$this->penaltiesLevies	=	$penaltiesLevies_rs;

	}
	
						
}
