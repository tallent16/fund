<?php namespace App\models;
class InvestorDashboardModel extends TranWrapper {

	public	$featuredLoanInfo		= 	array();
	public	$featuredLoanJson		= 	"";
	public	$barChartJson				= 	"";
	public	$fundsDepolyedInfo			= 	array();
	public	$invUnderBidInfo			= 	array();
	public	$overDueInfo				= 	array();
	public	$invested_amount 			=	0;
	public	$pending_investment 		=	0;
	public	$deposits 					=	0;
	public	$pending_deposits 			=	0;
	public	$withdrawals				=	0;
	public	$pending_withdrawals 		=	0;
	public	$earnings_verified			=	0;
	public	$earnings_pending 			=	0;
	public	$ava_for_invest 			=	0;
	public	$isFeaturedLoanInfo 		=	"";
	
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
													loans.loan_id,
													IFNULL(loans.target_interest,0.00) rate,
													loans.loan_tenure duration,
													ROUND(loans.apply_amount,2) amount,
													case loans.repayment_type 
														   when 1 then 'Bullet' 
														   when 2 then 'Monthly Interest'
														   when 3 then 'EMI'
													end as repayment_type,
													case loans.bid_type 
														   when 1 then 'Open Bid' 
														   when 2 then 'Closed Bid'
														   when 3 then 'Fixed Interest'
													end as bid_type,
													(	SELECT	sum(a.bid_amount)
														FROM	loan_bids a
														WHERE	a.loan_id = loans.loan_id
														AND		a.investor_id	=	{$current_inverstor_id}
													) amount_realized,
													date_format(loans.bid_close_date , '%d-%m-%Y') close_date,
													loans.funding_duration
													
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
	
