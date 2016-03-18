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
	
	public 	$bank_code						= 	array();
	public 	$bank_name						= 	array();
	public 	$branch_code					= 	array();
	public 	$bank_account_number			= 	array();
	
	
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
	//	echo $bankListSql;
		$this->bankListRs	=	$this->dbFetchAll($bankListSql);
		return;
	}
	
	function updateBankDetails() {
		$updateSql	=	"	UPDATE	{$this->typePrefix}_banks
							SET		bank_code 				=	{$_REQUEST['bank_code']},
									bank_name 				=	{$_REQUEST['bank_name']},
									branch_code 			=	{$_REQUEST['branch_code']},
									bank_account_number		=	{$_REQUEST['bank_account_number']}
							WHERE	{$this->typePrefix}_bankid 	=	{$_REQUEST['bankid']} ";
		
		$this->dbExecuteSql($updateSql);
		return; 
	
	}
	
	function addBankDetails() {
		$insertSql	=	"	INSERT INTO {$this->typePrefix}_banks 
							(	bank_code, bank_name, 
								branch_code, bank_account_number, 
								verified_status, active_status) VALUES 
							(	{$_REQUEST['bank_code']}, {$_REQUEST['bank_name']},
								{$_REQUEST['branch_code']}, {$_REQUEST['bank_account_number']},
								0, 0)";
								
		$this->dbExecuteSql($insertSql);
		return;
		
	}
	
}
	
	
