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
		$argArray							=	array();
		$argArray['bid_open_param']			=	LOAN_BIDS_STATUS_OPEN;
		$argArray['bid_accpt_param']		=	LOAN_BIDS_STATUS_ACCEPTED;
		$argArray['rep_paid_param']			=	INVESTOR_REPAYMENT_STATUS_VERIFIED;
			
		$investorStatusWhere				=	" investors.status " . ($filterStatus == "all"? 
													" IN(:approval,:verified) ":
												"=	:filterStatus"." ");
												
		$invlist_sql			= "	SELECT 		investors.investor_id,
												users.username, 
												users.firstname,
												users.lastname,
												users.email, 
												users.mobile mobile_number,
												DATE_FORMAT(investors.date_of_birth,'%d-%m-%Y') dob,
												investors.nric_number,
												investors.nationality,
												investors.estimated_yearly_income,
												IFNULL(ROUND(available_balance,2),0.00) available_balance,
												IFNULL(ROUND(loan_applied.cnt,2),0) no_loan_applied,
												IFNULL(ROUND(loan_accepted.cnt,2),0) no_loan_invested,
												IFNULL(ROUND(loan_accepted.tot_amt,2),0.00) tot_invest_amt,
												IFNULL(ROUND(rep_schd.tot_interest,2),0.00) tot_returns,
												IFNULL( ROUND((IFNULL(rep_schd.tot_interest,0) * 	
																	IFNULL(loan_accepted.tot_amt,0) )
																				* (12/100),2 ),
													'0.00') roi
									FROM 		investors
									INNER JOIN 	users 
												ON	investors.user_id = users.user_id
									LEFT JOIN	(
													SELECT 		investor_id, COUNT(*) cnt
													FROM		loan_bids
													WHERE		bid_status	=:bid_open_param	
													GROUP BY 	investor_id
												)	loan_applied	
												ON	loan_applied.investor_id	=	investors.investor_id
									LEFT JOIN	(
													SELECT 	investor_id, COUNT(*) cnt,SUM(accepted_amount) tot_amt
													FROM	loan_bids
													WHERE	bid_status	=:bid_accpt_param	
													GROUP BY 	investor_id
												)	loan_accepted
												ON	loan_accepted.investor_id	=	investors.investor_id
									LEFT JOIN	(
													SELECT 	investor_id, SUM(interest_amount) tot_interest
													FROM	investor_repayment_schedule
													WHERE	status	=:rep_paid_param	
													GROUP BY 	investor_id
												)	rep_schd	
												ON	rep_schd.investor_id	=	investors.investor_id
									WHERE 		{$investorStatusWhere}";
		
									
		if($filterStatus == "all") {
			$argArray['approval']			=	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL;
			$argArray['verified']			=	INVESTOR_STATUS_VERIFIED;
		}else{
			$argArray['filterStatus']		=	$filterStatus;
		}
		
		$this->invListInfo		= 	$this->dbFetchWithParam($invlist_sql,$argArray);
		//~ echo $invlist_sql;
		//~ $this->prnt($this->invListInfo);
	}
	
}
