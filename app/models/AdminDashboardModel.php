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
	public 	$recentActivitiesBor		= 	array();
	public 	$recentlyApprovedInv		= 	array();
	public 	$toBeApprovedInv			= 	array();
	public 	$recentActivitiesInv		= 	array();
	public	$loanJsonObj				=	"";
	public	$investmentJsonObj			=	"";
	
	public function getDashboardDetails() {
		
		$this->getLoanNotFullySubscribed();
		$this->getDefaultingLoans();
		$this->getCommissionsEarned();
		$this->getPenaltiesLevies();
		$this->getRecentlyApprovedBorrowers();
		$this->getToBeApprovedBorrowers();
		$this->getRecentActivitiesBorrowers();
		$this->getRecentlyApprovedInvestors();
		$this->getToBeApprovedInvestors();
		$this->getRecentActivitiesInvestors();
		$this->getLoanBarChartJson();
		$this->getInvestmentBarChartJson();
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
		return	$loanNotSubscribed_rs;

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
		return	$defaultLoan_rs;
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
		return	$commEarned_rs;
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
		return	$penaltiesLevies_rs;
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
													BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()
											AND		status	=	:approved_bor_param";
		
		$dataArrayBor		=	[
									"approved"				=> LOAN_STATUS_APPROVED,
									"closed"				=> LOAN_STATUS_CLOSED_FOR_BIDS,
									"disbursed"				=> LOAN_STATUS_DISBURSED,
									"repaid" 				=> LOAN_STATUS_LOAN_REPAID,
									"approved_bor_param" 	=> BORROWER_STATUS_APPROVED
								];
									
		$recentlyApprovedBor_rs		=	$this->dbFetchWithParam($recentlyApprovedBorSql, $dataArrayBor);
		
	
		if (!$recentlyApprovedBor_rs) {
			return -1;
		}
		$this->recentlyApprovedBor	=	$recentlyApprovedBor_rs;
		return	$recentlyApprovedBor_rs;
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
		return	$toBeApprovedBor_rs;
	}
	
	public function getRecentActivitiesBorrowers() {
		
		$recentActivitiesBorSql		=	"	SELECT 	borrowers.borrower_id,
													borrowers.business_name borrower_name,
													activity,
													loan_reference_number,
													DATE_FORMAT(act_date,'%d-%m-%Y') act_date,
													codelist_details.codelist_value statusTxt
												
											FROM(
													SELECT 	loans.borrower_id borrower_id,
															'' borrower_name,
															'Loan' activity,
															loan_reference_number,
															apply_date	act_date,
															loans.status statusTxt
													FROM	loans 
													WHERE	loans.status IN ( :loan_new_param, :loan_subapprov_param)
													UNION
													SELECT 	loans.borrower_id borrower_id,
															'' borrower_name,
															'Loan' activity,
															loan_reference_number,
															bid_close_date	act_date,
															loans.status statusTxt
													FROM	loans 
													WHERE	loans.status = :loan_verify_param
													UNION
													SELECT 	loans.borrower_id borrower_id,
															'' borrower_name,
															'Loan' activity,
															loan_reference_number,
															(	SELECT	MAX(repayment_actual_date)
																FROM	borrower_repayment_schedule
																WHERE	borrower_id = 	loans.borrower_id
																AND		loan_id		=	loans.loan_id)	act_date,
															loans.status statusTxt
													FROM	loans 
													WHERE	loans.status =:loan_repcom_param
													UNION
													SELECT 	bor_sch.borrower_id borrower_id,
															'' borrower_name,
															'Repayment' activity,
															loans.loan_reference_number,
															repayment_schedule_date act_date,
															bor_sch.repayment_status statusTxt
													FROM	borrower_repayment_schedule bor_sch
															LEFT JOIN loans
															ON loans.loan_id	=	bor_sch.loan_id
													WHERE	DATEDIFF(CURDATE(), bor_sch.repayment_actual_date) > -10
													AND		bor_sch.repayment_status = :repay_unpaid_param
													UNION
													SELECT 	bor_sch1.borrower_id borrower_id,
															'' borrower_name,
															'Repayment' activity,
															loans.loan_reference_number,
															repayment_actual_date act_date,
															bor_sch1.repayment_status statusTxt
													FROM	borrower_repayment_schedule bor_sch1
															LEFT JOIN loans
															ON loans.loan_id	=	bor_sch1.loan_id
													WHERE	DATEDIFF(CURDATE(), bor_sch1.repayment_actual_date) > -10
													AND		bor_sch1.repayment_status = :repay_paid_param  
													UNION
													SELECT 	bor_sch2.borrower_id borrower_id,
															'' borrower_name,
															'Repayment' activity,
															loans.loan_reference_number,
															repayment_schedule_date act_date,
															bor_sch2.repayment_status statusTxt
													FROM	borrower_repayment_schedule bor_sch2
															LEFT JOIN loans
															ON loans.loan_id	=	bor_sch2.loan_id
													WHERE	bor_sch2.repayment_schedule_date < curdate()
													AND		bor_sch2.repayment_status = :repay_overdue_param
											) xx
												LEFT JOIN borrowers
													ON borrowers.borrower_id = xx.borrower_id
												LEFT JOIN codelist_details
													ON ( (codelist_details.codelist_code = xx.statusTxt) 
															AND (codelist_details.codelist_id = IF(xx.activity = 'Loan',7,25)  )  )
											ORDER BY act_date";
		
		$dataArrayBor		=	[
									"loan_new_param"			=> LOAN_STATUS_NEW,
									"loan_subapprov_param"		=> LOAN_STATUS_SUBMITTED_FOR_APPROVAL,
									"loan_verify_param"			=> LOAN_STATUS_APPROVED,
									"loan_repcom_param"			=> LOAN_STATUS_LOAN_REPAID,
									"repay_unpaid_param"		=> BORROWER_REPAYMENT_STATUS_UNPAID,
									"repay_paid_param"			=> BORROWER_REPAYMENT_STATUS_PAID,
									"repay_overdue_param"		=> BORROWER_REPAYMENT_STATUS_OVERDUE
								];
									
		$recentActivitiesBor_rs		=	$this->dbFetchWithParam($recentActivitiesBorSql, $dataArrayBor);
		
	
		if (!$recentActivitiesBor_rs) {
			return -1;
		}
		$this->recentActivitiesBor	=	$recentActivitiesBor_rs;
		return	$recentActivitiesBor_rs;
	}
	
	
	public function getRecentlyApprovedInvestors() {
		
		$recentlyApprovedInvSql		=	"	SELECT 	investor_id,
													CONCAT(users.firstname,' ',users.lastname) investor_name,
													DATE_FORMAT(approval_datetime,'%d-%m-%Y') approve_date
											FROM 	investors
												LEFT JOIN users
													ON	users.user_id	=	investors.user_id
											WHERE	approval_datetime
													BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()
											AND		investors.status = :approved_inv_param";
		
		$dataArrayInv		=	[
									"approved_inv_param"	=> INVESTOR_STATUS_APPROVED
								];
									
		$recentlyApprovedInv_rs		=	$this->dbFetchWithParam($recentlyApprovedInvSql, $dataArrayInv);
		
	
		if (!$recentlyApprovedInv_rs) {
			return -1;
		}
		$this->recentlyApprovedInv	=	$recentlyApprovedInv_rs;
		return	$recentlyApprovedInv_rs;
	}
	
	public function getToBeApprovedInvestors() {
		
		$toBeApprovedInvSql		=	"	SELECT 	investor_id,
												CONCAT(users.firstname,' ',users.lastname) investor_name,
												investors.status,
												DATE_FORMAT(register_datetime,'%d-%m-%Y') register_datetime
										FROM 	investors
												LEFT JOIN users
													ON	users.user_id	=	investors.user_id
										WHERE	investors.status IN (:new_param,:sub_appr_param,:corr_req_param)";
		
		$dataArrayInv		=	[
									"new_param"			=> INVESTOR_STATUS_NEW,
									"sub_appr_param"	=> INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL,
									"corr_req_param"	=> INVESTOR_STATUS_COMMENTS_ON_ADMIN
								];
									
		$toBeApprovedInv_rs		=	$this->dbFetchWithParam($toBeApprovedInvSql, $dataArrayInv);
		
	
		if (!$toBeApprovedInv_rs) {
			return -1;
		}
		$this->toBeApprovedInv	=	$toBeApprovedInv_rs;
		return	$toBeApprovedInv_rs;
	}		
	
	public function getRecentActivitiesInvestors() {
		
		$recentActivitiesInvSql		=	"	SELECT 	investors.investor_id,
													loan_id,
													( 	SELECT CONCAT(users.firstname,' ',users.lastname)
														FROM	investors subInv
																LEFT JOIN users
																ON users.user_id = subInv.user_id
														WHERE	subInv.investor_id = investors.investor_id
														) investor_name,
													activity,
													ref_no,
													DATE_FORMAT(act_date,'%d-%m-%Y') act_date,
													cdlst.codelist_value statusTxt
												
											FROM(
													SELECT 	loan_bids.investor_id investor_id,
															loan_bids.loan_id,
															'' investor_name,
															'Investments' activity,
															loans.loan_reference_number ref_no,
															DATE(bid_datetime)	act_date,
															loan_bids.bid_status statusTxt
													FROM	loan_bids
															LEFT JOIN loans
															ON	loans.loan_id	=	loan_bids.loan_id
													WHERE	loan_bids.bid_status IN ( 	:bids_open_param, 	
																					:bids_accpt_param
																				)
													AND		DATEDIFF(NOW(), loan_bids.bid_datetime) > -10
													UNION
													SELECT 	inv_tran.investor_id investor_id,
															''	loan_id,
															'' investor_name,
															'Withdrawals' activity,
															payments.trans_reference_number ref_no,
															trans_date	act_date,
															inv_tran.status statusTxt
													FROM	investor_bank_transactions inv_tran
															LEFT JOIN payments
																ON	payments.payment_id =	inv_tran.trans_id
													WHERE	inv_tran.trans_type = 2
													AND		inv_tran.status	=	:witdraw_ver_param
													AND		DATEDIFF(CURDATE(), inv_tran.trans_date) > -10
													UNION
													SELECT 	inv_tran.investor_id investor_id,
															'' loan_id,
															'' investor_name,
															'Deposits' activity,
															payments.trans_reference_number ref_no,
															trans_date	act_date,
															inv_tran.status statusTxt
													FROM	investor_bank_transactions inv_tran
															LEFT JOIN payments
																ON	payments.payment_id =	inv_tran.trans_id
													WHERE	inv_tran.trans_type = 1
													AND		DATEDIFF(CURDATE(), inv_tran.trans_date) > -10
													UNION
													SELECT 	inv_tran.investor_id investor_id,
															'' loan_id,
															'' investor_name,
															'Withdrawal Requests' activity,
															payments.trans_reference_number ref_no,
															trans_date	act_date,
															inv_tran.status statusTxt
													FROM	investor_bank_transactions inv_tran
															LEFT JOIN payments
																ON	payments.payment_id =	inv_tran.trans_id
													WHERE	inv_tran.trans_type = 2
													AND		inv_tran.status	=	:witdraw_unver_param
													AND		DATEDIFF(CURDATE(), inv_tran.trans_date) > -10
													
											) xx
												LEFT JOIN investors
													ON investors.investor_id = xx.investor_id
												LEFT JOIN codelist_details cdlst
													ON ( (cdlst.codelist_code = xx.statusTxt) 
															AND  ( 
																	CASE 
																		WHEN xx.activity = 'Investments'
																				THEN  cdlst.codelist_id = 21
																		ELSE cdlst.codelist_id = 31  
																	END
																) )
											ORDER BY act_date";
		
		$dataArrayInv		=	[
									"bids_open_param"			=> LOAN_BIDS_STATUS_OPEN,
									"bids_accpt_param"			=> LOAN_BIDS_STATUS_ACCEPTED,
									"witdraw_ver_param"			=> LOAN_STATUS_APPROVED,
									"witdraw_unver_param"		=> INVESTOR_BANK_TRANS_STATUS_UNVERIFIED
								];
									
		$recentActivitiesInv_rs		=	$this->dbFetchWithParam($recentActivitiesInvSql, $dataArrayInv);
		
		if (!$recentActivitiesInv_rs) {
			return -1;
		}
		$this->recentActivitiesInv	=	$recentActivitiesInv_rs;
		return	$recentActivitiesInv_rs;
	}
	
	public function getLoanBarChartJson() {
		
		$loanBarChartSql		=	"		SELECT 		CONCAT(DATE_FORMAT(apply_date,'%b'),'/',YEAR(apply_date)) 
															month_year, 
														ROUND(SUM(apply_amount),2) tot_loan_amount
											FROM 		loans 
											WHERE 		apply_date	>=	DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
											AND			status	=	:loan_new_param
											GROUP BY	YEAR(apply_date),MONTH(apply_date)";
		
		$dataArrayLoan			=	[
										"loan_new_param" => LOAN_STATUS_NEW
									];
									
		$loanBarChart_rs		=	$this->dbFetchWithParam($loanBarChartSql, $dataArrayLoan);
		
		if (!$loanBarChart_rs) {
			return -1;
		}
		$this->loanJsonObj	=	json_encode($loanBarChart_rs);
		return	json_encode($loanBarChart_rs);
	}
	
	public function getInvestmentBarChartJson() {
		
		$investmentBarChartSql		=	"	SELECT 	CONCAT(DATE_FORMAT(bid_datetime,'%b'),'/',
														YEAR(bid_datetime)) month_year, 
													ROUND(SUM(bid_amount),2) tot_loan_amount
											FROM 	loan_bids
											WHERE 	DATE(bid_datetime)	>=	DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
											AND		bid_status IN (:bids_open_param,:bids_accpt_param)
											GROUP BY	
													YEAR(bid_datetime),MONTH(bid_datetime)";
		
		$dataArrayInvestment		=	[
											"bids_open_param"			=> LOAN_BIDS_STATUS_OPEN,
											"bids_accpt_param"			=> LOAN_BIDS_STATUS_ACCEPTED
										];
									
		$investmentBarChart_rs		=	$this->dbFetchWithParam($investmentBarChartSql, $dataArrayInvestment);
		
		if (!$investmentBarChart_rs) {
			return -1;
		}
		$this->investmentJsonObj	=	json_encode($investmentBarChart_rs);
		return	json_encode($investmentBarChart_rs);
	}
}
