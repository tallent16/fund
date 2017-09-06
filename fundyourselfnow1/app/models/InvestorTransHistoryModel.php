<?php namespace App\models;
use Config;
use DB;
use Lang;

class InvestorTransHistoryModel extends TranWrapper {
	
	public  $tranList = array();
	public	$tranTypeFilter;
	public	$fromDate;
	public  $toDate;
	public  $tranType;
	public  $investActReport						=	array();
	public  $openingBalance							= 	array();
	
	public function getInvestorActivityReportInfo($filterInv, $filterFromDate, $filterToDate) {
		
		$this->invFilterValue						=	$filterInv;
		$this->fromDateFilterValue					=	$filterFromDate;
		$this->toDateFilterValue					=	$filterToDate;
		$current_inverstor_id						=	 $this->getCurrentInvestorID();
		
		$this->getOpeningBalanceByInvestorId($current_inverstor_id,$filterFromDate);			
		$this->getInvestorTransList($filterFromDate, $filterToDate, $filterInv);				
	}
	
	public function getOpeningBalanceByInvestorId($investor_id,$filterFromDate) {
	
		
		//*****************************Total Deposit for the investor**********************************************//
		
		$depositTotSql							=	"	SELECT 	SUM(trans_amount) totDeposit
														FROM 	investor_bank_transactions
														WHERE	investor_id	=	{$investor_id}
														AND		trans_type	=	:dep_trantype_param
														AND		status		=	:trans_ver_param
														AND		trans_date	< '".$this->getDbDateFormat($filterFromDate)."'";
		$dataArrayDeposit						= 	[															
															"dep_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,
															"trans_ver_param" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED
													]	;
																			
		$depositTotRs							=	$this->dbFetchWithParam($depositTotSql, $dataArrayDeposit);					
		$this->investActReport[$investor_id]['totDeposit']	=	$depositTotRs[0]->totDeposit;					
		
	//*****************************Total Withdrawals for the investor**********************************************//
	
		$withdrawalTotSql						=	"	SELECT 	SUM(trans_amount) totWithdrawal
														FROM 	investor_bank_transactions
														WHERE	investor_id	=	{$investor_id}
														AND		trans_type	=	:with_trantype_param
														AND		status		=	:trans_ver_param
														AND		trans_date	< '".$this->getDbDateFormat($filterFromDate)."'";			
		$dataArrayWithdrawal					= 	[															
														"with_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
														"trans_ver_param" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED
													]	;
																		
		$withdrawalTotRs						=	$this->dbFetchWithParam($withdrawalTotSql, $dataArrayWithdrawal);		
		$this->investActReport[$investor_id]['totWithdrawal']	=	$withdrawalTotRs[0]->totWithdrawal;		
					
	//*****************************Total open bids made by the investor**********************************************//
	
		$openBidsSql							=	"		SELECT 	SUM(bid_amount) totBidsMade
															FROM 	loan_bids
															WHERE	investor_id	=	{$investor_id}
															AND		bid_status	=	:open_bids__param
															AND		DATE(bid_datetime)	
																			< '".$this->getDbDateFormat($filterFromDate)."'";
		$dataArrayOpenBids						= 	[															
															"open_bids__param" => LOAN_BIDS_STATUS_OPEN
													]	;
																			
		$openBidsRs								=	$this->dbFetchWithParam($openBidsSql, $dataArrayOpenBids);					
		$this->investActReport[$investor_id]['totBidsMade']	=	$openBidsRs[0]->totBidsMade;					
		
	//*****************************Total cancelled bids by the investor**********************************************//
	
		$cancelledBidsSql							=	"	SELECT 	SUM(bid_amount) totBidsCancelled
															FROM 	loan_bids
															WHERE	investor_id	=	{$investor_id}
															AND		bid_status	=	:cancel_bids__param
															AND		DATE(bid_datetime)
																			< '".$this->getDbDateFormat($filterFromDate)."'";
		$dataArrayCancelledBids						= 	[															
															"cancel_bids__param" => LOAN_BIDS_STATUS_CANCELLED
														]	;
																		
		$cancelledBidsRs							=	$this->dbFetchWithParam($cancelledBidsSql, $dataArrayCancelledBids);			
		$this->investActReport[$investor_id]['totBidsCancelled']	=	$cancelledBidsRs[0]->totBidsCancelled;			
				
	//*****************************Total rejected bids for the investor**********************************************//
		
		$rejectedBidsSql							=	"	SELECT 	SUM(bid_amount) totBidsRejected
															FROM 	loan_bids
															WHERE	investor_id	=	{$investor_id}
															AND		bid_status	=	:reject_bids__param
															AND		DATE(bid_datetime)	
																			< '".$this->getDbDateFormat($filterFromDate)."'";		
		$dataArrayRejectedBids						= 	[															
															"reject_bids__param" => LOAN_BIDS_STATUS_REJECTED
														]	;
																		
		$rejectedBidsRs								=	$this->dbFetchWithParam($rejectedBidsSql, $dataArrayRejectedBids);			
		$this->investActReport[$investor_id]['totBidsRejected']	=	$rejectedBidsRs[0]->totBidsRejected;			
						
	//*****************************Total interest repaid for the investor**********************************************//
	
		$interestRepaidSql							=	"		SELECT 	SUM(interest_amount) totInterestRepaid
																FROM 	investor_repayment_schedule
																WHERE	investor_id	=	{$investor_id}
																AND		status		=	:repaid_ver_param
																AND		payment_date	
																			< '".$this->getDbDateFormat($filterFromDate)."'";			
		$dataArrayInterestRepaid					= 	[															
															"repaid_ver_param" => INVESTOR_REPAYMENT_STATUS_VERIFIED
														]	;
																			
		$interestRepaidRs							=	$this->dbFetchWithParam($interestRepaidSql, $dataArrayInterestRepaid);					
		$this->investActReport[$investor_id]['totInterestRepaid']	=	$interestRepaidRs[0]->totInterestRepaid;					
		
	//*****************************Total principal repaid for the investor**********************************************//
	
		$principalRepaidSql								=	"		SELECT 	SUM(principal_amount) totPrincipalRepaid
																	FROM 	investor_repayment_schedule
																	WHERE	investor_id	=	{$investor_id}
																	AND		status		=	:repaid_ver_param
																	AND		payment_date	
																			< '".$this->getDbDateFormat($filterFromDate)."'";		
		$dataArrayPrincipalRepaid						= 	[															
																"repaid_ver_param" => INVESTOR_REPAYMENT_STATUS_VERIFIED
															];
																			
		$principalRepaidRs								=	$this->dbFetchWithParam($principalRepaidSql, 
																						$dataArrayPrincipalRepaid);					
		$this->investActReport[$investor_id]['totPrincipalRepaid']	=	$principalRepaidRs[0]->totPrincipalRepaid;					
		
	//*****************************Total Penalty earned**********************************************************//	
				
		$penaltyRepaidSql							=	"		SELECT IFNULL(SUM(interest_amount),0) totPenaltyEarned
																FROM 	investor_repayment_schedule
																WHERE	investor_id	=	{$investor_id}
																AND		status		=	:repaid_ver_param
																AND		payment_date	
																			< '".$this->getDbDateFormat($filterFromDate)."'";		
		$dataArrayPenaltyRepaid						= 	[															
															"repaid_ver_param" => INVESTOR_REPAYMENT_STATUS_VERIFIED
														]	;
																			
		$interestRepaidRs							=	$this->dbFetchWithParam($penaltyRepaidSql, $dataArrayPenaltyRepaid);					
		$this->investActReport[$investor_id]['totPenaltyEarned']	=	$interestRepaidRs[0]->totPenaltyEarned;
									
		$this->openingBalance[$investor_id]	=	0;
		
	   foreach($this->investActReport[$investor_id] as $key=>$val) {
		   
		  
		   if(empty($val)) {
			 $val	=	0;  
			}
			switch($key) {
				case'totDeposit':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	+	$val;
					break;
				case'totWithdrawal':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	-	$val;
					break;
				case'totBidsMade':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	-	$val;
					break;
				case'totBidsCancelled':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	+	$val;
					break;
				case'totBidsRejected':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	+	$val;
					break;
				case'totInterestRepaid':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	+	$val;
					break;
				case'totPrincipalRepaid':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	+	$val;
					break;
				case'totPenaltyEarned':
					$this->openingBalance[$investor_id]	=	$this->openingBalance[$investor_id]	+	$val;
					break;
			}
		
		}	

	}
	
	
	
