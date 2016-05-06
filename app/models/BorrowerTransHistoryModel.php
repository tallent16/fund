<?php namespace App\models;
use Config;
use DB;
use Lang;

class BorrowerTransHistoryModel extends TranWrapper {
	
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
						
		$disbSql	=	"SELECT	disbursements.loan_id,
								loans.loan_reference_number,
								'Disbursement' tran_type,
								disbursements.disbursement_date tran_date,
								disbursements.amount_disbursed tran_amt,
								'Amount Disbursed Less Fees' transdetail,
								amount_disbursed loan_balance,
								1 display_order
						FROM	disbursements,
								loans
						WHERE	disbursements.borrower_id = {$borrowId}
						AND		disbursements.loan_id	=	loans.loan_id";
						
		$levySql	=	"SELECT	disbursements.loan_id,
								loans.loan_reference_number,
								'Levies ' tran_type,
								disbursements.disbursement_date tran_date,
								disbursements.total_fees_levied tran_amt,
								'Processing Fees Levied' transdetail,
								total_fees_levied loan_balance,
								2 display_order
						FROM	disbursements,
								loans
						WHERE	disbursements.borrower_id 	= {$borrowId}
						AND		disbursements.loan_id		=	loans.loan_id";
						
		$prinSql	=	"SELECT borrower_repayment_schedule.loan_id,
								loans.loan_reference_number,
								'Repayment' tran_type,
								borrower_repayment_schedule.repayment_actual_date tran_date,
								principal_component tran_amt, 
								'Principal Component of Repayment' transdetail,
								(-1) * principal_component loan_balance,
								1 display_order
						FROM	borrower_repayment_schedule,
								loans
						WHERE	borrower_repayment_schedule.borrower_id = {$borrowId}
						AND		borrower_repayment_schedule.loan_id		=	loans.loan_id
						AND		repayment_status = 3";
						
		$intrSql	=	"SELECT borrower_repayment_schedule.loan_id,
								loans.loan_reference_number,
								'Repayment' tran_type,
								borrower_repayment_schedule.repayment_actual_date tran_date,
								interest_component tran_amt, 
								'Interest Component of Repayment' transdetail,
								0 loan_balance,
								2 display_order
						FROM	borrower_repayment_schedule,
								loans
						WHERE	borrower_repayment_schedule.borrower_id = {$borrowId}
						AND		borrower_repayment_schedule.loan_id		=	loans.loan_id
						AND		repayment_status = 3";
						
		$penlSql	=	"SELECT borrower_repayment_schedule.loan_id,
								loans.loan_reference_number,
								'Repayment' tran_type,
								borrower_repayment_schedule.repayment_actual_date tran_date,
								repayment_penalty_amount tran_amt, 
								'Penalty for late payment' transdetail,
								0 loan_balance,
								3 display_order
						FROM	borrower_repayment_schedule,
								loans
						WHERE	borrower_repayment_schedule.borrower_id = {$borrowId}
						AND		borrower_repayment_schedule.loan_id		=	loans.loan_id
						AND		repayment_status = 3";
						
		$orderby	=	" ) loantrans WHERE tran_amt > 0 
						AND	tran_date BETWEEN '" . $this->getDbDateFormat($fromDate) . "' and '".
						$this->getDbDateFormat($toDate) . "' ORDER BY tran_date, display_order ";
		
		$selectCol	=	"	SELECT	loan_id,
									loan_reference_number,
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

		$this->dbEnableQueryLog();
		$transListSql	=	$mainSql;
		$tranListRs		=	$this->dbFetchAll($transListSql);
		echo "<pre>", print_r($this->dbGetLog(),"</pre>";
		die;
		$this->tranList = $tranListRs;
		return;
	
		
	}
	
	public function getBorrowerTransactionDetail($loan_id) {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$transListSql			= "	SELECT 	loans.loan_reference_number loan_ref_no,
											DATE_FORMAT(loans.bid_close_date,'%d-%m-%Y') bid_close_date,
											ROUND(loans.loan_sanctioned_amount,2) sanctioned_amount,
											loans.final_interest_rate interest_rate,
											ROUND((	SELECT 	SUM(borrower_repayment_schedule.principal_component)
													FROM	borrower_repayment_schedule
													WHERE	borrower_repayment_schedule.borrower_id		=	{$current_borrower_id}
													AND		borrower_repayment_schedule.loan_id			=	{$loan_id}
													AND		repayment_status != 3
												)
											,2) balance_outstanding
									FROM 	loans
									WHERE	loans.borrower_id		=	{$current_borrower_id}
									AND		loans.loan_id			=	{$loan_id}";
		
		$tranListRs				= 	$this->dbFetchRow($transListSql);
		return	$tranListRs;
	}
	
}
