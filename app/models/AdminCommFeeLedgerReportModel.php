<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;

use Auth;  

use Request;

use DB;
class AdminCommFeeLedgerReportModel extends TranWrapper {
	
	public  $allTransList					= array();
	public  $loanListInfo					= array();
	public  $fromDate						= "";
	public  $toDate							= "";	
	
	public function getCommFeeLedgerReportInfo($fromDate, $toDate) {
		
		$this->fromDate			= 	$fromDate;
		$this->toDate			= 	$toDate;
		
		$lnListSql	=	"SELECT loans.loan_reference_number,
								loans.loan_id,
								borrowers.business_name,
								loans.loan_risk_grade,
								DATE_FORMAT(dis.disbursement_date,'%d-%m-%Y') disbursement_date,
								dis.amount_disbursed,
								dis.fixed_fees_levied process_fix_fees,
								dis.total_fees_levied process_commission
						FROM	loans 
						LEFT JOIN	borrowers
								ON  loans.borrower_id = borrowers.borrower_id
						LEFT JOIN	disbursements dis
								ON  dis.loan_id = loans.loan_id
						WHERE  	loans.status IN (:filter_codeparam,:filter_codeparam2)
						AND		loans.loan_process_date >= :fromDate
						AND		loans.loan_process_date <= :toDate
						order by loans.loan_id ASC";
						
		$dataArrayLoanList		=	[
										"filter_codeparam" => LOAN_STATUS_DISBURSED,
										"filter_codeparam2" => LOAN_STATUS_LOAN_REPAID,
										"fromDate" => $this->getDbDateFormat($this->fromDate),
										"toDate" => $this->getDbDateFormat($this->toDate)
									];
		echo $lnListSql;
		//~ die;
		$this->loanListInfo			=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
		$this->prnt($this->loanListInfo);
	}		
	
}
