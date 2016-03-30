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
	public	$schedDate;
	public	$repaymentDate;
	public	$repaymentSchdId	=	0;
	public  $isOverdue			=	0;
	public 	$todaydate			=  "";
	public  $remarks			=  "";
	
	
	
	
	public function __construct($attributes = array()){	
		
		// This will be called only from the borrower modules only
		$this->userType 		= 	$this->getUserType();
		if ($this->userType != 1) {
			// This is not a borrower. Just exit throwing an error
			return -1;
		}
		
		$this->borrowerId	=	$this->getCurrentBorrowerID();
		
	}
	
	public function getUnpaidLoans() {
	//	print_r($this->borrowerId);
		$unpaidloan_sql	=	"	SELECT 	repayment_schedule_id,
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
										FROM 	loan_repayment_schedule
										WHERE	repayment_status = 1 
										AND		date(repayment_schedule_date) < date(now())
										AND		borrower_id = {$this->borrowerId}
										UNION
										SELECT 	* 
										FROM 	loan_repayment_schedule
										WHERE	repayment_status = 1 
										AND 	date(repayment_schedule_date) >= date(now())
										and		borrower_id = {$this->borrowerId}
										limit 0,2) loan_repayment, 
										loans
								WHERE	loans.loan_id = loan_repayment.loan_id ";
								
		$this->unpaidLoanList	=	$this->dbFetchAll($unpaidloan_sql);	
		//echo '<pre>',print_r($unpaidLoanList),'</pre>';
		//die;
		return;

	}

	public function newRepayment ($installmentId) {
		$this->repaymentSchdId		=	$installmentId;	
		
			// Check if the Installment is overdue or not
			$repaySched_sql	=	"	SELECT 	if(datediff(now(), repayment_schedule_date) < 0, 
													'Overdue', 'Not Overdue') overdue,
											repayment_scheduled_amount,
											repayment_schedule_date,
											loan_id,
											borrower_id
									FROM	loan_repayment_schedule 
									WHERE	repayment_schedule_id = {$installmentId} ";
									
			$repaySched_rs	=	$this->dbFetchAll($repaySched_sql);
			
			$todaysdatesql			= "SELECT CURDATE()";
			$this->todaydate		= $this->dbFetchOne($todaysdatesql);
			
			//~ print_r($repaySched_sql);
			if (count($repaySched_rs) > 0) {
				// There will be only one row here so we are directly taking the values of the first row
				$this->isOverdue	=	$repaySched_rs[0]->overdue;
				$this->schedAmount	=	$repaySched_rs[0]->repayment_scheduled_amount;
				$this->schedDate	=	$repaySched_rs[0]->repayment_schedule_date;
				$this->loanId		=	$repaySched_rs[0]->loan_id;
				$this->borrowerId	=	$repaySched_rs[0]->borrower_id;
			} else {
				// This is an error condition. Can't be true
				return -1;
			}
			
			if ($this->isOverdue == 'Overdue') {
				// Calculate the penalty amount
				//~ $penalty_sql	=	"	SELECT	(if (penalty_type_applicable in (1,3), 
													//~ {$this->schedAmount} * 
														//~ power((1 + (final_interest_rate + penalty_fixed_percent) / (100*365)), 
														//~ datediff(now(), {$this->schedDate})), 0) + 
												//~ if (penalty_type_applicable in (2,3),
														//~ ifnull(penalty_fixed_amount, 0), 0) -
												//~ {$this->schedAmount}, 0) penalty 
										//~ FROM	loans
										//~ WHERE	loan_id = {$this->loanId}";
				$penalty_sql	=	"	SELECT	if (penalty_type_applicable in (1,3), 
													{$this->schedAmount} * 
														power((1 + (final_interest_rate + penalty_fixed_percent) / (100*365)), 
														datediff(now(), {$this->schedDate})) + 
												if (penalty_type_applicable in (2,3),
														ifnull(penalty_fixed_amount, 0), 0) -
												{$this->schedAmount}, 0) penalty 
										FROM	loans
										WHERE	loan_id = {$this->loanId}";
				$this->penaltyAmt	=	$this->dbFetchOne($penalty_sql);
			}

			// Calculate the Principal & Interest & get the loan_reference Number
			$intAmount_sql	=	"	SELECT	round((loan_sanctioned_amount - sum(principal_paid)) * 
												(final_interest_rate / 1200), 2) interest_amount,
											loan_reference_number
									FROM	borrower_repayments, loans
									WHERE	loans.loan_id = {$this->loanId}
									AND		borrower_repayments.loan_id = loans.loan_id 
									AND		borrower_repayments.status = 2";


			$intAmount_Rs	=	$this->dbFetchAll($intAmount_sql);
			if (count($intAmount_Rs) > 0) {
				$this->loanRefNumber	=	$intAmount_Rs[0]->loan_reference_number;
				$this->interestAmount	=	$intAmount_Rs[0]->interest_amount;
				$this->principalAmount	=	$this->schedAmount - $this->interestAmount;
				$this->amountPaid		=	$this->schedAmount + $this->penaltyAmt;
			} else {
				// Not possible -- Just return -1 
				return -1;
			}
		
		
	}
	
	
	public function saveRepayment($postArray) {
		//print_r($postArray["actualdate"]);
		
		// Values expected from the request
		// For the borrowers' table
		$this->loanId 			= 	$postArray["loan_id"];
		$this->borrowerId		=	$postArray["borrower_id"];
		$this->amountPaid 		=  	$postArray["amount_Paid"];
		$this->principalAmount	=	$postArray["principal_amount"];
		$this->interestAmount	=	$postArray["interest_amount"];
		$this->penaltyAmt		=	$postArray["penalty_amount"];
		$this->trans_date		=	$postArray["actualdate"];
		$this->repaymentSchdId	=	$postArray["repaymentSchdId"];
		$this->remarks			=	$postArray["repay_remarks"];
		$repaymentStatus		=	1; // Hardcoded to signify Unverified 
				
		// For the Payments Table
		$transInOrOut			=	1; // Hardcoded to signify inwards
		$currency				=	'SGD'; // Hardcoded value
		$transReference			=	$postArray["trans_ref"];
		//	currency: SGD (hardcode)
		//  trans_reference_number: Obtained from Screen
		//  Status: 1 (unverified --> Hardcode)

		$paymentInsert_data	=	array(
									'loan_id' => $this->loanId,
									'trans_date' => $this->trans_date,
									'trans_type' => 2,
									'xref_id' => $this->repaymentSchdId,
									'trans_in_out' => $transInOrOut,
									'trans_amount' => $this->amountPaid,
									'currency' => 'SGD',
									'trans_reference_number' => $transReference,
									'status' => 1,
									'remarks' => $this->remarks);

		$paymentId 			=	$this->dbInsert("payments", $paymentInsert_data, 1);
		
		$repayInsert_data	=	array(
									'loan_id' => $this->loanId,
									'trans_date' => $this->trans_date,
									'borrower_id' => $this->borrowerId,
									'repayment_schedule_id' => $this->repaymentSchdId,
									'amount_paid' => $this->amountPaid,
									'interest_paid' => $this->interestAmount,
									'principal_paid' => $this->principalAmount,
									'penalty_paid' => $this->penaltyAmt,
									'payment_id' => $paymentId,
									'status' => 1,
									'remarks' => $this->remarks);
									
		$this->dbInsert("borrower_repayments", $repayInsert_data, 0);
		
	}
}
