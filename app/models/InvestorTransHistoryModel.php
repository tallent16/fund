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
	public function getInvestorTransList($fromDate, $toDate, $transType) {
		
		$this->tranTypeFilter = array (	"Withdrawals"				=>	Lang::get("Withdrawals"),
										"Deposits"					=>	Lang::get("Deposits"),
										"Investments Accepted"		=>	Lang::get("Investments Accepted"),
										"Investments under Bid"		=>	Lang::get("Investments under Bid"),
										"Repayment for investments"	=>	Lang::get("Repayment for investments"),
										"Bid Cancelled"				=>	Lang::get("Bid Cancelled"),
										"All"						=>	Lang::get("All")
									);
		
		$this->fromDate = $fromDate;
		$this->toDate 	= $toDate;
		$this->tranType = $transType;
		
		$current_inverstor_id	=	 $this->getCurrentInvestorID();
		$this->current_inverstor_id = $current_inverstor_id;
		$trantype	= ($this->tranType == 'All' ?'trans_type' : "'{$this->tranType}'");
		
		$transListSql	=	"SELECT trans_reference_number,
									date_format(trans_date, '%d-%m-%Y') trans_date,
									date_format(trans_date, '%Y-%m-%d') date_order,
									trans_type,
									trans_amount,
									remarks,
									plus_or_minus,
									display_order
							FROM (
									SELECT	payments.trans_reference_number,
											payments.trans_datetime trans_date,
											if (investor_bank_transactions.trans_type = :invbankwithdrawal, 'Withdrawals', 'Deposits') trans_type,
											payments.trans_amount,
											payments.remarks,
											if (investor_bank_transactions.trans_type = :invbankdeposit, 1, -1) plus_or_minus,
											1 display_order
									FROM	payments,
											investor_bank_transactions
									WHERE	investor_bank_transactions.payment_id = payments.payment_id
									AND		payments.status = :payment_status_verified
									AND		investor_bank_transactions.investor_id = {$current_inverstor_id}
									UNION
									SELECT	loans.loan_reference_number,
											loans.loan_process_date,
											'Investments Accepted',
											loan_bids.accepted_amount,
											concat('Invested in ',borrowers.business_name,', Loan @', loan_bids.bid_interest_rate, '%'),
											-1,
											2 display_order
									FROM	loans,
											loan_bids,
											borrowers
									WHERE	loans.loan_id = loan_bids.loan_id
									and loans.borrower_id = borrowers.borrower_id
									AND	loans.status = :loan_status_disbursed
									and	loan_bids.bid_status = :loan_bids_accepted
									and	loan_bids.investor_id = {$current_inverstor_id}
									UNION
									SELECT	loans.loan_reference_number,
											bid_datetime,
											'Investments under Bid',
											loan_bids.bid_amount,
											concat('Bidded in ',borrowers.business_name, ', Loan @', loan_bids.bid_interest_rate, '%'),
											-1,
											2 display_order
									FROM	loans,
											loan_bids,
											borrowers
									WHERE	loans.loan_id = loan_bids.loan_id
									and loans.borrower_id = borrowers.borrower_id
									AND	loans.status = :loan_status_approved
								    AND	loans.status != :loan_status_disbursed1 	
								    and loan_bids.bid_status IN (1)							
									and	loan_bids.investor_id = {$current_inverstor_id}
									UNION
									SELECT	concat('REP-',loans.loan_id,'-',investor_repayment_schedule.installment_number) loan_reference_number,
											date_format(investor_repayment_schedule.payment_date, '%Y-%m-%d') payment_date,
											'Repayment for investments',
											payment_schedule_amount + 
											ifnull (investor_repayment_schedule.penalty_amount, 0),
											concat('Int Recd: ', format(investor_repayment_schedule.interest_amount, 2),
												if (isnull(penalty_amount), '', concat(' | ','Penalty Recd:', format(penalty_amount,2)))),
											1,
											3 display_order
									FROM	loans,
											investor_repayment_schedule
									WHERE	loans.loan_id = investor_repayment_schedule.loan_id
									AND	investor_repayment_schedule.investor_id = {$current_inverstor_id}
									AND	investor_repayment_schedule.status = :payment_verified
									UNION
									SELECT	loans.loan_reference_number,
											bid_datetime,
											'Bid Cancelled',
											loan_bids.bid_amount,
											concat('Bid Cancelled in ',borrowers.business_name, ', Loan @', loan_bids.bid_interest_rate, '%'),
											1,
											4 display_order
									FROM	loans,
											loan_bids,
											borrowers
									WHERE	loans.loan_id = loan_bids.loan_id
									and loans.borrower_id = borrowers.borrower_id
									
								   
									AND	loan_bids.bid_status IN ( :loan_status_cancelled)
								
									and	loan_bids.investor_id = {$current_inverstor_id}
									) investor_transaction
									WHERE trans_type = {$trantype}
									AND trans_date
									BETWEEN  '" . $this->getDbDateFormat($fromDate) . "' 
									and '".	$this->getDbDateFormat($toDate) . "' 
									order by date_order , display_order";
		
		$array_conditions	=	[	'invbankwithdrawal' => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
									'invbankdeposit'	=> INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,
									'loan_status_disbursed'	=>	LOAN_STATUS_DISBURSED,
									'loan_status_disbursed1'	=>	LOAN_STATUS_DISBURSED,
									'loan_bids_accepted' => LOAN_BIDS_STATUS_ACCEPTED,
									
									'loan_status_approved' => LOAN_STATUS_APPROVED,
									
									
									'loan_status_cancelled' => LOAN_BIDS_STATUS_CANCELLED,
									
									'payment_verified'	=>	INVESTOR_REPAYMENT_STATUS_VERIFIED,
									'payment_status_verified' => PAYMENT_STATUS_VERIFIED,
																
									];
		//~ echo "<pre>",print_r($transListSql),"</pre>";
		//~ $tranListRs		=	$this->dbFetchWithParam($transListSql, $array_conditions);
		//~ $this->tranList = $tranListRs;
		
		
		
		$investorActListSql				=	"	SELECT 	DATE_FORMAT(rept_date,'%d-%m-%Y') trans_date,
														DATE_FORMAT(rept_date,'%Y-%m-%d') rept_date_orderBy,
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
														AND		trans_date	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		trans_date	<= '".$this->getDbDateFormat($this->toDate) ."'
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
														AND		trans_date	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		trans_date	<= '".$this->getDbDateFormat($this->toDate )."'
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
																loan_bids.remarks details,
																loan_bids.bid_amount trans_amt,
																1 plus_or_minus,
																1 display_order,
																'' bid_amount,
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
																
																loan_bids.accepted_amount trans_amt,
																1 plus_or_minus,
																1 display_order,
																loan_bids.bid_amount,
																loan_bids.accepted_amount debit_amt,
																loan_bids.bid_amount credit_amt
																
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
														AND		inv_rep_sch.payment_date	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		inv_rep_sch.payment_date	<= '".$this->getDbDateFormat($this->toDate)."'
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
														AND		inv_rep_sch.payment_date	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		inv_rep_sch.payment_date	<= '".$this->getDbDateFormat($this->toDate)."'
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
														AND		inv_rep_sch.payment_date	>= '".$this->getDbDateFormat($this->fromDate)."'
														AND		inv_rep_sch.payment_date	<= '".$this->getDbDateFormat($this->toDate)."'
												) xx
												
												ORDER BY  rept_date_orderBy ,trans_type";			
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
		
		//~ echo "<pre>",print_r($this->investActReport[$current_inverstor_id]),"</pre>";
		
		$cur_invbalance = $this->getInvestorInfoById($current_inverstor_id);		
		$balance	= $cur_invbalance->available_balance;
		
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
