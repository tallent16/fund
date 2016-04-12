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
											borrowers.contact_person, 
											borrowers.industry, 
											(	SELECT 	COUNT(loans.loan_id)
												FROM 	loans 
												WHERE 	loans.status IN (:approved, :closed,:disbursed,:repaid)
												AND 	loans.borrower_id = lns.borrower_id
											) active_loan, 
											(	SELECT 	ROUND(sum(principal_component),2)
												FROM 	borrower_repayment_schedule 
												WHERE 	borrower_repayment_schedule.loan_id = lns.loan_id 
												AND		repayment_status != :repaidStatus 
												AND 	borrowers.borrower_id = borrower_repayment_schedule.borrower_id 
											) tot_bal_outstanding, 
											borrowers.status
									FROM 	borrowers, 
											loans lns, 
											users 
									WHERE 	borrowers.borrower_id = lns.borrower_id 
									AND 	borrowers.user_id = users.user_id 
									AND 	{$borrowerStatusWhere} 
									GROUP BY	borrowers.borrower_id";
									
		if($filterBorrowerStatus == "all") {
			$argArray['new']				=	BORROWER_STATUS_NEW_PROFILE;
			$argArray['approval']			=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
			$argArray['verified']			=	BORROWER_STATUS_VERIFIED;
			$argArray['pending_comments']	=	BORROWER_STATUS_COMMENTS_ON_ADMIN;
			
		}
							
		$borlist_rs		= 	$this->dbFetchWithParam($borlist_sql,$argArray);
		
		if ($borlist_rs) {
			foreach ($borlist_rs as $borRow) {
				$newrow = count($this->borrowerListInfo);
				$newrow ++;
				foreach ($borRow as $colname => $colvalue) {
					$this->borrowerListInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return	$borlist_rs;
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
