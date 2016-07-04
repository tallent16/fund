<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class AdminManageBidsModel extends TranWrapper {
	
	public $loan_reference_number = "";
	public $purpose = "";
	public $business_name = "";
	public $apply_amount = 0;
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
	public $borrower_id = 0;
	public $successTxt = "";
	
	public $loanBids = array();
	
	public function getLoanBids($loanId) {
		
		$loanInfo_sql	=	"	SELECT	loans.loan_id,
										loan_reference_number,
										purpose_singleline,
										borrowers.business_name,
										borrowers.borrower_id,
										apply_amount,
										date_format(apply_date, '%d-%m-%Y') apply_date,
										loan_tenure,
										date_format(bid_close_date, '%d-%m-%Y') bid_close_date,
										codelist_value('Loan Bid Type', bid_type) bid_type,
										partial_sub_allowed,
										min_for_partial_sub,
										codelist_value('Loan Repayment Type', repayment_type) repayment_type,
										target_interest,
										final_interest_rate,
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


		$bidstotal_sql	=	"	SELECT	sum(bid_amount) bid_amount_total
								FROM	loan_bids
								WHERE	loan_id = :loan_id
								AND		loan_bids.bid_status != :bid_cancelled ";
								
		$bidsInfo_sql	=	"	SELECT	users.username,
										bid_id,
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
								AND		loan_bids.bid_status != :bid_cancelled 
								ORDER BY bid_interest_rate, bid_datetime";
								
		$bidsInfo_args	=	[	"loan_id" => $loanId, 
								"bid_cancelled" => LOAN_BIDS_STATUS_CANCELLED
							];
		
		$this->loanBids	=	$this->dbFetchWithParam($bidsInfo_sql, $bidsInfo_args);
		if ($this->loan_status == LOAN_STATUS_CLOSED_FOR_BIDS) {
			// Auto fill the Accepted amount based on the formula
			// If the total_bids <= loan_apply_amount then accepted_amount = bid_amount
			$bidstotal_rs	=	$this->dbFetchWithParam($bidstotal_sql, $bidsInfo_args);
			$totalBid_amt	=	$bidstotal_rs[0]->bid_amount_total;
			$runningTotal	=	0;
			for ($index = 0; $index < count($this->loanBids); $index++) {
				
				if ($this->apply_amount > $runningTotal) {
					$diff = $this->apply_amount - ($runningTotal + $this->loanBids[$index]->bid_amount);
					if ($diff < 0 ) 
						$this->loanBids[$index]->accepted_amount = $this->loanBids[$index]->bid_amount + $diff;
					else 
						$this->loanBids[$index]->accepted_amount = $this->loanBids[$index]->bid_amount;
				} else {
					$this->loanBids[$index]->accepted_amount = 0;
				}
				
				$runningTotal += $this->loanBids[$index]->accepted_amount;
			}
		}
										
	}
	
	public function closeBids($loanId) {
		
		$moduleName	=	"Loan Process";
		$actionSumm =	"Bids Closed";
		$actionDet  =	"Bids Closed";
		$this->getLoanBids($loanId);
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"Loan Reference Nu",$this->loan_reference_number);
		
		$tableName		=	"loans";
		$dataArray		=	["status" 	=>	LOAN_STATUS_CLOSED_FOR_BIDS];
		$where			=	["loan_id"	=>	$loanId];
		
		$this->dbUpdate($tableName, $dataArray, $where);
		
		$borrUserInfo		=	$this->getBorrowerIdByUserInfo($this->borrower_id);
		$borrInfo			=	$this->getBorrowerInfoById($this->borrower_id);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		
		$fields 			= array('[borrower_contact_person]','[application_name]',
									'[loan_number]');
		$replace_array 		= array();
		$replace_array 		= array( 	$borrInfo->contact_person, 
										$moneymatchSettings[0]->application_name,
										$this->loan_reference_number );
		$slug_name			=	"loan_bid_closed";									
		$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
		$this->successTxt	=	$this->getSystemMessageBySlug("loan_bid_closed");
		return;	
		
		
	}
	
	public function acceptBids($loanId) {
		/* Validate the information since Javascript validation can be overriden in some
		 * Extreme cases
		 */
		$acceptAmtArray	=	$_REQUEST["accepted_amount"];
		$interestArray	=	$_REQUEST["bid_interest"];
		$bidAmtArray	=	$_REQUEST["bid_amount"];
		$investorArray	=	$_REQUEST["investor_ids"];
		$loanApplyAmt	=	0;
		$totAcceptedAmt	=	0;
		$finalInterest	=	0;

		$moduleName	=	"Loan Process";
		$actionSumm =	"Accept Loan Bids";
		$actionDet  =	"Accept Loan Bids";

		$this->getLoanBids($loanId);
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"Loan Reference Nu",$this->loan_reference_number);

		
		$loanApplyAmt_sql	=	"	SELECT	loans.apply_amount,
											if(partial_sub_allowed = 1, min_for_partial_sub, apply_amount) min_loan_amount
									FROM	loans
									WHERE	loan_id = :loan_id ";
		$loanApplyAmt_rs	=	$this->dbFetchWithParam($loanApplyAmt_sql, ["loan_id" => $loanId]);

		if (count($loanApplyAmt_rs) == 0) {
			// The unspeakable has happened. Return error
			return -1;
		}
		
		$loanApplyAmt		=	$loanApplyAmt_rs[0]->apply_amount;
		$loanMinAmt			=	$loanApplyAmt_rs[0]->min_loan_amount;
		
		foreach ($acceptAmtArray as $investor_id => $acceptAmount) {
			$totAcceptedAmt =	$totAcceptedAmt + $this->makeFloat($acceptAmount);
		}
		
		if ($totAcceptedAmt < $loanMinAmt) {
			// This validation should be done at the Frontend itself. But this is being done 
			// here to make sure that the validations have not been bypassed
			return -1;
		}

		/* When accepting bids, 
		*		Update loans table 
		*			make the status "Bid Accepted"
		* 		Update loan_bids table 
		* 			update the accepted_amount value
		* 			if accepted_amount > 0
		* 				make the bid_status as accepted
		* 			else
		* 				make the bid_status as rejected
		*/
		
		$moneymatchSettings = 	$this->getMailSettingsDetail();

		foreach ($acceptAmtArray as $bidId => $acceptedAmount) {
			$tableName		=	"loan_bids";
			if ($acceptedAmount > 0) {
				$bidStatus		=	LOAN_BIDS_STATUS_ACCEPTED;
				$bidInterest 	=	$interestArray[$bidId];
				$acceptAmount	=	$this->makeFloat($acceptedAmount);
				$finalInterest	+= 	$acceptAmount / $totAcceptedAmt * $bidInterest;
			} else {
				$bidStatus		=	LOAN_BIDS_STATUS_REJECTED;
				$acceptAmount	=	0;
			}
			
			$dataArray		=	["bid_status" 			=>	$bidStatus, 
								 "accepted_amount" 		=>	$acceptAmount,
								'process_date' 		=> $this->getDbDateFormat(date("d/m/Y"))
								 ];

			$where			=	["bid_id" 	=>	$bidId];
			
			$tableName		=	"loan_bids";
			$this->dbUpdate($tableName, $dataArray, $where);
			
			$investorId			=	$investorArray[$bidId];
			$invUserInfo		=	$this->getInvestorIdByUserInfo($investorId);
			
			$fields 			= 	array(	'[investor_firstname]', '[investor_lastname]',
											'[loan_number]',
											'[bid_amount]',
											'[bid_accepted_amount]',
											'[application_name]',
											);
			$replace_array 		= 	array( 		$invUserInfo->firstname,
												$invUserInfo->lastname,
												$bidAmtArray[$bidId],
												$acceptAmount,
												$this->loan_reference_number );
			if($bidStatus	==		LOAN_BIDS_STATUS_ACCEPTED)							
				$slug_name			=	"loan_bids_accepted";									
			else
				$slug_name			=	"loan_bids_rejected";		
											
			$this->sendMailByModule($slug_name,$invUserInfo->email,$fields,$replace_array);
		}
	
		$tableName		=	"loans";
		$dataArray		=	["status" 					=>	LOAN_STATUS_BIDS_ACCEPTED,
							 "final_interest_rate" 		=>	$finalInterest,
							 "loan_sanctioned_amount" 	=> 	$totAcceptedAmt];
		$where			=	["loan_id"	=>	$loanId];
		
		$this->dbUpdate($tableName, $dataArray, $where);
		$this->successTxt	=	$this->getSystemMessageBySlug("loan_bids_accepted");
		return;
	}
	
	public function cancelLoan($loanId) {
		$moduleName	=	"Loan Process";
		$actionSumm =	"Loan Cancelled";
		$actionDet  =	"Loan Cancelled";

		$this->getLoanBids($loanId);
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"Loan Reference Nu",$this->loan_reference_number);
		
		$tableName		=	"loans";
		$dataArray		=	["status" 	=>	LOAN_STATUS_CANCELLED];
		$where			=	["loan_id"	=>	$loanId];
		
		$this->dbUpdate($tableName, $dataArray, $where);
				
		$borrUserInfo		=	$this->getBorrowerIdByUserInfo($this->borrower_id);
		$borrInfo			=	$this->getBorrowerInfoById($this->borrower_id);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		
		$fields 			= array('[borrower_contact_person]','[application_name]',
									'[loan_number]');
		$replace_array 		= array();
		$replace_array 		= array( 	$borrInfo->contact_person, 
										$moneymatchSettings[0]->application_name,
										$this->loan_reference_number );
		$slug_name			=	"loan_cancelled";									
		$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
		
		return;
	}
	
}
