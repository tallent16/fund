<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use Auth;  

use Request;

use DB;
class AdminBorrowersProfileReportModel extends TranWrapper {
	
	public  $allAprovalStatus				= array();
	public  $borListInfo					= array();
	public  $filterStatusValue				= "";
	
	public function processDropDowns() {
				
		$this->allAprovalStatus['all'] 	=	"All";
		$this->allAprovalStatus['2'] 	=	"UnApproved";
		$this->allAprovalStatus['4'] 	=	"Approved";
	
	} // End process_dropdown
	
	
	public function getBorrowerProfileReportInfo($filterStatus) {
	
		
		$this->filterStatusValue			= 	$filterStatus;
		$borrowerStatusWhere				=	" borrowers.status " . ($filterStatus == "all"? 
													" IN(:approval,:verified) ":
												"=	:filterStatus"." ");
												
		$borlist_sql			= "	SELECT 		borrowers.borrower_id,
												borrowers.business_name, 
												borrowers.contact_person, 
												borrowers.contact_person_email, 
												borrowers.contact_person_mobile, 
												ROUND(borrowers.paid_up_capital,2) paid_up_capital, 
												DATE_FORMAT(borrowers.operation_since,'%d-%m-%Y') operation_since, 
												IFNULL(loan_applied.cnt,0) tot_loan_applied,
												IFNULL(loan_sanctioned.cnt,0) tot_loan_sanctioned,
												IFNULL(loan_avgerage.avg_int,0) avg_int_rate,
												IFNULL(ROUND(bor_rep_shcd_os.prin_os,2),'0.00') tot_principal_os,
												IFNULL(ROUND(bor_rep_shcd_os.int_os,2),'0.00') tot_int_os,
												IFNULL(ROUND(bor_rep_shcd_paid.prin_paid,2),'0.00') tot_principal_paid,
												IFNULL(ROUND(bor_rep_shcd_paid.int_paid,2),'0.00') tot_int_paid,
												IFNULL(ROUND(bor_rep_shcd_paid.penalty_paid,2),'0.00') tot_penalty_paid,
												IFNULL(ROUND(overdue1.overdue_amt,2),'0.00') overdue_amt,
												IFNULL(overdue2.overdue_since,'') overdue_since
									FROM 		borrowers
									LEFT JOIN	(
													SELECT 	borrower_id,COUNT(*) cnt
													FROM	loans
													WHERE	loans.status NOT IN (:loan_can_param,:loan_unsucc_param)
													GROUP BY
															borrower_id
												) loan_applied
												ON	loan_applied.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,COUNT(*) cnt
													FROM	loans
													WHERE	loans.status IN (:loan_disb_param,:loan_repcom_param)
													GROUP BY
															borrower_id
												) loan_sanctioned
												ON	loan_sanctioned.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,AVG(loans.final_interest_rate) avg_int
													FROM	loans
													WHERE	loans.status NOT IN (:loan_can_param1,:loan_unsucc_param1)
													GROUP BY
															borrower_id
												) loan_avgerage
												ON	loan_avgerage.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,
															SUM(principal_component) prin_os,	
															SUM(interest_component) int_os	
													FROM	borrower_repayment_schedule
													WHERE	repayment_status	IN	(:unpaid_rep_param,:paid_rep_param)
													GROUP BY
															borrower_id
												) bor_rep_shcd_os
												ON	bor_rep_shcd_os.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,
															SUM(principal_component) prin_paid,	
															SUM(interest_component) int_paid,
															SUM(repayment_penalty_interest+repayment_penalty_charges) 
																					penalty_paid	
													FROM	borrower_repayment_schedule
													WHERE	repayment_status	=	:verf_rep_param1
													GROUP BY
															borrower_id
												) bor_rep_shcd_paid
												ON	bor_rep_shcd_paid.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,
															SUM(principal_component+interest_component) overdue_amt
													FROM	borrower_repayment_schedule
													WHERE	repayment_status	!=	:verf_rep_param2
													AND		DATE(repayment_schedule_date) < DATE(NOW())
													GROUP BY
															borrower_id
												) overdue1
												ON	overdue1.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,
															MIN(date_format(repayment_schedule_date, '%d-%m-%Y')) overdue_since
													FROM	borrower_repayment_schedule
													WHERE	repayment_status	!=	:verf_rep_param3
													AND		DATE(repayment_schedule_date) < DATE(NOW())
													GROUP BY
															borrower_id
												) overdue2
												ON	overdue2.borrower_id	=	borrowers.borrower_id	
												
									WHERE 	{$borrowerStatusWhere}";
		
		$argArray['loan_can_param']			=	LOAN_STATUS_CANCELLED;
		$argArray['loan_unsucc_param']		=	LOAN_STATUS_UNSUCCESSFUL_LOAN;							
		
		$argArray['loan_disb_param']		=	LOAN_STATUS_DISBURSED;
		$argArray['loan_repcom_param']		=	LOAN_STATUS_LOAN_REPAID;							
		
		$argArray['loan_can_param1']		=	LOAN_STATUS_CANCELLED;
		$argArray['loan_unsucc_param1']		=	LOAN_STATUS_UNSUCCESSFUL_LOAN;							
		
		$argArray['unpaid_rep_param']		=	BORROWER_REPAYMENT_STATUS_UNPAID;
		$argArray['paid_rep_param']			=	BORROWER_REPAYMENT_STATUS_UNVERIFIED;							
		
		$argArray['verf_rep_param1']		=	BORROWER_REPAYMENT_STATUS_PAID;
		$argArray['verf_rep_param2']		=	BORROWER_REPAYMENT_STATUS_PAID;							
		$argArray['verf_rep_param3']		=	BORROWER_REPAYMENT_STATUS_PAID;							
		
		if($filterStatus == "all") {
			$argArray['approval']			=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
			$argArray['verified']			=	BORROWER_STATUS_VERIFIED;
		}else{
			$argArray['filterStatus']		=	$filterStatus;
		}
		//~ echo $borlist_sql;
		$this->borListInfo		= 	$this->dbFetchWithParam($borlist_sql,$argArray);
		//~ $this->prnt($this->borListInfo);
	}
}
