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
												borrowers.paid_up_capital, 
												borrowers.operation_since, 
												'' tot_loan_applied,
												'' tot_loan_sanctioned,
												'' avg_int_rate,
												'' tot_principal_os,
												'' tot_int_os,
												'' tot_principal_paid,
												'' tot_int_paid,
												'' tot_penalty_paid,
												'' overdue_amt,
												'' overdue_since
									FROM 		borrowers
									LEFT JOIN	(
													SELECT 	borrower_id,COUNT(*) cnt
													FROM	loans
													WHERE	loans.status NOT IN (8,9)
													GROUP BY
															borrower_id
												) loan_applied
												ON	loan_applied.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,COUNT(*) cnt
													FROM	loans
													WHERE	loans.status IN (7,10)
													GROUP BY
															borrower_id
												) loan_sanctioned
												ON	loan_sanctioned.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,AVG(loans.final_interest_rate) avg_int
													FROM	loans
													WHERE	loans.status NOT IN (8,9)
													GROUP BY
															borrower_id
												) loan_avgerage
												ON	loan_avgerage.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,
															SUM(principal_component) prin_os,	
															SUM(interest_component) int_os	
													FROM	borrower_repayment_schedule
													WHERE	repayment_status	IN	(1,2)
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
													WHERE	repayment_status	=	3
													GROUP BY
															borrower_id
												) bor_rep_shcd_paid
												ON	bor_rep_shcd_paid.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,
															SUM(principal_component) overdue_amt
													FROM	borrower_repayment_schedule
													WHERE	bor_rep_shcd_os.repayment_status	=	3
													GROUP BY
															borrower_id
												) bor_rep_shcd_paid
												ON	bor_rep_shcd_paid.borrower_id	=	borrowers.borrower_id	
									LEFT JOIN	(
													SELECT 	borrower_id,
															SUM(principal_component) prin_paid,	
															SUM(interest_component) int_paid,
															SUM(repayment_penalty_interest+repayment_penalty_charges) 
																					penalty_paid	
													FROM	borrower_repayment_schedule
													WHERE	bor_rep_shcd_os.repayment_status	=	3
													GROUP BY
															borrower_id
												) bor_rep_shcd_paid
												ON	bor_rep_shcd_paid.borrower_id	=	borrowers.borrower_id	
												
									WHERE 	{$borrowerStatusWhere}";
		
									
		if($filterStatus == "all") {
			$argArray['approval']			=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
			$argArray['verified']			=	BORROWER_STATUS_VERIFIED;
		}else{
			$argArray['filterStatus']		=	$filterStatus;
		}
		
		$this->borListInfo		= 	$this->dbFetchWithParam($borlist_sql,$argArray);
		$this->prnt($this->borListInfo);
	}
}
