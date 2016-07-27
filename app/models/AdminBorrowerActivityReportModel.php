<?php namespace App\models;

class AdminBorrowerActivityReportModel extends TranWrapper {
	
	public  $allactiveBorrowerList					=	array();
	public  $borrowerActReport						=	array();
	public  $openingBalance							= 	array();
	public	$borFilterValue							=	array();
	public	$fromDateFilterValue					=	"";
	public	$toDateFilterValue						=	"";
	
	public function processBorrowerDropDowns(){
	
		$filterSql						=	"SELECT borrowers.contact_person,
													borrowers.borrower_id
											 FROM   borrowers,users
											 WHERE  borrowers.user_id = users.user_id 
											 AND    users.status = 2
											 AND    users.email_verified = 1";			
		
								
		$filter_rs						= 	$this->dbFetchAll($filterSql);
		
		if (!$filter_rs	) {
			throw exception ("Not correct");
			return;
		}	
	  
	   foreach($filter_rs as $filter_row) {
		   $bor_name 					= 	$filter_row->contact_person;
		   $bor_id						=	$filter_row->borrower_id;
		   
		   $this->allactiveBorrowerList[$bor_id] = $bor_name;
	   }
	}
	
	public function getInvestorActivityReportInfo($filterBor, $filterFromDate, $filterToDate) {

		$this->borFilterValue						=	$filterBor;
		$this->fromDateFilterValue					=	$filterFromDate;
		$this->toDateFilterValue					=	$filterToDate;
		foreach($filterBor as $filterBorRow) {
			$this->getOpeningBalanceByBorrowerId($filterBorRow,$filterFromDate);
			$this->getBorrowerActivityReportList($filterBorRow,$filterFromDate, $filterToDate);
		}
		//~ $this->prnt($this->investActReport);
	}
	
