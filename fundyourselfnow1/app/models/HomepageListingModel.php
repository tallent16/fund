<?php 
namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use DB;
class HomepageListingModel extends TranWrapper {
	
	public	$inv_or_borr_id		=	"";
	public	$typePrefix			=	"";
	public	$userType			=	"";
	public $filterIntRateList	= array();
	public $filterLoanAmtList 	= array();
	public $filterProCatList 	= array();
	public $filterGradeList 	= array();
	public $filterIndustryList 	= array();
	public $sortbyList		 	= array();
	
	public $loanList 			= array();
	public $loanListing			= array();
	public $recommendedList 	= array();
	public $projectList 		= array();
	
	public $filterIntRateValue	= 'all';
	public $filterLoanAmtValue	= 'all';
	public $filterProCatValue 	= 'all';
	public $filterGradeValue 	= 'all';
	public $filterIndustryValue = 'all';
	public $sortbyvalue		 	= 'all';
	
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
		//Sorting Dropdown
		$this->sortbyList	= array(
									'all'			 =>'Sort',
									'bid_close_date' =>'Bid Close Date',
									'apply_amount'   =>'Project Amount');
		
	} // End process_dropdown
	
	public function getIndustries(){
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id ='16' ";
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);
		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}		
		//~ print_r($filter_rs); die;	
		foreach($filter_rs as $filter_row) {
			$this->filterIndustryList[]	= $filter_row;									
		}
					
	}
	
	public function getLoanListing($filterCat,$sortbyfield) {
	
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
			
		$this->sortbyvalue		  = $sortbyfield;
		$this->filterProCatValue  = $filterCat;
		
		if($this->sortbyvalue == "bid_close_date"){
			$sortWhere			=	 ($sortbyfield == "all"?"featured_loan desc, loan_display_order asc":" ".$sortbyfield. " ");
		}else{
			$sortWhere			=	 ($sortbyfield == "all"?"featured_loan desc, loan_display_order asc":" ".$sortbyfield. " desc");
		}												
		$proCatWhere		=	 ($filterCat == "all"?"":" AND purpose_singleline='".$filterCat. "' ");

		$loanlist_sql		=	"	SELECT	loans.loan_id,
											loan_title,
											concat(SUBSTRING(loan_description, 1, 100),'...') as loan_description,
											loan_product_image,
											loan_image_url,
											business_name,
											business_organisation,eth_baalance,wallet_address,
											borrowers.industry,
											purpose_singleline,
											featured_loan,
											concat(SUBSTRING(purpose, 1, 100),'...') as purpose,
											loan_tenure,
											total_bid,
											funding_duration,
											round(ifnull(total_bid * 100 / apply_amount,0),2) perc_funded,
											round(apply_amount,2) apply_amount,
											target_interest,
											datediff(crowd_end_date, now()) days_to_go,
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
											WHEN datediff(crowd_end_date, now()) >= 0
												THEN crowd_end_date
											ELSE ''
												END
									AND		loans.status = 3
																						
											{$proCatWhere}
											
									order by {$sortWhere} 
";
		
		$this->loanListing	=	$this->dbFetchWithParam($loanlist_sql, 
										["bids_cancelled" => LOAN_BIDS_STATUS_CANCELLED]);
		
	}
	
	public function getLoanList($filtercat=null) {
	
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
	
		if($filtercat){
			$where	=	($filtercat == "all"?"":" AND purpose_singleline= '". $filtercat. "' ");
			$limit  = '';
			$orderBy	=	" ORDER BY perc_funded desc";
		}else{
			$where	= '';
			$limit  = 'limit 3';
			$orderBy	=	" ORDER BY abs(loan_display_order) desc";
		}
		
	
		//~ $this->filterIntRateValue = $filterIntRate;
		//~ $this->filterLoanAmtValue = $filterLoanAmt;
		//~ $this->filterTenureValue  = $filterTenure;
		//~ $this->filterGradeValue   = $filterGrade;
		
		//~ $intWhere			=	($filterIntRate == "all"?"":" AND target_interest ". $filterIntRate. " ");
								
		//~ $loanAmtWhere		=	 ($filterLoanAmt == "all"?"":" AND apply_amount	".$filterLoanAmt. " ");
												
		//~ $tenureWhere		=	 ($filterTenure == "all"?"":" AND loan_tenure ".$filterTenure. " ");

		//~ $gradeWhere			=	($filterGrade == "all"? "":" AND loan_risk_grade ".$filterGrade. " ");
		
		$loanlist_sql		=	"	SELECT	loans.loan_id,
											loan_title,
											concat(SUBSTRING(loan_description, 1, 100),'...') as loan_description,
											loan_product_image,
											business_name,wallet_address,eth_baalance,
											loan_image_url,
											business_organisation,
											location_description,
											borrowers.industry,
											purpose_singleline,
											featured_loan,
											concat(SUBSTRING(purpose, 1, 100),'...') as purpose,
											loan_tenure,
											total_bid,
											funding_duration,
											round(ifnull(total_bid * 100 / apply_amount,0),2) perc_funded,
											round(apply_amount,2) apply_amount,
											target_interest,
											datediff(crowd_end_date, now()) days_to_go,
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
											WHEN datediff(crowd_end_date, now()) >= 0
												THEN crowd_end_date
											ELSE ''
												END
									AND		loans.status = 3
									$where		
									$orderBy
									$limit
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
	
	public function getRecommendedList($filtercat=null) {
	
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
		if($filtercat){
			$where		=	($filtercat == "all"?"":" AND purpose_singleline= '". $filtercat. "' ");
			$limit  	= 	'';
			$orderBy	=	" ORDER BY featured_loan,apply_date ";
		}else{
			$where	= '';
			$limit  = 'limit 3';
			$orderBy	=	" ORDER BY abs(loan_display_order)";
		}
		
		//~ $this->filterIntRateValue = $filterIntRate;
		//~ $this->filterLoanAmtValue = $filterLoanAmt;
		//~ $this->filterTenureValue  = $filtercat;
		//~ $this->filterGradeValue   = $filterGrade;
		
		//~ $intWhere			=	($filterIntRate == "all"?"":" AND target_interest ". $filterIntRate. " ");
								
		//~ $loanAmtWhere		=	 ($filterLoanAmt == "all"?"":" AND apply_amount	".$filterLoanAmt. " ");
												
		//~ $tenureWhere		=	 ($filterTenure == "all"?"":" AND loan_tenure ".$filterTenure. " ");

		//~ $gradeWhere			=	($filterGrade == "all"? "":" AND loan_risk_grade ".$filterGrade. " ");
		
		$loanlist_sql		=	"	SELECT	loans.loan_id,
											loan_title,
											concat(SUBSTRING(loan_description, 1, 100),'...') as loan_description,
											loan_product_image,
											loan_image_url,wallet_address,eth_baalance,
											business_name,
											business_organisation,
											location_description,
											borrowers.industry,
											purpose_singleline,
											concat(SUBSTRING(purpose, 1, 100),'...') as purpose,
											featured_loan,
											loan_tenure,
											total_bid,
											funding_duration,
											round(ifnull(total_bid * 100 / apply_amount,0)) perc_funded,
											round(apply_amount,2) apply_amount,
											target_interest,
											datediff(crowd_end_date, now()) days_to_go,
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
											WHEN datediff(crowd_end_date, now()) >= 0
												THEN crowd_end_date
											ELSE ''
												END
									AND		loans.status = 3
									AND 	featured_loan =1	
									$where
									$orderBy
									$limit
";
		//~ echo $loanlist_sql.LOAN_BIDS_STATUS_CANCELLED;
		//~ die;

		$this->recommendedList	=	$this->dbFetchWithParam($loanlist_sql, 
										["bids_cancelled" => LOAN_BIDS_STATUS_CANCELLED]);
		
									
	}
	
	public function getProjectList($category) {
		$this->filterProCatValue  = $category;
		if($category){
			$where = " AND purpose_singleline = '".$category."' "; 
		}else{
			$where = '';
		}
		
		$projectlistsql	=	"SELECT	loans.loan_id,
											loan_title,
											concat(SUBSTRING(loan_description, 1, 100),'...') as loan_description,
											loan_product_image,
											loan_image_url,
											business_name,
											business_organisation,wallet_address,eth_baalance,
											location_description,
											borrowers.industry,
											purpose_singleline,
											featured_loan,
											concat(SUBSTRING(purpose, 1, 100),'...') as purpose,
											loan_tenure,
											total_bid,
											funding_duration,
											round(ifnull(total_bid * 100 / apply_amount,0)) perc_funded,
											round(apply_amount,2) apply_amount,
											target_interest,
											datediff(crowd_end_date, now()) days_to_go,
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
											WHEN datediff(crowd_end_date, now()) >= 0
												THEN crowd_end_date
											ELSE ''
												END
									AND		loans.status = 3
									$where
									";     
		
			$this->projectList	=	$this->dbFetchWithParam($projectlistsql, 
										["bids_cancelled" => LOAN_BIDS_STATUS_CANCELLED]);
			
	}
	public function loans(){


	$loans = DB::table('loans')->select('loan_id', 'loan_product_image','loan_title','crowd_start_date','crowd_end_date','loan_image_url','loan_description')->where('status','3')->get();
    return $loans;

     }
	
	
}
