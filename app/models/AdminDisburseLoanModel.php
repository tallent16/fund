<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use DateTime;
use DateInterval;
	  
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
	public	$loan_tenure = 0;
	public	$emi = 0;
	public	$preEmiDays = 0;
	public	$nextPayDate = "";
	public	$firstInstdate = "";
	public	$plusOneMonth = "";
	
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
											loan_tenure,
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

		// Compute the Sanctioned amount and Processing Fees
		$this->loan_process_fees	=	$this->loan_sanctioned_amount * ($this->loan_fees_percent/100) + 
										$this->loan_fixed_fees;

		if ($this->loan_process_fees < $this->loan_fees_minimum_applicable) 
			$this->loan_process_fees = $this->loan_fees_minmum_applicable;
			
		$this->amount_disbursed = $this->loan_sanctioned_amount - $this->loan_process_fees;


		// Compute the pre-EMI days 
		/* The first installment may be different from the other installments if the processing
		 * date is different from the monthly pay-by-date. For instance if the processing date is 
		 * 24th April and the monthly pay by date is 5th then the interest is to be calculated 
		 * separately for the period of 24th April to 5th May (12 days)
		 * 
		 */
		$currentDate		=	new DateTime();
		$loanProcessDay		=	$currentDate->format('Y-m-d');
		$this->plusOneMonth	=	new DateInterval('P1M');
	
		
		if ($loanProcessDay < $this->monthly_pay_by_date) {
			$this->firstInstdate	=	new DateTime("{$currentDate->format('Y-m')}-{$this->monthly_pay_by_date}");
		} else {
			$tempDate	=	new DateTime("{$currentDate->format('Y-m')}-{$this->monthly_pay_by_date}");
			$this->firstInstdate	=	$tempDate->add($this->plusOneMonth);
		}

		$diff	=	date_diff($currentDate, $this->firstInstdate, true);

		$this->preEmiDays 	=	$diff->format('%d');

		
		// Now comes the bids	
		$loanBids_sql		=	"	SELECT	loan_id,
											investor_id,
											bid_interest_rate,
											accepted_amount
									FROM	loan_bids
									WHERE	loan_id = :loan_id
									AND		bid_status = :accepted_status";
		
		$dataArray_loanbid	=	[	"loan_id"	=> $loan_id,
									"accepted_status" =>	LOAN_BIDS_STATUS_ACCEPTED
								];
		
		$loanBids_rs			=	$this->dbFetchWithParam($loanBids_sql, $dataArray_loanbid);
		
		
		if (!$loanBids_rs) {
			return -1;
		}
		
		foreach ($loanBids_rs as $loanBids_row) {
			$investorId		=	$loanBids_row->investor_id;
			$invInterest	=	$loanBids_row->bid_interest_rate;
			$acceptAmount	=	$loanBids_row->accepted_amount;
			
			$this->fillInvestorRepaymentSchedule($investorId, $invInterest, $acceptAmount);
		}
		
		foreach ($this->investor_repayment as $investorId => $invRepaySch) {
			$investors[] = $investorId;
			echo "<h1>Repayment Schedule for Investor # {$investorId} </h1>";
			$this->printEmi($this->investor_repayment[$investorId]);
		}
		
		$totPrin	=	 0;
		
		foreach ($this->investor_repayment[$investorId] as $instlNum => $instlDtls ) {
			$schDate	= $instlDtls["payment_scheduled_date"];
			$prinAmt	=	0;
			$intAmt		=	0;
			$emiAmt		=	0;
			
			foreach ($investors as $investorId) {
				$prinAmt = $prinAmt + $this->investor_repayment[$investorId][$instlNum]["principal_amount"];
				$intAmt = $intAmt + $this->investor_repayment[$investorId][$instlNum]["interest_amount"];
				$emiAmt = $emiAmt + $this->investor_repayment[$investorId][$instlNum]["payment_schedule_amount"];
			}
			
			$this->repayment_schedule[$instlNum]["payment_scheduled_date"] = $schDate;
			$this->repayment_schedule[$instlNum]["principal_amount"] = $prinAmt;
			$this->repayment_schedule[$instlNum]["interest_amount"] = $intAmt;
			$this->repayment_schedule[$instlNum]["payment_schedule_amount"] = $emiAmt;
			
			$totPrin	=	 $totPrin + $prinAmt;
		}
		