	public function getInvestorTransList($fromDate, $toDate, $transType) {
		
		$this->tranTypeFilter = 
					array (	"Withdrawals"							=>	Lang::get("Withdrawals"),
							"Deposits"								=>	Lang::get("Deposits"),
							"Investments – Under Bids"				=>	Lang::get("Investments – Under Bids"),
							"Investments – Bids Cancelled"			=>	Lang::get("Investments – Bids Cancelled"),
							"Investments – Bids Rejected"			=>	Lang::get("Investments – Bids Rejected"),
							"Investments – Overbidded Amt Reversed"	=>	Lang::get("Investments – Overbidded Amt Reversed"),
							"Loan Repayments – Interest Repaid"		=>	Lang::get("Loan Repayments – Interest Repaid"),
							"Loan Repayments – Principal Repaid"	=>	Lang::get("Loan Repayments – Principal Repaid"),
							"Loan Repayments – Penalty Earned"		=>	Lang::get("Loan Repayments – Penalty Earned"),
							"All"									=>	Lang::get("All")
							);
		
		$this->fromDate = $fromDate;
		$this->toDate 	= $toDate;
		$this->tranType = $transType;
		
		$current_inverstor_id	=	 $this->getCurrentInvestorID();
		$this->current_inverstor_id = $current_inverstor_id;
		$trantype	= ($this->tranType == 'All' ?'trans_type' : "'{$this->tranType}'");
		
		$investorActListSql				=	"	SELECT 	DATE_FORMAT(rept_date,'%d-%m-%Y') trans_date,
														rept_date rept_date_orderBy,
														trans_type_orderBy,
														trans_type,
														ref_no trans_reference_number,
														details remarks,														
														trans_amt trans_amount,
														plus_or_minus,
														display_order,
														debit_amt,
														credit_amt
														
												FROM (
														SELECT 	trans_date rept_date,
																'Deposits' trans_type,
																'CR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																inv_tran.trans_amount trans_amt,
																1 plus_or_minus,
																1 display_order,
																'' bid_amount,
																'' debit_amt,
																inv_tran.trans_amount credit_amt
														FROM 	investor_bank_transactions inv_tran
															LEFT JOIN	payments
															ON	payments.payment_id	=	inv_tran.payment_id	
														WHERE	investor_id	=	{$current_inverstor_id}
														AND		inv_tran.trans_type	=	:dep_trantype_param
														AND		inv_tran.status		=	:trans_ver_param1
														AND		DATE(trans_date)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(trans_date)	<= '".$this->getDbDateFormat($this->toDate) ."'
														UNION
														SELECT 	trans_date rept_date,
																'Withdrawals' trans_type,
																'DR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																inv_tran.trans_amount trans_amt,
																-1 plus_or_minus,
																1 display_order,
																'' bid_amount,
																inv_tran.trans_amount debit_amt,
																'' credit_amt
																
														FROM 	investor_bank_transactions inv_tran
															LEFT JOIN	payments
															ON	payments.payment_id	=	inv_tran.payment_id	
														WHERE	investor_id	=	{$current_inverstor_id}
														AND		inv_tran.trans_type	=	:with_trantype_param
														AND		inv_tran.status		=	:trans_ver_param2
														AND		DATE(trans_date)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(trans_date)	<= '".$this->getDbDateFormat($this->toDate )."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments – Under Bids' trans_type,
																'DR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																concat('Bidded in ',borrowers.business_name,', Loan @', loan_bids.bid_interest_rate, '%'),
																loan_bids.bid_amount trans_amt,
																-1 plus_or_minus,
																2 display_order,
																'' bid_amount,
																loan_bids.bid_amount debit_amt,
																'' credit_amt
																
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
															LEFT JOIN	borrowers	
															ON	loans.borrower_id = borrowers.borrower_id
														WHERE	investor_id	=	{$current_inverstor_id}
														AND		DATE(bid_datetime)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(bid_datetime)	<= '".$this->getDbDateFormat($this->toDate)."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments – Bids Cancelled' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																concat('Bid Cancelled in ',borrowers.business_name,', Loan @', loan_bids.bid_interest_rate, '%'),
																loan_bids.bid_amount trans_amt,
																1 plus_or_minus,
																3 display_order,
																'' bid_amount,
																'' debit_amt,
																loan_bids.bid_amount credit_amt
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id
															LEFT JOIN	borrowers	
															ON	loans.borrower_id = borrowers.borrower_id	
														WHERE	investor_id	=	{$current_inverstor_id}
														AND		bid_status		=	:cancel_bids_param
														AND		DATE(bid_datetime)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(bid_datetime)	<= '".$this->getDbDateFormat($this->toDate)."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments – Bids Rejected' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																concat('Bid Rejected in ',borrowers.business_name,', Loan @', loan_bids.bid_interest_rate, '%'),
																loan_bids.bid_amount trans_amt,
																1 plus_or_minus,
																1 display_order,
																loan_bids.bid_amount bid_amount,
																'' debit_amt,
																loan_bids.bid_amount credit_amt
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
															LEFT JOIN	borrowers	
															ON	loans.borrower_id = borrowers.borrower_id
														WHERE	investor_id		=	{$current_inverstor_id}
														AND		bid_status		=	:reject_bids_param
														AND		DATE(bid_datetime)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(bid_datetime)	<= '".$this->getDbDateFormat($this->toDate)."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments – Investment Accepted' trans_type,
																'DR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																concat('Invested in ',borrowers.business_name,', Loan @', loan_bids.bid_interest_rate, '%'),
																loan_bids.accepted_amount trans_amt,
																-1 plus_or_minus,
																1 display_order,
																'' bid_amount,
																loan_bids.accepted_amount debit_amt,
																loan_bids.bid_amount credit_amt
																
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
															LEFT JOIN	borrowers	
															ON	loans.borrower_id = borrowers.borrower_id
														WHERE	investor_id		=	{$current_inverstor_id}
														AND		bid_status		=	:accept_bids_param
														AND		DATE(bid_datetime)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(bid_datetime)	<= '".$this->getDbDateFormat($this->toDate)."'
														UNION
															SELECT 	bid_datetime rept_date,
																'Investments – Overbidded Amt Reversed' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																concat('Bidded in ',borrowers.business_name,', Loan @', loan_bids.bid_interest_rate, '%'),
																
																(loan_bids.bid_amount-loan_bids.accepted_amount) trans_amt,
																1 plus_or_minus,
																1 display_order,
																loan_bids.bid_amount,
																'' debit_amt,
																'' credit_amt
																
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
															LEFT JOIN	borrowers	
															ON	loans.borrower_id = borrowers.borrower_id
														WHERE	investor_id		=	{$current_inverstor_id}
														and 	(loan_bids.bid_amount-loan_bids.accepted_amount ) > 0
														AND		bid_status		=	:accept_bids_param2
														AND		DATE(bid_datetime)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(bid_datetime)	<= '".$this->getDbDateFormat($this->toDate)."'
														UNION
														SELECT 	payment_date rept_date,
																'Loan Repayments – Interest Repaid' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																(	SELECT 	payments.remarks
																	FROM	borrower_repayment_schedule bor_rep_sch
																			LEFT JOIN	payments
																			ON	payments.payment_id	= bor_rep_sch.payment_id	
																	WHERE	bor_rep_sch.loan_id	=	inv_rep_sch.loan_id
																	AND		bor_rep_sch.installment_number	=	
																							inv_rep_sch.installment_number
																)details,
																inv_rep_sch.interest_amount trans_amt,
																1 plus_or_minus,
																3 display_order,
																'' bid_amount,
																'' debit_amt,
																inv_rep_sch.interest_amount credit_amt
														FROM 	investor_repayment_schedule inv_rep_sch
																LEFT JOIN	loans
																ON	loans.loan_id	=	inv_rep_sch.loan_id
														WHERE	investor_id			=	{$current_inverstor_id}
														AND		inv_rep_sch.status	=	:repaid_ver_param1
														AND		DATE(inv_rep_sch.payment_date)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(inv_rep_sch.payment_date)	<= '".$this->getDbDateFormat($this->toDate)."'
														UNION
														SELECT 	payment_date rept_date,
																'Loan Repayments – Principal Repaid' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																(	SELECT 	payments.remarks
																	FROM	borrower_repayment_schedule bor_rep_sch
																			LEFT JOIN	payments
																			ON	payments.payment_id	= bor_rep_sch.payment_id	
																	WHERE	bor_rep_sch.loan_id	=	inv_rep_sch.loan_id
																	AND		bor_rep_sch.installment_number	=	inv_rep_sch.installment_number) 
																			details,
																inv_rep_sch.principal_amount trans_amt,
																1 plus_or_minus,
																3 display_order,
																'' bid_amount,
																'' debit_amt,
																inv_rep_sch.principal_amount credit_amt
														FROM 	investor_repayment_schedule inv_rep_sch
																LEFT JOIN	loans
																ON	loans.loan_id	=	inv_rep_sch.loan_id
														WHERE	investor_id			=	{$current_inverstor_id}
														AND		inv_rep_sch.status	=	:repaid_ver_param2
														AND		DATE(inv_rep_sch.payment_date)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(inv_rep_sch.payment_date)	<= '".$this->getDbDateFormat($this->toDate)."'
														UNION
														SELECT 	payment_date rept_date,
																'Loan Repayments – Penalty Earned' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																(	SELECT 	payments.remarks
																	FROM	borrower_repayment_schedule bor_rep_sch
																			LEFT JOIN	payments
																			ON	payments.payment_id	= bor_rep_sch.payment_id	
																	WHERE	bor_rep_sch.loan_id	=	inv_rep_sch.loan_id
																	AND		bor_rep_sch.installment_number	=	inv_rep_sch.installment_number) 
																			details,
																IFNULL(inv_rep_sch.penalty_amount,0) trans_amt,
																1 plus_or_minus,
																3 display_order,
																'' bid_amount,
																'' debit_amt,
																IFNULL(inv_rep_sch.penalty_amount,0) credit_amt
														FROM 	investor_repayment_schedule inv_rep_sch
																LEFT JOIN	loans
																ON	loans.loan_id	=	inv_rep_sch.loan_id
														WHERE	investor_id			=	{$current_inverstor_id}
														AND		inv_rep_sch.status	=	:repaid_ver_param3
														AND		DATE(inv_rep_sch.payment_date)	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		DATE(inv_rep_sch.payment_date)	<= '".$this->getDbDateFormat($this->toDate)."'
												) xx
												
												WHERE trans_type = {$trantype} ORDER BY rept_date_orderBy";			
		$dataArrayInvList				= 	[															
													"dep_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,
													"trans_ver_param1" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED,
													"with_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
													"trans_ver_param2" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED,
													"cancel_bids_param" => LOAN_BIDS_STATUS_CANCELLED,
													"reject_bids_param" => LOAN_BIDS_STATUS_REJECTED,
													"accept_bids_param" => LOAN_BIDS_STATUS_ACCEPTED,
													"accept_bids_param2" => LOAN_BIDS_STATUS_ACCEPTED,
													"repaid_ver_param1" => INVESTOR_REPAYMENT_STATUS_VERIFIED,
													"repaid_ver_param2" => INVESTOR_REPAYMENT_STATUS_VERIFIED,
													"repaid_ver_param3" => INVESTOR_REPAYMENT_STATUS_VERIFIED
											];
																			
		$this->tranList[$current_inverstor_id]	=	$this->dbFetchWithParam($investorActListSql, $dataArrayInvList);	
				
		$balance	=	$this->openingBalance[$current_inverstor_id];
		
		foreach($this->tranList[$current_inverstor_id] as $key=>$row) {
		   $crAmt	=	$row->credit_amt;
		   $dbAmt	=	$row->debit_amt;
		   if(empty($crAmt)) {
			   $crAmt  =	0;
			}
		   if(empty($dbAmt)) {
			   $dbAmt  =	0;
			}
			$balance	=	($balance+$crAmt)	-	$dbAmt;
			$this->tranList[$current_inverstor_id][$key]->balance	=	$balance;
		}
		return;
	
		
	}
}