	public function getOpeningBalanceByBorrowerId($borrower_id,$filterFromDate) {
	
		
		//*****************************Total Loan Disuserd RepayCompleted for the Borrower*************************************//
		
		$loanDisRepaySql							=	"	SELECT 	SUM(loan_sanctioned_amount) totDisRepayComp
															FROM 	loans
															WHERE	borrower_id	=	{$borrower_id}
															AND		status	IN	(:loan_dis_param,:loan_repaid_param)
															AND		loan_process_date
																			< '".$this->getDbDateFormat($filterFromDate)."'";
		$dataArrayloanDisRepay						= 	[															
															"loan_dis_param" => LOAN_STATUS_DISBURSED,
															"loan_repaid_param" =>LOAN_STATUS_LOAN_REPAID
														]	;
																			
		$loanDisRepayRs								=	$this->dbFetchWithParam($loanDisRepaySql, $dataArrayloanDisRepay);					
		$this->borrowerActReport[$borrower_id]['totDisRepayComp']	=	$loanDisRepayRs[0]->totDisRepayComp;					
		
	//*****************************Total Interest Payable for the investor**********************************************//
	
		$interestPayableSql						=	"	SELECT 	SUM(interest_component) totInterestPay
														FROM 	borrower_repayment_schedule
														WHERE	borrower_id	=	{$borrower_id}
														AND		repayment_schedule_date
																< '".$this->getDbDateFormat($filterFromDate)."'";			
		
																		
		$interestPayableRs						=	$this->dbFetchAll($interestPayableSql);		
		$this->borrowerActReport[$borrower_id]['totInterestPay']	=	$interestPayableRs[0]->totInterestPay;		
					
	//*****************************Total Repayments – Penalty Interest**********************************************//
	
		$repayPenaltyIntSql						=	"	SELECT 	SUM(repayment_penalty_interest) totRepayPenInt
														FROM 	borrower_repayment_schedule
														WHERE	borrower_id	=	{$borrower_id}
														AND		repayment_schedule_date
																< '".$this->getDbDateFormat($filterFromDate)."'";			
		
																		
		$repayPenaltyIntRs						=	$this->dbFetchAll($repayPenaltyIntSql);		
		$this->borrowerActReport[$borrower_id]['totRepayPenInt']	=	$repayPenaltyIntRs[0]->totRepayPenInt;		
		
	//*****************************Total Repayments – Penalty charges**********************************************//
	
		$repayPenaltyCharSql						=	"	SELECT 	SUM(repayment_penalty_charges) totRepayPenCharge
															FROM 	borrower_repayment_schedule
															WHERE	borrower_id	=	{$borrower_id}
															AND		repayment_schedule_date
																	< '".$this->getDbDateFormat($filterFromDate)."'";			
			
																		
		$repayPenaltyCharRs							=	$this->dbFetchAll($repayPenaltyIntSql);		
		$this->borrowerActReport[$borrower_id]['totRepayPenCharge']	=	$repayPenaltyCharRs[0]->totRepayPenCharge;		
				
	//*****************************Total Repayments – Principal**********************************************//
		
		$repayPrincipalSql						=	"	SELECT 	SUM(principal_component) totPrincipal
														FROM 	borrower_repayment_schedule
														WHERE	borrower_id	=	{$borrower_id}
														AND		repayment_status	=	:repay_status_param1
														AND		repayment_schedule_date
																< '".$this->getDbDateFormat($filterFromDate)."'";			
		$dataArrayRepayPrincipal					=	[	
															"repay_status_param1" =>  BORROWER_REPAYMENT_STATUS_PAID
														];
																		
		$repayPrincipalRs							=	$this->dbFetchWithParam($repayPrincipalSql,$dataArrayRepayPrincipal);		
		$this->borrowerActReport[$borrower_id]['totPrincipal']	=	$repayPenaltyCharRs[0]->totPrincipal;	
						
	//*****************************Total Repayments – Interest**********************************************//
	
		$repayInterestSql							=	"	SELECT 	SUM(interest_component) totInterest
															FROM 	borrower_repayment_schedule
															WHERE	borrower_id	=	{$borrower_id}
															AND		repayment_status	=	:repay_status_param2
															AND		repayment_schedule_date
																	< '".$this->getDbDateFormat($filterFromDate)."'";			
			
		$dataArrayRepayInterest						=	[	
															"repay_status_param2" =>  BORROWER_REPAYMENT_STATUS_PAID
														];
	
		$repayInterestRs							=	$this->dbFetchWithParam($repayInterestSql,$dataArrayRepayInterest);		
		$this->borrowerActReport[$borrower_id]['totInterest']	=	$repayInterestRs[0]->totInterest;					
		
	//*****************************Total Penalty Interest Payable**********************************************//
	
		$penaltyInterestPaySql							=	"	SELECT 	SUM(penalty_interest) totpenaltyIntPay
																FROM 	borrower_repayment_schedule
																WHERE	borrower_id	=	{$borrower_id}
																AND		repayment_status	=	:repay_status_param3
																AND		repayment_schedule_date
																		< '".$this->getDbDateFormat($filterFromDate)."'";			
			
		$dataArrayPenaltyInterestPay					=	[	
																"repay_status_param3" =>  BORROWER_REPAYMENT_STATUS_PAID
															];
	
		$penaltyInterestPayRs							=	$this->dbFetchWithParam($penaltyInterestPaySql,		
																								$dataArrayPenaltyInterestPay);		
		$this->borrowerActReport[$borrower_id]['totpenaltyIntPay']	=	$penaltyInterestPayRs[0]->totpenaltyIntPay;					
		
	//*****************************Total Penalty Charges Payable**********************************************//
	
		$penaltyChargePaySql							=	"	SELECT 	SUM(penalty_charges) totpenaltyCharPay
																FROM 	borrower_repayment_schedule
																WHERE	borrower_id	=	{$borrower_id}
																AND		repayment_status	=	:repay_status_param4
																AND		repayment_schedule_date
																		< '".$this->getDbDateFormat($filterFromDate)."'";			
			
		$dataArrayPenaltyChargePay					=	[	
																"repay_status_param4" =>  BORROWER_REPAYMENT_STATUS_PAID
															];
	
		$penaltyChargePayRs							=	$this->dbFetchWithParam($penaltyChargePaySql,		
																								$dataArrayPenaltyChargePay);		
		$this->borrowerActReport[$borrower_id]['totpenaltyCharPay']	=	$penaltyChargePayRs[0]->totpenaltyCharPay;					
		
	
								
		$this->openingBalance[$borrower_id]	=	0;
	   foreach($this->borrowerActReport[$borrower_id] as $key=>$val) {
		   
		   
		   if(empty($val)) {
			 $val	=	0;  
			}
			switch($key) {
				case'totDisRepayComp':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	-	$val;
					break;
				case'totInterestPay':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	-	$val;
					break;
				case'totRepayPenInt':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	-	$val;
					break;
				case'totRepayPenCharge':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	-	$val;
					break;
				case'totPrincipal':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	+	$val;
					break;
				case'totInterest':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	+	$val;
					break;
				case'totpenaltyIntPay':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	+	$val;
					break;
				case'totpenaltyCharPay':
					$this->openingBalance[$borrower_id]	=	$this->openingBalance[$borrower_id]	+	$val;
					break;
			}
		
		}	

	}
	
	
	public function getBorrowerActivityReportList($borrower_id,$filterFromDate, $filterToDate) {
		
		$filterFromDate					=	$this->getDbDateFormat($filterFromDate);
		$filterToDate					=	$this->getDbDateFormat($filterToDate);
		
		$investorActListSql				=	"	SELECT 	DATE_FORMAT(rept_date,'%d-%m-%Y') rept_date,
														DATE_FORMAT(rept_date,'%Y-%m-%d') rept_date_orderBy,
														trans_type_orderBy,
														trans_type,
														ref_no,
														details,
														IF(debit_amt !='',ROUND(debit_amt,2),'') debit_amt,
														IF(credit_amt !='',ROUND(credit_amt,2),'') credit_amt
												FROM (
														SELECT 	loan_process_date rept_date,
																'Loan Disbursed' trans_type,
																'DR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																disbursements.remarks details,
																loans.loan_sanctioned_amount debit_amt,
																'' credit_amt
														FROM 	loans
															LEFT JOIN	disbursements
															ON	disbursements.loan_id	=	loans.loan_id	
														WHERE	borrower_id	=	{$borrower_id}
														AND		loans.status	=	:loan_dis_param
														AND		DATE(loan_process_date)	>= '".$filterFromDate."'
														AND		DATE(loan_process_date)	<= '".$filterToDate."'
														UNION
														SELECT 	loan_process_date rept_date,
																'Loan Processing Fees Charged' trans_type,
																'DR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																disbursements.remarks details,
																loans.loan_sanctioned_amount debit_amt,
																'' credit_amt
														FROM 	loans
															LEFT JOIN	disbursements
															ON	disbursements.loan_id	=	loans.loan_id	
														WHERE	borrower_id	=	{$borrower_id}
														AND		loans.status	=	:loan_repaid_param
														AND		DATE(loan_process_date)	>= '".$filterFromDate."'
														AND		DATE(loan_process_date)	<= '".$filterToDate."'
														UNION
														SELECT 	bor_sch.repayment_schedule_date rept_date,
																'Interest Payable' trans_type,
																'DR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																bor_sch.interest_component debit_amt,
																'' credit_amt
														FROM 	borrower_repayment_schedule bor_sch
															LEFT JOIN	payments
															ON	payments.payment_id	=	bor_sch.payment_id	
														WHERE	borrower_id	=	{$borrower_id}
														AND		repayment_schedule_date	>= '".$filterFromDate."'
														AND		repayment_schedule_date	<= '".$filterToDate."'
														UNION
														SELECT 	bor_sch.repayment_actual_date rept_date,
																'Repayments – Interest' trans_type,
																'CR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																bor_sch.interest_component debit_amt,
																'' credit_amt
														FROM 	borrower_repayment_schedule bor_sch
															LEFT JOIN	payments
															ON	payments.payment_id	=	bor_sch.payment_id	
														WHERE	borrower_id	=	{$borrower_id}
														AND		bor_sch.repayment_status	=	:repay_status_param1
														AND		repayment_schedule_date	>= '".$filterFromDate."'
														AND		repayment_schedule_date	<= '".$filterToDate."'
														UNION
														SELECT 	bor_sch.repayment_actual_date rept_date,
																'Repayments – Principal' trans_type,
																'CR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																bor_sch.principal_component debit_amt,
																'' credit_amt
														FROM 	borrower_repayment_schedule bor_sch
															LEFT JOIN	payments
															ON	payments.payment_id	=	bor_sch.payment_id	
														WHERE	borrower_id	=	{$borrower_id}
														AND		bor_sch.repayment_status	=	:repay_status_param2
														AND		repayment_schedule_date	>= '".$filterFromDate."'
														AND		repayment_schedule_date	<= '".$filterToDate."'
														UNION
														SELECT 	bor_sch.repayment_actual_date rept_date,
																'Repayments – Principal' trans_type,
																'CR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																bor_sch.principal_component debit_amt,
																'' credit_amt
														FROM 	borrower_repayment_schedule bor_sch
															LEFT JOIN	payments
															ON	payments.payment_id	=	bor_sch.payment_id	
														WHERE	borrower_id	=	{$borrower_id}
														AND		bor_sch.repayment_status	=	:repay_status_param2
														AND		repayment_schedule_date	>= '".$filterFromDate."'
														AND		repayment_schedule_date	<= '".$filterToDate."'
												) xx
												ORDER BY  rept_date_orderBy, if(trans_type_orderBy='DR', 1, 0)";			
		$dataArrayInvList				= 	[															
													"dep_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,
													"trans_ver_param1" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED,
													"with_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
													"trans_ver_param2" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED,
													"open_bids_param" => LOAN_BIDS_STATUS_OPEN,
													"cancel_bids_param" => LOAN_BIDS_STATUS_CANCELLED,
													"reject_bids_param" => LOAN_BIDS_STATUS_REJECTED,
													"accept_bids_param" => LOAN_BIDS_STATUS_ACCEPTED,
													"repaid_ver_param1" => INVESTOR_REPAYMENT_STATUS_VERIFIED,
													"repaid_ver_param2" => INVESTOR_REPAYMENT_STATUS_VERIFIED,
													"repaid_ver_param3" => INVESTOR_REPAYMENT_STATUS_VERIFIED
													
											];
																			
		$this->investActReport[$investor_id]			=	$this->dbFetchWithParam($investorActListSql, $dataArrayInvList);				
		
		
	   $balance	=	$this->openingBalance[$investor_id];
	   foreach($this->investActReport[$investor_id] as $key=>$row) {
		   $crAmt	=	$row->credit_amt;
		   $dbAmt	=	$row->debit_amt;
		   if(empty($crAmt)) {
			   $crAmt  =	0;
			}
		   if(empty($dbAmt)) {
			   $dbAmt  =	0;
			}
			$balance	=	($balance+$crAmt)	-	$dbAmt;
			$this->investActReport[$investor_id][$key]->balance	=	$balance;
	   }
	}
	
}
