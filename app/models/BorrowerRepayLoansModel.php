<?php namespace App\models;
class BorrowerRepayLoansModel extends TranWrapper {
	
	public	$unpaidLoanList		=	array();
	public	$loanId				=	0;
	public	$loanRefNumber		=	"";
	public	$borrowerId			=	0;
	public	$interestAmount		=	0;
	public	$principalAmount	=	0;
	public	$penaltyAmt			=	0;
	public	$penaltyCompShare	=	0;
	public	$schedAmount		=	0;
	public	$amountPaid			=	0;
	public	$schedDate				;
	public	$repaymentDate			;
	public	$repaymentSchdId	=	0;
	public  $isOverdue			=	0;	
	public  $remarks			=  "";
	public 	$installmentNumber	=  "";
	public 	$transreference_no 	=  "";
	public 	$repaymentStatus 	=  "";
	public 	$paymentId 			=  0;
	
	public function __construct($attributes = array()){	
		
		// This will be called only from the borrower modules only
		$this->userType 		= 	$this->getUserType();
		if ($this->userType != 1) {
			// This is not a borrower. Just exit throwing an error
			return -1;
		}		
		$this->borrowerId		=	$this->getCurrentBorrowerID();		
	}
	
	public function getUnpaidLoans() {
	
		$unpaidloan_sql			=	"SELECT loans.loan_id,
										installment_number,
										repayment_schedule_id,										
										repayment_status,
										loan_reference_number ref, 
										repayment_schedule_date schd_date,
										date_format(repayment_schedule_date ,'%Y-%m') inst_period,
										if (date(repayment_schedule_date) < date(now()),
											if (penalty_type_applicable in (1,3), 
													repayment_scheduled_amount * 
														power((1 + (final_interest_rate + penalty_fixed_percent) / (100*365)), 
															datediff(now(), repayment_schedule_date)), 0) + 
											if (penalty_type_applicable in (2,3),
													ifnull(penalty_fixed_amount, 0), 0) -
											repayment_scheduled_amount, 0) penalty,
										repayment_scheduled_amount schd_amount
										
										FROM	(
												SELECT	*
												FROM 	borrower_repayment_schedule
												WHERE	repayment_status = 1 
												AND		date(repayment_schedule_date) < date(now())
												AND		borrower_id = {$this->borrowerId}
												UNION
												SELECT 	* 
												FROM 	borrower_repayment_schedule
												WHERE	repayment_status = 1 
												AND 	date(repayment_schedule_date) >= date(now())
												and		borrower_id = {$this->borrowerId}
												limit 0,2) loan_repayment, 
												loans
										WHERE	loans.loan_id = loan_repayment.loan_id 
										ORDER BY loan_id, installment_number";
								
		$this->unpaidLoanList	=	$this->dbFetchAll($unpaidloan_sql);	
			
		return;

	}

	public function newRepayment ($installmentId,$loanid) {
		
		
		// Check if the Installment is overdue or not
		$repaySched_sql					=	"SELECT 	if(datediff(now(), repayment_schedule_date) > 0, 
															'Overdue', 'Not Overdue') overdue,
													repayment_scheduled_amount,
													date_format(repayment_schedule_date,'%d-%m-%Y') repayment_schedule_date ,
													loan_id,installment_number,
													repayment_schedule_id,
													borrower_id,
													IFNULL(payment_id,0) payment_id,
													remarks,
													repayment_status
											FROM	borrower_repayment_schedule 
											WHERE	installment_number = {$installmentId} 
											AND		loan_id = {$loanid} ";
								
		$repaySched_rs					=	$this->dbFetchAll($repaySched_sql);
			
		$actualdatesql					= "SELECT date_format(CURDATE(),'%d-%m-%Y')";
		$this->repaymentDate			= $this->dbFetchOne($actualdatesql);
					
