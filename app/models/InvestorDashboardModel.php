<?php namespace App\models;
class InvestorDashboardModel extends TranWrapper {

	public $featuredLoanInfo	= 	array();
	public $featuredLoanJson	= 	"";
	public $barChartJson		= 	"";
	public $fundsDepolyedInfo	= 	array();
	public $invUnderBidInfo		= 	array();
	public $overDueInfo			= 	array();
	public $invAccountSummary	= 	array();
	
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
		$barchart_sql					=	"	SELECT 	trans_month, 
														round(sum((repayment * interest_wt_ratio)) / 
																sum((bal_os *principal_wt_ratio)) * 1200, 2) roi
												FROM	(	SELECT 	loans.loan_id, 
																	date_format(trans_date, '%Y %m') trans_month, 
																	loan_bids.bid_amount / loans.loan_sanctioned_amount principal_wt_ratio,
																	loan_bids.bid_amount / loans.loan_sanctioned_amount 
																		* loan_bids.bid_interest_rate / loans.final_interest_rate interest_wt_ratio,
																	loan_sanctioned_amount -  (	SELECT	ifnull(sum(principal_paid),0)
																		FROM	borrower_repayments a
																		WHERE	a.trans_date < borrower_repayments.trans_date
																		AND		a.loan_id     = borrower_repayments.loan_id) bal_os,
																	(interest_paid + penalty_paid) repayment
															FROM 	loan_bids,
																	loans, 
																	borrower_repayments
															WHERE 	bid_status = 2 
															AND 	investor_id = {$current_inverstor_id}
															AND		loans.loan_id = loan_bids.loan_id
															AND		loans.loan_id = borrower_repayments.loan_id
														) xx
												GROUP BY trans_month";
	}
	
	public function getInvestorFundsDepolyed() {
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		$fundsdepolyed_rs				=
		$fundsdepolyed_sql				= "	SELECT 	loans.loan_id,
													borrowers.business_name borrower_name,
													borrowers.borrower_risk_grade grade,
													loans.final_interest_rate,	
													ROUND(loans.apply_amount,2) amount_applied,
													'' amount_invested,
													'' date_of_investment,
													loans.loan_tenure,
													case loans.repayment_type 
													   when 1 then 'Bullet' 
													   when 2 then 'Monthly Interest'
													   when 3 then 'EMI'
													end as repayment_type,
													'' insterest_paid,
													'' principal_paid
											FROM 	loans, 
													borrowers
											WHERE 	loans.loan_id	IN
																(
																	SELECT 	loan_id
																	FROM	loan_bids
																	WHERE	investor_id	=	{$current_inverstor_id}
																)
											AND		loans.borrower_id = borrowers.borrower_id";
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
		$loanUnderBid_sql				= "	SELECT 	loans.loan_id,
													borrowers.business_name borrower_name,
													borrowers.borrower_risk_grade grade,
													ROUND(loans.apply_amount,2) amount_applied,
													'' amount_invested,
													'' date_of_investment,
													loans.loan_tenure,
													case loans.repayment_type 
													   when 1 then 'Bullet' 
													   when 2 then 'Monthly Interest'
													   when 3 then 'EMI'
													end as repayment_type,
													loans.bid_close_date
											FROM 	loans, 
													borrowers
											WHERE 	loans.loan_id	IN
																(
																	SELECT 	loan_id
																	FROM	loan_bids
																	WHERE	investor_id	=	{$current_inverstor_id}
																)
											AND		loans.borrower_id = borrowers.borrower_id";
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
		
		$overDue_sql					= "	SELECT 	loans.loan_id,
													borrowers.business_name borrower_name,
													borrowers.borrower_risk_grade grade
													ROUND(loans.apply_amount,2) amount_applied,
													'' amount_overdue,
													'' overdue_since,
													'' remarks,
											FROM 	loans, 
													borrowers
											WHERE 	loans.loan_id	IN
																(
																	SELECT 	loan_id
																	FROM	loan_bids
																	WHERE	investor_id	=	{$current_inverstor_id}
																)
											AND		loans.borrower_id = borrowers.borrower_id";
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
		$accSummary_rs					=	array();
		
		$accSummary_sql					= "";
		$accSummary_rs					= 	$this->dbFetchAll($accSummary_sql);
		$this->invAccountSummary		=	$accSummary_rs;
		return $accSummary_rs;
	}
	
	
}
