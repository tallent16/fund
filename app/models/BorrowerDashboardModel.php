<?php namespace App\models;

class BorrowerDashboardModel extends TranWrapper {
	
	public $loan_details		= 	array();
	public $curloans			= 	array();
	public $barchart_detJson	= 	"";
	public $current_loansJson	= 	"";
	public $barchart_details	= 	array();
	
	public function getBorrowerDashboardDetails() {
		$this->getBorrowerLoanList();
		$this->barchart_detJson		=	json_encode($this->getBorrowerBarChart());
		$this->current_loansJson	=	json_encode($this->getBorrowerCurrentLoans());
		$this->curloans				=	json_decode($this->current_loansJson);
		if($this->curloans	==	""){
			$this->curloans	=	array();
		}
	}
	
	public function getBorrowerLoanList() {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
									
		$loandetails_sql	=	"	SELECT	loans.loan_reference_number,
											(	SELECT	min(repayment_schedule_date)
													FROM	borrower_repayment_schedule
													WHERE	repayment_status != 3
												AND	loan_id = loans.loan_id) next_payment,
											(	SELECT	max(repayment_schedule_date)
													FROM	borrower_repayment_schedule
												WHERE	repayment_status = 3
												AND		loan_id = loans.loan_id) last_payment,
											(	SELECT	 ROUND(sum(repayment_scheduled_amount),2) repayment_scheduled_amount
												FROM	borrower_repayment_schedule
												WHERE	loan_id = loans.loan_id 
												AND	repayment_status = 3) amount_paid,
												final_interest_rate inst_rate,
												loan_tenure no_of_installment,
											(	SELECT	ROUND(sum(repayment_scheduled_amount),2) repayment_scheduled_amount
												FROM	borrower_repayment_schedule
												WHERE	loan_id = loans.loan_id) total_repayments,
											(	SELECT	ROUND(sum(principal_component),2) principal_component
												FROM	borrower_repayment_schedule
												WHERE	loan_id = loans.loan_id 
												AND		repayment_status != 3) tot_prin_outstanding,
											(	SELECT	if(avg(repayment_status) = 3, 'Paid', 'Overdue')
												FROM	borrower_repayment_schedule
												WHERE	loan_id = loans.loan_id 
												AND	repayment_schedule_date < now()) repayment_status
									FROM	loans
									WHERE	borrower_id = {$current_borrower_id}
									AND		loans.status = 7";
									
		$loandetails_rs		= 	$this->dbFetchAll($loandetails_sql);
		
		if ($loandetails_rs) {
			foreach ($loandetails_rs as $loanRow) {
				$newrow = count($this->loan_details);
				$newrow ++;
				foreach ($loanRow as $colname => $colvalue) {
					$this->loan_details[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $loandetails_rs;
	}
	
	public function getBorrowerCurrentLoans() {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$loandetails_sql	=	"	SELECT	   	loan_tenure duration,
												loans.final_interest_rate rate,
												borrowers.business_name,
												business_organisations.bo_name business_organisation,
												loans.purpose,
												ROUND(loans.loan_sanctioned_amount,2) amount
									FROM		borrowers
									LEFT JOIN 	business_organisations
									ON			borrowers.bo_id	= business_organisations.bo_id,
												loans
									WHERE  		borrowers.borrower_id = {$current_borrower_id}
									AND    		borrowers.borrower_id = loans.borrower_id
									AND			loans.status IN (3,5,7)";
									
		$current_loans_rs		= 	$this->dbFetchAll($loandetails_sql);
			
		if ($current_loans_rs) {
			return $current_loans_rs;
		}
		return "";
	}
	
	public function getBorrowerBarChart() {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
				
		$barchartdetails_sql	=	"	SELECT  loans.loan_id,
												loans.loan_reference_number loan_ref,
												group_concat(date_format(repayment_actual_date, '%y %m')) barChartLabel,
												group_concat(repayment_scheduled_amount + ifnull(repayment_penalty_amount, 0)) barChartValue
										FROM 	borrower_repayment_schedule,
												loans,
												( 	SELECT	distinct date_format(repayment_actual_date, '%Y%m') payment_period
													FROM	borrower_repayment_schedule
															WHERE	repayment_actual_date is not null
															ORDER BY	date_format(repayment_actual_date, '%Y%m')
															 LIMIT 0, 3) limit_payment_month
										WHERE 	repayment_status = 3
										and	loans.borrower_id = {$current_borrower_id}
										and	loans.loan_id = borrower_repayment_schedule.loan_id
										and	limit_payment_month.payment_period = date_format(repayment_actual_date, '%Y%m')
										GROUP BY loans.loan_id
										ORDER BY loans.loan_id, repayment_actual_date";
		
		$barchartdetails_rs		= 	$this->dbFetchAll($barchartdetails_sql);
		
		if ($barchartdetails_rs) {
			return $barchartdetails_rs;
		}
		return "";
	}
}
