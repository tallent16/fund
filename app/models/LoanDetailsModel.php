<?php namespace App\models;
class LoanDetailsModel extends TranWrapper {

	public	$borrower_id				=	"";
	public	$company_name				=	"";
	public	$company_image				=	"";
	public 	$industry					=	"";
	public 	$about_us					=	"";
	public 	$risk_industry				=	"";
	public 	$risk_strength				=	"";
	public 	$risk_weakness				=	"";
	public 	$company_profile			=	"";
	public 	$company_aboutus			=	"";
	public 	$purpose					=	"";
	public 	$purpose_singleline			=	"";
	public 	$statusText  				=  	"";
	public 	$directorInfo				= 	array();
	public 	$bidInfo 					= 	array();
	public 	$commentInfo 				= 	array();
	public 	$finacialRatioInfo 			= 	array();
	public 	$finacialInfo 				= 	array();
	
	public function getLoanDetails($loan_id) {
		
		$this->getLoan($loan_id);
		$this->getLoanFinacialRatio();
		$this->getLoanFinacial();
		$this->getLoanDirector();
		$this->getLoanBids($loan_id);
		$this->getLoanComments($loan_id);
	}
		
	public function getLoan($loan_id) {
		
		/* ---------------------------------------------------------------
		 * Values to be returned in the Array
		 * 	Company Name  --> borrowers table
			Industy + loan_purpose_single_line  --> borrowers + loans tables
			About Us   --> borrowers tables
			Company Profile   --> borrowers tables
			Risk Industry: risk_industry --> borrowers table
			Strength: risk_strength --> borrowers table
			Weakness: risk_weakness --> borrowers table
			image of the company --> get from S3 or local depending on the config from the borrowers table
			loan purpose -->  loans table
		 ---------------------------------------------------------------------------*/

		$loanlist_sql			= "	SELECT 	borrowers.business_name company_name,
											borrowers.borrower_id,
											borrowers.industry,
											borrowers.company_aboutus about_us,
											borrowers.risk_industry,
											borrowers.risk_strength,
											borrowers.risk_weakness,
											borrowers.company_profile,
											borrowers.company_aboutus,
											borrowers.company_image,
											borrowers.status,
											case loans.status 
												   when 1 then 'New' 
												   when 2 then 'Submitted for Approval'
												   when 3 then 'Pending Comments'
												   when 4 then 'Approved for Bid'
												   when 5 then 'Bid Closed'
												   when 6 then 'Loan Disbursed'
												   when 7 then 'Repayments Complete'
											end as statusText,
											loans.purpose_singleline,
											loans.purpose
									FROM 	loans,
											borrowers 
									WHERE	loans.loan_id				=	{$loan_id}
									AND		borrowers.borrower_id		=	loans.borrower_id";
		
		$loanlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		$rowIndex			=	0;
		if ($loanlist_rs) {
			$fieldList	 = 	get_object_vars ( $loanlist_rs[0] );
			foreach($fieldList as $colname=>$colvalue) {
				$this->{$colname} = $colvalue;
			}
		}
		if($this->company_image!=""){
			
		}
		return	$loanlist_rs;
	}
	
	public function getLoanDirector() {
		
		$director_sql		= 	"	SELECT 	name,
											accomplishments,
											directors_profile
									FROM 	borrower_directors
									WHERE	borrower_id	=	{$this->borrower_id}";
		
		
		$director_rs		= 	$this->dbFetchAll($director_sql);
			
		if ($director_rs) {
			foreach ($director_rs as $directorRow) {
				$newrow = count($this->directorInfo);
				$newrow ++;
				foreach ($directorRow as $colname => $colvalue) {
					$this->directorInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $director_rs;
	}
	
	public function getLoanFinacialRatio() {
		
		$finacialRation_rs	= 	$this->getFinacialRatioList($this->borrower_id);
			
		if ($finacialRation_rs) {
			foreach ($finacialRation_rs as $finRatioRow) {
				$newrow = count($this->finacialRatioInfo);
				$newrow ++;
				foreach ($finRatioRow as $colname => $colvalue) {
					$this->finacialRatioInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $finacialRation_rs;
	}
			
	public function getLoanFinacial() {
		
		$finacial_rs	= 	$this->getFinacialList($this->borrower_id);
			
		if ($finacial_rs) {
			foreach ($finacial_rs as $directorRow) {
				$newrow = count($this->finacialInfo);
				$newrow ++;
				foreach ($directorRow as $colname => $colvalue) {
					$this->finacialInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $finacial_rs;
	}
	
	public function getLoanBids($loan_id) {
		
		$bid_sql	= 	"		SELECT 		ROUND(bid_interest_rate,1) bid_interest_rate,
											ROUND(bid_amount,2) bid_amount,
											bid_id
								FROM 		loan_bids	
								WHERE		loan_id	=	{$loan_id}
								AND			bid_status	=	2
								ORDER BY	bid_interest_rate,bid_amount";
		
		
		$bid_rs		= 	$this->dbFetchAll($bid_sql);
			
		if ($bid_rs) {
			foreach ($bid_rs as $bidRow) {
				$newrow = count($this->bidInfo);
				$newrow ++;
				foreach ($bidRow as $colname => $colvalue) {
					$this->bidInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $bid_rs;
	}
			
	public function getLoanComments($loan_id) {
		
		$finacial_sql	= 	"	SELECT 	comments_id,
										comment_datetime,
										commented_by_user,
										in_response_to,
										comments_text
								FROM 	loan_comments
								WHERE	loan_id	=	{$loan_id}";
		
		
		$finacial_rs	= 	$this->dbFetchAll($finacial_sql);
			
		if ($finacial_rs) {
			foreach ($finacial_rs as $directorRow) {
				$newrow = count($this->commentInfo);
				$newrow ++;
				foreach ($directorRow as $colname => $colvalue) {
					$this->commentInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $finacial_rs;
	}
	
}
