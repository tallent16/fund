<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;

class BankProcessModel extends TranWrapper {
	/*-----------------------------------------------------------------------
	 * Used by bankProcessController
	 * Purpose: To add, update and list the banks for borrowers & investors
	 * 
	 * Special Notes:
	 * This is common for both the investors' banks and Borrowers' banks though 
	 * the two entities are stored in different tables. 
	 * 
	 * The model uses the logged in user's type (borrower / investor)
	 * 
	 * --------------------------------------------------------------------*/
	 
	public	$inv_or_borr_id;
	public	$typePrefix;
	public	$userType;
	public	$bankListRs = array();
	public  $transtype;
	
	public function __construct($attributes = array()){	
		
		// This will be called only from the borrower / Investors' model so this will be investor or borrower
		$this->userType 		= 	$this->getUserType();
		$this->inv_or_borr_id	=	($this->userType == 1)? $this->getCurrentBorrowerID(): 
															$this->getCurrentInvestorID();
		$this->typePrefix		=	($this->userType == 1)? "borrower":
															"investor";
	}
	
	function getBanksList() {

		$bankListSql	=	"	SELECT	{$this->typePrefix}_bankid bankid,
										bank_code,
										bank_name,
										branch_code,
										bank_account_number,
										verified_status,
										active_status,
										concat(if (verified_status = 0, 1, if (active_status = 0, 2, 3)), 
												{$this->typePrefix}_bankid) orderby
								FROM	{$this->typePrefix}_banks
								WHERE	{$this->typePrefix}_id = {$this->inv_or_borr_id}
								ORDER BY orderby ";
		
		$this->bankListRs	=	$this->dbFetchAll($bankListSql);		
		return;
	}
	
	function updateBankDetails($postArray) {
		
		$bankcode		=	$postArray['bankcode'];
		$bankname		=	$postArray['bankname'];
		$branchcode		=	$postArray['branchcode'];
		$bankaccnumber	=	$postArray['bankaccnumber'];
		$bankid			=	$postArray['bankid'];
		
		$updateSql	=	"	UPDATE	{$this->typePrefix}_banks
							SET		bank_code 				=	'".$bankcode."',
									bank_name 				=	'".$bankname."',
									branch_code 			=	'".$branchcode."',
									bank_account_number		=	'".$bankaccnumber."'
							WHERE	{$this->typePrefix}_bankid 	=	$bankid ";
		
		$this->dbExecuteSql($updateSql);	
		return; 
	
	}
	
	function addBankDetails($postArray) {
	
		$bankcode		=	$postArray['bankcode'];
		$bankname		=	$postArray['bankname'];
		$branchcode		=	$postArray['branchcode'];
		$bankaccnumber	=	$postArray['bankaccnumber'];
		
		$insertSql	=	"	INSERT INTO {$this->typePrefix}_banks 
							(	{$this->typePrefix}_id,
								bank_code, bank_name, 
								branch_code, bank_account_number, 
								verified_status, active_status) VALUES 
							(	{$this->inv_or_borr_id},
								'".$bankcode."','".$bankname."',
								'".$branchcode."','".$bankaccnumber."',
								1, 0)";
		
		$this->dbExecuteSql($insertSql);
		return true;		
	}
	
	function processBankDetails($postArray) {		
		$transtype	=	$postArray['transtype'];
		if($transtype	==	"add") {
			$this->addBankDetails($postArray);			
		}else{			
			$this->updateBankDetails($postArray);
		}		
	}	
}
	
	