		if($loanlist_rs) {
			
			$this->isFeaturedLoanInfo	=	"yes";
		}else{
			
			$this->isFeaturedLoanInfo	=	"no";
			$loanlist_sql					= "	SELECT	loans.loan_id,borrowers.business_name,
													loans.purpose,
													IFNULL(loans.target_interest,0.00) rate,
													loans.loan_tenure duration,
													ROUND(loans.apply_amount,2) amount,
													case loans.repayment_type 
														   when 1 then 'Bullet' 
														   when 2 then 'Monthly Interest'
														   when 3 then 'EMI'
													end as repayment_type,
													case loans.bid_type 
														   when 1 then 'Open Bid' 
														   when 2 then 'Closed Bid'
														   when 3 then 'Fixed Interest'
													end as bid_type,
													(	SELECT	sum(a.bid_amount)
														FROM	loan_bids a
														WHERE	a.loan_id = loans.loan_id
														AND		a.investor_id	=	{$current_inverstor_id}
													) amount_realized,
													date_format(loans.bid_close_date , '%d-%m-%Y') close_date,
													loans.funding_duration
											FROM	loans,
													borrowers
											WHERE	loans.status = 3
											AND		loans.borrower_id	=	borrowers.borrower_id
											";
		$loanlist_rs				= 	$this->dbFetchAll($loanlist_sql);
		}
		return	$loanlist_rs;
	}
	
	public function getInvestorBarChart() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		$barchart_rs					=	array();
		$barchart_sql					=	"	SELECT	pay_period,
														SUM(interest_amount),
														SUM(bal_os),
														ROUND(SUM(interest_amount) * 1200 / SUM(bal_os), 2) percentage_payment
												FROM 	(
														SELECT 	date_format(payment_date, '%b %y') pay_period,
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
													date_format(bid_datetime, '%d-%m-%y') date_of_investment,
													date_format(loans.bid_close_date, '%d-%m-%y') close_date,
													'0.00' amount_realized,
													loans.funding_duration,
													loans.loan_risk_grade,
													loan_tenure,
													case loans.bid_type 
														   when 1 then 'Open Bid' 
														   when 2 then 'Closed Bid'
														   when 3 then 'Fixed Interest'
													end as bid_type,
													bid_interest_rate,
														(	SELECT	sum(a.principal_amount) principal_amount_paid
														FROM	investor_repayment_schedule a,loans
															WHERE	a.loan_id = loans.loan_id
														AND	a.status =  3) principal_amount_paid,
													(	SELECT	sum(a.interest_amount) interest_amount
														FROM	investor_repayment_schedule a,loans
														WHERE	a.loan_id = loans.loan_id
														AND	a.status =  3) interest_paid
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
													'0.00' amount_realized,
													loans.funding_duration,
													loans.loan_risk_grade,
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
													datediff(now(),payment_scheduled_date)  overdue_since,
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
		
		$invested_amount_sql			= 	"	SELECT	ROUND(SUM(bid_amount),2) bid_amount
												FROM	loan_bids,
														loans
												WHERE	loan_bids.loan_id	=	loans.loan_id
												AND		loans.status= 7
												AND		bid_status = 2 
												AND		investor_id = {$current_inverstor_id}";
		
		$this->invested_amount			=	$this->dbFetchOne($invested_amount_sql);
		if($this->invested_amount	==	"")
			$this->invested_amount			=	0;
		
		$pending_investment_sql			=	"	SELECT	ROUND(SUM(bid_amount),2)  bid_amount
												FROM	loan_bids,
														loans
												WHERE	loan_bids.loan_id	=	loans.loan_id
												AND		loans.status IN (3,5,6)	
												AND		bid_status  IN (1,2)
												AND		investor_id = {$current_inverstor_id}";
												
		$this->pending_investment		=	$this->dbFetchOne($pending_investment_sql);
		if($this->pending_investment	==	"")
			$this->pending_investment			=	0;
	
		$deposits_sql					=	"	SELECT 	ROUND(SUM(trans_amount),2) 
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 2
												AND		trans_type = 1"; 
		$this->deposits					=	$this->dbFetchOne($deposits_sql);

		if($this->deposits	==	"")
			$this->deposits			=	0;

		$pending_deposits_sql			=	"	SELECT 	ROUND(SUM(trans_amount),2) 
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 1
												AND		trans_type = 1"; 
												
		$this->pending_deposits			=	$this->dbFetchOne($pending_deposits_sql);
		if($this->pending_deposits	==	"")
			$this->pending_deposits			=	0;
		
		$withdrawals_sql				=	"	SELECT 	ROUND(SUM(trans_amount),2)
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 2
												AND		trans_type = 2"; 
		$this->withdrawals				=	$this->dbFetchOne($withdrawals_sql);
		if($this->withdrawals	==	"")
			$this->withdrawals			=	0;
		
		$pending_withdrawals_sql		=	"	SELECT 	ROUND(SUM(trans_amount),2)
												FROM	investor_bank_transactions
												WHERE	investor_id = {$current_inverstor_id}
												AND		status = 1
												AND		trans_type = 2"; 
		$this->pending_withdrawals		=	$this->dbFetchOne($pending_withdrawals_sql);
		if($this->pending_withdrawals	==	"")
			$this->pending_withdrawals			=	0;
		
		$earning_sql				=	"	SELECT 	ROUND(SUM(payment_schedule_amount+IFNULL(penalty_amount,0)),2)
											FROM	investor_repayment_schedule
											WHERE	investor_id = {$current_inverstor_id}
											AND		status = 3"; 
		$this->earnings_verified	=	$this->dbFetchOne($earning_sql);
		if($this->earnings_verified	==	"")
			$this->earnings_verified			=	0;
		
		$pending_earning_sql			=	"	SELECT 	ROUND(SUM(payment_schedule_amount+IFNULL(penalty_amount,0)),2)
												FROM	investor_repayment_schedule
												WHERE	investor_id = {$current_inverstor_id}
												AND		(payment_scheduled_date < NOW() AND	status	=	1)
												AND		status	=	2"; 
		$this->earnings_pending			=	$this->dbFetchOne($pending_earning_sql);
		if($this->earnings_pending	==	"")
			$this->earnings_pending			=	0;
			
		$addAmount						=	($this->deposits	+	$this->earnings_verified);
		$minusAmount					=	($this->withdrawals	+	$this->pending_withdrawals);
		$minusAmount					=	$minusAmount	+	($this->invested_amount	+	$this->pending_investment);
		
		$this->ava_for_invest			=	$addAmount	-	$minusAmount;	
											
	}
}
