<?php namespace App\models;
use Config;
use DB;
use Lang;

class InvestorTransHistoryModel extends TranWrapper {
	
	public  $tranList = array();
	
	public function getInvestorTransList() {
	
		$current_inverstor_id	=	 $this->getCurrentInvestorID();
						
		$transListSql	=	"SELECT * FROM (
									SELECT	payments.trans_reference_number,
											payments.trans_date,
											if (payments.trans_type = 1, 'Deposits', 'Withdrawals') trans_type,
											payments.trans_amount,
											payments.remarks,
											if (payments.trans_type = 1, 1, -1) plus_or_minus,
											1 display_order
									FROM	payments,
											investor_bank_transactions
									WHERE	investor_bank_transactions.payment_id = payments.payment_id
									AND	investor_bank_transactions.investor_id = 2
									UNION
									SELECT	loans.loan_reference_number,
											loans.loan_process_date,
											'Investments',
											loan_bids.accepted_amount,
											concat('Invested in Loan @', loan_bids.bid_interest_rate, '%'),
											-1,
											2 display_order
									FROM	loans,
											loan_bids
									WHERE	loans.loan_id = loan_bids.loan_id
									AND	loans.status = 6
									and	loan_bids.investor_id = {$current_inverstor_id}
									UNION
									SELECT	loans.loan_reference_number,
											date_format(investor_repayment_schedule.payment_date, '%d-%m-%y'),
											'Repayment for investments',
											payment_schedule_amount + 
											ifnull (investor_repayment_schedule.penalty_amount, 0),
											concat('Int Recd. ', format(investor_repayment_schedule.interest_amount, 2),
												if (isnull(penalty_amount), '', concat('Penalty recd', format(penalty_amount,2)))),
											1,
											3 display_order
									FROM	loans,
											investor_repayment_schedule
									WHERE	loans.loan_id = investor_repayment_schedule.loan_id
									AND	investor_repayment_schedule.investor_id = 2
									AND	investor_repayment_schedule.status = 3) investor_transaction
							order by trans_date, display_order";
							
		$tranListRs		=	$this->dbFetchAll($transListSql);
		$this->tranList = $tranListRs;
		return;
	
		
	}
}