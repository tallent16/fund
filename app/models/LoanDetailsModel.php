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
	public 	$loan_reference_number		=  	"";
	public 	$loan_tenure				=  	"";
	public	$perc_funded				=	"";
	public	$days_to_go					=	"";
	public	$isfeatured					=	"";
	public	$no_of_bidders				=	"";
	public	$total_bid					=	"";
	public	$apply_amount				=	"";
	public	$repayment_type				=	"";
	public	$loan_status				=	"";
	public	$target_interest			=	0;
	public	$bid_type					=	0;
	public	$min_bid_amount				=	0;
	public 	$directorInfo				= 	array();
	public 	$bidInfo 					= 	array();
	public 	$bidDetail 					= 	array();
	public 	$commentInfo 				= 	array();
	public 	$finacialRatioInfo 			= 	array();
	public 	$finacialInfo 				= 	array();
	public 	$paymentScheduleInfo 		= 	array();
	public 	$bidSystemMessageInfo 		= 	array();
	public 	$successTxt 				= 	"";
	
	public function __construct($attributes = array()){	
		
		// This will be called only from the borrower / Investors' model so this will be investor or borrower
		$this->userType 		= 	$this->getUserType();
		$this->inv_or_borr_id	=	($this->userType == 1)? $this->getCurrentBorrowerID(): 
															$this->getCurrentInvestorID();
		$this->typePrefix		=	($this->userType == 1)? "borrower":
															"investor";
		$this->min_bid_amount	=	$this->getSystemSettingFieldByKey("minmum_bid_amount");
	}
	
	public function getLoanDetails($loan_id) {
		
		$this->getLoan($loan_id);
		$this->getLoanFinacialRatio();
		$this->getLoanFinacial();
		$this->getLoanDirector();
		$this->getBidAverageInterest($loan_id);
		$this->getLoanComments($loan_id);	
		$this->getLoanComments($loan_id);	
		switch($this->userType) {
			case	USER_TYPE_INVESTOR:
				$this->getPaymentSchedule($loan_id);
				$this->getBidDetails($loan_id);
				break;
			case	USER_TYPE_BORROWER:
				$this->getPaymentSchedule($loan_id);
				$this->getLoanBids($loan_id);
				break;
		}
		$this->bidSystemMessageInfo	=	json_encode($this->getSystemMessages(4));
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
											loans.loan_reference_number,
											loans.loan_tenure,
											round(ifnull(total_bid * 100 / apply_amount,0),2) perc_funded,
											loans.target_interest,
											loans.bid_type,
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
											( 	SELECT	codelist_value 
												FROM	codelist_details
												WHERE	codelist_id = 7
												AND		codelist_code = loans.status
											) statusText,
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
		
		if ($this->userType == USER_TYPE_BORROWER) {
			
			$paymentschedule_sql			= "	SELECT 	ifnull(DATE_FORMAT(loanrepsch.repayment_schedule_date,'%d-%m-%Y'),'') 
																	schd_date,
														ROUND(loanrepsch.repayment_scheduled_amount,2) schd_amt,
														case loanrepsch.repayment_status 
															   when 1 then 'Unpaid' 
															   when 2 then 'Paid'
														end as status,
														ifnull(DATE_FORMAT(loanrepsch.repayment_actual_date,'%d-%m-%Y'),'') 							payment_date ,
														ROUND(if (repayment_status != 1, repayment_scheduled_amount + ifnull(repayment_penalty_interest, 0) + ifnull(repayment_penalty_charges, 0), 0),2) amt_paid,
														ROUND(ifnull(repayment_penalty_interest, 0) + ifnull(repayment_penalty_charges, 0),2) penal_paid
												FROM 	borrower_repayment_schedule loanrepsch
												WHERE	loanrepsch.borrower_id		=	{$this->inv_or_borr_id}
												AND		loanrepsch.loan_id			=	{$loan_id}";
		} else {
			$paymentschedule_sql	= 	"SELECT	DATE_FORMAT(payment_date,'%d-%m-%Y') payment_date,
												interest_amount int_paid,
												payment_schedule_amount + ifnull(penalty_amount,0) amt_paid,
												penalty_amount penal_paid,
												principal_amount princ_paid,
												DATE_FORMAT(payment_scheduled_date,'%d-%m-%Y') schd_date,
												payment_schedule_amount schd_amt,
												CASE status 
													WHEN 1 THEN 'Unpaid'
													WHEN 2 THEN 'Not approved'
													WHEN 3 THEN 'Payment Approved'
												END status
										FROM 	investor_repayment_schedule
										WHERE 	loan_id = {$loan_id}
										AND		investor_id = {$this->inv_or_borr_id} ";
		}
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
		
		$transType				=	$postArray['bid_trantype'];
		$bid_amount				=	$this->makeFloat($postArray['bid_amount']);
		$bid_interest_rate		=	$this->makeFloat($postArray['bid_interest_rate']);
		$this->min_bid_amount	=	$this->getSystemSettingFieldByKey("minmum_bid_amount");
		if(	($bid_interest_rate	>	0)	&&	($bid_interest_rate	>	0)	) {
			if(	$bid_amount	>=	$this->min_bid_amount ) {
			
				if($transType	==	"new") {
					return $this->insertBidInfo($postArray);
				}else{
					return $this->updateBidInfo($postArray);
				}
			}
		}else{
			return	-1;
		}
	}
	
	public function insertBidInfo($postArray) {
		
		$bid_amount				=	$postArray['bid_amount'];
		$bid_amount				=	$this->makeFloat($bid_amount);
		$bid_interest_rate		=	$postArray['bid_interest_rate'];
		$bid_interest_rate		=	$this->makeFloat($bid_interest_rate);
		$available_balance		=	$this->getInvestorAvailableBalanceById($this->inv_or_borr_id);
		
		$dataArray 				= 	array(	'loan_id'			=> $postArray['loan_id'],
											'investor_id'		=> $this->inv_or_borr_id,
											'bid_datetime' 		=> $this->getDbDateFormat(date("d/m/Y")),
											'bid_amount' 		=> $bid_amount,
											'bid_interest_rate' => $bid_interest_rate,
											'bid_status' 		=> LOAN_BIDS_STATUS_OPEN);
							
		$loanBidId				= 	$this->dbInsert('loan_bids', $dataArray, true);
		
		
		//Update the Available Balance For the Investor
		$resetAvailableBalance	=	$available_balance	-	$bid_amount;
		
		$investorWhereArray		=	array("investor_id"	=>	$this->inv_or_borr_id);
		$investorDataArray		=	array("available_balance"	=>	$resetAvailableBalance);
		
		$this->dbUpdate('investors', $investorDataArray, $investorWhereArray);
		
		$this->successTxt	=	$this->getSystemMessageBySlug("loan_bids_by_investor");
		
		//Update the Available Balance For the Investor
		
		return $loanBidId;
	}
	
	public function updateBidInfo($postArray) {
		
		$bid_amount				=	$postArray['bid_amount'];
		$bid_amount				=	$this->makeFloat($bid_amount);
		$bid_interest_rate		=	$postArray['bid_interest_rate'];
		$bid_interest_rate		=	$this->makeFloat($bid_interest_rate);
		$prev_bid_amount		=	$this->makeFloat($postArray['prev_bid_amount']);
		$available_balance		=	$this->getInvestorAvailableBalanceById($this->inv_or_borr_id);

		$moduleName	=	"Loan Process";
		$investName	=	$this->getUserName("Investor", $this->inv_or_borr_id);
		
		$bid_id					=	$postArray['bid_id'];
		if($postArray['isCancelButton']	==	"yes") {
			
			$dataArray 				= 	array(	'bid_datetime' 		=> $this->getDbDateFormat(date("d/m/Y")),
												'process_date' 		=> $this->getDbDateFormat(date("d/m/Y")),
												'bid_status' 		=> LOAN_BIDS_STATUS_CANCELLED);
			$resetAvailableBalance	=	$available_balance	+	$prev_bid_amount;
			$actionSumm =	"Bid Cancelled";
			$actionDet  =	"Loan Bid Cancelled by Invesotr";
			$this->successTxt	=	$this->getSystemMessageBySlug("loan_bids_cancelled_by_investor");
		}else{
			$dataArray 				= 	array(	'bid_datetime' 		=> $this->getDbDateFormat(date("d/m/Y")),
												'bid_amount' 		=> $bid_amount,
												'bid_interest_rate' => $bid_interest_rate,
												'bid_status' 		=> LOAN_BIDS_STATUS_OPEN);
			$resetAvailableBalance	=	($available_balance	+	$prev_bid_amount)	-	$bid_amount;
			$actionSumm =	"Loan Bid By Investor";
			$actionDet  =	"Loan Bid by Investor";
			$this->successTxt	=	$this->getSystemMessageBySlug("loan_bid_updated");
			
		}

		$this->setAuditOn($moduleName, $actionSumm, $actionDet, "Investor Name",$investName);
							
		$whereArry					=	array("bid_id" =>"{$bid_id}");
		$this->dbUpdate('loan_bids', $dataArray, $whereArry);
		
		//Update the Available Balance For the Investor
		
		$investorWhereArray		=	array("investor_id"	=>	$this->inv_or_borr_id);
		$investorDataArray		=	array("available_balance"	=>	$resetAvailableBalance);
		
		$this->dbUpdate('investors', $investorDataArray, $investorWhereArray);
		
		//Update the Available Balance For the Investor
		
		return $bid_id;
	}
	
	public	function getInvestorAvailablBalance() {
		$available_balance		=	$this->getInvestorAvailableBalanceById($this->inv_or_borr_id);
		return	$available_balance;
	}
}
