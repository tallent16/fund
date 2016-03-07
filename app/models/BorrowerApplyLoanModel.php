<?php namespace App\models;

class BorrowerApplyLoanModel extends TranWrapper {
	
	public $loan_id		  					=  	"";
	public $loan_reference_number  			=  	"";
	public $borrower_id  					=  	"";
	public $purpose		  					=  	"";
	public $apply_date			  			=  	"";
	public $apply_amount		  			=  	"";
	public $loan_currency_code			  	=	"";
	public $loan_tenure		  				=  	"";
	public $target_interest  				=  	"";
	public $bid_open_date		  			=  	"";
	public $bid_close_date  				=  	"";
	public $bid_type			  			=  	"";
	public $partial_sub_allowed  			=  	"";
	public $min_for_partial_sub  			=  	"";
	public $repayment_type  				=  	"";
	public $status  						=  	"";
	public $comments  						=  	"";
	public $final_interest_rate  			=  	"";
	public $loan_sactioned_amount  			=  	"";
	public $trans_fees  					=  	"";
	public $total_disbursed  				=  	"";
	public $total_principal_repaid  		=  	"";
	public $total_interest_paid  			=  	"";
	public $total_penalties_paid  			=  	"";
	public $loan_product_image  			=  	"";
	public $loan_video_url  				=  	"";

	public $document_details				= 	array();
	
	public function getBorrowerLoanDetails($loan_id) {
		
		$this->getBorrowerLoanInfo($loan_id);
		$this->getBorrowerDocumentListInfo();
		//~ $this->processDropDowns();
	}
		
	public function getBorrowerLoanInfo($loan_id) {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$loanlist_sql			= "	SELECT 	loans.loan_id,
											loans.loan_reference_number,
											loans.borrower_id,
											loans.purpose,
											ifnull(DATE_FORMAT(loans.apply_date,'%d/%m/%Y'),'') apply_date,
											ROUND(loans.apply_amount,2) apply_amount ,
											loans.loan_currency_code,
											loans.loan_tenure,
											loans.target_interest,
											ifnull(DATE_FORMAT(loans.bid_open_date,'%d/%m/%Y'),'') bid_open_date,
											ifnull(DATE_FORMAT(loans.bid_close_date,'%d/%m/%Y'),'') bid_close_date,
											ifnull(DATE_FORMAT(borrowers.operation_since,'%d/%m/%Y'),'') operation_since,
											loans.bid_type,
											loans.partial_sub_allowed,
											loans.min_for_partial_sub,
											loans.repayment_type,
											loans.status,
											loans.comments,
											loans.final_interest_rate,
											case loans.status 
												   when 1 then 'New' 
												   when 2 then 'Submitted for Approval'
												   when 3 then 'Pending Comments'
												   when 4 then 'Approved for Bid'
												   when 5 then 'Bid Closed'
												   when 6 then 'Loan Disbursed'
												   when 7 then 'Repayments Complete'
											end as statusText,
											loans.comments,
											loans.final_interest_rate,
											loans.loan_sactioned_amount,
											loans.trans_fees,
											loans.total_disbursed,
											loans.total_principal_repaid,
											loans.total_interest_paid,
											loans.total_penalties_paid,
											loans.loan_product_image,
											loans.loan_video_url
									FROM 	loans
									WHERE	loans.loan_id		=	{$loan_id}";
		
		$loanlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		
		if ($loanlist_rs) {
		
			$vars = get_object_vars ( $loanlist_rs[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
		}
	}
	
	public function getBorrowerDocumentListInfo() {
		
		$loandocument_sql		= 	"	SELECT 	loan_doc_id,
												doc_name,
												is_mandatory,
												short_name
										FROM 	loan_doc_master";
		
		
		$loandocument_rs		= 	$this->dbFetchAll($loandocument_sql);
			
		if ($loandocument_rs) {
			foreach ($loandocument_rs as $docRow) {
				$newrow = count($this->document_details);
				$newrow ++;
				foreach ($docRow as $colname => $colvalue) {
					$this->document_details[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $loandocument_rs;
	}
}
