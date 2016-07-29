<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class AdminLoanListingModel extends TranWrapper {
	
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
										codelist_code NOT IN (8,9) ORDER BY codelist_value";
								
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
}
