<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;

use Auth;  

use Request;

use DB;
class AdminLoanListingReportModel extends TranWrapper {
	
	public  $allTransList					= array();
	public  $loanListInfo					= array();
	public  $filter_code					= "";
	public  $fromDate						= "";
	public  $toDate							= "";	
	
	public function processDropDowns() {
				
				
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id in (7) && 														
										codelist_code NOT IN (8,9) 
								ORDER BY CASE WHEN codelist_value = 'All' THEN '1'
								  WHEN codelist_value = 'New' THEN '2'
								  WHEN codelist_value = 'Submitted for Approval' THEN '3' 
								  WHEN codelist_value = 'Pending Comments' THEN '4'
								  WHEN codelist_value = 'Open for Bids' THEN '5'
								  WHEN codelist_value = 'Closed for Bids' THEN '6'
								  WHEN codelist_value = 'Bids Accepted' THEN '7'
								  WHEN codelist_value = 'Loans Disbursed' THEN '8'
								  WHEN codelist_value = 'Repayments Complete' THEN '9'
								  ELSE codelist_value END ASC";
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);	
		
		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
				
		foreach($filter_rs as $filter_row) {

			$codeId 	= 	$filter_row->codelist_id;
			$codeCode 	= 	$filter_row->codelist_code;
			$codeValue 	= 	$filter_row->codelist_value;
			$codeExpr 	= 	$filter_row->expression;
			
			
			switch ($codeId) {
			
				case 7:
					$this->allTransList[$codeCode] 	=	$codeValue;
					break;

			}								
					
		}
		
		
	} // End process_dropdown
	
	public function viewTransList($fromDate, $toDate, $all_Trans) {
		
		$this->fromDate			= 	date('d-m-Y', strtotime(date('Y-m')." -1 month"));
		$this->toDate			= 	date('d-m-Y', strtotime(date('Y-m')." +1 month"));
		$this->filter_code 		= 	11;	
		$applyFilter			=	0;
		
		if (isset($_REQUEST['filter_transcations'])) {
		 	$this->filter_code 	= $_REQUEST['filter_transcations'];
			$this->fromDate		= $_REQUEST['fromdate'];
			$this->toDate		= $_REQUEST['todate'];
			$applyFilter		= 1;
		} 
			
										
		$lnListSql	=	"SELECT FORMAT(loans.loan_sanctioned_amount,2) loan_sanctioned_amount,
								loans.loan_reference_number,
								loans.loan_id,
								( 	SELECT	codelist_value 
									FROM	codelist_details
									WHERE	codelist_id = :bidstatus_codeparam
									AND		codelist_code = loans.bid_type) bid_type_name,
                                IFNULL(loans.bid_type,'') bid_type,								
								DATE_FORMAT(loans.bid_close_date, '%d-%m-%Y') bid_close_date,	
								IFNULL(loans.target_interest,'0.00') target_interest,
                                loans.loan_tenure,										
								( 	SELECT	codelist_value 
									FROM	codelist_details
									WHERE	codelist_id = :loanstatus_codeparam
									AND		codelist_code = loans.status) loan_status_name,
								loans.status,
								borrowers.business_name
						FROM	loans 
								LEFT OUTER JOIN
								borrowers
								ON  loans.borrower_id = borrowers.borrower_id
						WHERE  	loans.status = if(:filter_codeparam = 11, loans.status, :filter_codeparam2)
						AND		loans.bid_close_date BETWEEN 
								if (:applyFilter1 = 0, loans.bid_close_date, :fromDate) AND 
								if (:applyFilter2 = 0, loans.bid_close_date, :toDate)
						order by loans.loan_id ASC,loans.bid_close_date DESC";
						
		$dataArrayLoanList		=	[
										"bidstatus_codeparam" => LOAN_BID_TYPE,
										"loanstatus_codeparam" => LOAN_STATUS,						
										"filter_codeparam" => $this->filter_code,
										"filter_codeparam2" => $this->filter_code,
										"fromDate" => $this->getDbDateFormat($this->fromDate),
										"toDate" => $this->getDbDateFormat($this->toDate),
										"applyFilter1" => $applyFilter,
										"applyFilter2" => $applyFilter
									];

		$this->loanListInfo			=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
		$row			=	array();
		if ($this->loanListInfo) {
			foreach ($this->loanListInfo as $Row) {
				
				$row[] 	= array(
									"DT_RowId"=>"row_".$Row->loan_id,
									"loan_id"=>$Row->loan_id,
									"loan_reference_number"=>$Row->loan_reference_number,
									"business_name"=>$Row->business_name,									
									"loan_sanctioned_amount"=>$Row->loan_sanctioned_amount,
									"target_interest"=>$Row->target_interest,									
									"loan_tenure"=>$Row->loan_tenure,									
									"bid_type"=>$Row->bid_type,		
									"status"=>$Row->status,									
									"bid_close_date"=>$Row->bid_close_date,
									"loan_status_name"=>$Row->loan_status_name									
								);	
			}
		}		
		return	$row;			
	}		
	
	public function viewLoanDisplayOrderList(){
	
		$displayListSql	=	"SELECT FORMAT(loans.loan_sanctioned_amount,2) loan_sanctioned_amount,
									loans.loan_reference_number,
									loans.featured_loan,
									loans.loan_display_order,
									loans.loan_id,
									( 	SELECT	codelist_value 
										FROM	codelist_details
										WHERE	codelist_id = :bidstatus_codeparam
										AND		codelist_code = loans.bid_type) bid_type_name,
									IFNULL(loans.bid_type,'') bid_type,								
									DATE_FORMAT(loans.bid_close_date, '%d-%m-%Y') bid_close_date,	
									IFNULL(loans.target_interest,'0.00') target_interest,
									loans.loan_tenure,										
									( 	SELECT	codelist_value 
										FROM	codelist_details
										WHERE	codelist_id = :loanstatus_codeparam
										AND		codelist_code = loans.status) loan_status_name,
									loans.status,
									borrowers.business_name
							FROM	loans 
									LEFT OUTER JOIN
									borrowers
									ON  loans.borrower_id = borrowers.borrower_id
							WHERE  	loans.status = :filter_codeparam						
							order by loans.loan_id ASC";
							
			$dataArrayLoanList		=	[
											"bidstatus_codeparam" => LOAN_BID_TYPE,
											"loanstatus_codeparam" => LOAN_STATUS,						
											"filter_codeparam" => LOAN_STATUS_APPROVED											
										];

			$this->loanListInfo			=	$this->dbFetchWithParam($displayListSql, $dataArrayLoanList);			
			$row			=	array();
			if ($this->loanListInfo) {
				foreach ($this->loanListInfo as $Row) {
					
					$row[] 	= array(
										"DT_RowId"=>"row_".$Row->loan_id,
										"loan_id"=>$Row->loan_id,
										"loan_reference_number"=>$Row->loan_reference_number,
										"featured_loan"=>$Row->featured_loan,
										"loan_display_order"=>$Row->loan_display_order,
										"business_name"=>$Row->business_name,									
										"loan_sanctioned_amount"=>$Row->loan_sanctioned_amount,										
										"bid_type"=>$Row->bid_type_name,		
										"status"=>$Row->status,									
										"bid_close_date"=>$Row->bid_close_date,
										"loan_status_name"=>$Row->loan_status_name									
									);	
				}
			}		
			return	$row;
	}
	public function EditLoanDisplayOrderList($postArray){
		
		$loanid		   = $postArray['id'];
		$featured	   = isset($postArray['data']['featured_loan'][0])?$postArray['data']['featured_loan'][0]:0;
		$loandisplay   = $postArray['data']['loan_display_order'];
		$dataArray 	   = array( 'featured_loan'	=> $featured,'loan_display_order'=>$loandisplay);
		$whereArry	   = array("loan_id"=>str_replace("row_","",$loanid));
		$this->dbUpdate('loans', $dataArray, $whereArry );		
		return	$this->getUpdatedRowByLoanId(str_replace("row_","",$loanid));
	}
	
	public function getUpdatedRowByLoanId($loan_id) {
		
		$displayListSql	=	"SELECT FORMAT(loans.loan_sanctioned_amount,2) loan_sanctioned_amount,
									loans.loan_reference_number,
									loans.featured_loan,
									loans.loan_display_order,
									loans.loan_id,
									( 	SELECT	codelist_value 
										FROM	codelist_details
										WHERE	codelist_id = :bidstatus_codeparam
										AND		codelist_code = loans.bid_type) bid_type_name,
									IFNULL(loans.bid_type,'') bid_type,								
									DATE_FORMAT(loans.bid_close_date, '%d-%m-%Y') bid_close_date,	
									IFNULL(loans.target_interest,'0.00') target_interest,
									loans.loan_tenure,										
									( 	SELECT	codelist_value 
										FROM	codelist_details
										WHERE	codelist_id = :loanstatus_codeparam
										AND		codelist_code = loans.status) loan_status_name,
									loans.status,
									borrowers.business_name
							FROM	loans 
									LEFT OUTER JOIN
									borrowers
									ON  loans.borrower_id = borrowers.borrower_id
							WHERE  	loans.loan_id	=	{$loan_id}
							order by loans.loan_id ASC";
							
		$dataArrayLoanList		=	[
										"bidstatus_codeparam" => LOAN_BID_TYPE,
										"loanstatus_codeparam" => LOAN_STATUS
										
									];

		$this->loanListInfo			=	$this->dbFetchWithParam($displayListSql, $dataArrayLoanList);			
		$row			=	array();
		if ($this->loanListInfo) {
			$row	= array(
							"DT_RowId"=>"row_".$this->loanListInfo[0]->loan_id,
							"loan_id"=>$this->loanListInfo[0]->loan_id,
							"loan_reference_number"=>$this->loanListInfo[0]->loan_reference_number,
							"featured_loan"=>$this->loanListInfo[0]->featured_loan,
							"loan_display_order"=>$this->loanListInfo[0]->loan_display_order,
							"business_name"=>$this->loanListInfo[0]->business_name,									
							"loan_sanctioned_amount"=>$this->loanListInfo[0]->loan_sanctioned_amount,
							"bid_type"=>$this->loanListInfo[0]->bid_type_name,		
							"status"=>$this->loanListInfo[0]->status,									
							"bid_close_date"=>$this->loanListInfo[0]->bid_close_date,
							"loan_status_name"=>$this->loanListInfo[0]->loan_status_name									
						);	
		}	
		
		return	$row;
		
	}
}
