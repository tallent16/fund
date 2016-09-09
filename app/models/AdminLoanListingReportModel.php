<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;

use Auth;  

use Request;

use DB;
class AdminLoanListingReportModel extends TranWrapper {
	
	public  $allLoanStatus					=	array();
	public  $allBorGrade					= 	array();
	public  $loanListInfo					= 	array();
	public  $filter_code					= 	"";
	public  $fromDate						= 	"";
	public  $toDate							= 	"";	
	
	public function processDropDowns() {
				
				
		$allLoanStatusSql		=	"	SELECT	codelist_id,
												codelist_code,
												codelist_value,
												expression
										FROM	codelist_details
										WHERE	codelist_id in (7) && 														
												codelist_code NOT IN (8,9) 
										AND		codelist_value !='All'
										ORDER BY CASE 
										  WHEN codelist_value = 'New' THEN '1'
										  WHEN codelist_value = 'Submitted for Approval' THEN '2' 
										  WHEN codelist_value = 'Pending Comments' THEN '3'
										  WHEN codelist_value = 'Open for Bids' THEN '4'
										  WHEN codelist_value = 'Closed for Bids' THEN '5'
										  WHEN codelist_value = 'Bids Accepted' THEN '6'
										  WHEN codelist_value = 'Loans Disbursed' THEN '7'
										  WHEN codelist_value = 'Repayments Complete' THEN '8'
										  ELSE codelist_value END ASC";
								
		$filter_rs		= 	$this->dbFetchAll($allLoanStatusSql);	
		
		if (!empty($filter_rs)) {
				
			foreach($filter_rs as $filter_row) {

				$codeId 	= 	$filter_row->codelist_id;
				$codeCode 	= 	$filter_row->codelist_code;
				$codeValue 	= 	$filter_row->codelist_value;
				$codeExpr 	= 	$filter_row->expression;
				$this->allLoanStatus[$codeCode] 	=	$codeValue;
			}
		}
		$allBorGradeSql		=	"	SELECT	codelist_id,
												codelist_code,
												codelist_value,
												expression
										FROM	codelist_details
										WHERE	codelist_id = 20
										AND		codelist_value !='All'
										ORDER BY codelist_value ASC";
								
		$allBorGrade_rs		= 	$this->dbFetchAll($allBorGradeSql);	
		
		if (!empty($allBorGrade_rs)) {
				
			foreach($allBorGrade_rs as $filter_row) {

				$codeId 	= 	$filter_row->codelist_id;
				$codeCode 	= 	$filter_row->codelist_code;
				$codeValue 	= 	$filter_row->codelist_value;
				$codeExpr 	= 	$filter_row->expression;
				$this->allBorGrade[$codeValue] 	=	$codeValue;
			}
		}
		
	} // End process_dropdown

	public function getLoanListingReportInfo($fromDate,$toDate,$loanStatus,$borGrade){
	
			$fromDate		=	date("Y-m-d",strtotime($fromDate));
			$toDate			=	date("Y-m-d",strtotime($toDate));
			$displayListSql	="SELECT 	loans.loan_reference_number,
										loans.loan_id,
										borrowers.business_name,
										loans.loan_risk_grade bor_grade,
										loans.apply_amount,
										DATE_FORMAT(loans.apply_date,'%d-%m-%Y') apply_date,
										IFNULL(DATE_FORMAT(loans.loan_approval_date,'%d-%m-%Y'),'') loan_approval_date,
										IFNULL(DATE_FORMAT(dis.disbursement_date,'%d-%m-%Y'),'') disbursement_date,
										loans.loan_tenure,
										cl1.codelist_value bid_type,
										loans.target_interest,
										cl2.codelist_value repayment_type,
										loans.min_for_partial_sub par_sub_amt,
										cl3.codelist_value loan_status_name
							FROM		loans 
							LEFT JOIN	borrowers
								ON  loans.borrower_id = borrowers.borrower_id
							 LEFT JOIN	disbursements dis	
								ON	(dis.loan_id = loans.loan_id )
							LEFT JOIN	codelist_details cl1
								ON	(cl1.codelist_id = 6 AND	cl1.codelist_code = loans.bid_type)
							LEFT JOIN	codelist_details cl2
								ON	(cl2.codelist_id = 8 AND	cl2.codelist_code = loans.repayment_type)
							LEFT JOIN	codelist_details cl3
								ON	(cl3.codelist_id = 7 AND	cl3.codelist_code = loans.status)
							
							WHERE  	loans.status IN (".implode(',',$loanStatus).")						
							AND		loans.loan_risk_grade	IN	('".implode("','",$borGrade)."')
							AND		loans.apply_date	>=	'{$fromDate}'
							AND		loans.apply_date	<=	'{$toDate}'
							order by loans.loan_id ASC";
		
			$this->loanListInfo			=	$this->dbFetchAll($displayListSql);			
			
	}

}
