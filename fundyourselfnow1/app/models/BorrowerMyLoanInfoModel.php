<?php
 namespace App\models;
 use DB;
 use Auth;
class BorrowerMyLoanInfoModel extends TranWrapper {

	public $allloan_details					= 	array();
	public $filterloanStatusList			= 	array();
	public $filterloanStatusValue			= 	'all';
	
	public function getBorrowerAllLoanDetails($filterLoanStatus	=	"all") {
		$this->getBorrowerLoanList($filterLoanStatus);
		$this->processDropDowns();
	}
	
	public function processDropDowns() {
		
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id =	7
								AND		codelist_code not in (8,9)
								ORDER BY CASE WHEN codelist_value = 'All' THEN '1'
								  WHEN codelist_value = 'New' THEN '2'
								  WHEN codelist_value = 'Submitted for Approval' THEN '3' 
								  WHEN codelist_value = 'Pending Comments' THEN '4'
								  WHEN codelist_value = 'Open for Bids' THEN '5'
								  WHEN codelist_value = 'Closed for Bids' THEN '6'
								  WHEN codelist_value = 'Bids Accepted' THEN '7'
								  WHEN codelist_value = 'Loans Disbursed' THEN '8'
								  WHEN codelist_value = 'Repayments Complete' THEN '9'
								  ELSE codelist_value END ASC";
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);

		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
	
		foreach($filter_rs as $filter_row) {

			$codeCode 								= 	$filter_row->codelist_code;
			$codeValue 								= 	$filter_row->codelist_value;
			$this->filterloanStatusList[$codeCode] 	=	$codeValue;
		}
		
	} // End process_dropdown
	
	public function getBorrowerLoanList($filterLoanStatus) {
		$loan_cancelled	=	LOAN_STATUS_CANCELLED;
		$this->filterloanStatusValue	= 	$filterLoanStatus;
		$loanStatusWhere				=	" loans.status " . ($filterLoanStatus == "11"? "= loans.status  ":
												"=	{$filterLoanStatus}"."");
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$loanlist_sql			= "	SELECT 	loans.loan_id,
											loans.borrower_id,loans.loan_title,
											loans.loan_reference_number,loans.ristricted_countries as countries,
											ifnull(DATE_FORMAT(loans.apply_date,'%d %b %Y'),'') apply_date,
											loans.status,
											case loans.status 
												   when 1 then 'New' 
												   when 2 then 'Submitted for Approval'
												   when 3 then 'Approved for Bid'
												   when 4 then 'Pending Comments'
												   when 5 then 'Bid Closed'
												   when 6 then 'Bid Accepted'
												   when 7 then 'Loan Disbursed'
												   when 9 then 'Unsuccessful Loan'
												   when 10 then 'Repayment Complete'
											end as statusText,
											( 	SELECT	codelist_value 
												FROM	codelist_details
												WHERE	codelist_id = 7
												AND		codelist_code = loans.status
											) statusText,

											case loans.status 
												   when 1 then 'Edit Project' 
												   when 2 then 'Project Details'
												   when 3 then 'Project Details'
												   when 4 then 'Edit Project'
												   when 5 then 'Project Details'
												   when 6 then 'Project Details'
												   when 7 then 'Project Details'
												   when 8 then 'Cancelled Project'
												   when 9 then 'Project Details'
												   when 10 then 'Project Details'
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
									AND		borrowers.borrower_id		=	loans.borrower_id									
									AND 	{$loanStatusWhere}
									AND     loans.status != {$loan_cancelled}";
		
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
		
		$loanlist_sql			= "	SELECT 	ifnull(DATE_FORMAT(loanrepsch.repayment_schedule_date,'%d/%m/%Y'),'') repayment_schedule_date,
											FORMAT(loanrepsch.repayment_scheduled_amount,2) repayment_scheduled_amount,
											case loanrepsch.repayment_status 
												   when 1 then 'Unpaid' 
												   when 2 then 'Not Approved'
												   when 3 then 'Paid'
												   when 4 then 'Cancelled'
												   when 5 then 'Overdue'
											end as repayment_status,
											ifnull(DATE_FORMAT(loanrepsch.repayment_actual_date,'%d/%m/%Y'),'') repayment_actual_date ,
											FORMAT(if (repayment_status != 1, repayment_scheduled_amount + ifnull(repayment_penalty_interest, 0) + ifnull(repayment_penalty_charges, 0), 0.00),2) repayment_actual_amount
									FROM 	borrower_repayment_schedule loanrepsch
									WHERE	loanrepsch.borrower_id		=	{$current_borrower_id}
									AND		loanrepsch.loan_id			=	{$loan_id}";
		
		$repayschedlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		return	$repayschedlist_rs;
	}
	
	public function updateLoanStatus($loanId) {
		
		$dataArray	=	array('status' => LOAN_STATUS_CANCELLED);
		$whereArry	=	array("loan_id" =>"{$loanId}");
		$this->dbUpdate('loans', $dataArray, $whereArry);
	}
	public function myloans(){

	$current_borrower_id	=	 $this->getCurrentBorrowerID();
	$loans = DB::table('loans')->select('loan_id', 'loan_product_image','loan_title','crowd_start_date','crowd_end_date','loan_image_url','loan_description')->where('status','3')->orderBy('crowd_start_date', 'asc')->get();

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
