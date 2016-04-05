<?php namespace App\models;
class InvestorDashboardModel extends TranWrapper {

	public	$featuredLoanInfo	= 	array();
	public	$featuredLoanJson	= 	"";
	public	$barChartJson			= 	"";
	public	$fundsDepolyedInfo		= 	array();
	public	$invUnderBidInfo		= 	array();
	public	$overDueInfo			= 	array();
	public	$invested_amount 		=	0;
	public	$pending_investment 	=	0;
	public	$deposits 				=	0;
	public	$pending_deposits 		=	0;
	public	$withdrawals			=	0;
	public	$pending_withdrawals 	=	0;
	
	public function getInvestorDashboardDetails() {
		
		$loanlistRs					=	$this->getInvestorFeaturedLoanList();
		$this->featuredLoanJson		=	json_encode($loanlistRs);
		$this->featuredLoanInfo		=	$loanlistRs;
		$this->barChartJson			=	json_encode($this->getInvestorBarChart());
		$this->getInvestorFundsDepolyed();
		$this->getInvestorLoanUderBid();
		$this->getInvestorOverDue();
		$this->getInvestorAccountSummary();
	}
		
	public function getInvestorFeaturedLoanList() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		
		$loanlist_rs					=	array();
		
		$loanlist_sql					= "	SELECT	borrowers.business_name,
													loans.purpose,
													loans.final_interest_rate rate,
													loans.loan_tenure,
													ROUND(loans.loan_sanctioned_amount,2) amount,
													case loans.repayment_type 
														   when 1 then 'Bullet' 
														   when 2 then 'Monthly Interest'
														   when 3 then 'EMI'
													end as repayment_type,
													case loans.bid_type 
														   when 1 then 'Open Bid' 
														   when 2 then 'Closed Bid'
														   when 3 then 'Fixed Interest'
													end as bid_type
											FROM	loans,
													borrowers,
													featured_loans
											WHERE	loans.loan_id	IN
																(
																	SELECT 	loan_id
																	FROM	loan_bids
																	WHERE	investor_id	=	{$current_inverstor_id}
																)
											AND		loans.loan_id		=	featured_loans.loan_id
											AND		loans.borrower_id	=	borrowers.borrower_id
											";
		$loanlist_rs				= 	$this->dbFetchAll($loanlist_sql);
		return	$loanlist_rs;
	}
	
	public function getInvestorBarChart() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		$barchart_rs					=	array();
		$barchart_sql					=	"	SELECT	pay_period,
														SUM(interest_amount),
														SUM(bal_os),
														ROUND(SUM(interest_amount) * 1200 / SUM(bal_os), 2) 
												FROM 	(
														SELECT 	date_format(payment_date, '%Y%m') pay_period,
															main_irs.loan_id,
															interest_amount, 
															bid_interest_rate,        
															interest_amount * 1200 / bid_interest_rate bal_os
														FROM	investor_repayment_schedule main_irs,
															loan_bids
														WHERE	status = 3
														AND		main_irs.investor_id = {$current_inverstor_id}
														AND		main_irs.loan_id = loan_bids.loan_id
														AND		main_irs.investor_id = loan_bids.investor_id ) repay
												GROUP BY pay_period";
												
		$barchart_rs					= 	$this->dbFetchAll($barchart_sql);
		return	$barchart_rs;
												
	}
	
	public function getInvestorFundsDepolyed() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		$fundsdepolyed_rs				=
		$fundsdepolyed_sql				= "SELECT	borrowers.business_name,
													borrowers.borrower_risk_grade,
													loan_sanctioned_amount,
													bid_amount,
													date_format(bid_datetime, '%d-%m-%y') date_of_investment
													loan_tenure,
													case loans.bid_type 
														   when 1 then 'Open Bid' 
														   when 2 then 'Closed Bid'
														   when 3 then 'Fixed Interest'
													end as bid_type,
													bid_interest_rate,
														(	SELECT	sum(principal_amount) principal_amount_paid
														FROM	investor_repayment_schedule
															WHERE	loan_id = loans.loan_id
														AND	status =  3),
													(	SELECT	sum(interest_amount)
														FROM	investor_repayment_schedule
														WHERE	loan_id = loans.loan_id
														AND	status =  3) interest_paid
											FROM	borrowers,
													loans,
													loan_bids
											WHERE	loans.borrower_id = borrowers.borrower_id
											AND		loans.loan_id = loan_bids.loan_id
											AND		loans.status = 6
											AND		loan_bids.investor_id = {$current_inverstor_id}";
		$fundsdepolyed_rs				= 	$this->dbFetchAll($fundsdepolyed_sql);
		if ($fundsdepolyed_rs) {
			foreach ($fundsdepolyed_rs as $loanRow) {
				$newrow = count($this->fundsDepolyedInfo);
				$newrow ++;
				foreach ($loanRow as $colname => $colvalue) {
					$this->fundsDepolyedInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $fundsdepolyed_rs;
	}
	
	public function getInvestorLoanUderBid() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		$loanUnderBid_rs				=	array();
		$loanUnderBid_sql				= "SELECT	borrowers.business_name,
													borrowers.borrower_risk_grade,
													apply_amount,
													bid_amount,
													date_format(bid_datetime, '%d-%m-%y') date_of_investment,
													date_format(bid_close_date, '%d-%m-%y') bid_close_date,
													loan_tenure,
													case loans.bid_type 
														   when 1 then 'Open Bid' 
														   when 2 then 'Closed Bid'
														   when 3 then 'Fixed Interest'
													end as bid_type
											FROM	borrowers,
													loans,
													loan_bids
											WHERE	loans.borrower_id = borrowers.borrower_id
											AND		loans.loan_id = loan_bids.loan_id
											AND		loan_bids.investor_id = {$current_inverstor_id}
											AND		loans.status in (3, 5)";
		$loanUnderBid_rs				= 	$this->dbFetchAll($loanUnderBid_sql);
		if ($loanUnderBid_rs) {
			foreach ($loanUnderBid_rs as $loanRow) {
				$newrow = count($this->invUnderBidInfo);
				$newrow ++;
				foreach ($loanRow as $colname => $colvalue) {
					$this->invUnderBidInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $loanUnderBid_rs;
	}
	
	public function getInvestorOverDue() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		$overDue_rs						=	array();
		
		$overDue_sql					= "SELECT	borrowers.business_name,
													borrowers.borrower_risk_grade,
													accepted_amount,
													payment_schedule_amount,
													datediff(now(),payment_scheduled_date)  overdue_since
													installment_number
											FROM	borrowers,
													loans,
													loan_bids,
													investor_repayment_schedule
											WHERE	loans.borrower_id = borrowers.borrower_id
											AND		loans.loan_id = loan_bids.loan_id
											AND		investor_repayment_schedule.loan_id = loans.loan_id
											AND		investor_repayment_schedule.investor_id = loan_bids.investor_id
											AND		payment_scheduled_date < now()
											AND		investor_repayment_schedule.status != 3
											AND		loan_bids.investor_id = {$current_inverstor_id}
											AND		loans.status = 6";
		$overDue_rs						= 	$this->dbFetchAll($overDue_sql);
		if ($overDue_rs) {
			foreach ($overDue_rs as $loanRow) {
				$newrow = count($this->overDueInfo);
				$newrow ++;
				foreach ($loanRow as $colname => $colvalue) {
					$this->overDueInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $overDue_rs;
	}
	
	public function getInvestorAccountSummary() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		
		$invested_amount_sql			= 	"	SELECT 	ROUND(SUM(principal_amount),2) 
												FROM 	investor_repayment_schedule
												WHERE	status != 3 
												AND 	investor_id = {$current_inverstor_id}";
	
		$this->invested_amount			=	$this->dbFetchOne($invested_amount_sql);
		
		$pending_investment_sql			=	"	SELECT	ROUND(SUM(bid_amount),2)  
												FROM	loan_bids 
												WHERE	bid_status = 1 
												AND		investor_id = {$current_inverstor_id}";
												
		$this->pending_investment		=	$this->dbFetchOne($pending_investment_sql);
	
		$deposits_sql					=	"	SELECT 	ROUND(SUM(trans_amount),2) 
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 2
												AND		trans_type = 1"; 
		$this->deposits					=	$this->dbFetchOne($deposits_sql);

		$pending_deposits_sql			=	"	SELECT 	ROUND(SUM(trans_amount),2) 
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 1
												AND		trans_type = 1"; 
												
		$this->pending_deposits			=	$this->dbFetchOne($pending_deposits_sql);
		
		$withdrawals_sql				=	"	SELECT 	SUM(trans_amount)
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 2
												AND		trans_type = 2"; 
		$this->withdrawals				=	$this->dbFetchOne($pending_deposits_sql);
		
		$pending_withdrawals_sql		=	"	SELECT 	SUM(trans_amount)
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 1
												AND		trans_type = 2"; 
		$this->pending_withdrawals		=	$this->dbFetchOne($pending_deposits_sql);

	}
}
