<?php namespace App\models;
class BorrowerMyLoanInfoModel extends TranWrapper {

	public $allloan_details					= 	array();
	
	public function getBorrowerAllLoanDetails() {
		$this->getBorrowerLoanList();
	}
		
	public function getBorrowerLoanList() {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$loanlist_sql			= "	SELECT 	loans.loan_id,
											loans.borrower_id,
											loans.loan_reference_number,
											ifnull(DATE_FORMAT(loans.apply_date,'%d %b %Y'),'') apply_date,
											loans.status,
											case loans.status 
												   when 1 then 'New' 
												   when 2 then 'Submitted for Approval'
												   when 3 then 'Pending Comments'
												   when 4 then 'Approved for Bid'
												   when 5 then 'Bid Closed'
												   when 6 then 'Loan Disbursed'
												   when 7 then 'Repayments Complete'
											end as statusText,
											case loans.status 
												   when 1 then 'Edit Loan' 
												   when 2 then 'Loan Details'
												   when 3 then 'Edit Loan'
												   when 4 then 'Loan Details'
												   when 5 then 'Loan Details'
												   when 6 then 'Loan Details'
												   when 7 then 'Loan Details'
											end as viewStatus,
											case loans.repayment_type 
												   when 1 then 'Bullet' 
												   when 2 then 'Monthly Interest'
												   when 3 then 'EMI'
											end as repayment_type,
											case loans.bid_type 
												   when 1 then 'Open Bid' 
												   when 2 then 'Closed Bid'
												   when 3 then 'Fixed Interest '
											end as bid_type,
											loans.target_interest,
											ROUND(loans.apply_amount,2) amount_applied ,
											ROUND(loans.loan_sanctioned_amount,2) amount_realized,
											 ROUND((loans.apply_amount - loans.loan_sanctioned_amount),2) outstanding
									FROM 	loans,
											borrowers 
									WHERE	borrowers.borrower_id		=	{$current_borrower_id}
									AND		borrowers.borrower_id			=	loans.borrower_id
									LIMIT 4";
		
		$loanlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		$rowIndex			=	0;
		if ($loanlist_rs) {
			foreach ($loanlist_rs as $loanRow) {
				$rowValue	=	$loanRow;
				$this->allloan_details[$rowIndex] = $rowValue;
				$rowIndex++;
			}
		}
		return	$loanlist_rs;
	}
	
	public function getBorrowerRepaymentSchedule($loan_id) {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$loanlist_sql			= "	SELECT 	ifnull(DATE_FORMAT(loanrepsch.repayment_schedule_date,'%d/%m/%Y'),'') 
																							repayment_schedule_date,
											ROUND(loanrepsch.repayment_scheduled_amount,2) repayment_scheduled_amount,
											case loanrepsch.repayment_status 
												   when 1 then 'Unpaid' 
												   when 2 then 'Paid'
											end as repayment_status,
											ifnull(DATE_FORMAT(loanrepsch.repayment_actual_date,'%d/%m/%Y'),'') 
																						repayment_actual_date ,
											ifnull(ROUND(loanrepsch.repayment_actual_amount,2),'') repayment_actual_amount
									FROM 	loan_repayment_schedule loanrepsch
									WHERE	loanrepsch.borrower_id		=	{$current_borrower_id}
									AND		loanrepsch.loan_id			=	{$loan_id}";
		
		$repayschedlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		return	$repayschedlist_rs;
	}
	
}
