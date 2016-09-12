<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;

use Auth;  

use Request;

use DB;
class AdminPenaltiesLeviesReportModel extends TranWrapper {
	
	public  $loanListInfo					= array();
	public  $fromDate						= "";
	public  $toDate							= "";	
	
	public function getPenaltyLeviesReport($fromDate, $toDate) {
		
		$this->fromDate		= $_REQUEST['fromdate'];
		$this->toDate		= $_REQUEST['todate'];
			
		$lnListSql	=	"SELECT 	loans.loan_reference_number,
									loans.loan_id,
									borrowers.business_name,
									bor_rep_schd.installment_number,
									bor_rep_schd.repayment_schedule_date,
									bor_rep_schd.repayment_actual_date,
									bor_rep_schd.repayment_penalty_interest,
									bor_rep_schd.repayment_penalty_charges
						FROM		loans
						INNER JOIN	borrower_repayment_schedule bor_rep_schd
									ON 	(	bor_rep_schd.loan_id	=	loans.loan_id
											AND	bor_rep_schd.repayment_status	=	:repaid_param
										)
						LEFT JOIN	borrowers
									ON  loans.borrower_id = borrowers.borrower_id
						WHERE  		loans.status IN (:filter_codeparam,:filter_codeparam2)
						AND			loans.loan_process_date	>=:fromDate
						AND			loans.loan_process_date	<=:toDate
						ORDER BY 	loans.loan_id ASC,bor_rep_schd.installment_number ASC";
						
		$dataArrayLoanList		=	[
										"repaid_param" => BORROWER_REPAYMENT_STATUS_PAID,
										"filter_codeparam" => LOAN_STATUS_DISBURSED,
										"filter_codeparam2" => LOAN_STATUS_LOAN_REPAID,
										"fromDate" => $this->getDbDateFormat($this->fromDate),
										"toDate" => $this->getDbDateFormat($this->toDate)
									];
		
		$this->loanListInfo			=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
	}
	
}
