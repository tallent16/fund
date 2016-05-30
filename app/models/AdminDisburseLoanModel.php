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
	public	$borrower_id = 0;
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
	public	$loan_status = 0;
	
	public	$repayment_schedule = array();
	public 	$investor_repayment	= array();
	
	public function getDisburseDetails($loan_id) {
		
		$loanDtl_sql		=	"	SELECT	loan_id,
											loans.status loan_status,
											loan_reference_number,
											borrower_id,
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

	}
	
	function computeRepaySchedule($loan_id, $loanProcessDate) {

		// Compute the pre-EMI days 
		/* The first installment may be different from the other installments if the processing
		 * date is different from the monthly pay-by-date. For instance if the processing date is 
		 * 24th April and the monthly pay by date is 5th then the interest is to be calculated 
		 * separately for the period of 24th April to 5th May (12 days)
		 * 
		 */
		 
		$this->getDisburseDetails($loan_id);
		
		$loanProcessDay		=	substr($loanProcessDate, 0,2);
		$loanProcessDate 	=	substr($loanProcessDate, 6,4)."-".substr($loanProcessDate, 3,2)."-".
								substr($loanProcessDate, 0,2);

		$this->plusOneMonth	=	new DateInterval('P1M');
		$currentDate		=	new DateTime();
	
		if ($this->repayment_type == REPAYMENT_TYPE_ONE_TIME) {
			$this->firstInstdate = new DateTime ($loanProcessDate);
			$this->firstInstdate->add(New DateInterval("P{$this->loan_tenure}M"));
		} else {
			if ($this->monthly_pay_by_date == 0) {
				$tempDate = new DateTime ($loanProcessDate);
				$this->firstInstdate = $tempDate->add($this->plusOneMonth);
			} else {
				if ($loanProcessDay < $this->monthly_pay_by_date) {
					$this->firstInstdate	=	new DateTime("{$currentDate->format('Y-m')}-{$this->monthly_pay_by_date}");
				} else {
					$tempDate	=	new DateTime("{$currentDate->format('Y-m')}-{$this->monthly_pay_by_date}");
					$this->firstInstdate	=	$tempDate->add($this->plusOneMonth);
				}
			}
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
		
		$repaySched = json_encode($this->repayment_schedule);
		return $repaySched;
		
		
	}
	
	public function saveDisburseLoan() {
		/* Validate the information since Javascript validation can be overriden in some
		 * Extreme cases
		 */

		// Steps for saving the disbursal
		// Update Loans Table 
		// Insert row into Payments Table
		// Insert row into disbursement Table
		// Insert rows into borrower_repayments_table
		// Insert rows into investor_repayments_table
		
		$loan_id			=	$_REQUEST["loan_id"];
		$loan_process_date 	=	$_REQUEST["disbursement_date"];
		$disburseDate		=	$this->getDbDateFormat($loan_process_date);
		$loan_process_fees	=	$this->makeFloat($_REQUEST["loan_process_fees"]);
		$total_disbursed	=	$this->makeFloat($_REQUEST["amount_disbursed"]);
		$loan_fixed_fees	=	$this->makeFloat($_REQUEST["loan_fixed_fees"]);
		$loan_fees_percent	=	$this->makeFloat($_REQUEST["loan_fees_percent"]);
		$paymentRef			=	$_REQUEST["payment_ref"];
		$remarks			=	$_REQUEST["remarks"];
		$this->getDisburseDetails($loan_id);
		$this->computeRepaySchedule($loan_id, $loan_process_date);

		$moduleName	=	"Loan Process";
		$actionSumm =	"Loan Disbursal";
		$actionDet  =	"Loan Disbursal";

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"Loan Reference Nu",$this->loan_reference_number);
		

		$dataArray	=	[	"status"			=> 	LOAN_STATUS_DISBURSED,
							"loan_process_date" =>	$disburseDate,
							"trans_fees"		=>	$loan_process_fees,
							"total_disbursed"	=>	$total_disbursed];

		$tableName	=	"loans";
		$where		=	["loan_id"	=>	$loan_id];
		
		if (!$this->dbUpdate("loans", $dataArray, $where)) 
			return -1;
			
	
		// Insert into Payments Table
		$payData	=	[	"trans_datetime"	=>	$disburseDate,
							"trans_type"		=>	PAYMENT_TRANSCATION_LOAN_DISBURSEMENT,
							"trans_amount"		=>	$total_disbursed,
							"currency"			=>	"SGD",
							"trans_reference_number"	=>	$paymentRef,
							"status"			=>	PAYMENT_STATUS_VERIFIED,
							"remarks"			=>	$remarks];
		
		$paymentId	=	$this->dbInsert("payments", $payData, true);
		
		if (!$paymentId) 
			return -1;
			
		// Insert into Disbursements table
		$disbData	=	[	"disbursement_date"	=>	$disburseDate,
							"loan_id"			=>	$loan_id,
							"borrower_id"		=>	$this->borrower_id,
							"amount_disbursed"	=>	$total_disbursed,
							"currency"			=>	"SGD",
							"fixed_fees_levied" =>	$loan_fixed_fees,
							"fees_percent_levied"	=>	$loan_fees_percent,
							"total_fees_levied"	=>	$loan_process_fees,
							"payment_id"		=>	$paymentId,
							"remarks"			=>	$remarks,
							"status"			=>	PAYMENT_STATUS_VERIFIED];

		$this->dbInsert("disbursements", $disbData, false);
		
		// Insert new rows in borrower_repayment_schedule
		foreach ($this->repayment_schedule as $instNum => $repaySchd) {
			$borrSchdData	=	[	"loan_id"						=>	$loan_id,
								"borrower_id"					=>	$this->borrower_id,
								"installment_number"			=>	$instNum+1,
								"repayment_schedule_date"		=>	$repaySchd["payment_scheduled_date"],
								"repayment_scheduled_amount"	=>	$repaySchd["payment_schedule_amount"],
								"principal_component"			=>	$repaySchd["principal_amount"],
								"interest_component"			=>	$repaySchd["interest_amount"],
								"repayment_status"				=>	BORROWER_REPAYMENT_STATUS_UNPAID];
								
			$this->dbInsert("borrower_repayment_schedule", $borrSchdData, false);
			
		}

		foreach ($this->investor_repayment as $investorId => $invRepaySch) {
			foreach ($invRepaySch as $instlNum => $instlDtls ) {
				$invSchdData	=	[	"loan_id"					=>	$loan_id,
									"investor_id"				=>	$investorId,
									"installment_number"		=>	$instlNum+1,
									"payment_scheduled_date"	=>	$instlDtls["payment_scheduled_date"],
									"principal_amount"			=>	$instlDtls["principal_amount"],
									"interest_amount"			=>	$instlDtls["interest_amount"],
									"payment_schedule_amount"	=>	$instlDtls["payment_schedule_amount"],
									"status"					=>	BORROWER_REPAYMENT_STATUS_UNPAID ];
				
				$this->dbInsert("investor_repayment_schedule", $invSchdData, false);
			}
		
		}
		
		return 1;
	}

	public function fillInvestorRepaymentSchedule($investorId, $interestRate, $acceptAmount) {
		$installmentNo	=	0;
		$firstEmiDate	=	"";
		$firstMonthInt	=	0;
		$principalAmt	=	0;
		$interestAmt	=	0;
		$monthlyEmi		=	0;
		$instDate		=	clone $this->firstInstdate;
		$preEmiAmount	=	round($acceptAmount * ($interestRate / 36500) * $this->preEmiDays, 2);

		// If the disbursement date is other than the pay by date, then there will be a pre-emi component
		// for the difference between the disbursement date and the next pay-by date
		
		switch ($this->repayment_type) {
			
			case 	REPAYMENT_TYPE_EMI:

					if ($this->preEmiDays > 0) {
						$this->investor_repayment[$investorId][0]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$this->investor_repayment[$investorId][0]['principal_amount'] = 0;
						$this->investor_repayment[$investorId][0]['interest_amount'] = round($preEmiAmount,2);
						$this->investor_repayment[$investorId][0]['payment_schedule_amount'] = round($preEmiAmount,2);
						$instDate	= $instDate->add(new DateInterval('P1M'));
						$installmentNo ++;
					}

					$adjInterest =	 $interestRate / 1200;
					$monthlyEmi	=	($acceptAmount * $adjInterest) * 
										(1 + $adjInterest)**$this->loan_tenure / 
										((1 + $adjInterest)**$this->loan_tenure - 1);
					$monthlyEmi = round($monthlyEmi);
					$balOs		=	$acceptAmount;

					for ($instNumber = $installmentNo; $instNumber <= $this->loan_tenure; $instNumber++ ) {
						
						$this->investor_repayment[$investorId][$instNumber]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$interestAmt	=	round($balOs * $adjInterest, 2);
						$principalAmt	=	$monthlyEmi - $interestAmt;
						$balOs			=	$balOs - $principalAmt;
						if ($instNumber == $this->loan_tenure) {
							$principalAmt = $principalAmt + $balOs;
							$monthlyEmi = $monthlyEmi + $balOs;
						}
						
						$this->investor_repayment[$investorId][$instNumber]['interest_amount'] = round($interestAmt,2);
						$this->investor_repayment[$investorId][$instNumber]['principal_amount'] = round($principalAmt,2);
						$this->investor_repayment[$investorId][$instNumber]['payment_schedule_amount'] = round($monthlyEmi,2);
						$instDate	= $instDate->add(new DateInterval('P1M'));
					
					}
					break;
			
			case	REPAYMENT_TYPE_INTEREST_ONLY:
					$monthlyEmi	=	$acceptAmount * $interestRate / 1200;
				
					if ($this->preEmiDays > 0) {
						$this->investor_repayment[$investorId][0]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$this->investor_repayment[$investorId][0]['principal_amount'] = 0;
						$this->investor_repayment[$investorId][0]['interest_amount'] = round($preEmiAmount,2);
						$this->investor_repayment[$investorId][0]['payment_schedule_amount'] = round($preEmiAmount,2);
						$instDate	= $instDate->add(new DateInterval('P1M'));
						$installmentNo ++;
					}

					for ($instNumber = $installmentNo; $instNumber <= $this->loan_tenure; $instNumber++ ) {
					
						$this->investor_repayment[$investorId][$instNumber]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$interestAmt	=	round($monthlyEmi, 2);
						$principalAmt	=	0;
						$balOs			=	$acceptAmount;
						if ($instNumber == $this->loan_tenure + ($this->preEmiDays > 0?0:1)) {
							$principalAmt = $acceptAmount;
							$monthlyEmi = $monthlyEmi + $acceptAmount;
						}
						
						$this->investor_repayment[$investorId][$instNumber]['interest_amount'] = round($interestAmt,2);
						$this->investor_repayment[$investorId][$instNumber]['principal_amount'] = round($principalAmt,2);
						$this->investor_repayment[$investorId][$instNumber]['payment_schedule_amount'] = round($monthlyEmi,2);
						$instDate	= $instDate->add(new DateInterval('P1M'));
					
					}
					break;
			
			case	REPAYMENT_TYPE_ONE_TIME:
					// total repayable is calculated by the formula
					// P (1 + r/n) ^ nt where
					// P --> Accepted Amount
					// r --> Interest Rate / 100
					// n --> Tenure
					// t --> n / 12 (no. of years)
			
					$tenure			=	$this->loan_tenure;
					$adjIntRate		=	$interestRate / 100;
					$noofyears		=	$this->loan_tenure / 12;
					$balOs			=	$acceptAmount * ((1 + $adjIntRate/ $tenure)**($tenure*$noofyears));
					$balOs			=	$balOs;
					$interestAmt	=	$balOs - $acceptAmount;
					
					$this->investor_repayment[$investorId][0]['interest_amount'] = round($interestAmt, 2);
					$this->investor_repayment[$investorId][0]['principal_amount'] = round($acceptAmount,2);
					$this->investor_repayment[$investorId][0]['payment_schedule_amount'] = round($balOs,2);
					$this->investor_repayment[$investorId][0]['payment_scheduled_date'] = $instDate->format('Y-m-d');
					
					break;
		
		}
	
		
	}

						
}
