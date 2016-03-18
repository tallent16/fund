<?php namespace App\models;
class InvestorMyLoanInfoModel extends TranWrapper {

	public $allLoanInfo		= 	array();
	
	public function getInvestorAllLoanDetails() {
		$this->getInvestorLoanList();
	}
		
	public function getInvestorLoanList() {
		
		$current_inverstor_id	=	 $this->getCurrentInvestorID();
		
		$loanlist_sql			= "	SELECT 	loans.loan_id,
											loans.borrower_id,
											loans.loan_reference_number,
											borrowers.business_name borrower_name,
											borrowers.borrower_risk_grade,
											loans.target_interest,
											ROUND(loans.apply_amount,2) amount_applied ,
											'' amount_offered ,
											'' amount_accepted ,
											loan_bids.bid_interest_rate insterest_bid ,
											'' status,
											'Loan Details' viewStatus
									FROM 	loan_bids,
											loans, 
											borrowers,
											investors
									WHERE	investors.investor_id		=	{$current_inverstor_id}
									AND		investors.investor_id		=	loan_bids.investor_id
									AND		loan_bids.loan_id			=	loans.loan_id
									AND		loans.borrower_id			=	borrowers.borrower_id
									LIMIT 4";
		
		$loanlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		$rowIndex			=	0;
		if ($loanlist_rs) {
			foreach ($loanlist_rs as $loanRow) {
				$rowValue	=	$loanRow;
				$this->allLoanInfo[$rowIndex] = $rowValue;
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
