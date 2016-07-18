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
	public 	$successTxt = 	"";
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
										bank_statement_url,
										verified_status,
										active_status,
										{$this->typePrefix}_id inv_or_bor_id,
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
		
		//~ $updateSql	=	"	UPDATE	{$this->typePrefix}_banks
							//~ SET		bank_code 				=	'".$bankcode."',
									//~ bank_name 				=	'".$bankname."',
									//~ branch_code 			=	'".$branchcode."',
									//~ bank_account_number		=	'".$bankaccnumber."'
							//~ WHERE	{$this->typePrefix}_bankid 	=	$bankid ";
		
		//~ $this->dbExecuteSql($updateSql);	
		
		$dataArray = array(	
							'bank_code' 			=> $bankcode,
							'bank_name' 			=> $bankname,
							'branch_code' 			=> $branchcode,
							'bank_account_number'	=> $bankaccnumber,
							);
		
		$whereArry	=	array("{$this->typePrefix}_bankid" =>"{$bankid}");
		$this->dbUpdate("{$this->typePrefix}_banks", $dataArray, $whereArry);
		
		return $bankid ;
	
	}
	
	function addBankDetails($postArray) {
		
		$bankcode		=	$postArray['bankcode'];
		$bankname		=	$postArray['bankname'];
		$branchcode		=	$postArray['branchcode'];
		$bankaccnumber	=	$postArray['bankaccnumber'];
		
		//~ $insertSql	=	"	INSERT INTO {$this->typePrefix}_banks 
							//~ (	{$this->typePrefix}_id,
								//~ bank_code, bank_name, 
								//~ branch_code, bank_account_number, 
								//~ verified_status, active_status) VALUES 
							//~ (	{$this->inv_or_borr_id},
								//~ '".$bankcode."','".$bankname."',
								//~ '".$branchcode."','".$bankaccnumber."',
								//~ 1, 0)";
		$dataArray = array(	$this->typePrefix.'_id' => $this->inv_or_borr_id,
							'bank_code' 			=> $bankcode,
							'bank_name' 			=> $bankname,
							'branch_code' 			=> $branchcode,
							'bank_account_number'	=> $bankaccnumber,
							'verified_status' 		=> 0,
							'active_status' 		=> 1,
							);
						
		$bankId =  $this->dbInsert("{$this->typePrefix}_banks", $dataArray, true);
		
		$updatesql = "UPDATE {$this->typePrefix}_banks
							 SET active_status=0 
							 WHERE {$this->typePrefix}_bankid NOT IN 
								( SELECT {$this->typePrefix}_bankid 
										FROM 
											(SELECT max({$this->typePrefix}_bankid) {$this->typePrefix}_bankid 
												    FROM {$this->typePrefix}_banks 
												    WHERE {$this->typePrefix}_id = {$this->inv_or_borr_id}) 
											xx ) 
							AND {$this->typePrefix}_id = {$this->inv_or_borr_id} ";
							
		$this->dbExecuteSql($updatesql);		
		
		return $bankId ;
		
		return true;		
	}
	
	function processBankDetails($postArray) {		
		$transtype	=	$postArray['transtype'];
		if($transtype	==	"add") {
			$bankId	=	$this->addBankDetails($postArray);		
			$this->successTxt	=	$this->getSystemMessageBySlug("borrower_bank_submit");	
		}else{			
			$bankId	=	$this->updateBankDetails($postArray);
			$this->successTxt	=	$this->getSystemMessageBySlug("bank_detail_saved");
		}	
		$this->uploadBankStatementAttachment($postArray,$bankId);		
		
	}	
	
	function  uploadBankStatementAttachment($postArray,$bankId) {
		
		$destinationPath 			= 	Config::get('moneymatch_settings.upload_inv');
		$fileUploadObj				=	new FileUpload();
		
		$updateAttachment		=	false;
		if(isset($postArray['bank_statement'])){
			if(isset($postArray['bank_statement_hidden'])){
				$filePath		=	$postArray['bank_statement_hidden'];
				$fileUploadObj->deleteFile($filePath);
				
			}
			
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$filePath				=	$destinationPath."/".$this->inv_or_borr_id;
			$fileUploadObj->createIfNotExists($filePath);
			
			$file					=	$postArray['bank_statement'];
			
			$prefix					=	"bank_stat_".$bankId."_";
			$bank_statement_path	=	$fileUploadObj->storeFile($filePath ,$file,$prefix);
			$updateDataArry			=	array(	"bank_statement_url"=>$bank_statement_path);
			$updateAttachment		=	true;
		}
		if($updateAttachment) {
			$whereArray	=	["{$this->typePrefix}_id" 		=>$this->inv_or_borr_id,
							 "{$this->typePrefix}_bankid"	=> $bankId];
			$this->dbUpdate("{$this->typePrefix}_banks", $updateDataArry, $whereArray);
		}
	}
}
	
	
