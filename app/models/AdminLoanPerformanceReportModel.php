<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;

use Auth;  

use Request;

use DB;
class AdminLoanPerformanceReportModel extends TranWrapper {
	
	public  $loanListInfo					= array();
	public  $fromDate						= "";
	public  $toDate							= "";	
	
	
	public function getLoanPerformanceReportInfo($fromDate,$toDate){
	
			$fromDate		=	date("Y-m-d",strtotime($fromDate));
			$toDate			=	date("Y-m-d",strtotime($toDate));
			$displayListSql	="SELECT 	loans.loan_reference_number,
										loans.loan_id,
										borrowers.business_name,
										loans.loan_risk_grade bor_grade,
										cl1.codelist_value bid_type,
										cl2.codelist_value repayment_type,
										loans.loan_tenure,
										loans.apply_amount,
										'' tot_bids_received,
										'' tot_bids_received_amt,
										'' tot_sanctioned_amt,
										'' tot_principal_os,
										'' tot_interest_os,
										'' tot_penalty_insterest,
										'' tot_penalty_charges,
										'' overdue_amt,
										'' overdue_since
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
							
							WHERE  	loans.loan_approval_date	>=	'{$fromDate}'
							AND		loans.loan_approval_date	<=	'{$toDate}'
							order by loans.loan_id ASC";
		
			$this->loanListInfo			=	$this->dbFetchAll($displayListSql);			
			$this->prnt($this->loanListInfo);
	}
}
