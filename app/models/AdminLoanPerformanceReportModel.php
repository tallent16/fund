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
	public	$repayment_schedule 			= array();
	public	$jsonBorrRepay 					= "";
	
	public function getLoanPerformanceReportInfo($fromDate,$toDate){
	
			$this->fromDate	=	$fromDate;
			$this->toDate	=	$toDate;
			
			$fromDate		=	date("Y-m-d",strtotime($fromDate));
			$toDate			=	date("Y-m-d",strtotime($toDate));
			
			$displayListSql	="SELECT 	loans.loan_reference_number,
										loans.loan_id,
										borrowers.business_name,
										loans.loan_risk_grade bor_grade,
										cl1.codelist_value bid_type,
										cl2.codelist_value repayment_type,
										loans.loan_tenure,
										ROUND(loans.apply_amount,2) apply_amount,
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
							WHERE	loans.status	IN	(:disb_param,:repay_param)  	
							AND		loans.loan_approval_date	>=	'{$fromDate}'
							AND		loans.loan_approval_date	<=	'{$toDate}'
							
							order by loans.loan_id ASC";
			$argArray['bid_accpt_param']		=	LOAN_BIDS_STATUS_ACCEPTED;
			
			$argArray['unpaid_rep_param']		=	BORROWER_REPAYMENT_STATUS_UNPAID;
			$argArray['paid_rep_param']			=	BORROWER_REPAYMENT_STATUS_UNVERIFIED;							
			
			$argArray['verf_rep_param2']		=	BORROWER_REPAYMENT_STATUS_PAID;							
			$argArray['verf_rep_param3']		=	BORROWER_REPAYMENT_STATUS_PAID;	
			
			$argArray['disb_param']				=	LOAN_STATUS_DISBURSED;							
			$argArray['repay_param']			=	LOAN_STATUS_LOAN_REPAID;	
			
			$this->loanListInfo					=	$this->dbFetchWithParam($displayListSql,$argArray);	
			//~ $this->prnt($this->loanListInfo);
	}
	
	function getBorrRepaySchd() {
		
		$sql	=	"	SELECT 	installment_number,
								loan_id,
								date_format(repayment_schedule_date, '%d-%m-%Y') repayment_schedule_date,
								repayment_scheduled_amount,
								principal_component,
								interest_component,
								repayment_status,
								ifnull(date_format(repayment_actual_date, '%d-%m-%Y'),'') repayment_actual_date,
								ifnull(repayment_penalty_interest,0) repayment_penalty_interest,
								ifnull(repayment_penalty_charges,0) repayment_penalty_charges,
								ifnull(repayment_penalty_interest,0) + ifnull(repayment_penalty_charges,0) penalty,
								ifnull(principal_component,0) + ifnull(interest_component,0) + 
								ifnull(repayment_penalty_interest,0) + ifnull(repayment_penalty_charges,0) total
						FROM	borrower_repayment_schedule
						ORDER BY loan_id,installment_number";
		
		$rs		=	$this->dbFetchAll($sql);
		$i	=	0;
		foreach($rs	as $row) {
			$loan_id	=	$row->loan_id;
			$this->repayment_schedule[$loan_id][$i]	=	$row;
			
			switch ($row->repayment_status) {
				
				case BORROWER_REPAYMENT_STATUS_UNPAID:
					$status = 'Unpaid';
					break;
					
				case BORROWER_REPAYMENT_STATUS_UNVERIFIED:
					$status = 'Not Approved';
					break;
					
				case BORROWER_REPAYMENT_STATUS_PAID:
					$status = 'Paid';
					break;
					
				case BORROWER_REPAYMENT_STATUS_CANCELLED:
					$status = 'Cancelled';
					break;
				
				case BORROWER_REPAYMENT_STATUS_OVERDUE:
					$status = 'Overdue';
					break;
			}
			$obj		=	$this->repayment_schedule[$loan_id][$i];	
			$schdAmt	=	$obj->repayment_scheduled_amount;
			$princAmt	=	$obj->principal_component;
			$IntsAmt	=	$obj->interest_component;
			$penaltyAmt	=	$obj->penalty;
			
			$obj->repayment_status = $status;
			$obj->repayment_scheduled_amount =  number_format($schdAmt, 2, ".", ",");;
			$obj->principal_component =  number_format($princAmt, 2, ".", ",");
			$obj->interest_component =  number_format($IntsAmt, 2, ".", ",");;
			$obj->penalty =  number_format($penaltyAmt, 2, ".", ",");;
			$i++;
		}
		//~ $this->prnt($this->repayment_schedule);
		$this->jsonBorrRepay = json_encode($this->repayment_schedule);
	}
	
	function getExcelBorrRepaySchd() {
		
		$sql	=	"	SELECT 	installment_number,
								loan_id,
								date_format(repayment_schedule_date, '%d-%m-%Y') repayment_schedule_date,
								ifnull(date_format(repayment_actual_date, '%d-%m-%Y'),'') repayment_actual_date,
								repayment_scheduled_amount,
								ROUND(principal_component,2) principal_component,
								ROUND(interest_component,2) interest_component,
								ROUND(ifnull(repayment_penalty_interest,0) + ifnull(repayment_penalty_charges,0),2)
																										penalty,
								repayment_status
						FROM	borrower_repayment_schedule
						ORDER BY loan_id,installment_number";
		
		$rs		=	$this->dbFetchAll($sql);
		
		$i	=	0;
		foreach($rs	as $row) {
			$loan_id	=	$row->loan_id;
			$this->repayment_schedule[$loan_id][$i]	=	$row;
			
			switch ($row->repayment_status) {
				
				case BORROWER_REPAYMENT_STATUS_UNPAID:
					$status = 'Unpaid';
					break;
					
				case BORROWER_REPAYMENT_STATUS_UNVERIFIED:
					$status = 'Not Approved';
					break;
					
				case BORROWER_REPAYMENT_STATUS_PAID:
					$status = 'Paid';
					break;
					
				case BORROWER_REPAYMENT_STATUS_CANCELLED:
					$status = 'Cancelled';
					break;
				
				case BORROWER_REPAYMENT_STATUS_OVERDUE:
					$status = 'Overdue';
					break;
			}
			$obj	=	$this->repayment_schedule[$loan_id][$i];
			$obj->repayment_status = $status;
			unset($obj->loan_id);
			$i++;
		}
		
	}
	
}
