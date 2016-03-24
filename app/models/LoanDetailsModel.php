<?php namespace App\models;
class LoanDetailsModel extends TranWrapper {

	public	$inv_or_borr_id				=	"";
	public	$typePrefix					=	"";
	public	$userType					=	"";
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
	public 	$avg_int_bid  				=  	"";
	public 	$status						=  	"";
	public 	$borrower_risk_grade		=  	"";
	public 	$loan_id					=  	"";
	public 	$loan_tenure				=  	"";
	public	$perc_funded				=	"";
	public	$days_to_go					=	"";
	public	$isfeatured					=	"";
	public	$no_of_bidders				=	"";
	public	$total_bid					=	"";
	public	$apply_amount				=	"";
	public	$repayment_type				=	"";
	public	$loan_status				=	"";
	public 	$directorInfo				= 	array();
	public 	$bidInfo 					= 	array();
	public 	$bidDetail 					= 	array();
	public 	$commentInfo 				= 	array();
	public 	$finacialRatioInfo 			= 	array();
	public 	$finacialInfo 				= 	array();
	public 	$paymentScheduleInfo 		= 	array();
	
	
	public function __construct($attributes = array()){	
		
		// This will be called only from the borrower / Investors' model so this will be investor or borrower
		$this->userType 		= 	$this->getUserType();
		$this->inv_or_borr_id	=	($this->userType == 1)? $this->getCurrentBorrowerID(): 
															$this->getCurrentInvestorID();
		$this->typePrefix		=	($this->userType == 1)? "borrower":
															"investor";
	}
	
	public function getLoanDetails($loan_id) {
		
		$this->getLoan($loan_id);
		$this->getLoanFinacialRatio();
		$this->getLoanFinacial();
		$this->getLoanDirector();
		$this->getBidAverageInterest($loan_id);
		$this->getLoanComments($loan_id);	
		
		switch($this->userType) {
			case	USER_TYPE_INVESTOR:
				$this->getPaymentSchedule($loan_id);
				$this->getBidDetails($loan_id);
				break;
			case	USER_TYPE_BORROWER:
				$this->getLoanBids($loan_id);
				break;
		}
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
											borrowers.borrower_risk_grade,
											loans.loan_id,
											loans.loan_tenure,
											round(ifnull(total_bid * 100 / apply_amount,0),2) perc_funded,
											loans.target_interest,
											if(loans.bid_close_date < now(),'Bid Closed',
													datediff(loans.bid_close_date, now())) days_to_go,
											if (ifnull(featured.loan_id,-1) = -1, 0, 1) isfeatured,
											no_of_bidders,
											ROUND(total_bid,2) total_bid,
											ROUND(apply_amount,2) apply_amount,
											case loans.status 
												   when 1 then 'New' 
												   when 2 then 'Submitted for Approval'
												   when 3 then 'Approved'
												   when 4 then 'Pending Comments'
												   when 5 then 'Closed for Bids'
												   when 6 then 'Disbursed'
												   when 7 then 'Unsuccessful Loan'
												   when 9 then 'Repayments Complete'
											end as statusText,
											case loans.repayment_type 
												   when 1 then 'Bullet' 
												   when 2 then 'Monthly Interest'
												   when 3 then 'EMI'
											end as repayment_type,
											loans.purpose_singleline,
											loans.purpose,
											loans.status	loan_status
									FROM 	loans
											LEFT OUTER JOIN 
											(	SELECT	loan_id, 
														count(bid_id) no_of_bidders,
														sum(bid_amount) total_bid
												FROM	loan_bids
												WHERE	loan_bids.loan_id	=	{$loan_id}
												AND		(bid_status	=	2	OR	bid_status	=	1)
												) loan_bids on 
											loan_bids.loan_id = loans.loan_id
											LEFT OUTER JOIN 
											(	SELECT	loan_id 
												FROM	featured_loans
												WHERE	now() BETWEEN featured_fromdate and featured_todate ) featured on
											featured.loan_id = loans.loan_id,
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
								AND			(bid_status	=	2	OR	bid_status	=	1)
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
	
	public function getBidAverageInterest($loan_id) {
		
		$bid_sql	= 	"		SELECT 		(ROUND(loan_bids.bid_amount,2)/loan_bids_tot.total_bid)*loan_bids.bid_interest_rate
											average_int
								FROM 		loan_bids,
											(	SELECT 	 ROUND(sum(bid_amount),2) total_bid
												FROM 		loan_bids
												WHERE		loan_id	=	{$loan_id}
											) loan_bids_tot
								WHERE		loan_id	=	{$loan_id}
								AND			(bid_status	=	2	OR	bid_status	=	1)
								";
		
		
		$bid_rs		= 	$this->dbFetchAll($bid_sql);
			
		if ($bid_rs) {
			$tot_average	=	0.00;
			foreach ($bid_rs as $bidRow) {
				$tot_average	=	$tot_average	+	$bidRow->average_int;
			}
			$this->avg_int_bid	=	ROUND($tot_average,2);
		}
		
		
	}
			
	public function getLoanComments($loan_id) {
		
		$finacial_sql	= 	"	SELECT 		round(if( isnull(in_response_to), 
													comments_id + 0.9999, in_response_to + (comments_id / 10000)),4) orderby_col,
											in_response_to,
											comments_id,
											comments_text,
											commented_by_user,
											comment_datetime,
											users.username
								FROM 		loan_comments,
											users
								WHERE		loan_id={$loan_id}
								AND			loan_comments.commented_by_user	=	users.user_id	
								ORDER BY	orderby_col desc";
		
		
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

