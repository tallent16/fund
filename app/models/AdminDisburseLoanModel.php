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
	public	$repayment_typeText = "";
	public	$bid_typeText = "";
	public	$jsonInvRepay = "";
	public	$repayment_schedule = array();
	public 	$investor_repayment	= array();
	public 	$loanInvestors		= array();
	public 	$bothSchd = array();
	public	$jsonBorrRepay = "";
	
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
											target_interest,
											repayment_type,
											case loans.repayment_type 
												   when 1 then 'Bullet' 
												   when 2 then 'Monthly Interest'
												   when 3 then 'EMI'
											end as repayment_typeText,
											case loans.bid_type 
												   when 1 then 'Open Bid' 
												   when 2 then 'Closed Bid'
												   when 3 then 'Fixed Interest '
											end as bid_typeText,
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
	
	function getBorrRepaySchd($loanId) {
		// When the loan is disbursed, the repaySchedule is to be obtained from the table 
		// When the loan is in accepted status, the repaySchedule is calculated (since it is not yet stored in DB)
		
		$sql	=	"	SELECT 	installment_number,
								date_format(repayment_schedule_date, '%d-%m-%Y') repayment_schedule_date,
								repayment_scheduled_amount,
								principal_component,
								interest_component,
								repayment_status,
								date_format(repayment_actual_date, '%d-%m-%Y') repayment_actual_date,
								repayment_penalty_interest,
								repayment_penalty_charges,
								ifnull(principal_component,0) + ifnull(interest_component,0) + 
								ifnull(repayment_penalty_interest,0) + ifnull(repayment_penalty_charges,0) total
						FROM	borrower_repayment_schedule
						WHERE	loan_id = :loan_id
						order by installment_number";
		
		$rs		=	$this->dbFetchWithParam($sql, ["loan_id" => $loanId]);
		foreach($rs	as $index => $row) {
			$this->repayment_schedule[$index]["installment_number"] 		= $index;
			$this->repayment_schedule[$index]["repayment_schedule_date"] 	= $row->repayment_schedule_date;
			$this->repayment_schedule[$index]["repayment_scheduled_amount"] = number_format($row->repayment_scheduled_amount, 2, ".", ",");
			$this->repayment_schedule[$index]["principal_component"] 		= number_format($row->principal_component, 2, ".", ",");
			$this->repayment_schedule[$index]["interest_component"] 		= number_format($row->interest_component, 2, ".", ",");
			$this->repayment_schedule[$index]["repayment_actual_date"] 		= $row->repayment_actual_date;
			$this->repayment_schedule[$index]["repayment_penalty_charges"] 	= number_format($row->repayment_penalty_charges, 2, ".", ",");
			$this->repayment_schedule[$index]["repayment_penalty_interest"] = number_format($row->repayment_penalty_interest, 2, ".", ",");
			$this->repayment_schedule[$index]["total"] = number_format($row->total, 2, ".", ",");
			
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
			}
					
			$this->repayment_schedule[$index]["repayment_status"] = $status;
			$this->jsonBorrRepay = json_encode($this->repayment_schedule);
			
		}
	}
	
	function computeRepaySchedule($loan_id, $loanProcessDate="", $payByDay=0) {
		
		// When the loan is in accepted status then the repaySchedule is not yet saved in the DB. That time you 
		// have to compute the repaySchedule.

		// Compute the pre-EMI days 
		/* The first installment may be different from the other installments if the processing
		 * date is different from the monthly pay-by-date. For instance if the processing date is 
		 * 24th April and the monthly pay by date is 5th then the interest is to be calculated 
		 * separately for the period of 24th April to 5th May (12 days)
		 * 
		 */
		
		// This function can be called:
		// 		when the loan is in viewed and is at accepted status
		// 		when the user has changed the details of disbursement date or the pay-by-date
		
		// getDisburseDetails gets all the important information and stores it in public variables
		// rather than having another function to get the information, we are calling the same function
		$this->getDisburseDetails($loan_id);
		
				
		if ($this->loan_status != LOAN_STATUS_BIDS_ACCEPTED) {
			return $this->getBorrRepaySchd($loan_id);
		}
		

		// if the user has changed the monthly pay by date then use that otherwise use the value from 
		// the settings table
		if ($payByDay != 0) {
			$this->monthly_pay_by_date = $payByDay;
		}
		
		/* -------------------------------------------------
		 * Calculation of Pre-emi and the first installment date
				if loan_process_date empty
					loan_process_date = current date
			
				if loan_process_date->day == monthly_pay_by_day 
					calc_preemi = false
				else
					calc_preemi = true
			
				first_installment = loan_process_date->"y-m" + loan_process_date
				if loan_process_date->day >= monthly_pay_by_day
					first_installment = first_installment + 1 month
			
				if calc_preemi 
					preemi_days = date_diff(loan_process_date, first_installment)

		*/
			
		// If the user has changed the disbursement date (loan process date) then use the new 
		// disbursement date or use the current date
		if ($loanProcessDate == "") {
			$loanProcessDate = new DateTime();
			$loanProcessDay	 = $loanProcessDate->format('d');
		} else {
			$loanProcessDate = DateTime::createFromFormat("d-m-Y", $loanProcessDate);
			$loanProcessDay	 = $loanProcessDate->format('d');
		}
	
		if ($loanProcessDay == $this->monthly_pay_by_date) {
			$calcPreEmi = false;
		} else {
			$calcPreEmi = true;
		}
		
		$this->plusOneMonth	=	new DateInterval('P1M');
		$this->firstInstdate = clone $loanProcessDate;
	
		if ($this->repayment_type == REPAYMENT_TYPE_ONE_TIME) {
			$this->firstInstdate->add(New DateInterval("P{$this->loan_tenure}M"));
		} else {
			if ($this->monthly_pay_by_date == 0) {
				$this->firstInstdate->add($this->plusOneMonth);
			} else {
				if ($loanProcessDay < $this->monthly_pay_by_date) {
					$this->firstInstdate	=	new DateTime("{$loanProcessDate->format('Y-m')}-{$this->monthly_pay_by_date}");
				} else {
					$tempDate	=	new DateTime("{$loanProcessDate->format('Y-m')}-{$this->monthly_pay_by_date}");
					$this->firstInstdate	=	$tempDate->add($this->plusOneMonth);
				}
			}
		}

		if ($calcPreEmi) {
			$diff	=	date_diff($loanProcessDate, $this->firstInstdate, true);
			$this->preEmiDays 	=	$diff->format('%d');
		} else {
			$this->preEmiDays	= 0;
		}
		
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
		
		// get the list of investors
		foreach ($this->investor_repayment as $investorId => $invRepaySch) {
			$investors[] = $investorId;
		}
		
		$totPrin	=	 0;
		
		
		
		foreach ($this->investor_repayment[$investorId] as $instlNum => $instlDtls ) {
			$schDate	= $instlDtls["payment_scheduled_date"];
			$tmpDate	=	date_format(date_create($schDate), "d-m-Y");
			$prinAmt	=	0;
			$intAmt		=	0;
			$emiAmt		=	0;
			
			foreach ($investors as $investorId) {
				$tmpPrin	=	$this->investor_repayment[$investorId][$instlNum]["principal_amount"];
				$tmpInt		=	$this->investor_repayment[$investorId][$instlNum]["interest_amount"];
				$tmpEmi		=	$this->investor_repayment[$investorId][$instlNum]["payment_schedule_amount"];

				$prinAmt += $tmpPrin;
				$intAmt += $tmpInt;
				$emiAmt += $tmpEmi;
				
				$this->investor_repayment[$investorId][$instlNum]["principal_amount"] = number_format($tmpPrin, 2, ".", ",");
				$this->investor_repayment[$investorId][$instlNum]["interest_amount"] = number_format($tmpInt, 2, ".", ",");
				$this->investor_repayment[$investorId][$instlNum]["payment_schedule_amount"] = number_format($tmpEmi, 2, ".", ",");
				$this->investor_repayment[$investorId][$instlNum]["payment_scheduled_date"] = $tmpDate;

			}
			


			$this->repayment_schedule[$instlNum]["payment_scheduled_date"] = $tmpDate;
			$this->repayment_schedule[$instlNum]["principal_amount"] = number_format($prinAmt, 2, ".", ",");
			$this->repayment_schedule[$instlNum]["interest_amount"] = number_format($intAmt, 2, ".", ",");
			$this->repayment_schedule[$instlNum]["payment_schedule_amount"] = number_format($emiAmt, 2, ".", ",");

			$totPrin	=	 $totPrin + $prinAmt;
		}
	
		$this->bothSchd['borrSchd'] = $this->repayment_schedule;
		$this->bothSchd['invSchd'] = $this->investor_repayment;
		
		$this->jsonInvRepay = json_encode($this->investor_repayment);
		$this->jsonBorrRepay = json_encode($this->repayment_schedule);
		$repaySchd = json_encode($this->bothSchd);
		
		return $repaySchd;
		
		
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
		$paybyday			=	$_REQUEST["monthly_pay_by_date"];
		$disburseDate		=	$this->getDbDateFormat($loan_process_date);
		$loan_process_fees	=	$this->makeFloat($_REQUEST["loan_process_fees"]);
		$total_disbursed	=	$this->makeFloat($_REQUEST["amount_disbursed"]);
		$loan_fixed_fees	=	$this->makeFloat($_REQUEST["loan_fixed_fees"]);
		$loan_fees_percent	=	$this->makeFloat($_REQUEST["loan_fees_percent"]);
		$paymentRef			=	$_REQUEST["payment_ref"];
		$remarks			=	$_REQUEST["remarks"];
		$this->getDisburseDetails($loan_id);
		$this->computeRepaySchedule($loan_id, $loan_process_date, $paybyday);

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
			$date	=	$this->getDbDateFormat($repaySchd["payment_scheduled_date"]);
			
			$borrSchdData	=	[	"loan_id"						=>	$loan_id,
								"borrower_id"					=>	$this->borrower_id,
								"installment_number"			=>	$instNum+1,
								"repayment_schedule_date"		=>	$date,
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
		
		if ($this->preEmiDays > 0) {
			$lastInstallment = $this->loan_tenure + 1;
		} else {
			$lastInstallment = $this->loan_tenure;
		}
		
	
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

					for ($instNumber = $installmentNo; $instNumber < $lastInstallment; $instNumber++ ) {
						
						$this->investor_repayment[$investorId][$instNumber]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$interestAmt	=	round($balOs * $adjInterest, 2);
						$principalAmt	=	$monthlyEmi - $interestAmt;
						$balOs			=	$balOs - $principalAmt;
						if ($instNumber + 1 == $this->loan_tenure + ($this->preEmiDays > 0?1:0) ) {
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

					for ($instNumber = $installmentNo; $instNumber < $lastInstallment; $instNumber++ ) {
					
						$this->investor_repayment[$investorId][$instNumber]['payment_scheduled_date'] = $instDate->format('Y-m-d');
						$interestAmt	=	round($monthlyEmi, 2);
						$principalAmt	=	0;
						$balOs			=	$acceptAmount;
						if ($instNumber + 1 == $this->loan_tenure + ($this->preEmiDays > 0?1:0)) {
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
	
	public function getAllInvestorByLoan($loan_id) {
		
		$bidsInfo_sql	=	"	SELECT	users.username,
										bid_id,
										mainInvestor.investor_id,
										date_format(bid_datetime, '%d-%m-%Y %h:%i') bid_datetime,
										bid_amount,
										bid_interest_rate,
										accepted_amount,
										(	SELECT SUM(principal_amount+interest_amount+IFNULL(penalty_amount,0))
											FROM	investor_repayment_schedule
											WHERE	loan_id = {$loan_id}
											AND		investor_id = mainInvestor.investor_id	
											AND		status	=	:paid_param
										) totalrepaid
								FROM	users,
										investors mainInvestor,
										loan_bids
								WHERE	loan_bids.loan_id = :loan_id
								AND		loan_bids.investor_id = mainInvestor.investor_id
								AND		mainInvestor.user_id = users.user_id
								AND		loan_bids.bid_status = :bid_cancelled 
								ORDER BY bid_interest_rate, bid_datetime";
					
		$bidsInfo_args	=	[	"loan_id" => $loan_id, 
								"bid_cancelled" => LOAN_BIDS_STATUS_ACCEPTED,
								"paid_param" => INVESTOR_REPAYMENT_STATUS_VERIFIED
							];
		
		$this->loanInvestors	=	$this->dbFetchWithParam($bidsInfo_sql, $bidsInfo_args);

	}
	
	public function getInvestorRepay($loan_id,$investor_id) {
		
		$investorInfo_sql	=	"	SELECT	installment_number,
											payment_scheduled_date,
											ROUND(principal_amount,2) principal_amount,
											ROUND(interest_amount,2) interest_amount,
											(	SELECT 	codelist_value
												FROM	codelist_details
												WHERE	codelist_id = 25
												AND		codelist_code	=	status) statusText,
											ROUND(IFNULL(penalty_amount,0),2) penalty_amount,
											ROUND((principal_amount+interest_amount+IFNULL(penalty_amount,0)),2) total_amount
									FROM	investor_repayment_schedule
									WHERE	loan_id = {$loan_id}
									AND		investor_id = {$investor_id}
									ORDER BY installment_number";
								
	
		$result				=		$this->dbFetchAll($investorInfo_sql);
		return $result;
	}
	
	public function getInvRepaySchd($loan_id) {
		$sql		=	"	SELECT 	investor_id,
									installment_number,
									date_format(payment_scheduled_date, '%d-%m-%Y') repayment_schedule_date,
									payment_schedule_amount repayment_scheduled_amount,
									principal_amount principal_component,
									interest_amount interest_component,
									status repayment_status,
									if(isnull(payment_date), '', 
									date_format(payment_date, '%d-%m-%Y')) repayment_actual_date,
									penalty_amount repayment_penalty_interest,
									ifnull(principal_amount,0) + ifnull(interest_amount,0) + 
									ifnull(penalty_amount,0) total
							FROM	investor_repayment_schedule
							WHERE	loan_id = :loan_id";		
														
		$rs			=	$this->dbFetchWithParam($sql, ["loan_id" => $loan_id]);
		
		foreach ($rs	as $row) {
			$invId		=	$row->investor_id;
			$instNum	=	$row->installment_number;
			$schdDate	=	$row->repayment_schedule_date;
			$actDate	=	$row->repayment_actual_date;
			$prinAmt	=	$row->principal_component;
			$intAmt		=	$row->interest_component;
			$penalty	=	$row->repayment_penalty_interest;
			$total		=	$row->total;
			$status		=	$row->repayment_status;
			
			switch ($status) {
				case BORROWER_REPAYMENT_STATUS_UNPAID:
					$status = 'Unpaid';
					break;
					
				case BORROWER_REPAYMENT_STATUS_UNVERIFIED:
					$status = 'Not Approved';
					break;
					
				case BORROWER_REPAYMENT_STATUS_PAID:
					$status = 'Paid';
					break;
			
			}
			$instNum = $instNum - 1;
			$this->investor_repayment[$invId][$instNum]['payment_schedule_date'] = $schdDate;
			$this->investor_repayment[$invId][$instNum]['repayment_actual_date'] = $actDate;
			$this->investor_repayment[$invId][$instNum]['principal_component'] = number_format($prinAmt, 2, ".", ",");
			$this->investor_repayment[$invId][$instNum]['interest_component'] = number_format($intAmt, 2, ".", ",");
			$this->investor_repayment[$invId][$instNum]['repayment_penalty_interest'] = number_format($penalty, 2, ".", ",");
			$this->investor_repayment[$invId][$instNum]['total'] = number_format($total,2);
			$this->investor_repayment[$invId][$instNum]['repayment_status'] = $status;
		}
		
		$this->jsonInvRepay = json_encode($this->investor_repayment);
		
		
	}
						
}
