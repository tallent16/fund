<?php namespace App\models;
use Config;
use DB;
use Lang;

class InvestorTransHistoryModel extends TranWrapper {
	
	public  $tranList = array();
	
	public function getInvestorTransList() {
	
		$current_inverstor_id	=	 $this->getCurrentInvestorID();
						
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
											concat('Invested in Loan @', loan_bids.bid_interest_rate, '%'),
											-1,
											2 display_order
									FROM	loans,
											loan_bids
									WHERE	loans.loan_id = loan_bids.loan_id
									AND	loans.status = :loan_status_disbursed
									and	loan_bids.bid_status = :loan_bids_accepted
									and	loan_bids.investor_id = {$current_inverstor_id}
									UNION
									SELECT	loans.loan_reference_number,
											bid_datetime,
											'Investments under Bid',
											loan_bids.bid_amount,
											concat('Invested in Loan @', loan_bids.bid_interest_rate, '%'),
											-1,
											2 display_order
									FROM	loans,
											loan_bids
									WHERE	loans.loan_id = loan_bids.loan_id
									AND	loans.status = :loan_status_approved
									AND	loan_bids.bid_status = :bid_status_open
									and	loan_bids.investor_id = {$current_inverstor_id}
									UNION
									SELECT	concat('REP-',loans.loan_id,'-',investor_repayment_schedule.installment_number) loan_reference_number,
											date_format(investor_repayment_schedule.payment_date, '%d-%m-%y'),
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
									) investor_transaction
							order by date_order , display_order";
		
		$array_conditions	=	[	'invbankwithdrawal' => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
									'invbankdeposit'	=> INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,
									'loan_status_disbursed'	=>	LOAN_STATUS_DISBURSED,
									'loan_bids_accepted' => LOAN_BIDS_STATUS_ACCEPTED,
									'loan_status_approved' => LOAN_STATUS_APPROVED,
									'bid_status_open' 	=>	LOAN_BIDS_STATUS_OPEN,
									'payment_verified'	=>	INVESTOR_REPAYMENT_STATUS_VERIFIED,
									'payment_status_verified' => PAYMENT_STATUS_VERIFIED
									];
		
		$tranListRs		=	$this->dbFetchWithParam($transListSql, $array_conditions);
		$this->tranList = $tranListRs;
		return;
	
		
	}
}
