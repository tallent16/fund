<?php namespace App\models;

class AdminBankActivityReportModel extends TranWrapper {
	
	public  $openingBalance							= 	0;
	public  $bankActReport							= 	array();
	public  $bankActList							= 	array();
	public	$fromDateFilterValue					=	"";
	public	$toDateFilterValue						=	"";
	
	public function getBankActivityReportInfo( $filterFromDate, $filterToDate) {

		$this->fromDateFilterValue					=	$filterFromDate;
		$this->toDateFilterValue					=	$filterToDate;
		$this->getOpeningBalance($filterFromDate);
		$this->getBankActivityReportList($filterFromDate, $filterToDate);
		//~ $this->prnt($this->investActReport);
	}
	
	public function getOpeningBalance($filterFromDate) {

		
	//*****************************Total Withdrawals **********************************************//
	
		$withdrawalTotSql						=	"	SELECT 	SUM(trans_amount) totWithdrawal
														FROM 	payments
														WHERE	trans_type	=	:withdrawal_trantype_param
														AND		status		=	:trans_ver_param1
														AND		DATE(trans_datetime)
																< '".$this->getDbDateFormat($filterFromDate)."'";			
		$dataArrayWithdrawal					= 	[															
														"withdrawal_trantype_param" => PAYMENT_TRANSCATION_INVESTOR_WITHDRAWAL,
														"trans_ver_param1" =>PAYMENT_STATUS_VERIFIED
													]	;
																		
		$withdrawalTotRs						=	$this->dbFetchWithParam($withdrawalTotSql, $dataArrayWithdrawal);		
		$this->bankActReport['totWithdrawal']	=	$withdrawalTotRs[0]->totWithdrawal;		
					
	//*****************************Total Loan Disbursed **********************************************//
	
		$loanDisbursedTotSql						=	"	SELECT 	SUM(trans_amount) totLoanDisbursed
															FROM 	payments
															WHERE	trans_type	=	:disbursed_trantype_param
															AND		status		=	:trans_ver_param2
															AND		DATE(trans_datetime)
																< '".$this->getDbDateFormat($filterFromDate)."'";;			
		$dataArrayLoanDisbursed						= 	[															
															"disbursed_trantype_param" => PAYMENT_TRANSCATION_LOAN_DISBURSEMENT,
															"trans_ver_param2" =>PAYMENT_STATUS_VERIFIED
														]	;
																		
		$loanDisbursedTotRs							=	$this->dbFetchWithParam($loanDisbursedTotSql, $dataArrayLoanDisbursed);		
		$this->bankActReport['totLoanDisbursed']	=	$loanDisbursedTotRs[0]->totLoanDisbursed;		
					
					
	//*****************************Total Deposit **********************************************//
	
		$depositTotSql								=	"	SELECT 	SUM(trans_amount) totDeposit
															FROM 	payments
															WHERE	trans_type	=	:deposit_trantype_param
															AND		status		=	:trans_ver_param3
															AND		DATE(trans_datetime)
																	< '".$this->getDbDateFormat($filterFromDate)."'";			
		$dataArrayDeposit							= 	[															
															"deposit_trantype_param" => PAYMENT_TRANSCATION_INVESTOR_DEPOSIT,
															"trans_ver_param3" =>PAYMENT_STATUS_VERIFIED
														]	;
																		
		$depositTotRs								=	$this->dbFetchWithParam($depositTotSql, $dataArrayDeposit);		
		$this->bankActReport['totDeposit']			=	$depositTotRs[0]->totDeposit;		
					
					
	//*****************************Total Loan Repayment **********************************************//
	
		$loanRepaymentTotSql						=	"	SELECT 	SUM(trans_amount) totLoanRepayment
															FROM 	payments
															WHERE	trans_type	=	:repayment_trantype_param
															AND		status		=	:trans_ver_param4
															AND		DATE(trans_datetime)
																	< '".$this->getDbDateFormat($filterFromDate)."'";			
		$dataArrayLoanRepayment						= 	[															
															"repayment_trantype_param" => PAYMENT_TRANSCATION_LOAN_REPAYMENT,
															"trans_ver_param4" =>PAYMENT_STATUS_VERIFIED
														]	;
																		
		$loanRepaymentTotRs							=	$this->dbFetchWithParam($loanRepaymentTotSql, $dataArrayLoanRepayment);		
		$this->bankActReport['totLoanRepayment']	=	$loanRepaymentTotRs[0]->totLoanRepayment;		
					
		
		$this->openingBalance	=	0;
	   foreach($this->bankActReport as $key=>$val) {
		   
		   
		   if(empty($val)) {
			 $val	=	0;  
			}
			switch($key) {
			
				case'totWithdrawal':
					$this->openingBalance			=	$this->openingBalance	-	$val;
					break;
				case'totLoanDisbursed':
					$this->openingBalance			=	$this->openingBalance	-	$val;
					break;
				case'totDeposit':
					$this->openingBalance			=	$this->openingBalance	+	$val;
					break;
				case'totLoanRepayment':
					$this->openingBalance			=	$this->openingBalance	+	$val;
					break;
				
			}
		
		}	

	}
	
	
	public function getBankActivityReportList($filterFromDate, $filterToDate) {
		
	
		$filterFromDate					=	$this->getDbDateFormat($filterFromDate);
		$filterToDate					=	$this->getDbDateFormat($filterToDate);
		
		$bankActListSql					=	"	SELECT 	DATE_FORMAT(rept_date,'%d-%m-%Y') rept_date,
														DATE_FORMAT(rept_date,'%Y-%m-%d') rept_date_orderBy,
														trans_type_orderBy,
														trans_type,
														ref_no,
														details,
														IF(debit_amt !='',ROUND(debit_amt,2),'') debit_amt,
														IF(credit_amt !='',ROUND(credit_amt,2),'') credit_amt
												FROM (
														SELECT 	trans_datetime rept_date,
																'Investor Deposit' trans_type,
																'CR' trans_type_orderBy,
																trans_reference_number ref_no,
																remarks details,
																'' debit_amt,
																trans_amount credit_amt
														FROM 	payments
														WHERE	trans_type	=	:deposit_trantype_param
														AND		status		=	:trans_ver_param1
														AND		DATE(trans_datetime)	>= '".$filterFromDate."'
														AND		DATE(trans_datetime)	<= '".$filterToDate."'
														UNION
														SELECT 	trans_datetime rept_date,
																'Investor Withdrawals' trans_type,
																'DR' trans_type_orderBy,
																trans_reference_number ref_no,
																remarks details,
																trans_amount debit_amt,
																 '' credit_amt
														FROM 	payments
														WHERE	trans_type	=	:withdrawal_trantype_param
														AND		status		=	:trans_ver_param2
														AND		DATE(trans_datetime)	>= '".$filterFromDate."'
														AND		DATE(trans_datetime)	<= '".$filterToDate."'
														UNION
														SELECT 	trans_datetime rept_date,
																'Loan Disbursed' trans_type,
																'DR' trans_type_orderBy,
																trans_reference_number ref_no,
																remarks details,
																trans_amount debit_amt,
																 '' credit_amt
														FROM 	payments
														WHERE	trans_type	=	:disbursed_trantype_param
														AND		status		=	:trans_ver_param3
														AND		DATE(trans_datetime)	>= '".$filterFromDate."'
														AND		DATE(trans_datetime)	<= '".$filterToDate."'
														UNION
														SELECT 	trans_datetime rept_date,
																'Loan Repayment' trans_type,
																'CR' trans_type_orderBy,
																trans_reference_number ref_no,
																remarks details,
																'' debit_amt,
																trans_amount credit_amt
														FROM 	payments
														WHERE	trans_type	=	:repayment_trantype_param
														AND		status		=	:trans_ver_param4
														AND		DATE(trans_datetime)	>= '".$filterFromDate."'
														AND		DATE(trans_datetime)	<= '".$filterToDate."'
														
														
												) xx
												ORDER BY  rept_date_orderBy, if(trans_type_orderBy='DR', 1, 0)";			
		$dataArrayBankList				= 	[															
													"deposit_trantype_param" => PAYMENT_TRANSCATION_INVESTOR_DEPOSIT,
													"trans_ver_param1" =>PAYMENT_STATUS_VERIFIED,
													"withdrawal_trantype_param" => PAYMENT_TRANSCATION_INVESTOR_WITHDRAWAL,
													"trans_ver_param2" =>PAYMENT_STATUS_VERIFIED,
													"disbursed_trantype_param" => PAYMENT_TRANSCATION_LOAN_DISBURSEMENT,
													"trans_ver_param3" => PAYMENT_STATUS_VERIFIED,
													"repayment_trantype_param" => PAYMENT_TRANSCATION_LOAN_REPAYMENT,
													"trans_ver_param4" => PAYMENT_STATUS_VERIFIED
											];
																			
		$this->bankActList			=	$this->dbFetchWithParam($bankActListSql, $dataArrayBankList);				
		
		
	   $balance	=	$this->openingBalance;
	   foreach($this->bankActList as $key=>$row) {
		   $crAmt	=	$row->credit_amt;
		   $dbAmt	=	$row->debit_amt;
		   if(empty($crAmt)) {
			   $crAmt  =	0;
			}
		   if(empty($dbAmt)) {
			   $dbAmt  =	0;
			}
			$balance	=	($balance+$crAmt)	-	$dbAmt;
			$this->bankActList[$key]->balance	=	$balance;
	   }
	}
	
}
