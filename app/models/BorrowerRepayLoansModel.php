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
	public 	$borrower_name 		=  "";
	
	public function __construct($attributes = array()){	
		
		// This will be called only from the borrower modules only
		$this->userType 		= 	$this->getUserType();
		if ($this->userType != 1) {
			// This is not a borrower. Just exit throwing an error
			return -1;
		}		
		$this->borrowerId		=	$this->getCurrentBorrowerID();		
	}
	public function getLoanRefNo($repaySchdId) {
		$sql	=	"	SELECT	loan_reference_number 
						FROM	loans, borrower_repayment_schedule
						WHERE	loans.loan_id = borrower_repayment_schedule.loan_id
						AND		repayment_schedule_id = $repaySchdId";
		$this->loanRefNumber = $this->dbFetchOne($sql);
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
	public function getRepaymentDetails($repaymentId ,$loanid) {
		
			$repaySched_sql		=	"	SELECT 	repayment_status
										FROM	borrower_repayment_schedule 
										WHERE	repayment_schedule_id = {$repaymentId} 
										AND		loan_id = {$loanid} ";
								
		$repaySched_status		=	$this->dbFetchOne($repaySched_sql);
		
		if($repaySched_status	==	BORROWER_REPAYMENT_STATUS_UNPAID) { //check whether repayment paid or unpaid
			$this->newRepayment ($repaymentId ,$loanid);
		}else{
			$this->getSavdRepayment ($repaymentId ,$loanid);
		}
	}
	
	public function getSavdRepayment ($repaymentId ,$loanid) {
	
	
		$repaySched_sql					=	"SELECT	repayment_scheduled_amount,
													date_format(repayment_schedule_date,'%d-%m-%Y') repayment_schedule_date ,
													date_format(repayment_actual_date,'%d-%m-%Y') repayment_actual_date ,
													loan_id, 
													(
														SELECT 	loan_reference_number 
														FROM 	loans 
														WHERE 	loans.loan_id=borrower_repayment_schedule.loan_id
													) loan_reference_number, 
													installment_number,
													principal_component,
													interest_component,
													repayment_schedule_id,
													borrower_id,
													payment_id,
													(
														SELECT 	trans_reference_number
														FROM	payments
														WHERE	payments.payment_id=borrower_repayment_schedule.payment_id
													) trans_reference_number,
													remarks,
													repayment_penalty_interest,
													repayment_penalty_charges,
													(
														SELECT 	trans_amount
														FROM	payments
														WHERE	payments.payment_id=borrower_repayment_schedule.payment_id
													) trans_amount,
													(
														SELECT 	business_name 
														FROM 	borrowers 
														WHERE 	borrowers.borrower_id=borrower_repayment_schedule.borrower_id
													) borrower_name,
													repayment_status
											FROM	borrower_repayment_schedule
											WHERE	repayment_schedule_id = {$repaymentId} 
											AND		borrower_repayment_schedule.loan_id = {$loanid} ";
								
		$repaySched_rs					=	$this->dbFetchAll($repaySched_sql);
			
		if (count($repaySched_rs) > 0) {			
			// There will be only one row here so we are directly taking the values of the first row
			$this->loanRefNumber		=	$repaySched_rs[0]->loan_reference_number;
			$this->schedAmount			=	$repaySched_rs[0]->repayment_scheduled_amount;
			$this->schedDate			=	$repaySched_rs[0]->repayment_schedule_date;
			$this->repaymentDate		= 	$repaySched_rs[0]->repayment_actual_date;
			$this->loanId				=	$repaySched_rs[0]->loan_id;
			$this->borrowerId			=	$repaySched_rs[0]->borrower_id;			
			$this->installmentNumber	=	$repaySched_rs[0]->installment_number;		
			$this->principalAmount		=	$repaySched_rs[0]->principal_component;
			$this->interestAmount		=	$repaySched_rs[0]->interest_component;
			$this->repaymentSchdId		=	$repaySched_rs[0]->repayment_schedule_id;		
			$this->transreference_no	=	$repaySched_rs[0]->trans_reference_number;		
			$this->remarks				=	$repaySched_rs[0]->remarks;		
			$this->repaymentStatus		=	$repaySched_rs[0]->repayment_status;		
			$this->paymentId			=	$repaySched_rs[0]->payment_id;	
			$this->penaltyAmt			=	$repaySched_rs[0]->repayment_penalty_interest;	
			$this->penaltyCompShare		=	$repaySched_rs[0]->repayment_penalty_charges;	
			$this->amountPaid			=	$repaySched_rs[0]->trans_amount;	
			$this->borrower_name		=	$repaySched_rs[0]->borrower_name;	
		} else {
			// This is an error condition. Can't be true
			return -1;
		}
			
	}	
	
	public function newRepayment ($repaymentId ,$loanid) {
		// Check if the Installment is overdue or not
		$repaySched_sql					=	"SELECT if(datediff(now(), repayment_schedule_date) > 0, 
															'Overdue', 'Not Overdue') overdue,
													repayment_scheduled_amount,
													date_format(repayment_schedule_date,'%d-%m-%Y') repayment_schedule_date ,
													loans.loan_id,
													loan_reference_number,
													installment_number,
													principal_component,
													interest_component,
													repayment_penalty_interest,
													repayment_penalty_charges,
													repayment_schedule_id,
													loans.borrower_id,
													IFNULL(borrower_repayment_schedule.payment_id,0) payment_id,
													payments.trans_reference_number,
													payments.remarks,
													repayment_status,
													(	SELECT 	business_name 
														FROM 	borrowers 
														WHERE 	borrowers.borrower_id=borrower_repayment_schedule.borrower_id
													) borrower_name
											FROM	borrower_repayment_schedule 
													LEFT OUTER JOIN payments
														on payments.payment_id = borrower_repayment_schedule.payment_id,
													loans
											WHERE	loans.loan_id = borrower_repayment_schedule.loan_id
											AND		repayment_schedule_id = {$repaymentId} 
											AND		loans.loan_id = {$loanid} ";
								
		$repaySched_rs					=	$this->dbFetchAll($repaySched_sql);
			
		$actualdatesql					= "SELECT date_format(CURDATE(),'%d-%m-%Y')";
		$this->repaymentDate			= $this->dbFetchOne($actualdatesql);
					
		if (count($repaySched_rs) > 0) {			
			// There will be only one row here so we are directly taking the values of the first row
			$this->loanRefNumber		=	$repaySched_rs[0]->loan_reference_number;
			$this->isOverdue			=	$repaySched_rs[0]->overdue;
			$this->schedAmount			=	$repaySched_rs[0]->repayment_scheduled_amount;
			$this->schedDate			=	$repaySched_rs[0]->repayment_schedule_date;
			$this->loanId				=	$repaySched_rs[0]->loan_id;
			$this->borrowerId			=	$repaySched_rs[0]->borrower_id;			
			$this->installmentNumber	=	$repaySched_rs[0]->installment_number;		
			$this->principalAmount		=	$repaySched_rs[0]->principal_component;
			$this->interestAmount		=	$repaySched_rs[0]->interest_component;
			$this->penaltyInt			=	$repaySched_rs[0]->repayment_penalty_interest;
			$this->penaltyFee			=	$repaySched_rs[0]->repayment_penalty_charges;
			$this->repaymentSchdId		=	$repaySched_rs[0]->repayment_schedule_id;		
			$this->transreference_no	=	$repaySched_rs[0]->trans_reference_number;		
			$this->remarks				=	$repaySched_rs[0]->remarks;		
			$this->repaymentStatus		=	$repaySched_rs[0]->repayment_status;		
			$this->paymentId			=	$repaySched_rs[0]->payment_id;	
			$this->borrower_name		=	$repaySched_rs[0]->borrower_name;
			
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
		
		if ($this->penaltyInt > 0 || $this->penaltyFee) {
			// The admin has already fixed the penalty amount. You don't have to calculate the penalty amount
			$this->penaltyAmt = $this->penaltyInt + $this->penaltyFee;
			$this->penaltyCompShare = $this->penaltyFee;
		} else {
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
		}
		
		$this->amountPaid		=	$this->schedAmount + $this->penaltyAmt;
			
	}	
	
	public function approvePayments($loanId, $instNum) {

		// Approve the payment in the Payment Table
		$payId_sql		=	"	SELECT 	payment_id
								FROM	borrower_repayment_schedule
								WHERE	loan_id = :loan_id
								AND		installment_number = :inst_num ";
		
		$whereArray		=	Array( 	"inst_num"	=> $instNum,
									"loan_id"	=> $loanId);
		
		$payId_rs		=	$this->dbFetchWithParam($payId_sql, $whereArray); 

		
		$paymentId		=	$payId_rs[0]->payment_id;
		
		$dataArray		=	Array (	"status"	=>	PAYMENT_STATUS_VERIFIED);
		$whereArray		=	Array ( "payment_id"	=> $paymentId);
		
		$this->dbUpdate("payments", $dataArray, $whereArray);
		// Approve the payments in the borrower repayment table
		$dataArray		=	Array (	"repayment_status" 	=>	BORROWER_REPAYMENT_STATUS_PAID);
		$whereArray		=	Array ( "loan_id"			=>	$loanId,
									"installment_number"=>	$instNum);
									
		$this->dbUpdate("borrower_repayment_schedule", $dataArray, $whereArray);

		// Approve the payments in the investor_repayment table
		$dataArray		=	Array (	"status"	=>	INVESTOR_REPAYMENT_STATUS_VERIFIED);
		$whereArray		=	Array ( "loan_id"			=>	$loanId,
									"installment_number"=>	$instNum);
		$this->dbUpdate("investor_repayment_schedule", $dataArray, $whereArray);
		
		//=================== Send mail to borrower repayment approved starts =====================================
		
		$borrUserInfo		=	$this->getBorrowerIdByUserInfo($this->borrowerId);
		$borrInfo			=	$this->getBorrowerInfoById($this->borrowerId);
		$moneymatchSettings = $this->getMailSettingsDetail();
		$slug_name			=	"repayment_approved";
		$fields 			= array(
									'[borrower_contact_person]',
									'[installment_number]',
									'[loan_number]',
									'[application_name]');
		$replace_array 		= array();
		$replace_array 		= 	array( 
										$borrInfo->contact_person, 
										$instNum,
										$this->loanRefNumber,
										$moneymatchSettings[0]->application_name);
		$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
		
		//====================Send mail to borrower repayment approved ends ========================================
		
		// Update the Investor Available Balance
		$invList_sql	=	"	SELECT	investor_id,
										payment_schedule_amount + ifnull(penalty_amount, 0) payAmt
								FROM	investor_repayment_schedule
								WHERE	loan_id	=	:loan_id
								AND		installment_number = :inst_num ";

		unset($whereArray);
		$whereArray		=	Array( 	"inst_num"	=> $instNum,
									"loan_id"	=> $loanId);

		
		$invList_rs		=	$this->dbFetchWithParam($invList_sql, $whereArray);
		
		foreach ($invList_rs as $invList_row) {
			$invId		=	$invList_row->investor_id;
			$payAmt		=	$invList_row->payAmt;
			
			$updSql		=	"	UPDATE	investors
								SET		available_balance = available_balance + {$payAmt} 
								WHERE	investor_id = {$invId}";
			
			$this->dbExecuteSql($updSql);
			//=================== Send mail to investor repayment received starts =====================================

			$invUserInfo		=	$this->getInvestorIdByUserInfo($invId);
			$moneymatchSettings = 	$this->getMailSettingsDetail();
			$slug_name			=	"repayment_received_investor";
			$available_balance	=	$this->getInvestorAvailableBalanceById($invId);
			$fields 			= array(
										'[investor_firstname]',
										'[investor_lastname]',
										'[installment_number]',
										'[loan_number]',
										'[investor_current_balance]',
										'[application_name]');
			$replace_array 		= array();
			$replace_array 		= 	array( 
											$invUserInfo->firstname, 
											$invUserInfo->lastname, 
											$instNum,
											$this->loanRefNumber,
											$available_balance,
											$moneymatchSettings[0]->application_name);
			$this->sendMailByModule($slug_name,$invUserInfo->email,$fields,$replace_array);
			
			//====================Send mail to investor repayment received ends =======================================
		}									
		$status	=	$this->checkLoanRepaymentCompleted($loanId);
		if($status) {
			//=================== Send mail to borrower repayment completed starts =====================================
			
			$borrUserInfo		=	$this->getBorrowerIdByUserInfo($this->borrowerId);
			$borrInfo			=	$this->getBorrowerInfoById($this->borrowerId);
			$moneymatchSettings = 	$this->getMailSettingsDetail();
			$slug_name			=	"loan_repayment_complete";
			$fields 			= array(
										'[borrower_contact_person]',
										'[installment_number]',
										'[loan_number]',
										'[application_name]');
			$replace_array 		= array();
			$replace_array 		= 	array( 
											$borrInfo->contact_person, 
											$instNum,
											$this->loanRefNumber,
											$moneymatchSettings[0]->application_name);
			$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
			
			//====================Send mail to borrower repayment completed ends =======================================
			$this->updateBorrowerApplyLoanStatus($loanId,LOAN_STATUS_LOAN_REPAID);
		}	
	}

	public function unapprovePayments($loanId, $instNum) {

		
		// Approve the payment in the Payment Table
		$payId_sql		=	"	SELECT 	payment_id, loan_reference_number,borrower_repayment_schedule.borrower_id
								FROM	borrower_repayment_schedule, loans
								WHERE	borrower_repayment_schedule.loan_id = :loan_id
								AND		installment_number = :inst_num 
								AND		borrower_repayment_schedule.loan_id = loans.loan_id";
		
		$whereArray		=	Array( 	"inst_num"	=> $instNum,
									"loan_id"	=> $loanId);
		
		$payId_rs		=	$this->dbFetchWithParam($payId_sql, $whereArray); 

		
		$paymentId		=	$payId_rs[0]->payment_id;
		$loanRefNumber	=	$payId_rs[0]->loan_reference_number;
		$borrowerId		=	$payId_rs[0]->borrower_id;
		
		$dataArray		=	Array (	"status"	=>	PAYMENT_STATUS_UNVERIFIED);
		$whereArray		=	Array ( "payment_id"	=> $paymentId);

		$moduleName	=	"Loan Repayment";
		$actionSumm =	"Unapproval";
		$actionDet  =	"Unapproval of Loan Repayment";
		
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"Loan Reference Nu",$this->loan_reference_number);	
		
		$this->dbUpdate("payments", $dataArray, $whereArray);
		// Approve the payments in the borrower repayment table
		$dataArray		=	Array (	"repayment_status" 	=>	BORROWER_REPAYMENT_STATUS_UNVERIFIED);
		$whereArray		=	Array ( "loan_id"			=>	$loanId,
									"installment_number"=>	$instNum);
									
		$this->dbUpdate("borrower_repayment_schedule", $dataArray, $whereArray);

		// Approve the payments in the investor_repayment table
		$dataArray		=	Array (	"status"	=>	INVESTOR_REPAYMENT_STATUS_PAID);
		$whereArray		=	Array ( "loan_id"			=>	$loanId,
									"installment_number"=>	$instNum);
		$this->dbUpdate("investor_repayment_schedule", $dataArray, $whereArray);
		
		//=================== Send mail to borrower repayment unapproved starts =====================================
		
		$borrUserInfo		=	$this->getBorrowerIdByUserInfo($borrowerId);
		$borrInfo			=	$this->getBorrowerInfoById($borrowerId);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		$slug_name			=	"repayment_unapproved";
		$fields 			= array(
									'[borrower_contact_person]',
									'[installment_number]',
									'[loan_number]',
									'[application_name]');
		$replace_array 		= array();
		$replace_array 		= 	array( 
										$borrInfo->contact_person, 
										$instNum,
										$loanRefNumber,
										$moneymatchSettings[0]->application_name);
		$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
		
		//====================Send mail to borrower repayment unapproved ends ========================================
		// Update the Investor Available Balance
		$invList_sql	=	"	SELECT	investor_id,
										payment_schedule_amount + ifnull(penalty_amount, 0) payAmt
								FROM	investor_repayment_schedule
								WHERE	loan_id	=	:loan_id
								AND		installment_number = :inst_num ";

		unset($whereArray);
		$whereArray		=	Array( 	"inst_num"	=> $instNum,
									"loan_id"	=> $loanId);

		
		$invList_rs		=	$this->dbFetchWithParam($invList_sql, $whereArray);
		
		foreach ($invList_rs as $invList_row) {
			$invId		=	$invList_row->investor_id;
			$payAmt		=	$invList_row->payAmt;
			
			$updSql		=	"	UPDATE	investors
								SET		available_balance = available_balance - {$payAmt} 
								WHERE	investor_id = {$invId}";
			
			$this->dbExecuteSql($updSql);
			//=================== Send mail to investor repayment received starts =====================================

			$invUserInfo		=	$this->getInvestorIdByUserInfo($invId);
			$moneymatchSettings = 	$this->getMailSettingsDetail();
			$slug_name			=	"repayment_cancelled_received_investor";
			$available_balance	=	$this->getInvestorAvailableBalanceById($invId);
			$fields 			= array(
										'[investor_firstname]',
										'[investor_lastname]',
										'[installment_number]',
										'[loan_number]',
										'[investor_current_balance]',
										'[application_name]');
			$replace_array 		= array();
			$replace_array 		= 	array( 
											$invUserInfo->firstname, 
											$invUserInfo->lastname, 
											$instNum,
											$loanRefNumber,
											$available_balance,
											$moneymatchSettings[0]->application_name);
			$this->sendMailByModule($slug_name,$invUserInfo->email,$fields,$replace_array);
			
			//====================Send mail to investor repayment received ends =======================================

		}
		if($this->getLoanStatus($loanId)	==	LOAN_STATUS_LOAN_REPAID) {
			//=================== Send mail to borrower repayment completed cancelled starts===========================
			
			$borrUserInfo		=	$this->getBorrowerIdByUserInfo($this->borrowerId);
			$borrInfo			=	$this->getBorrowerInfoById($this->borrowerId);
			$moneymatchSettings = 	$this->getMailSettingsDetail();
			$slug_name			=	"loan_repayment_complete_cancelled";
			$fields 			= array(
										'[borrower_contact_person]',
										'[installment_number]',
										'[loan_number]',
										'[application_name]');
			$replace_array 		= array();
			$replace_array 		= 	array( 
											$borrInfo->contact_person, 
											$instNum,
											$this->loanRefNumber,
											$moneymatchSettings[0]->application_name);
			$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
			
			//====================Send mail to borrower repayment completed cancelled ends =============================
		}
		$this->updateBorrowerApplyLoanStatus($loanId,LOAN_STATUS_DISBURSED);
	}

	// This function is called when the save button is clicked
	public function saveRepayment($postArray) {
		
		$this->loanId 				= 	$postArray["loan_id"];
		$this->loanRefNumber 		= 	$postArray["loan_reference_number"];
		$this->borrowerId			=	$postArray["borrower_id"];
		$this->amountPaid 			=  	$this->makefloat($postArray["amount_Paid"]);
		$this->principalAmount		=	$this->makefloat($postArray["principal_amount"]);
		$this->interestAmount		=	$this->makefloat($postArray["interest_amount"]);
		$this->penaltyAmt			=	$this->makefloat($postArray["penalty_amount"]);
		$this->penaltyCompShare		=	$this->makefloat($postArray["penalty_companyshare"]);
		$this->repaymentSchdId		=	$postArray["repaymentSchdId"];
		$this->transreference_no	=	$postArray["trans_ref"];
		$this->remarks				=	$postArray["repay_remarks"];
		$this->schedDate			=	$this->getDbDateFormat($postArray["duedate"]); 
		$this->repaymentDate		=	$this->getDbDateFormat($postArray["actual_date"]); 
		$this->installmentNumber	=	$postArray["installment_number"];
		$this->paymentId 			=	$postArray["payment_id"];
		$loanSanctionedAmt			=	0;
		$currency					=	'SGD'; // Hardcoded value

		$repaymentStatus	=	BORROWER_REPAYMENT_STATUS_UNVERIFIED; 

		$moduleName	=	"Loan Repayment";
		if ($postArray["isSaveButton"] != "yes") {
			$actionSumm =	"Approval";
			$actionDet  =	"Approval of Loan Repayment";
		} else {
			if ($this->paymentId == 0) {
				$actionSumm =	"Add";
				$actionDet  =	"Add Loan Repayment";
			} else {
				$actionSumm =	"Update";
				$actionDet  =	"Update Loan Repayment";
			}
		}

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"Loan Reference Nu",$this->loanRefNumber);


		// For the Payments Table
		$paymentInsert_data		=	array(	'trans_datetime' 	=> $this->repaymentDate,
											'trans_type' 		=> PAYMENT_TRANSCATION_LOAN_REPAYMENT,
											'trans_amount'		=> $this->amountPaid,
											'currency' 			=> $currency,
											'trans_reference_number' => $this->transreference_no,
											'status' 			=> PAYMENT_STATUS_UNVERIFIED,
											'remarks'			=> $this->remarks);
		if($this->paymentId	==	0) {	
			$this->paymentId 		=	$this->dbInsert("payments", $paymentInsert_data, 1);
		}else{
			$whereArry	=	array("payment_id" =>"{$this->paymentId}");
			$this->dbUpdate('payments', $paymentInsert_data, $whereArry);
		}
		
		// Update the Borrower Repayment Schedule Table
		$dataArray	=	array(								
							'repayment_status' 				=> $repaymentStatus,
							'payment_id' 					=> $this->paymentId ,
							'repayment_actual_date'			=> $this->repaymentDate,
							'repayment_penalty_interest'	=> $this->penaltyAmt,
							'repayment_penalty_charges'		=> $this->penaltyCompShare,
							'repayment_status'				=> $repaymentStatus,
							'remarks' 						=> $this->remarks);
			
		$whereArray	=	array("repayment_schedule_id" =>"{$this->repaymentSchdId}");
		$this->dbUpdate('borrower_repayment_schedule', $dataArray, $whereArray);
		
		unset($dataArray);
		unset($whereArray);
		
		// Update the Investor Repayment Schedule Table
		$dataArray	=	array(								
							'status' 		=> $repaymentStatus,
							'payment_date' 	=> $this->repaymentDate);
									
		$whereArray	=	array(
							"loan_id" 				=>	"{$this->loanId}",
							"installment_number" 	=>	"{$this->installmentNumber}");
		
		$this->dbUpdate('investor_repayment_schedule', $dataArray, $whereArray);
		unset($dataArray);
		unset($whereArray);
		
		if ($this->penaltyAmt > 0) {
			// When there is a penalty for overdue payments then the penalty should be shared
			// between the investors in the ratio of their amount bidded
			$investBids_sql			=	"SELECT investor_id, 
												bid_amount
										 FROM	loan_bids
										 WHERE	loan_id = {$this->loanId}
										 AND	bid_status = ".LOAN_BIDS_STATUS_ACCEPTED;
				
			$investBids_rs			=	$this->dbFetchAll($investBids_sql);

			$loanSanctionedAmt_sql	=	"SELECT	loan_sanctioned_amount
										 FROM	loans
										 WHERE	loan_id = {$this->loanId}";
										 
			$loanSanctionedAmt	=	$this->dbFetchOne($loanSanctionedAmt_sql);
			
			foreach ($investBids_rs as $investBids_row) {
				$investorId	=	$investBids_row->investor_id;
				$bidAmount	=	$investBids_row->bid_amount;
				$invShare	=	$bidAmount / $loanSanctionedAmt * $this->penaltyAmt;
				
				$dataArray	=	array(	'penalty_amount'		=> $invShare);
				$whereArray	=	array(	"loan_id" 				=> $this->loanId,
										"installment_number" 	=> $this->installmentNumber,
										"investor_id"			=> $investorId);
												
				$this->dbUpdate('investor_repayment_schedule', $dataArray, $whereArray);
				unset($dataArray);
				unset($whereArray);
			}
			
		}
		
		if ($postArray["isSaveButton"] != "yes") {
			//~ echo "approval called .. <br>";
			$this->approvePayments($this->loanId, $this->installmentNumber);
		}			
		
	}
	
	public function getAllBorrowerRepaymentLoans() {
	
		$repaymentloan_sql	=	"SELECT loans.loan_id,
										installment_number,
										repayment_schedule_id,										
										repayment_status,
										loan_reference_number ref, 
										repayment_schedule_date schd_date,
										ifnull(repayment_actual_date ,'') act_date,
										date_format(repayment_schedule_date ,'%Y-%m') inst_period,
										ROUND(if ( date(repayment_schedule_date) < date(now()) && repayment_status = 1,
											repayment_scheduled_amount * (penalty_fee_percent/100) / 365 * datediff(now(), repayment_schedule_date) + 
											greatest(repayment_scheduled_amount * (penalty_fee_percent / 100), penalty_fee_minimum), 0),2) penalty,
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
											SELECT * FROM borrower_repayment_schedule WHERE repayment_status = 3
											UNION
											SELECT * FROM borrower_repayment_schedule a
											WHERE 		installment_number = 
													(	SELECT 	min(installment_number) 
														FROM 	borrower_repayment_schedule b
														WHERE	a.loan_id = b.loan_id
														AND		b.repayment_status in (1,2))
										) loan_repayment
										LEFT JOIN	payments
										ON	loan_repayment.payment_id	=	payments.payment_id,
										loans
									WHERE	loans.loan_id = loan_repayment.loan_id";
					
		$this->repaymentLoanList	=	$this->dbFetchAll($repaymentloan_sql);	
		
		return;

	}
	public function recalculatePenality($postArray) {
		
		$schRepDate				=	$postArray['schRepDate'];
		$actRepDate				=	$postArray['actRepDate'];
		$principalAmt			=	$this->makefloat($postArray['principalAmt']);
		$interestAmt			=	$this->makefloat($postArray['interestAmt']);
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
	
	public function approveBorrowerRepayment($repaySchdId) {


		$moduleName	=	"Loan Repayment";
		$actionSumm =	"Approval";
		$actionDet  =	"Approval of Loan Repayment";
		
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"Loan Reference Nu",$this->loan_reference_number);	
								
		$fetchSql		=	"	SELECT	installment_number,
										loan_id
								FROM	borrower_repayment_schedule
								WHERE	repayment_schedule_id = :repaySchdId ";
		$whereArray		=	Array ("repaySchdId"	=>	$repaySchdId);
		
		$fetchRs		=	$this->dbFetchWithParam($fetchSql, $whereArray);
		
		$loanId			=	$fetchRs[0]->loan_id;
		$instNum		=	$fetchRs[0]->installment_number;
		
		$this->approvePayments($loanId, $instNum);
	}
	
	public function bulkApproveBorrowerRepayment($postArray) {
		
		foreach($postArray['repayment_schedule'] as $repayment_schedule_id) {
			$this->approveBorrowerRepayment($repayment_schedule_id);
		}
	}
}
