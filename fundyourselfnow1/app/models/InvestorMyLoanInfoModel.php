<?php 
namespace App\models;
use DB;
use Auth;
class InvestorMyLoanInfoModel extends TranWrapper {

	public $allLoanInfo				= 	array();
	public $filterloanStatusList	= 	array();
	public $filterloanStatusValue	= 	'all';
	
	public function getInvestorAllLoanDetails($filterLoanStatus	=	"all") {
		$this->getInvestorLoanList($filterLoanStatus);
		$this->processDropDowns();
	}
		
	public function getInvestorLoanList($filterLoanStatus) {
		
		$this->filterloanStatusValue	= 	$filterLoanStatus;
		$loanStatusWhere				=	" loans.status " . ($filterLoanStatus == "all"? " IN(3,5,6,7) ":
												"=	{$filterLoanStatus}"." ");
		
		$current_inverstor_id			=	 $this->getCurrentInvestorID();
		
		$loanlist_sql					= "	SELECT 	loans.loan_id,
													loans.borrower_id,
													loans.loan_title,
													loans.loan_reference_number,
													borrowers.business_name borrower_name,
													borrowers.borrower_risk_grade,
													loans.target_interest,
													ROUND(loans.apply_amount,2) amount_applied ,
													ROUND(loan_bids.bid_amount,2) amount_offered ,
													ROUND(loan_bids.accepted_amount,2) amount_accepted ,
													loan_bids.bid_interest_rate insterest_bid ,
													case loan_bids.bid_status 
														   when 1 then 'Backed' 
														   when 2 then 'Bid Accepted'
														   when 3 then 'Bid Not Accepted'
													end as status,
													'Project Details' viewStatus
											FROM 	loan_bids,
													loans, 
													borrowers
											WHERE 	loan_bids.loan_id = loans.loan_id
											AND 	loans.borrower_id = borrowers.borrower_id
											AND		loan_bids.bid_status != 4
											AND 	loan_bids.investor_id =  {$current_inverstor_id}
											AND 	{$loanStatusWhere} ";
		$loanlist_rs				= 	$this->dbFetchAll($loanlist_sql);
		$rowIndex					=	0;
		
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
	
	public function processDropDowns() {
		
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id =	7
								AND		codelist_code in (3,6)";
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);

		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
		$this->filterloanStatusList['all'] 	=	'All Projects';
		foreach($filter_rs as $filter_row) {

			$codeCode 								= 	$filter_row->codelist_code;
			$codeValue 								= 	$filter_row->codelist_value;
			$this->filterloanStatusList[$codeCode] 	=	$codeValue;
		}
		
	} // End process_dropdown
	public function loans(){
     $loans = DB::table('loans')->select('loan_id', 'loan_product_image','loan_title','crowd_start_date','crowd_end_date','loan_image_url','loan_description')->where('status','3')->orderBy('crowd_start_date', 'asc')->get();
     //paginate(15);
     $current_borrower_id	=	 Auth::user()->user_id;

     foreach($loans as $k=>$val){
     
     	$res = DB::table('loan_follows')
     		->where('loan_id','=',$val->loan_id)
     		->where('user_id','=',$current_borrower_id)
     		->where('status','=','1')
     		->get();

     	if($res){
     		$loans[$k]->follow = '1';
     	} else{
     		$loans[$k]->follow = '0';
     	}
     } 
    return $loans;

	}
}
