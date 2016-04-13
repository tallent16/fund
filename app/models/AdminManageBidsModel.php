<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class AdminManageBidsModel extends TranWrapper {
	
	public $loan_reference_number = "";
	public $purpose = "";
	public $business_name = "";
	public $apply_amount = "";
	public $apply_date = "";
	public $loan_tenure = 12;
	public $bid_close_date = "";
	public $bid_type = 3;
	public $partial_sub_allowed = 0;
	public $min_for_partial_sub = 0;
	public $repayment_type = 0;
	public $target_interest = 0;
	public $status = 0;
	
	public $loanBids = array();
	
	public function getLoanBids($loanId) {
		
		$loanInfo_sql	=	"	SELECT	loan_reference_number,
										purpose,
										borrowers.business_name,
										apply_amount,
										apply_date,
										loan_tenure,
										bid_close_date,
										bid_type,
										partial_sub_allowed,
										min_for_partial_sub,
										repayment_type,
										target_interest,
										loans.status
								FROM	loans,
										borrowers
								WHERE	loans.borrower_id = borrowers.borrower_id 
								AND		loan_id = :loan_id";
		
		$loanInfo_rs	=	$this->dbFetchWithParam($filterSql, ["loan_id" => $loanId]);
		if ($loanInfo_rs) {
			foreach ($loanInfo_rs as $loanInfo_row) {
				foreach ($loanInfo_row as $colname => $value) {
					$this->{$colname} = $value;
				}
			}
			return 1;
		} else {
			return -1;
		}
							
	}
	
	public function closeBids($loanId) {
		
		
	}
	
	public function acceptBids($loanId) {
		
		
	}
	
	public function cancelLoan($loanId) {
		
		
	}
	
}