	public function getBidDetails($loan_id) {
		
		$bid_sql	= 	"		SELECT 		bid_id,
											bid_datetime,
											ROUND(bid_amount,2) bid_amount,
											bid_interest_rate,
											bid_status,
											accepted_amount
								FROM 		loan_bids	
								WHERE		loan_id	=	{$loan_id}
								AND			investor_id	= {$this->inv_or_borr_id}
								AND			(bid_status	=	2	OR	bid_status	=	1)";
		
		
		$bid_rs		= 	$this->dbFetchRow($bid_sql);
		
		if ($bid_rs) {
			$this->bidDetail	=	$bid_rs;
		}
		return $bid_rs;
	}
	
	
	public function getPaymentSchedule($loan_id) {
		
			$paymentschedule_sql		= 	"	SELECT 		IFNULL(DATE_FORMAT(borrower_repayments.trans_date,'%d/%m/%Y'),'--') 
																										payment_date, 
															IFNULL(ROUND(interest_paid * investor_ratio,2),'--') int_paid, 
															IFNULL(ROUND(amount_paid * investor_ratio,2),'--') amt_paid,
															IFNULL(ROUND(principal_paid * investor_ratio,2),'--') princ_paid, 
															IFNULL(ROUND(penalty_paid * investor_ratio, 2),'--') penal_paid, 
															DATE_FORMAT(repayment_schedule_date,'%d/%m/%Y') schd_date, 
															ROUND(repayment_scheduled_amount * investor_ratio,2) schd_amt,
															if (isnull(borrower_repayments.amount_paid), 'Unpaid', 'Paid') status
												FROM 		loan_repayment_schedule 
															LEFT OUTER JOIN borrower_repayments 
																ON 	(loan_repayment_schedule.loan_id = borrower_repayments.loan_id
																AND  borrower_repayments.repayment_schedule_id = 
																			loan_repayment_schedule.repayment_schedule_id), 
															( SELECT 	loans.loan_id, 
																		(sum(loan_bids.bid_amount)
																				/ loans.loan_sanctioned_amount) investor_ratio 
																FROM 	loans, 
																		loan_bids	
																WHERE loans.loan_id = {$loan_id} 
																AND loan_bids.loan_id = {$loan_id} 
																AND loan_bids.investor_id = {$this->inv_or_borr_id}
															) xxx
											WHERE loan_repayment_schedule.loan_id = {$loan_id}";
			
		$paymentschedule_rs	= 	$this->dbFetchAll($paymentschedule_sql);
			
		if ($paymentschedule_rs) {
			foreach ($paymentschedule_rs as $paymentRow) {
				$newrow = count($this->paymentScheduleInfo);
				$newrow ++;
				foreach ($paymentRow as $colname => $colvalue) {
					$this->paymentScheduleInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $paymentschedule_rs;
	}
	
	public function updateCommentReply($postArray) {
			
		$dataArray = array(	'in_response_to'				=> $postArray['commentID'],
							'comments_text'					=> $postArray['commentTxt'],
							'commented_by_user'				=> $postArray['userID'],
							'loan_id' 						=> $postArray['loanID'],
							'comment_datetime' 				=> date("Y-m-d h:i:sa"));
							
			$commentId =  $this->dbInsert('loan_comments', $dataArray, true);
			if ($commentId < 0) {
				return -1;
			}
			return	$commentId;
	}
	
	public function insertComment($postArray) {
			
		$dataArray = array(	'in_response_to'				=> NULL,
							'comments_text'					=> $postArray['commentTxt'],
							'commented_by_user'				=> $postArray['userID'],
							'loan_id' 						=> $postArray['loanID'],
							'comment_datetime' 				=> date("Y-m-d h:i:sa"));
							
			$commentId =  $this->dbInsert('loan_comments', $dataArray, true);
			if ($commentId < 0) {
				return -1;
			}
			return	$commentId;
	}
	
	public function processBid($postArray) {
		
		$transType 	= $postArray['bid_trantype'];
		if($transType	==	"new") {
			$this->insertBidInfo($postArray);
		}else{
			$this->updateBidInfo($postArray);
		}
	}
	
	public function insertBidInfo($postArray) {
		
		$bid_amount				=	($postArray['bid_amount']!="")?$postArray['bid_amount']:null;
		$bid_interest_rate		=	($postArray['bid_interest_rate']!="")?$postArray['bid_interest_rate']:null;
		
		$dataArray 				= 	array(	'loan_id'			=> $postArray['loan_id'],
											'investor_id'		=> $this->inv_or_borr_id,
											'bid_datetime' 		=> $this->getDbDateFormat(date("d/m/Y")),
											'bid_amount' 		=> $bid_amount,
											'bid_interest_rate' => $bid_interest_rate,
											'bid_status' 		=> LOAN_BIDS_STATUS_OPEN);
							
		$loanBidId =  $this->dbInsert('loan_bids', $dataArray, true);
		return $loanBidId;
	}
	
	public function updateBidInfo($postArray) {
		
		$bid_amount				=	($postArray['bid_amount']!="")?$postArray['bid_amount']:null;
		$bid_interest_rate		=	($postArray['bid_interest_rate']!="")?$postArray['bid_interest_rate']:null;
		$bid_id					=	$postArray['bid_id'];
		if($postArray['isCancelButton']	==	"yes") {
			
			$dataArray 				= 	array(	'bid_datetime' 		=> $this->getDbDateFormat(date("d/m/Y")),
												'bid_status' 		=> LOAN_BIDS_STATUS_CANCELLED);
		}else{
			$dataArray 				= 	array(	'bid_datetime' 		=> $this->getDbDateFormat(date("d/m/Y")),
												'bid_amount' 		=> $bid_amount,
												'bid_interest_rate' => $bid_interest_rate,
												'bid_status' 		=> LOAN_BIDS_STATUS_ACCEPTED);
		}
							
		$whereArry					=	array("bid_id" =>"{$bid_id}");
		$this->dbUpdate('loan_bids', $dataArray, $whereArry);
	}
}