		if (count($repaySched_rs) > 0) {			
			// There will be only one row here so we are directly taking the values of the first row
			$this->isOverdue			=	$repaySched_rs[0]->overdue;
			$this->schedAmount			=	$repaySched_rs[0]->repayment_scheduled_amount;
			$this->schedDate			=	$repaySched_rs[0]->repayment_schedule_date;
			$this->loanId				=	$repaySched_rs[0]->loan_id;
			$this->borrowerId			=	$repaySched_rs[0]->borrower_id;			
			$this->installmentNumber	=	$repaySched_rs[0]->installment_number;		
			$this->repaymentSchdId		=	$repaySched_rs[0]->repayment_schedule_id;		
			$this->remarks				=	$repaySched_rs[0]->remarks;		
			$this->repaymentStatus		=	$repaySched_rs[0]->repayment_status;		
			$this->paymentId			=	$repaySched_rs[0]->payment_id;		
			if($repaySched_rs[0]->payment_id	!=	0) {
				$payment_sql				=	"	SELECT trans_reference_number
													FROM	payments
													WHERE	payment_id={$repaySched_rs[0]->payment_id}";
				
				$this->transreference_no	=	$this->dbFetchOne($payment_sql);
			}
		} else {
			// This is an error condition. Can't be true
			return -1;
		}
		//~ echo 			$this->isOverdue;
		if ($this->isOverdue == 'Overdue') {
			// Calculate the penalty amount
			$dbFormattedschedDate	=	$this->getDbDateFormat($this->schedDate);
			$dbFormattedcurDate		=	$this->getDbDateFormat($this->repaymentDate);
			
			$penaltyComp_sql		=	"SELECT	penalty_fee_percent,
												penalty_fee_minimum,
												penalty_interest
										FROM	system_settings";
										
			$penaltyComp_rs			=	$this->dbFetchAll($penaltyComp_sql);
			
			$datetime1 = new \DateTime($dbFormattedschedDate);
			$datetime2 = new \DateTime($dbFormattedcurDate);
			$interval = $datetime1->diff($datetime2);
			$delay_days	= $interval->format('%a');
			
			if (count($penaltyComp_rs) > 0) {
				if(strtotime($dbFormattedcurDate) > strtotime($dbFormattedschedDate)) {
					
					$this->penaltyAmt		=	round(($this->schedAmount*(1+
												$penaltyComp_rs[0]->penalty_interest/36500)**$delay_days)-(
													$this->schedAmount),2);
					$this->penaltyCompShare	=	round(max(($this->schedAmount	*(($penaltyComp_rs[0]->penalty_fee_percent)/
																		100)),$penaltyComp_rs[0]->penalty_fee_minimum),2);
				}
			}
		}
		// Calculate the Principal & Interest & get the loan_reference Number
		$intAmount_sql				=	"SELECT	round((loan_sanctioned_amount - sum(principal_component)) * 
													(final_interest_rate / 1200), 2) interest_component,
												loan_reference_number
										FROM	borrower_repayment_schedule, loans
										WHERE	loans.loan_id = {$this->loanId}
										AND		borrower_repayment_schedule.loan_id = loans.loan_id 
										AND		borrower_repayment_schedule.repayment_status = 3";
		//print_r($intAmount_sql);
		$intAmount_Rs				=	$this->dbFetchAll($intAmount_sql);
		
		if (count($intAmount_Rs) > 0) {
			$this->loanRefNumber	=	$intAmount_Rs[0]->loan_reference_number;
			$this->interestAmount	=	$intAmount_Rs[0]->interest_component;
			$this->principalAmount	=	$this->schedAmount - $this->interestAmount;
			$this->amountPaid		=	$this->schedAmount + $this->penaltyAmt;
			
		} else {
			// Not possible -- Just return -1 
			return -1;
		}	
	}	
	
	public function saveRepayment($postArray) {
		
		//~ echo "<pre>",print_r($postArray),"</pre>"	;
		//~ die;
		// Values expected from the request
		// For the borrowers' table
		$this->loanId 				= 	$postArray["loan_id"];
		$this->borrowerId			=	$postArray["borrower_id"];
		$this->amountPaid 			=  	$postArray["amount_Paid"];
		$this->principalAmount		=	$postArray["principal_amount"];
		$this->interestAmount		=	$postArray["interest_amount"];
		$this->penaltyAmt			=	$postArray["penalty_amount"];
		$this->penaltyCompShare		=	$postArray["penalty_companyshare"];
	//	$this->trans_date			=	$this->repaymentDate;       //$this->getDbDateFormat($postArray["actualdate"]);
		$this->repaymentSchdId		=	$postArray["repaymentSchdId"];
		$this->remarks				=	$postArray["repay_remarks"];
		$this->schedDate			=	$this->getDbDateFormat($postArray["duedate"]); 
		$this->repaymentDate		=	$this->getDbDateFormat($postArray["actual_date"]); 
		$this->installmentNumber	=	$postArray["installment_number"];
		$this->paymentId 			=	$postArray["payment_id"];
		
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes"){
			$repaymentStatus			=	BORROWER_REPAYMENT_STATUS_PAID; 
			$paymentStatus				=	PAYMENT_STATUS_VERIFIED;
			
		}else{
			$repaymentStatus			=	BORROWER_REPAYMENT_STATUS_UNVERIFIED; 
			$paymentStatus				=	PAYMENT_STATUS_UNVERIFIED;
		}
				
		// For the Payments Table
		//	$transInOrOut				=	1; // Hardcoded to signify inwards
		$currency					=	'SGD'; // Hardcoded value
		$transReference				=	$postArray["trans_ref"];
		//	currency: SGD (hardcode)
		//  trans_reference_number: Obtained from Screen
		//  Status: 1 (unverified --> Hardcode)
		
		$paymentInsert_data		=	array(
											'trans_date' => $this->repaymentDate,
											'trans_type' => PAYMENT_TRANSCATION_LOAN_REPAYMENT,							
											'trans_amount' => $this->amountPaid,
											'currency' => $currency,
											'trans_reference_number' => $transReference,
											'status' => $paymentStatus,
											'remarks' => $this->remarks);
		if($this->paymentId	==	0) {	
			$this->paymentId 		=	$this->dbInsert("payments", $paymentInsert_data, 1);
		}else{
			$whereArry	=	array("payment_id" =>"{$this->paymentId}");
			$this->dbUpdate('payments', $paymentInsert_data, $whereArry);
		}
		
			// Update the Borrower Repayment Schedule Table
		$repayUpdateBor_data			=	array(								
												'repayment_status' 				=> $repaymentStatus,
												'payment_id' 					=> $this->paymentId ,
												'repayment_actual_date'			=> $this->repaymentDate,
												'repayment_penalty_interest'	=> $this->penaltyAmt,
												'repayment_penalty_charges'		=> $this->penaltyCompShare,
												'remarks' 						=> $this->remarks);
			
		$whereArry	=	array("repayment_schedule_id" =>"{$this->repaymentSchdId}");
		$this->dbUpdate('borrower_repayment_schedule', $repayUpdateBor_data, $whereArry);
		
			// Update the Investor Repayment Schedule Table
		$repayUpdateInv_data			=	array(								
												'status' 				=> $repaymentStatus,
												'payment_date' 			=> $this->repaymentDate ,
												'penalty_amount'		=> $this->penaltyAmt);
			
		$whereArry	=	array("loan_id" =>"{$this->loanId}",
								"installment_number" =>"{$this->installmentNumber}");
		$this->dbUpdate('investor_repayment_schedule', $repayUpdateInv_data, $whereArry);
	}
	
	public function getAllBorrowerRepaymentLoans() {
	
		$repaymentloan_sql			=	"SELECT 	loans.loan_id,
													installment_number,
													repayment_schedule_id,										
													repayment_status,
													loan_reference_number ref, 
													repayment_schedule_date schd_date,
													ifnull(repayment_actual_date ,'') act_date,
													date_format(repayment_schedule_date ,'%Y-%m') inst_period,
													ROUND(if (date(repayment_schedule_date) < date(now()),
															if (penalty_type_applicable in (1,3), 
																	repayment_scheduled_amount * 
																		power((1 + (final_interest_rate + penalty_fixed_percent) / (100*365)), 
																			datediff(now(), repayment_schedule_date)), 0) + 
															if (penalty_type_applicable in (2,3),
																	ifnull(penalty_fixed_amount, 0), 0) -
															repayment_scheduled_amount, 0),2) penalty,
													ROUND(repayment_scheduled_amount,2) schd_amount,
													CASE repayment_status
														   when '1' and (datediff(now(), repayment_schedule_date) > 0)
																	then	'Overdue'
														   when '1' then  	'Unpaid'
														   when '2' then 	'Not Approved'
														   when '3' then 	'Approved'
													END as repayment_status,
													repayment_status dataStatus,
													IFNULL(payments.trans_reference_number,'') trans_reference_number
													
													FROM	(
																SELECT 		*	 
																FROM 		borrower_repayment_schedule
																WHERE 		repayment_status in (1,2)
																GROUP BY 	loan_id
																HAVING 		repayment_schedule_date = MIN(repayment_schedule_date)
																UNION
																SELECT 		* 
																FROM 		borrower_repayment_schedule
																WHERE 		repayment_status = 3
																GROUP BY 	loan_id
																HAVING 		repayment_schedule_date = MIN(repayment_schedule_date)
																
															) loan_repayment
															LEFT JOIN	payments
															ON	loan_repayment.payment_id	=	payments.payment_id,
															loans
													WHERE	loans.loan_id = loan_repayment.loan_id ";
								
		$this->repaymentLoanList	=	$this->dbFetchAll($repaymentloan_sql);	
		
		return;

	}
	public function recalculatePenality($postArray) {
		
		$schRepDate				=	$postArray['schRepDate'];
		$actRepDate				=	$postArray['actRepDate'];
		$principalAmt			=	$postArray['principalAmt'];
		$interestAmt			=	$postArray['interestAmt'];
		$schedAmount			=	$principalAmt	+	$interestAmt;
		$dbFormattedschedDate	=	$this->getDbDateFormat($schRepDate);
		$dbFormattedcurDate		=	$this->getDbDateFormat($actRepDate);
		
		if(strtotime($dbFormattedcurDate) > strtotime($dbFormattedschedDate)) {
			
			
			$penaltyComp_sql		=	"SELECT	penalty_fee_percent,
												penalty_fee_minimum,
												penalty_interest
										FROM	system_settings";
										
			$penaltyComp_rs			=	$this->dbFetchAll($penaltyComp_sql);
			
			$datetime1 = new \DateTime($dbFormattedschedDate);
			$datetime2 = new \DateTime($dbFormattedcurDate);
			$interval = $datetime1->diff($datetime2);
			$delay_days	= $interval->format('%a');
			
			$penaltyAmt				=	round(($schedAmount*(1+
													$penaltyComp_rs[0]->penalty_interest/36500)**$delay_days)-(
													$schedAmount),2);
			$penaltyCompShare		=	round(max(($schedAmount	*(($penaltyComp_rs[0]->penalty_fee_percent)/
																100)),$penaltyComp_rs[0]->penalty_fee_minimum),2);
			$amountPaid				=	$schedAmount	+	$penaltyAmt;
		}else{
			
			$penaltyAmt				=	0;
			$penaltyCompShare		=	0;
			$amountPaid				=	$schedAmount	+	$penaltyAmt;
		}
		return	array(	"amountPaid"=>$amountPaid,
						"penaltyAmt"=>$penaltyAmt,
						"penaltyCompShare"=>$penaltyCompShare
						);
	}
	
	public function approveBorrowerRepayment($repayment_schedule_id) {
		$loanInstallmentIds	=	$this->getloanInstallmentIds($repayment_schedule_id);
		$this->newRepayment ($loanInstallmentIds[0]->installment_number,$loanInstallmentIds[0]->loan_id);
		$dataArray			=	array(
										"loan_id"				=>	$this->loanId,
										"borrower_id"			=>	$this->borrowerId,
										"amount_Paid"			=>	$this->amountPaid,
										"principal_amount"		=>	$this->principalAmount,
										"interest_amount"		=>	$this->interestAmount,
										"penalty_amount"		=>	$this->penaltyAmt,
										"penalty_companyshare"	=>	$this->penaltyCompShare,
										"repaymentSchdId"		=>	$this->repaymentSchdId,
										"repay_remarks"			=>	$this->remarks,
										"duedate"				=>	$this->schedDate,
										"actual_date"			=>	$this->repaymentDate,
										"installment_number"	=>	$this->installmentNumber,
										"payment_id"			=>	$this->paymentId,
										"isSaveButton"			=>	"no",
										"trans_ref"				=>	$this->transreference_no
									);
		if($this->transreference_no!="") {
				$this->saveRepayment($dataArray);
		}
	}
	
	public function bulkApproveBorrowerRepayment($postArray) {
		
		foreach($postArray['repayment_schedule'] as $repayment_schedule_id) {
			$this->approveBorrowerRepayment($repayment_schedule_id);
		}
	}
}
