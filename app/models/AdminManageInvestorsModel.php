<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class AdminManageInvestorsModel extends TranWrapper {
	
	public	$investorListInfo			=	array();
	public	$filterInvestorStatusList	=	array();
	public 	$filterInvestorStatusValue	= 	'all';
	
	public function getManageInvestorDetails($filterInvestorStatus_filter) {
		$this->processDropDowns();
		$this->getInvestorListInfo($filterInvestorStatus_filter);
		
	}
	
	public function getInvestorListInfo($filterInvestorStatus) {
	
		$argArray		=	[
							"bid_open" => LOAN_BIDS_STATUS_OPEN,
							"bid_accepted" => LOAN_BIDS_STATUS_ACCEPTED,
							"repayment_complete" => LOAN_STATUS_LOAN_REPAID
							];
		$this->filterInvestorStatusValue	= 	$filterInvestorStatus;
		$investorStatusWhere				=	" investors.status " . ($filterInvestorStatus == "all"? 
													" IN(:new,:approval,:verified,:pending_comments) ":
												"=	{$filterInvestorStatus}"." ");
		$invlist_sql			= "	SELECT 	users.email, 
											users.firstname display_name,
											users.mobile mobile_number,
											investors.investor_id,
											investors.user_id,
											(	SELECT 	COUNT(*)
												FROM 	loan_bids,
														loans
												WHERE 	(loan_bids.bid_status = (:bid_open) 
															OR loan_bids.bid_status = (:bid_accepted))
												AND 	loans.status != (:repayment_complete)
												AND 	loan_bids.investor_id = investors.investor_id
												AND		loan_bids.loan_id	=	loans.loan_id
											) active_loan,
											case investors.status 
												   when 1 then 'New profile' 
												   when 2 then 'Submitted for verification'
												   when 3 then 'Corrections required'
												   when 4 then 'Verified'
											end as statusText,
											investors.status,
											IFNULL(FORMAT(available_balance,2),'0.00') available_balance
									FROM 	investors, 
											users 
									WHERE 	investors.user_id = users.user_id
									AND 	{$investorStatusWhere}";
									
		if($filterInvestorStatus == "all") {
			$argArray['new']				=	INVESTOR_STATUS_NEW_PROFILE;
			$argArray['approval']			=	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL;
			$argArray['verified']			=	INVESTOR_STATUS_VERIFIED;
			$argArray['pending_comments']	=	INVESTOR_STATUS_COMMENTS_ON_ADMIN;
			
		}
							
		$invlist_rs		= 	$this->dbFetchWithParam($invlist_sql,$argArray);
		
		if ($invlist_rs) {
			foreach ($invlist_rs as $invRow) {
				$row[] 	= array(
									"DT_RowId"=>"row_".$invRow->user_id,
									"user_id"=>$invRow->user_id,
									"email"=>$invRow->email,									
									"display_name"=>$invRow->display_name,
									"mobile_number"=>$invRow->mobile_number,									
									"active_loan"=>$invRow->active_loan,									
									"available_balance"=>$invRow->available_balance,		
									"status"=>$invRow->status,									
									"statusText"=>$invRow->statusText,									
									"investor_id"=>$invRow->investor_id									
								);	
				//~ $newrow = count($this->investorListInfo);
				//~ $newrow ++;
				//~ foreach ($invRow as $colname => $colvalue) {
					//~ $this->investorListInfo[$newrow][$colname] = $colvalue;
				//~ }
			}
		}
		//return	$invlist_rs;
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
							"new" => INVESTOR_STATUS_NEW_PROFILE,
							"approval" => INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL,
							"verified" => INVESTOR_STATUS_VERIFIED,
							"pending_comments" 	=> INVESTOR_STATUS_COMMENTS_ON_ADMIN
							];
							
		$filter_rs		= 	$this->dbFetchWithParam($filterSql,$argArray);
		
		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
		$this->filterInvestorStatusList['all'] 	=	'All Investors';
		foreach($filter_rs as $filter_row) {

			$codeCode 									= 	$filter_row->codelist_code;
			$codeValue 									= 	$filter_row->codelist_value;
			$this->filterInvestorStatusList[$codeCode] 	=	$codeValue;
		}
		
	} // End process_dropdown
}
