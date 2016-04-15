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
	public $loan_status = 0;
	public $loan_status_text = "";
	public $loan_id = 0;
	
	public $loanBids = array();
	
	public function getLoanBids($loanId) {
		
		$loanInfo_sql	=	"	SELECT	loans.loan_id,
										loan_reference_number,
										purpose_singleline,
										borrowers.business_name,
										apply_amount,
										date_format(apply_date, '%d-%m-%Y') apply_date,
										loan_tenure,
										date_format(bid_close_date, '%d-%m-%Y') bid_close_date,
										codelist_value('Loan Bid Type', bid_type) bid_type,
										partial_sub_allowed,
										min_for_partial_sub,
										codelist_value('Loan Repayment Type', repayment_type) repayment_type,
										target_interest,
										codelist_value('Loan Status', loans.status) loan_status_text,
										loans.status loan_status
								FROM	loans,
										borrowers
								WHERE	loans.borrower_id = borrowers.borrower_id 
								AND		loan_id = :loan_id";
		
		$loanInfo_rs	=	$this->dbFetchWithParam($loanInfo_sql, ["loan_id" => $loanId]);
		if ($loanInfo_rs) {
			foreach ($loanInfo_rs as $loanInfo_row) {
				foreach ($loanInfo_row as $colname => $value) {
					$this->{$colname} = $value;
				}
			}
		} else {
			return -1;
		}

		$bidsInfo_sql	=	"	SELECT	users.username,
										investors.investor_id,
										date_format(bid_datetime, '%d-%m-%Y %h:%i') bid_datetime,
										bid_amount,
										bid_interest_rate,
										accepted_amount
								FROM	users,
										investors,
										loan_bids
								WHERE	loan_bids.loan_id = :loan_id
								AND		loan_bids.investor_id = investors.investor_id
								AND		investors.user_id = users.user_id
								AND		loan_bids.bid_status != :bid_cancelled ";
		$bidsInfo_args	=	["loan_id" => $loanId, "bid_cancelled" => LOAN_BIDS_STATUS_CANCELLED];
		
		$this->loanBids	=	$this->dbFetchWithParam($bidsInfo_sql, $bidsInfo_args);
										
	}
	
	public function closeBids($loanId) {
		$bidsClose_sql	=	"	UPDATE	loans
								SET		loans.status = :bids_close_status
								WHERE	loans.loan_id = :loan_id ";
		
		$tableName		=	"loans";
		$dataArray		=	["status" 	=>	LOAN_STATUS_CLOSED_FOR_BIDS];
		$where			=	["loan_id"	=>	$loanId];
		
		$this->dbUpdate($tableName, $dataArray, $where);
		return;
		
		
	}
	
	public function acceptBids($loanId) {
		
		
	}
	
	public function cancelLoan($loanId) {
		
		
	}
	
}
