<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
	  
class AdminDisburseLoanModel extends TranWrapper {
	public	$loan_reference_number = "";
	public	$loan_sanctioned_amount = 0;
	public	$loan_process_date = "";
	public  $fixed_fees_levied = 0;
	public	$fees_percent_levied = 0;
	public  $total_fees_levied = 0;
	public	$amount_disbursed = 0;
	public	$trans_reference_number = "";
	public	$remarks = "";
	public	$loan_process_fees = 0;
	public	$system_date = "";
	public	$repayment_type = 0;
	public	$final_interest_rate = 0;
	public	$monthly_pay_by_date = 0;
	public	$loanTenure = 0;
	public	$emi = 0;
	
	public	$repayment_schedule = array();
	public 	$investor_repayment	= array();
	
	public function getDisburseDetails($loan_id) {
		
		$loanDtl_sql		=	"	SELECT	loan_id,
											loan_reference_number,
											date_format(now(), '%d-%m-%Y') loan_process_date,
											(	SELECT 	sum(accepted_amount) 
												FROM	loan_bids
												WHERE	bid_status = 2
												AND		loan_id = loans.loan_id) loan_sanctioned_amount,
											fees_type_applicable,
											codelist_value,
											loan_fees_percent,
											loan_fixed_fees,
											final_interest_rate,
											repayment_type,
											loan_fees_minimum_applicable,
											monthly_pay_by_date,
											date_format(now(), '%d-%m-%Y') system_date
									FROM	loans,
											system_settings,
											codelist_details
									WHERE	loan_id = :loan_id 
									AND		codelist_details.codelist_id = :loanfees_applicable
									AND		codelist_details.codelist_code = system_settings.fees_type_applicable";
		
		$dataArrayLoan		=	[
									"loan_id" => $loan_id,
									"loanfees_applicable" => LOAN_FEES_APPLICABLE
								];
									
		$loanDtl_rs			=	$this->dbFetchWithParam($loanDtl_sql, $dataArrayLoan);
		
		
		if (!$loanDtl_rs) {
			return -1;
		}
		foreach ($loanDtl_rs as $loanDtl_row) {
			foreach ($loanDtl_row as $colname => $value) {
				$this->{$colname} = $value;
			}
		}
		$this->loan_process_fees	=	$this->loan_sanctioned_amount * ($this->loan_fees_percent/100) + 
										$this->loan_fixed_fees;
	
		if ($this->loan_process_fees < $this->loan_fees_minimum_applicable) 
			$this->loan_process_fees = $this->loan_fees_minmum_applicable;
			
		$this->amount_disbursed = $this->loan_sanctioned_amount - $this->loan_process_fees;
		
		// Now comes the bids	
		$loanBids_sql		=	"	SELECT	loan_id,
											investor_id,
											bid_interest_rate,
											bid_status,
											accepted_amount,
											emi
									FROM	loan_bids
									WHERE	loan_id = :loan_id
									AND		bid_status = :accepted_status";
		
		$dataArray_loanbid	=	[	"loan_id"	=> $loan_id,
									"accepted_status" =>	LOAN_BIDS_STATUS_ACCEPTED
								];
		
		$loanBids_rs			=	$this->dbFetchWithParam($loanBids_sql, $dataArray_Loanbid);
		
		
		if (!$loanBids_rs) {
			return -1;
		}

		

		
	}
	
	public function saveDisburseLoanAction)() {
		/* Validate the information since Javascript validation can be overriden in some
		 * Extreme cases
		 */

		// Update Loans Table
		
		$dataArray	=	["status"					=> 	LOAN_STATUS_DISBURSED,
						 "loan_process_date" 		=>	$_REQUEST["disbursement_date"],
						 "loan_sanctioned_amount" 	=>	$_REQUEST["loan_sanctioned_amount"],
						 "trans_fees"				=>	$_REQUEST["loan_process_fees"],
						 "total_disbursed"			=>	$_REQUEST["amount_disbursed"]];

		$tableName	=	"loans";
		$where		=	["loan_id"	=>	$REQUEST["loan_id"]];
		
		
		
		$this->dbUpdate($tableName, $dataArray, $where);

		// 

		

		
		
		
	}
	public function processDropDowns() {
		
		
	}

	public function fillInvestorRepaymentSchedule($investorId, $interestRate, $acceptAmount) {
		$installmentId	=	1;
		$firstEmiDate	=	"";
		$firstMonthInt	=	0;
		$principalAmt	=	0;
		$interestAmt	=	0;
		$monthlyEmi		=	0;
		
		switch ($this->repayment_type) {
			
			case 	REPAYMENT_TYPE_EMI:
					$monthlyEmi	=	$acceptAmount * ($interestRate / 100) * 
										((1 + ($interestRate / 1200))**$this->loanTenure);
		
					break;
			
			case	REPAYMENT_TYPE_INTEREST_ONLY:
					$monthlyEmi	=	$acceptAmount * ($interestRate / 1200);
					
					break;
			
			case	REPAYMENT_TYPE_ONE_TIME:
			
					break;
			
			
			
			
		}
		if ($this->repayment_type == )
		
		
		
	}
						
}
