<?php namespace App\models;

class AdminInvestorActivityReportModel extends TranWrapper {
	
	public  $allactiveinvestList					=	array();
	public  $investActReport						=	array();
	public  $openingBalance							= 	array();
	public	$invFilterValue							=	array();
	public	$fromDateFilterValue					=	"";
	public	$toDateFilterValue						=	"";
	
	public function processInvestorDropDowns(){
	
		$filterSql						=	"SELECT users.firstname,
													investors.investor_id
											 FROM   investors,users
											 WHERE  investors.user_id = users.user_id 
											 AND    users.status = 2
											 AND    users.email_verified = 1";			
		/*$dataArrayInvList				= 	[															
												"userstatus_codeparam" => "2",
												"emailverified_codeparam" => "1"
											]	
																			
		$this->invListInfo				=	$this->dbFetchWithParam($filterSql, $dataArrayInvList);		*/				
								
		$filter_rs						= 	$this->dbFetchAll($filterSql);
		
		if (!$filter_rs	) {
			throw exception ("Not correct");
			return;
		}	
	   //~ $this->allactiveinvestList['selectAll'] = "All";
	   foreach($filter_rs as $filter_row) {
		   $inv_name 					= 	$filter_row->firstname;
		   $inv_id						=	$filter_row->investor_id;
		   
		   $this->allactiveinvestList[$inv_id] = $inv_name;
	   }
	}
	
	public function getInvestorActivityReportInfo($filterInv, $filterFromDate, $filterToDate) {

		$this->invFilterValue						=	$filterInv;
		$this->fromDateFilterValue					=	$filterFromDate;
		$this->toDateFilterValue					=	$filterToDate;
		foreach($filterInv as $filterInvRow) {
			$this->getOpeningBalanceByInvestorId($filterInvRow,$filterFromDate);
			$this->getInvestorActivityReportList($filterInvRow,$filterFromDate, $filterToDate);
		}
		//~ $this->prnt($this->investActReport);
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
	
	
	public function getInvestorActivityReportList($investor_id,$filterFromDate, $filterToDate) {
		
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
														SELECT 	trans_date rept_date,
																'Deposits' trans_type,
																'CR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																'' debit_amt,
																inv_tran.trans_amount credit_amt
														FROM 	investor_bank_transactions inv_tran
															LEFT JOIN	payments
															ON	payments.payment_id	=	inv_tran.payment_id	
														WHERE	investor_id	=	{$investor_id}
														AND		inv_tran.trans_type	=	:dep_trantype_param
														AND		inv_tran.status		=	:trans_ver_param1
														AND		trans_date	>= '".$filterFromDate."'
														AND		trans_date	<= '".$filterToDate."'
														UNION
														SELECT 	trans_date rept_date,
																'Withdrawals' trans_type,
																'DR' trans_type_orderBy,
																payments.trans_reference_number ref_no,
																payments.remarks details,
																inv_tran.trans_amount debit_amt,
																'' credit_amt
														FROM 	investor_bank_transactions inv_tran
															LEFT JOIN	payments
															ON	payments.payment_id	=	inv_tran.payment_id	
														WHERE	investor_id	=	{$investor_id}
														AND		inv_tran.trans_type	=	:with_trantype_param
														AND		inv_tran.status		=	:trans_ver_param2
														AND		trans_date	>= '".$filterFromDate."'
														AND		trans_date	<= '".$filterToDate."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments - Bids' trans_type,
																'DR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																loan_bids.remarks details,
																loan_bids.bid_amount debit_amt,
																'' credit_amt
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
														WHERE	investor_id	=	{$investor_id}
														AND		DATE(bid_datetime)	>= '".$filterFromDate."'
														AND		DATE(bid_datetime)	<= '".$filterToDate."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments – Bids Cancelled' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																loan_bids.remarks details,
																'' debit_amt,
																loan_bids.bid_amount credit_amt
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
														WHERE	investor_id	=	{$investor_id}
														AND		bid_status		=	:cancel_bids_param
														AND		DATE(bid_datetime)	>= '".$filterFromDate."'
														AND		DATE(bid_datetime)	<= '".$filterToDate."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments – Bids Rejected' trans_type,
																'CR' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																loan_bids.remarks details,
																'' debit_amt,
																loan_bids.bid_amount credit_amt
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
														WHERE	investor_id		=	{$investor_id}
														AND		bid_status		=	:reject_bids_param
														AND		DATE(bid_datetime)	>= '".$filterFromDate."'
														AND		DATE(bid_datetime)	<= '".$filterToDate."'
														UNION
														SELECT 	bid_datetime rept_date,
																'Investments – Investment Accepted' trans_type,
																'XX' trans_type_orderBy,
																loans.loan_reference_number ref_no,
																loan_bids.remarks details,
																loan_bids.accepted_amount debit_amt,
																loan_bids.bid_amount credit_amt
														FROM 	loan_bids
															LEFT JOIN	loans
															ON	loans.loan_id	=	loan_bids.loan_id	
														WHERE	investor_id		=	{$investor_id}
														AND		bid_status		=	:accept_bids_param
														AND		DATE(bid_datetime)	>= '".$filterFromDate."'
														AND		DATE(bid_datetime)	<= '".$filterToDate."'
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
																'' debit_amt,
																inv_rep_sch.interest_amount credit_amt
														FROM 	investor_repayment_schedule inv_rep_sch
																LEFT JOIN	loans
																ON	loans.loan_id	=	inv_rep_sch.loan_id
														WHERE	investor_id			=	{$investor_id}
														AND		inv_rep_sch.status	=	:repaid_ver_param1
														AND		inv_rep_sch.payment_date	>= '".$filterFromDate."'
														AND		inv_rep_sch.payment_date	<= '".$filterToDate."'
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
																'' debit_amt,
																inv_rep_sch.principal_amount credit_amt
														FROM 	investor_repayment_schedule inv_rep_sch
																LEFT JOIN	loans
																ON	loans.loan_id	=	inv_rep_sch.loan_id
														WHERE	investor_id			=	{$investor_id}
														AND		inv_rep_sch.status	=	:repaid_ver_param2
														AND		inv_rep_sch.payment_date	>= '".$filterFromDate."'
														AND		inv_rep_sch.payment_date	<= '".$filterToDate."'
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
																'' debit_amt,
																IFNULL(inv_rep_sch.penalty_amount,0) credit_amt
														FROM 	investor_repayment_schedule inv_rep_sch
																LEFT JOIN	loans
																ON	loans.loan_id	=	inv_rep_sch.loan_id
														WHERE	investor_id			=	{$investor_id}
														AND		inv_rep_sch.status	=	:repaid_ver_param3
														AND		inv_rep_sch.payment_date	>= '".$filterFromDate."'
														AND		inv_rep_sch.payment_date	<= '".$filterToDate."'
												) xx
												where debit_amt > 0 or credit_amt > 0
												ORDER BY  rept_date_orderBy, trans_type_orderBy, ref_no";			
		$dataArrayInvList				= 	[															
													"dep_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,
													"trans_ver_param1" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED,
													"with_trantype_param" => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
													"trans_ver_param2" =>INVESTOR_BANK_TRANS_STATUS_VERIFIED,
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
