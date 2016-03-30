<?php namespace App\models;
class InvestorDashboardModel extends TranWrapper {

	public $allLoanInfo				= 	array();
	public $filterloanStatusList	= 	array();
	public $filterloanStatusValue	= 	'all';
	
	public function getInvestorDashboardDetails() {
		//~ $this->getInvestorLoanList();
		//~ $this->processDropDowns();
	}
		
	//~ public function getInvestorLoanList($filterLoanStatus) {
		
		//~ $this->filterloanStatusValue	= 	$filterLoanStatus;
		//~ $loanStatusWhere				=	" loans.status " . ($filterLoanStatus == "all"? " IN(3,6,9) ":
												//~ "=	{$filterLoanStatus}"." ");
		
		//~ $current_inverstor_id			=	 $this->getCurrentInvestorID();
		
		//~ $loanlist_sql					= "	SELECT 	loans.loan_id,
													//~ loans.borrower_id,
													//~ loans.loan_reference_number,
													//~ borrowers.business_name borrower_name,
													//~ borrowers.borrower_risk_grade,
													//~ loans.target_interest,
													//~ ROUND(loans.apply_amount,2) amount_applied ,
													//~ ROUND(loan_bids.bid_amount,2) amount_offered ,
													//~ ROUND(loan_bids.accepted_amount,2) amount_accepted ,
													//~ loan_bids.bid_interest_rate insterest_bid ,
													//~ case loan_bids.bid_status 
														   //~ when 1 then 'Bidded' 
														   //~ when 2 then 'Bid Accepted'
														   //~ when 3 then 'Bid Not Accepted'
													//~ end as status,
													//~ 'Loan Details' viewStatus
											//~ FROM 	loan_bids,
													//~ loans, 
													//~ borrowers
											//~ WHERE 	loan_bids.loan_id = loans.loan_id
											//~ AND 	loans.borrower_id = borrowers.borrower_id
											//~ AND		loan_bids.bid_status != 4
											//~ AND 	loan_bids.investor_id =  {$current_inverstor_id}
											//~ AND 	{$loanStatusWhere}
											//~ LIMIT 	4";
		//~ $loanlist_rs				= 	$this->dbFetchAll($loanlist_sql);
		//~ $rowIndex					=	0;
		
		//~ if ($loanlist_rs) {
			//~ foreach ($loanlist_rs as $loanRow) {
				//~ $rowValue	=	$loanRow;
				//~ $this->allLoanInfo[$rowIndex] = $rowValue;
				//~ $rowIndex++;
			//~ }
		//~ }
		//~ return	$loanlist_rs;
	//~ }
	
	//~ public function getBorrowerRepaymentSchedule($loan_id) {
		
		//~ $current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		//~ $loanlist_sql			= "	SELECT 	ifnull(DATE_FORMAT(loanrepsch.repayment_schedule_date,'%d/%m/%Y'),'') 
																							//~ repayment_schedule_date,
											//~ ROUND(loanrepsch.repayment_scheduled_amount,2) repayment_scheduled_amount,
											//~ case loanrepsch.repayment_status 
												   //~ when 1 then 'Unpaid' 
												   //~ when 2 then 'Paid'
											//~ end as repayment_status,
											//~ ifnull(DATE_FORMAT(loanrepsch.repayment_actual_date,'%d/%m/%Y'),'') 
																						//~ repayment_actual_date ,
											//~ ifnull(ROUND(loanrepsch.repayment_actual_amount,2),'') repayment_actual_amount
									//~ FROM 	loan_repayment_schedule loanrepsch
									//~ WHERE	loanrepsch.borrower_id		=	{$current_borrower_id}
									//~ AND		loanrepsch.loan_id			=	{$loan_id}";
		
		//~ $repayschedlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		//~ return	$repayschedlist_rs;
	//~ }
	
}
