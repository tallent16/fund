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
		$borlist_sql			= "	SELECT 	borrowers.borrower_id,
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
									FROM 	borrowers
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
