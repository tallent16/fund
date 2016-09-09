<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
	
use Auth;  

use Request;

use DB;
class AdminInvestorsProfileReportModel extends TranWrapper {
	
	public  $allAprovalStatus				= array();
	public  $invListInfo					= array();
	public  $filterStatusValue				= "";
	
	public function processDropDowns() {
				
		$this->allAprovalStatus['all'] 	=	"All";
		$this->allAprovalStatus['2'] 	=	"UnApproved";
		$this->allAprovalStatus['4'] 	=	"Approved";
	
	} // End process_dropdown
	
	
	public function getInvestorProfileReportInfo($filterStatus) {
	
		
		$this->filterStatusValue			= 	$filterStatus;
		$investorStatusWhere				=	" investors.status " . ($filterStatus == "all"? 
													" IN(:approval,:verified) ":
												"=	:filterStatus"." ");
		$invlist_sql			= "	SELECT 	investors.investor_id,
											users.username, 
											users.firstname,
											users.lastname,
											users.email, 
											users.mobile mobile_number,
											investors.date_of_birth dob,
											investors.nric_number,
											investors.nationality,
											investors.estimated_yearly_income,
											IFNULL(FORMAT(available_balance,2),'0.00') available_balance,
											'' no_loan_applied,
											'' no_loan_invested,
											'' tot_invest_amt,
											'' tot_returns,
											'' roi
									FROM 	investors, 
											users 
									WHERE 	investors.user_id = users.user_id
									AND 	{$investorStatusWhere}";
		
									
		if($filterStatus == "all") {
			$argArray['approval']			=	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL;
			$argArray['verified']			=	INVESTOR_STATUS_VERIFIED;
		}else{
			$argArray['filterStatus']		=	$filterStatus;
		}
		
		$this->invListInfo		= 	$this->dbFetchWithParam($invlist_sql,$argArray);
	}
	
}
