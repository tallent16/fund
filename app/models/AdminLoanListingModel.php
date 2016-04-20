<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class AdminLoanListingModel extends TranWrapper {
	
	public  $allTransList					= array();
	public  $allTransValue					= 'all';
	public 	$filterStatusValue				= 'all';
	
	public function processDropDowns() {
		$allTransCode	=	7;
		
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id in (7) && 														
										codelist_code not in (8,9)";
								
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
						
		$lnListSql	=	"SELECT loans.loan_sanctioned_amount,
								loans.loan_reference_number,
								( 	SELECT	codelist_value 
									FROM	codelist_details
									WHERE	codelist_id = :bidstatus_code
									AND		codelist_code = loans.bid_type) bid_type_name,
                                loans.bid_type,								
								DATE_FORMAT(loans.bid_close_date, '%d-%m-%Y') bid_close_date,	
								loans.target_interest,
                                loans.loan_tenure,										
								( 	SELECT	codelist_value 
									FROM	codelist_details
									WHERE	codelist_id = :loanstatus_code
									AND		codelist_code = loans.status) bid_type_name,
								loans.status ,
                                borrowers.business_organisation                                                                                                                 
						FROM	loans 
								LEFT OUTER JOIN
								borrowers
								ON  loans.borrower_id = borrowers.borrower_id
						WHERE   loans.status = :filter_code ";
						
		$dataArrayLoan		=	[
									"bidstatus_code" => $all_Trans,
									"loanstatus_code" => LOAN_FEES_APPLICABLE,
									"filter_code" => $all_Trans
								];
									
		$loanlist_rs			=	$this->dbFetchWithParam($lnListSql, $dataArrayLoan);
		
			
		if (!$loanlist_rs) {
			return -1;
		}
		foreach ($loanlist_rs as $loanlist_row) {
			foreach ($loanlist_row as $colname => $value) {
				$this->{$colname} = $value;
			}
		}
		return;
		
		
	}
		
}
