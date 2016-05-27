<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;

class LoanListingModel extends TranWrapper {
	
	public	$inv_or_borr_id		=	"";
	public	$typePrefix			=	"";
	public	$userType			=	"";
	public $filterIntRateList	= array();
	public $filterLoanAmtList 	= array();
	public $filterTenureList 	= array();
	public $filterGradeList 	= array();
	
	public $loanList 			= array();
	
	public $filterIntRateValue	= 'all';
	public $filterLoanAmtValue	= 'all';
	public $filterTenureValue 	= 'all';
	public $filterGradeValue 	= 'all';
	
	public function __construct(){	
		
		// This will be called only from the borrower / Investors' model so this will be investor or borrower
		$this->userType 		= 	$this->getUserType();
		$this->inv_or_borr_id	=	($this->userType == 1)? $this->getCurrentBorrowerID(): 
															$this->getCurrentInvestorID();
		$this->typePrefix		=	($this->userType == 1)? "borrower":
															"investor";
	}
	
	public function processDropDowns() {
		$intRateCode	=	17;
		$loanAmtCode	=	18;
		$loanTenureCode =	19;
		$borrGradeCode	=	20;
		
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id in (17, 18, 19, 20)";
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);

		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
		
		foreach($filter_rs as $filter_row) {

			$codeId 	= 	$filter_row->codelist_id;
			$codeCode 	= 	$filter_row->codelist_code;
			$codeValue 	= 	$filter_row->codelist_value;
			$codeExpr 	= 	$filter_row->expression;
			
			switch ($codeId) {
				
				case 17:
					$this->filterIntRateList[$codeExpr] 	=	$codeValue;
					break;
				
				case 18:
					$this->filterLoanAmtList[$codeExpr] 	=	$codeValue;
					break;
				
				case 19:
					$this->filterTenureList[$codeExpr] 	=	$codeValue;
					break;

				case 20:
					$this->filterGradeList[$codeExpr] 	=	$codeValue;
					break;
			}
			
					
					
		}
		
		
	} // End process_dropdown
	
	public function getLoanList($filterIntRate, $filterLoanAmt, $filterTenure, $filterGrade) {
	
		/* ---------------------------------------------------------------
		 * Values to be returned in the Array
		 * 	Company Name  --> borrowers table
			Purpose of Loan Single Line from Loans
			% Funded --> sum( bid_amount from loan_bids) / (apply_amount from loans) * 100
			Loan Amount --> apply_amount from loans
			Target Interest --> target_interest from loans
			Days to Go --> datediff(bid_close_date, now()) mysql function
			Grade of the borrower --> borrowers
			Type of the repayment --> loans
			Thumbnail of the company --> get from S3 or local depending on the config from the borrowers table
		 ---------------------------------------------------------------------------*/
	
		$this->filterIntRateValue = $filterIntRate;
		$this->filterLoanAmtValue = $filterLoanAmt;
		$this->filterTenureValue  = $filterTenure;
		$this->filterGradeValue   = $filterGrade;
		
		$intWhere			=	($filterIntRate == "all"?"":" AND target_interest ". $filterIntRate. " ");
								
		$loanAmtWhere		=	 ($filterLoanAmt == "all"?"":" AND apply_amount	".$filterLoanAmt. " ");
												
		$tenureWhere		=	 ($filterTenure == "all"?"":" AND loan_tenure ".$filterTenure. " ");

		$gradeWhere			=	($filterGrade == "all"? "":" AND borrowers.borrower_risk_grade ".$filterGrade. " ");
		
		$loanlist_sql		=	"	SELECT	loans.loan_id,
											business_name,
											business_organisation,
											borrowers.industry,
											purpose_singleline,
											loan_tenure,
											round(ifnull(total_bid * 100 / apply_amount,0),2) perc_funded,
											round(apply_amount,2) apply_amount,
											target_interest,
											datediff(bid_close_date, now()) days_to_go,
											borrower_risk_grade,
											repayment_type,
											company_image_thumbnail,
                                            if (ifnull(featured.loan_id,-1) = -1, 0, 1) isfeatured
									FROM	loans 
											LEFT OUTER JOIN 
											(	SELECT	loan_id, 
														sum(bid_amount) total_bid
												FROM	loan_bids
												WHERE	bid_status != :bids_cancelled
												GROUP BY  loan_id) loan_bids on 
											loan_bids.loan_id = loans.loan_id
											LEFT OUTER JOIN 
											(	SELECT	loan_id 
												FROM	featured_loans
												WHERE	now() BETWEEN featured_fromdate and featured_todate ) featured on
											featured.loan_id = loans.loan_id,
											borrowers
									WHERE	borrowers.borrower_id = loans.borrower_id
									AND		loans.status = 3
											{$intWhere}
											{$loanAmtWhere}
											{$tenureWhere}
											{$gradeWhere}
									order by isfeatured desc, loan_display_order asc
";
		$this->loanList	=	$this->dbFetchWithParam($loanlist_sql, 
										["bids_cancelled" => LOAN_BIDS_STATUS_CANCELLED]);
	
	
	}
	
}
