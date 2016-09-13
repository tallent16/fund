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
										IFNULL(ROUND(loan_bids.cnt,2),0) tot_bids_received,
										IFNULL(ROUND(loan_bids.accpt_amt,2),'0.00') tot_bids_received_amt,
										IFNULL(ROUND(loans.loan_sanctioned_amount,2),0) loan_sanctioned_amount,
										IFNULL(ROUND(bor_rep_shcd_os.prin_os,2),'0.00') tot_principal_os,
										IFNULL(ROUND(bor_rep_shcd_os.int_os,2),'0.00') tot_interest_os,
										IFNULL(ROUND(loan_penalty.penalty_int,2),'0.00') tot_penalty_interest,
										IFNULL(ROUND(loan_penalty.penalty_charges,2),'0.00') tot_penalty_charges,
										IFNULL(ROUND(overdue1.overdue_amt,2),'0.00') overdue_amt,
										overdue2.overdue_since
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
							LEFT JOIN	(
											SELECT 	loan_id,
													COUNT(*) cnt,
													SUM(accepted_amount) accpt_amt
											FROM	loan_bids
											WHERE	bid_status = :bid_accpt_param
											GROUP BY
													loan_id
										) loan_bids
										ON	loan_bids.loan_id	=	loans.loan_id	
							LEFT JOIN	(
											SELECT 	loan_id,
													SUM(principal_component) prin_os,	
													SUM(interest_component) int_os	
											FROM	borrower_repayment_schedule
											WHERE	repayment_status	IN	(:unpaid_rep_param,:paid_rep_param)
											GROUP BY
													loan_id
										) bor_rep_shcd_os
										ON	bor_rep_shcd_os.loan_id	=	loans.loan_id	
							LEFT JOIN	(
											SELECT 	loan_id,
													SUM(repayment_penalty_interest) penalty_int,	
													SUM(repayment_penalty_charges) penalty_charges	
											FROM	borrower_repayment_schedule
											GROUP BY
													loan_id
										) loan_penalty
										ON	loan_penalty.loan_id	=	loans.loan_id	
							LEFT JOIN	(
											SELECT 	loan_id,
													SUM(principal_component+interest_component) overdue_amt
											FROM	borrower_repayment_schedule
											WHERE	repayment_status	!=	:verf_rep_param2
											AND		DATE(repayment_schedule_date) < DATE(NOW())
											GROUP BY
													loan_id
										) overdue1
										ON	overdue1.loan_id	=	loans.loan_id	
							LEFT JOIN	(
											SELECT 	loan_id,
													MIN(date_format(repayment_schedule_date, '%d-%m-%Y')) overdue_since
											FROM	borrower_repayment_schedule
											WHERE	repayment_status	!=	:verf_rep_param3
											AND		DATE(repayment_schedule_date) < DATE(NOW())
											GROUP BY
													loan_id
										) overdue2
										ON	overdue2.loan_id	=	loans.loan_id
							WHERE  	loans.loan_approval_date	>=	'{$fromDate}'
							AND		loans.loan_approval_date	<=	'{$toDate}'
							
							order by loans.loan_id ASC";
			$argArray['bid_accpt_param']		=	LOAN_BIDS_STATUS_ACCEPTED;
			
			$argArray['unpaid_rep_param']		=	BORROWER_REPAYMENT_STATUS_UNPAID;
			$argArray['paid_rep_param']			=	BORROWER_REPAYMENT_STATUS_UNVERIFIED;							
			
			$argArray['verf_rep_param2']		=	BORROWER_REPAYMENT_STATUS_PAID;							
			$argArray['verf_rep_param3']		=	BORROWER_REPAYMENT_STATUS_PAID;	
			
			$this->loanListInfo					=	$this->dbFetchWithParam($displayListSql,$argArray);	
			$this->prnt($this->loanListInfo);
	}
}
