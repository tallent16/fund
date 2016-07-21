<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class AdminManageBorrowersModel extends TranWrapper {
	
	public	$borrowerListInfo			=	array();
	public	$filterBorrowerStatusList	=	array();
	public 	$filterBorrowerStatusValue	= 	'all';
	
	public function getManageBorrowerDetails($filterBorrowerStatus_filter) {
		$this->processDropDowns();
		$this->getBorrowerListInfo($filterBorrowerStatus_filter);
		
	}
	
	public function getBorrowerListInfo($filterBorrowerStatus) {
	
		$argArray		=	[
							"approved" => LOAN_STATUS_APPROVED,
							"closed" => LOAN_STATUS_CLOSED_FOR_BIDS,
							"disbursed" => LOAN_STATUS_DISBURSED,
							"repaid" 	=> LOAN_STATUS_LOAN_REPAID,
							"repaidStatus" => BORROWER_REPAYMENT_STATUS_PAID
							];
		$this->filterBorrowerStatusValue	= 	$filterBorrowerStatus;
		$borrowerStatusWhere				=	" borrowers.status " . ($filterBorrowerStatus == "all"? 
													" IN(:new,:approval,:verified,:pending_comments) ":
												"=	{$filterBorrowerStatus}"." ");
		$borlist_sql			= "	SELECT 	users.email, 
											borrowers.business_name, 
											borrowers.borrower_id, 
											borrowers.user_id, 
											borrowers.contact_person, 
											borrowers.industry, 
											(	SELECT 	COUNT(loans.loan_id)
												FROM 	loans 
												WHERE 	loans.status IN (:approved, :closed,:disbursed,:repaid)
												AND 	loans.borrower_id = borrowers.borrower_id
											) active_loan, 
											IFNULL((	SELECT 	ROUND(sum(principal_component),2)
												FROM 	borrower_repayment_schedule 
												WHERE 	repayment_status != :repaidStatus 
												AND 	borrowers.borrower_id = borrower_repayment_schedule.borrower_id 
											),'0.00') tot_bal_outstanding, 
											case borrowers.status 
												   when 1 then 'New profile' 
												   when 2 then 'Submitted for verification'
												   when 3 then 'Corrections required'
												   when 4 then 'Verified'
											end as statusText,
											borrowers.status 
									FROM 	borrowers, 
											users 
									WHERE 	borrowers.user_id = users.user_id 
									AND 	{$borrowerStatusWhere} 
									GROUP BY	borrowers.borrower_id";
									
		if($filterBorrowerStatus == "all") {
			$argArray['new']				=	BORROWER_STATUS_NEW_PROFILE;
			$argArray['approval']			=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
			$argArray['verified']			=	BORROWER_STATUS_VERIFIED;
			$argArray['pending_comments']	=	BORROWER_STATUS_COMMENTS_ON_ADMIN;
			
		}
							
		$borlist_rs		= 	$this->dbFetchWithParam($borlist_sql,$argArray);
		$row			=	array();
		if ($borlist_rs) {
			foreach ($borlist_rs as $borRow) {
				//$newrow = count($this->borrowerListInfo);
				//	$newrow ++;
				$row[] 	= array(
									"DT_RowId"=>"row_".$borRow->user_id,
									"user_id"=>$borRow->user_id,
									"email"=>$borRow->email,									
									"business_name"=>$borRow->business_name,
									"industry"=>$borRow->industry,									
									"active_loan"=>$borRow->active_loan,									
									"tot_bal_outstanding"=>$borRow->tot_bal_outstanding,		
									"status"=>$borRow->status,									
									"statusText"=>$borRow->statusText,									
									"borrower_id"=>$borRow->borrower_id									
								);	
				//	foreach ($borRow as $colname => $colvalue) {
						//$this->borrowerListInfo[$newrow][$colname] = $colvalue;	
								              
				//	}
			}
		}
		//return	$borlist_rs;
		return	$row;
	}
	
	public function processDropDowns() {
				
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id =	2
								AND		codelist_code in (:new,:approval,:verified,:pending_comments)";
		$argArray		=	[
							"new" => BORROWER_STATUS_NEW_PROFILE,
							"approval" => BORROWER_STATUS_SUBMITTED_FOR_APPROVAL,
							"verified" => BORROWER_STATUS_VERIFIED,
							"pending_comments" 	=> BORROWER_STATUS_COMMENTS_ON_ADMIN
							];
							
		$filter_rs		= 	$this->dbFetchWithParam($filterSql,$argArray);
		
		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
		$this->filterBorrowerStatusList['all'] 	=	'All Borrowers';
		foreach($filter_rs as $filter_row) {

			$codeCode 									= 	$filter_row->codelist_code;
			$codeValue 									= 	$filter_row->codelist_value;
			$this->filterBorrowerStatusList[$codeCode] 	=	$codeValue;
		}
		
	} // End process_dropdown
}
