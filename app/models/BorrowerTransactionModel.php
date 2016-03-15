<?php namespace App\models;
use Config;
use DB;

class BorrowerTransactionModel extends TranWrapper {
	public	$loanList = array();
	public  $tranList = array();
	
	public function viewTransList($fromDate, $toDate, $tranType) {
		$borrowId 	= getCurrentBorrowerID();

		$lnListSql	=	"SELECT loans.loan_id,
								loans.loan_reference_number,
								loans.apply_date,
								loans.bid_close_date,
								loans.apply_amount,
								ifnull(loans.loan_sactioned_amount, bids.total_bid_amount) bid_sanctioned_amount,
								loans.target_interest,
								loans.final_interest_rate,
								loans.loan_sactioned_amount - loans.total_principal_repaid balance_os,
								loans.status
						FROM	loans left outer join 
									(	SELECT 	loan_id, sum(bid_amount) total_bid_amount
										FROM	loan_bids
										GROUP BY loan_id) bids on bids.loan_id = loans.loan_id
						WHERE	status in (3,5,6,9)
						AND		borrower_id = {$borrowId}";
						
						
		$disbSql	=	"SELECT	loan_id,
								'Disbursement',
								disbursements.disbursement_date tran_date,
								disbursements.amount_disbursed,
								'Amount Disbursed',
								amount_disbursed loan_balance,
								1 display_order
						FROM	disbursements
						WHERE	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm ";
						
		$levySql	=	"SELECT	loan_id,
								'Levies ',
								disbursements.disbursement_date  tran_date,
								disbursements.total_fees_levied,
								'Total Fees Levied',
								total_fees_levied loan_balance,
								2 display_order
						FROM	disbursements
						where	borrower_id = {$borrowId} 
						AND		loan_id = :loan_idparm ";
						
		$prinSql	=	"SELECT 	loan_id,
								'Repayment',
								trans_date disbursement_date  tran_date,
								principal_paid, 
								'Principal Component',
								(-1) * principal_paid loan_balance,
								1 display_order
						FROM	borrower_repayments 
						where	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm ";
						
		$intrSql	=	"SELECT 	loan_id,
								'Repayment',
								trans_date  tran_date,
								interest_paid, 
								'Interest Component',
								0 loan_balance,
								2 display_order
						FROM	borrower_repayments
						where	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm ";
						
		$penlSql	=	"SELECT 	loan_id,
								'Repayment',
								trans_date  tran_date,
								penalty_paid, 
								'Penalty for late payment',
								0 loan_balance,
								3 display_order
						FROM	borrower_repayments
						where	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm ";
						
		$orderby	=	" order by loan_id, tran_date, display_order ";
		
		switch ($tranType) {
			case 'Disbursals':
				$mainSql	=	$disbSql.$orderby;
				break;
				
			case 'Fees':
				$mainSql	=	$levySql.$orderby;
				break;
			
			case 'Repayment':
				$mainSql	=	"SELECT * FROM ( ".
								$prinSql. " UNION ".
								$intrSql. " UNION ".
								$penlSql. " ) ".$orderby;
				break;

			case 'All':
				$mainSql	=	"SELECT * FROM ( ".
								$disbSql. " UNION ".
								$levySql. " UNION ".
								$prinSql. " UNION ".
								$intrSql. " UNION ".
								$penlSql. " ) ".$orderby;
				break;
		}
								
		$lnListRs			=	$this->dbFetchAll($lnListSql);
		foreach ($lnListRs as $lnListRow) {
			$loan_id 		=	$lnListRow->loan_id;
			$tranListRs		=	$this->dbFetchWithParam($mainSql, ['loan_idparm' => $loan_id]);
			
			
		}
			
			
	
		
	}
	
	
	
	
	
}
