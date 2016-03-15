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
		
		$loandetails_sql	=	"SELECT 	loans.loan_reference_number,
										   ifnull(DATE_FORMAT(last_payment,'%d/%m/%Y'),'')  last_payment,
										   ifnull(DATE_FORMAT(next_payment,'%d/%m/%Y'),'')  next_payment,
										   ROUND(amount_paid,2) amount_paid,
										   loans.final_interest_rate inst_rate,
										   no_of_installment,
										   ROUND(total_repayments,2) total_repayments,
										   ROUND((loans.loan_sactioned_amount - loans.loan_sactioned_amount),2) tot_prin_outstanding,
											case repayment_status 
											   when 1 then 'Unpaid' 
											   when 2 then 'Paid'
											end as repayment_status
									FROM   borrowers,
										   loans
									LEFT JOIN (
											   SELECT loan_id, max(repayment_actual_date) last_payment
											   FROM   loan_repayment_schedule
											   WHERE  loan_repayment_schedule.borrower_id = {$current_borrower_id}
											   GROUP BY loan_id )  loan_repay ON loans.loan_id = loan_repay.loan_id
									LEFT JOIN (
											   SELECT loan_id, sum(amount_paid) amount_paid
											   FROM   borrower_repayments
											   WHERE  borrower_repayments.borrower_id = {$current_borrower_id}
											   GROUP BY loan_id)  borrower_repay on loans.loan_id = borrower_repay.loan_id
									LEFT JOIN (
											   SELECT loan_id, COUNT(loan_id) no_of_installment
											   FROM   loan_repayment_schedule
											   WHERE  loan_repayment_schedule.borrower_id = {$current_borrower_id}
											   GROUP BY loan_id
										   )  loan_repay_install ON loans.loan_id = loan_repay_install.loan_id     
									LEFT JOIN (
											   SELECT loan_id, sum(amount_paid) total_repayments
											   FROM   borrower_repayments
											   WHERE  borrower_repayments.borrower_id = {$current_borrower_id}
											   GROUP BY loan_id
										   )  borrower_repay_tot ON loans.loan_id = borrower_repay_tot.loan_id
									LEFT JOIN (     
												SELECT xx.loan_id, repayment_status
												FROM loan_repayment_schedule, 
												(
													SELECT 	loan_id, max(repayment_schedule_date) max_date
													FROM 	loan_repayment_schedule
													WHERE 	repayment_schedule_date < date(now()) 
													GROUP BY loan_id
												) xx
												WHERE loan_repayment_schedule.loan_id = xx.loan_id
												AND loan_repayment_schedule.repayment_schedule_date = xx.max_date
											  ) loan_status ON loans.loan_id = loan_status.loan_id
									LEFT JOIN (     
												SELECT aa.loan_id, repayment_schedule_date next_payment
												FROM loan_repayment_schedule, 
												(
													SELECT 	loan_id, min(repayment_schedule_date) next_payment_date
													FROM 	loan_repayment_schedule
													WHERE 	repayment_status = 1 
													GROUP BY loan_id
												) aa
												WHERE loan_repayment_schedule.loan_id = aa.loan_id
												AND loan_repayment_schedule.repayment_schedule_date = aa.next_payment_date
											  ) loan_next_payment ON loans.loan_id = loan_next_payment.loan_id
									WHERE  borrowers.borrower_id = {$current_borrower_id}
									AND    borrowers.borrower_id = loans.borrower_id
									AND   	loans.status = 6";
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
		
		$loandetails_sql	=	"	SELECT	   	no_of_installment duration,
												loans.final_interest_rate rate,
												borrowers.business_name,
												business_organisations.bo_name business_organisation,
												loans.purpose,
												ROUND(loans.loan_sactioned_amount,2) amount
									FROM		borrowers
									LEFT JOIN 	business_organisations
									ON			borrowers.bo_id	= business_organisations.bo_id,
												loans
									LEFT JOIN (
												SELECT loan_id, COUNT(loan_id) no_of_installment
												FROM   loan_repayment_schedule
												WHERE  loan_repayment_schedule.borrower_id = {$current_borrower_id}
												GROUP BY loan_id
										   )  	loan_repay_install ON loans.loan_id = loan_repay_install.loan_id     
									
									WHERE  		borrowers.borrower_id = {$current_borrower_id}
									AND    		borrowers.borrower_id = loans.borrower_id
									AND			loans.status = 6";
									
		$current_loans_rs		= 	$this->dbFetchAll($loandetails_sql);
			
		if ($current_loans_rs) {
			return $current_loans_rs;
		}
		return "";
	}
	
	public function getBorrowerBarChart() {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$barchartdetails_sql	=	"	SELECT 	GROUP_CONCAT(ROUND(amount_paid,0)) as barChartValue,
												GROUP_CONCAT(DATE_FORMAT( loan_repay.repayment_actual_date,'%b %y')) as barChartLabel,
												loans.loan_reference_number loan_ref
										FROM 	loans,
												borrower_repayments bor_repay
										LEFT JOIN loan_repayment_schedule loan_repay
										ON 		bor_repay.repayment_schedule_id = loan_repay.repayment_schedule_id
										WHERE 	bor_repay.borrower_id = {$current_borrower_id} 
										AND		loans.loan_id	=	bor_repay.loan_id
										GROUP BY bor_repay.loan_id
										";
									
		$barchartdetails_rs		= 	$this->dbFetchAll($barchartdetails_sql);
			
		if ($barchartdetails_rs) {
			return $barchartdetails_rs;
		}
		return "";
	}
}
