<?php namespace App\models;
use Config;
use DB;
use Lang;

class BorrowerLoanSummaryModel extends TranWrapper {
	public	$loanList = array();
	public  $tranList = array();
	public	$tranTypeFilter;
	public	$fromDate;
	public  $toDate;
	public  $tranType;
	
	public function viewTransList($fromDate, $toDate, $tranType) {
		$this->tranTypeFilter = array (	"Disbursals"	=>	Lang::get("Disbursal"),
										"Fees"		=>	Lang::get("Levies"),
										"Repayment"	=>	Lang::get("Repayment"),
										"All"		=>	Lang::get("All")
									);
		$this->fromDate = $fromDate;
		$this->toDate = $toDate;
		$this->tranType = $tranType;
		
		$borrowId 	= $this->getCurrentBorrowerID();
 
		$lnListSql	=	"SELECT loans.loan_id,
								loans.loan_reference_number,
								DATE_FORMAT(loans.apply_date, '%d-%m-%Y') apply_date,
								DATE_FORMAT(loans.bid_close_date, '%d-%m-%Y') bid_close_date,
								round(loans.apply_amount,2) apply_amount,
								round(ifnull(loans.loan_sanctioned_amount, bids.total_bid_amount),2) bid_sanctioned_amount,
								loans.target_interest,
								round(loans.final_interest_rate,2) final_interest_rate,
								round(loans.loan_sanctioned_amount - loans.total_principal_repaid,2) balance_os,
								loans.status,
								total_milestone
						FROM	loans 
						LEFT OUTER JOIN 
								(	SELECT 	loan_id, sum(bid_amount) total_bid_amount
									FROM	loan_bids
									GROUP BY loan_id
								) bids on bids.loan_id = loans.loan_id
						LEFT OUTER JOIN 
								(	SELECT 	loan_id, count(milestone_name) total_milestone
									FROM	loan_milestones milstone
									GROUP BY loan_id
								) milstone on milstone.loan_id = loans.loan_id
						WHERE	status in (3,5,6,7,10)
						AND		borrower_id = {$borrowId}";
						
						
		$disbSql	=	"SELECT	loan_id,
								'Disbursement' tran_type,
								disbursements.disbursement_date tran_date,
								disbursements.amount_disbursed tran_amt,
								'Amount Disbursed Less Fees' transdetail,
								amount_disbursed loan_balance,
								1 display_order
						FROM	disbursements
						WHERE	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm ";
						
		$levySql	=	"SELECT	loan_id,
								'Levies ' tran_type,
								disbursements.disbursement_date tran_date,
								disbursements.total_fees_levied tran_amt,
								'Processing Fees Levied' transdetail,
								total_fees_levied loan_balance,
								2 display_order
						FROM	disbursements
						where	borrower_id = {$borrowId} 
						AND		loan_id = :loan_idparm ";
						
		$prinSql	=	"SELECT loan_id,
								'Repayment' tran_type,
								borrower_repayment_schedule.repayment_actual_date tran_date,
								principal_component tran_amt, 
								'Principal Component of Repayment' transdetail,
								(-1) * principal_component loan_balance,
								1 display_order
						FROM	borrower_repayment_schedule 
						where	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm 
						AND		repayment_status = 3";
						
		$intrSql	=	"SELECT loan_id,
								'Repayment' tran_type,
								borrower_repayment_schedule.repayment_actual_date tran_date,
								interest_component tran_amt, 
								'Interest Component of Repayment' transdetail,
								0 loan_balance,
								2 display_order
						FROM	borrower_repayment_schedule
						where	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm 
						AND		repayment_status = 3";
						
		$penlSql	=	"SELECT loan_id,
								'Repayment' tran_type,
								borrower_repayment_schedule.repayment_actual_date tran_date,
								ifnull(repayment_penalty_interest,0) + 
								ifnull(repayment_penalty_charges, 0) tran_amt, 
								'Penalty for late payment' transdetail,
								0 loan_balance,
								3 display_order
						FROM	borrower_repayment_schedule
						where	borrower_id = {$borrowId}
						AND		loan_id = :loan_idparm 
						AND		repayment_status = 3";
						
		$orderby	=	" ) loantrans where tran_amt > 0 
						and	tran_date between '" . $this->getDbDateFormat($fromDate) . "' and '".
						$this->getDbDateFormat($toDate) . "' order by loan_id, tran_date, display_order ";
		
		$selectCol	=	"	SELECT	loan_id,
									tran_type,
									date_format(tran_date, '%d-%m-%Y') tran_date,
									round(tran_amt,2) tran_amt,
									transdetail,
									round(loan_balance,2) loan_balance,
									display_order FROM ( ";
		switch ($tranType) {
			case 'Disbursals':
				$mainSql	=	$selectCol . $disbSql. $orderby;
				break;
				
			case 'Fees':
				$mainSql	=	$selectCol . $levySql. $orderby;
				break;
			
			case 'Repayment':
				$mainSql	=	$selectCol . $prinSql. " UNION ". $intrSql. " UNION ".
								$penlSql. $orderby;
				break;

			case 'All':
				$mainSql	=	$selectCol . 
								$disbSql. " UNION ".
								$levySql. " UNION ".
								$prinSql. " UNION ".
								$intrSql. " UNION ".
								$penlSql. $orderby;
				break;
		}

		$this->loanList			=	$this->dbFetchAll($lnListSql);
		foreach ($this->loanList as $lnListRow) {
			$loan_id 		=	$lnListRow->loan_id;
			$transListSql	=	str_replace(":loan_idparm", $loan_id, $mainSql);
			$tranListRs		=	$this->dbFetchAll($transListSql);
			$this->tranList[$loan_id] = $tranListRs;
		}
		return;
	
		
	}
	
	
	
	
	
}