//		echo "Total principal repaid is $totPrin <br>";
//		echo "<pre>", print_r($this->repayment_schedule), "</pre>";
			echo "<h1>Repayment Schedule for Loan ID </h1>";
		$this->printEmi($this->repayment_schedule);
		die;
		
	}
	
	public function saveDisburseLoanAction() {
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
		
		
		
	}

	public function fillInvestorRepaymentSchedule($investorId, $interestRate, $acceptAmount) {
		$installmentId	=	1;
		$firstEmiDate	=	"";
		$firstMonthInt	=	0;
		$principalAmt	=	0;
		$interestAmt	=	0;
		$monthlyEmi		=	0;
		

		$preEmiAmount		=	round($acceptAmount * ($interestRate / 36500) * $this->preEmiDays, 2);
		
		
		switch ($this->repayment_type) {
			
			case 	REPAYMENT_TYPE_EMI:
					$adjInterest =	 $interestRate / 1200;
					$monthlyEmi	=	($acceptAmount * $adjInterest) * 
										(1 + $adjInterest)**$this->loan_tenure / 
										((1 + $adjInterest)**$this->loan_tenure - 1);
					$monthlyEmi = round($monthlyEmi);
					$balOs		=	$acceptAmount;
					$instDate	=	clone $this->firstInstdate;

					
					if ($this->preEmiDays > 0) {
						$this->investor_repayment[$investorId][0]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$this->investor_repayment[$investorId][0]['principal_amount'] = 0;
						$this->investor_repayment[$investorId][0]['interest_amount'] = $preEmiAmount;
						$this->investor_repayment[$investorId][0]['payment_schedule_amount'] = $preEmiAmount;
						$instDate	= $instDate->add(new DateInterval('P1M'));
					}


					for ($instNumber = 1; $instNumber <= $this->loan_tenure; $instNumber++ ) {
						
						$this->investor_repayment[$investorId][$instNumber]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$interestAmt	=	round($balOs * $adjInterest, 2);
						$principalAmt	=	$monthlyEmi - $interestAmt;
						$balOs			=	$balOs - $principalAmt;
						if ($instNumber == $this->loan_tenure) {
							$principalAmt = $principalAmt + $balOs;
							$monthlyEmi = $monthlyEmi + $balOs;
						}
						
						$this->investor_repayment[$investorId][$instNumber]['interest_amount'] = $interestAmt;
						$this->investor_repayment[$investorId][$instNumber]['principal_amount'] = $principalAmt;
						$this->investor_repayment[$investorId][$instNumber]['payment_schedule_amount'] = $monthlyEmi;
						$instDate	= $instDate->add(new DateInterval('P1M'));
					
					}
					break;
			
			case	REPAYMENT_TYPE_INTEREST_ONLY:
					$monthlyEmi	=	$acceptAmount * $interestRate;
					
					break;
			
			case	REPAYMENT_TYPE_ONE_TIME:
			
					break;
		
		}
	
		
	}
	
	public function printEmi($emiArray) {
		echo "
		<table>
			<tr>
				<td>Installment #</td>
				<td>Payment Date</td>
				<td>Principal</td>
				<td>Interest</td>
				<td>EMI</td>
			</tr> ";

		foreach ($emiArray as $instNum => $emiDtls) {
			echo "<tr>
					<td>{$instNum} </td>
					<td>{$emiDtls['payment_scheduled_date']} </td>
					<td>{$emiDtls['principal_amount']} </td>
					<td>{$emiDtls['interest_amount']} </td>
					<td>{$emiDtls['payment_schedule_amount']} </td>
					</tr>";
		}
		
		echo "</table>";
		
	}
						
}
