<?php namespace App\models;
class BorrowerRepayLoansModel extends TranWrapper {
	
	public	$unpaidLoanList		=	array();
	public	$loanId				=	0;
	public	$loanRefNumber		=	"";
	public	$borrowerId			=	0;
	public	$interestAmount		=	0;
	public	$principalAmount	=	0;
	public	$penaltyAmt			=	0;
	public	$schedAmount		=	0;
	public	$amountPaid			=	0;
	public	$schedDate				;
	public	$repaymentDate			;
	public	$repaymentSchdId	=	0;
	public  $isOverdue			=	0;	
	public  $remarks			=  "";
	public 	$installmentNumber	=  "";
	
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
	
		$unpaidloan_sql			=	"SELECT 	loans.loan_id,
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
										WHERE	loans.loan_id = loan_repayment.loan_id ";
								
		$this->unpaidLoanList	=	$this->dbFetchAll($unpaidloan_sql);	
			
		return;

	}

	public function newRepayment ($installmentId,$loanid) {
		$this->repaymentSchdId			=	$installmentId;	
		
		// Check if the Installment is overdue or not
		$repaySched_sql					=	"SELECT 	if(datediff(now(), repayment_schedule_date) > 0, 
															'Overdue', 'Not Overdue') overdue,
													repayment_scheduled_amount,
													repayment_schedule_date,
													loan_id,installment_number,
													borrower_id
											FROM	borrower_repayment_schedule 
											WHERE	repayment_schedule_id = {$installmentId} 
											AND		loan_id = {$loanid} ";
								
		$repaySched_rs					=	$this->dbFetchAll($repaySched_sql);
			
		$actualdatesql					= "SELECT CURDATE()";
		$this->repaymentDate			= $this->dbFetchOne($actualdatesql);
					
		if (count($repaySched_rs) > 0) {			
			// There will be only one row here so we are directly taking the values of the first row
			$this->isOverdue			=	$repaySched_rs[0]->overdue;
			$this->schedAmount			=	$repaySched_rs[0]->repayment_scheduled_amount;
			$this->schedDate			=	$repaySched_rs[0]->repayment_schedule_date;
			$this->loanId				=	$repaySched_rs[0]->loan_id;
			$this->borrowerId			=	$repaySched_rs[0]->borrower_id;			
			$this->installmentNumber	=	$repaySched_rs[0]->installment_number;			
		} else {
			// This is an error condition. Can't be true
			return -1;
		}
		
		if ($this->isOverdue == 'Overdue') {
			// Calculate the penalty amount
			$penalty_sql			=	"SELECT	if (penalty_type_applicable in (1,3), 
													{$this->schedAmount} * 
														power((1 + (final_interest_rate + penalty_fixed_percent) / (100*365)), 
														datediff(now(), '{$this->schedDate}')) + 
												if (penalty_type_applicable in (2,3),
														ifnull(penalty_fixed_amount, 0), 0) -
												{$this->schedAmount}, 0) penalty 
										FROM	loans
										WHERE	loan_id = {$this->loanId}";
			$this->penaltyAmt		=	$this->dbFetchOne($penalty_sql);
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
				
		// Values expected from the request
		// For the borrowers' table
		$this->loanId 				= 	$postArray["loan_id"];
		$this->borrowerId			=	$postArray["borrower_id"];
		$this->amountPaid 			=  	$postArray["amount_Paid"];
		$this->principalAmount		=	$postArray["principal_amount"];
		$this->interestAmount		=	$postArray["interest_amount"];
		$this->penaltyAmt			=	$postArray["penalty_amount"];
	//	$this->trans_date			=	$this->repaymentDate;       //$this->getDbDateFormat($postArray["actualdate"]);
		$this->repaymentSchdId		=	$postArray["repaymentSchdId"];
		$this->remarks				=	$postArray["repay_remarks"];
		$this->schedDate			=	$this->getDbDateFormat($postArray["duedate"]); 
		$this->installmentNumber	=	$postArray["installment_number"];
		$repaymentStatus			=	BORROWER_REPAYMENT_STATUS_UNVERIFIED; // Hardcoded to signify Unverified 
				
		// For the Payments Table
		//	$transInOrOut				=	1; // Hardcoded to signify inwards
		$currency					=	'SGD'; // Hardcoded value
		$transReference				=	$postArray["trans_ref"];
		//	currency: SGD (hardcode)
		//  trans_reference_number: Obtained from Screen
		//  Status: 1 (unverified --> Hardcode)

		$paymentInsert_data			=	array(
										'trans_date' => $this->repaymentDate,
										'trans_type' => PAYMENT_TRANSCATION_LOAN_REPAYMENT,							
										'trans_amount' => $this->amountPaid,
										'currency' => $currency,
										'trans_reference_number' => $transReference,
										'status' => PAYMENT_STATUS_UNVERIFIED,
										'remarks' => $this->remarks);
		
		$paymentId 					=	$this->dbInsert("payments", $paymentInsert_data, 1);
	
		$repayInsert_data			=	array(								
										'loan_id' => $this->loanId,
										'borrower_id' => $this->borrowerId,
										'installment_number' => $this->installmentNumber,	 						
										'repayment_schedule_date' => $this->schedDate,
										'repayment_scheduled_amount' => $this->amountPaid,
										'principal_component' => $this->principalAmount,
										'interest_component' => $this->interestAmount,
										'repayment_status' => $repaymentStatus,
										'payment_id' => $paymentId ,
										'repayment_actual_date'	=> $this->repaymentDate,
										'repayment_penalty_amount'	=> $this->penaltyAmt,									
										'remarks' => $this->remarks);
			
		$this->dbInsert("borrower_repayment_schedule", $repayInsert_data, 0);		
	}
}
