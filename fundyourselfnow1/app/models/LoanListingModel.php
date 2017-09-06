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
	public $filterProCatList 	= array();
	public $filterGradeList 	= array();
	
	public $loanList 			= array();
	
	public $filterIntRateValue	= 'all';
	public $filterLoanAmtValue	= 'all';
	public $filterProCatValue 	= 'all';
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
		$loanTenureCode =	16;
		$borrGradeCode	=	20;
		
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id in (17, 18, 16, 20)";
								
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
				
				case 16:
					$this->filterProCatList['all'] 			= 'All';
					$this->filterProCatList[$codeValue] 	=	$codeValue;
					break;

				case 20:
					$this->filterGradeList[$codeExpr] 	=	$codeValue;
					break;
			}	
		}
	} // End process_dropdown
	
	public function getLoanList($filterLoanAmt, $filterCat, $filterGrade) {
	
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
	
		$this->filterLoanAmtValue = $filterLoanAmt;
		$this->filterProCatValue  = $filterCat;
		$this->filterGradeValue   = $filterGrade;
								
		$loanAmtWhere		=	 ($filterLoanAmt == "all"?"":" AND apply_amount	".$filterLoanAmt. " ");
												
		$proCatWhere		=	 ($filterCat == "all"?"":" AND purpose_singleline='".$filterCat. "' ");

		$gradeWhere			=	($filterGrade == "all"? "":" AND loan_risk_grade ".$filterGrade. " ");
		
		$loanlist_sql		=	"	SELECT	loans.loan_id,
											loan_title,
											loan_description,
											loan_product_image,
											business_name,
											business_organisation,
											borrowers.industry,
											purpose_singleline,
											concat(SUBSTRING(purpose, 1, 100),'...') as purpose,
											featured_loan,
											loan_tenure,
											loan_image_url,
											round(ifnull(total_bid * 100 / apply_amount,0),2) perc_funded,
											round(apply_amount,2) apply_amount,
											target_interest,
											datediff(bid_close_date, now()) days_to_go,
											IFNULL(loan_risk_grade,'') borrower_risk_grade,
											repayment_type,											
											 CASE  repayment_type 
												WHEN 1 THEN 'Bullet'   
												WHEN 2 THEN 'Monthly Interest'   
												WHEN 3 THEN 'EMI'
											END as repayment_type_name,
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
									AND 	CASE 
											WHEN datediff(bid_close_date, now()) >= 0
												THEN bid_close_date
											ELSE ''
												END
									AND		loans.status = 3
											
											{$loanAmtWhere}
											{$proCatWhere}
											{$gradeWhere}
									order by featured_loan desc, loan_display_order asc
";
	 
		$this->loanList	=	$this->dbFetchWithParam($loanlist_sql, 
										["bids_cancelled" => LOAN_BIDS_STATUS_CANCELLED]);
		 
	}
	
	function getAllActiveLoans() {
		$this->getLoanList('all', 'all', 'all', 'all');
		$fileUploadObj	=	new FileUpload();

		for ($tmpIndex = 0; $tmpIndex < count($this->loanList); $tmpIndex ++) {
			$thumbFile	=	$this->loanList[$tmpIndex]->company_image_thumbnail;
			$thumbUrl	=	$fileUploadObj->getFile($thumbFile);
			$this->loanList[$tmpIndex]->company_image_thumbnail = $thumbUrl;
		}
		$jsonLoanList	=	json_encode($this->loanList);
		
		echo $jsonLoanList;
		
	}
	
}
