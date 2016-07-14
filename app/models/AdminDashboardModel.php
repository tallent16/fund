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
	public 	$recentlyApprovedBor		= 	array();
	public 	$toBeApprovedBor			= 	array();
	
	public function getDashboardDetails() {
		
		$this->getLoanNotFullySubscribed();
		$this->getDefaultingLoans();
		$this->getCommissionsEarned();
		$this->getPenaltiesLevies();
		$this->getRecentlyApprovedBorrowers();
		$this->getToBeApprovedBorrowers();

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
													DATE_FORMAT(ln.bid_close_date,'%d-%m-%Y') bid_close_date,
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
		
		$defaultLoanSql		=	"	SELECT 	(	SELECT 	loan_reference_number
												FROM	loans
												WHERE	loan_id	=	bor_rep_sch.loan_id
											) loan_reference_number,
											bor_rep_sch.loan_id,
											(	SELECT business_name
												FROM	borrowers
												WHERE	borrower_id = bor_rep_sch.borrower_id
											) borrower_name,
											DATE_FORMAT(repayment_schedule_date,'%d-%m-%Y') due_date,
											ROUND(repayment_scheduled_amount,2) inst_amount
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
		
		$commEarnedSql		=	"	SELECT 		CONCAT(DATE_FORMAT(loan_process_date,'%b'),'/'
														,YEAR(loan_process_date)) month_year,
												ROUND(SUM(trans_fees),2) commission_earned
									FROM 		loans
									WHERE		status	IN (:disbursed_param,:repaid_param)
									GROUP BY	YEAR(loan_process_date),MONTH(loan_process_date) ";
		
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
		
		$penaltiesLeviesSql		=	"	SELECT 		CONCAT(DATE_FORMAT(repayment_actual_date,'%b'),'/',
															YEAR(repayment_actual_date)) month_year,
													ROUND(SUM(repayment_penalty_interest),2) penalty_interest,
													ROUND(SUM(repayment_penalty_charges),2) penalty_charges
										FROM 		borrower_repayment_schedule
										WHERE		repayment_status	=	:repaid_param
										GROUP BY	YEAR(repayment_actual_date),MONTH(repayment_actual_date)";
		
		$dataArrayLoan		=	[
									"repaid_param" => BORROWER_REPAYMENT_STATUS_PAID
								];
									
		$penaltiesLevies_rs		=	$this->dbFetchWithParam($penaltiesLeviesSql, $dataArrayLoan);
		
	
		if (!$penaltiesLevies_rs) {
			return -1;
		}
		$this->penaltiesLevies	=	$penaltiesLevies_rs;

	}
	
	public function getRecentlyApprovedBorrowers() {
		
		$recentlyApprovedBorSql		=	"	SELECT 	borrower_id,
													business_name borrower_name,
													DATE_FORMAT(approval_datetime,'%d-%m-%Y') approve_date,
													IFNULL(
														(	
															SELECT GROUP_CONCAT(CONCAT_WS('|',
																		loan_reference_number,loan_id,status)) 
															FROM	loans
															WHERE	borrower_id	=	borrowers.borrower_id
															AND		status IN (:approved, :closed,:disbursed,:repaid)
														),'') loan_list
											FROM 	borrowers
											WHERE	approval_datetime
													BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()";
		
		$dataArrayBor		=	[
									"approved"	=> LOAN_STATUS_APPROVED,
									"closed"	=> LOAN_STATUS_CLOSED_FOR_BIDS,
									"disbursed"	=> LOAN_STATUS_DISBURSED,
									"repaid" 	=> LOAN_STATUS_LOAN_REPAID
								];
									
		$recentlyApprovedBor_rs		=	$this->dbFetchWithParam($recentlyApprovedBorSql, $dataArrayBor);
		
	
		if (!$recentlyApprovedBor_rs) {
			return -1;
		}
		$this->recentlyApprovedBor	=	$recentlyApprovedBor_rs;

	}
	
	public function getToBeApprovedBorrowers() {
		
		$toBeApprovedBorSql		=	"	SELECT 	borrower_id,
												business_name borrower_name,
												status,
												DATE_FORMAT(register_datetime,'%d-%m-%Y') register_datetime
										FROM 	borrowers
										WHERE	status IN (:new_param,:sub_appr_param,:corr_req_param)";
		
		$dataArrayBor		=	[
									"new_param"			=> BORROWER_STATUS_NEW,
									"sub_appr_param"	=> BORROWER_STATUS_SUBMITTED_FOR_APPROVAL,
									"corr_req_param"	=> BORROWER_STATUS_COMMENTS_ON_ADMIN
								];
									
		$toBeApprovedBor_rs		=	$this->dbFetchWithParam($toBeApprovedBorSql, $dataArrayBor);
		
	
		if (!$toBeApprovedBor_rs) {
			return -1;
		}
		$this->toBeApprovedBor	=	$toBeApprovedBor_rs;

	}
	
						
}
