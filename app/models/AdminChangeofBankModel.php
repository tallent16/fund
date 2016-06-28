<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use Log;
use Auth;
class AdminChangeofBankModel extends TranWrapper {
	
	public 	$bank_lists 	= array();
	public  $account_proof 	= "";
	/****List the borrower/investor bank Entries***/
	public function getborrowerinvestorbanks(){
		
		$boin_sql = "SELECT 
							borrower_banks.borrower_id,
							borrower_banks.borrower_bankid,
							borrower_banks.bank_statement_url,
							borrower_banks.bank_code,
							borrower_banks.bank_name,
							borrower_banks.branch_code	,
							borrower_banks.bank_account_number,
                            borrowers.business_name,                           
                            CONCAT(users.firstname,users.lastname) as name,
							users.usertype,
								CASE users.usertype
									 when 1 then 'Borrower'
									 when 2 then 'Investor'	
								END as user_type
						FROM 	borrower_banks,borrowers,users
						WHERE 	borrower_banks.borrower_id = borrowers.borrower_id
						AND 	borrowers.user_id = users.user_id
						AND 	borrower_banks.verified_status = 0
					UNION ALL
						SELECT 
							investor_banks.investor_id,
							investor_banks.investor_bankid,
							investor_banks.bank_statement_url,
							investor_banks.bank_code,
							investor_banks.bank_name,
							investor_banks.branch_code,
							investor_banks.bank_account_number,							
							CONCAT(users.firstname,users.lastname) as name,
                            NULL as business_name,
							users.usertype,
								CASE users.usertype
									 when 1 then 'Borrower'
									 when 2 then 'Investor'	
								END as user_type
						FROM 	investor_banks,investors,users
						WHERE 	investor_banks.investor_id = investors.investor_id
						AND 	investors.user_id = users.user_id
						AND 	investor_banks.verified_status = 0 ";
			
		$res = 	$this->dbFetchAll($boin_sql);
		$this->bank_lists = $res;
		
	}
	/****Edit Approve Screen***/
	public function getborrowerinvestorbankinfo($usertype,$borinv_id,$borinvbankid){
		
		if($usertype == "Borrower"){
			$editinfosql	= "SELECT  borrower_banks.borrower_id,
									   borrower_banks.borrower_bankid,
									   borrower_banks.bank_name,
									   borrower_banks.bank_code,
									   borrower_banks.branch_code,
									   borrower_banks.bank_account_number,
									   borrower_banks.bank_statement_url,
									   CONCAT(users.firstname,users.lastname) as name,
											CASE users.usertype
												 when 1 then 'Borrower'
												 when 2 then 'Investor'	
											END as user_type_name
								FROM 	borrower_banks, borrowers,users 
								WHERE	borrower_banks.borrower_id = :borrower_investor_id
								AND	 	borrowers.borrower_id = :borrower_investor_id2
								AND		borrower_banks.borrower_bankid = :borrower_investor_bank_id
								AND 	borrowers.user_id = users.user_id"	;
								
			$paramArray			=	["borrower_investor_id"	 		=>$borinv_id ,
									 "borrower_investor_id2"		=>$borinv_id ,
									 "borrower_investor_bank_id"	=>$borinvbankid
									];
			$borinvrow		= 	$this->dbFetchWithParam($editinfosql,$paramArray);
			if (count($borinvrow) > 0) {			
					$this->bank_name			=	$borinvrow[0]->bank_name;
					$this->bank_code			=	$borinvrow[0]->bank_code;
					$this->branch_code			=	$borinvrow[0]->branch_code;
					$this->bank_account_number	=	$borinvrow[0]->bank_account_number;
					$this->name					=	$borinvrow[0]->name;
					$this->user_type_name		=	$borinvrow[0]->user_type_name;
					$this->borrower_id			=	$borinvrow[0]->borrower_id;
					$this->borrower_bankid		=	$borinvrow[0]->borrower_bankid;
					$this->bank_statement_url	=	$borinvrow[0]->bank_statement_url;
			}
			
		}else{
			$editinfosql	= "SELECT  investor_banks.investor_id,
									   investor_banks.investor_bankid,
									   investor_banks.bank_name,
									   investor_banks.bank_code,
									   investor_banks.branch_code,
									   investor_banks.bank_account_number,
									   investor_banks.bank_statement_url,
									   CONCAT(users.firstname,users.lastname) as name,
											CASE users.usertype
												 when 1 then 'Borrower'
												 when 2 then 'Investor'	
											END as user_type_name
								FROM 	investor_banks, investors,users 
								WHERE	investor_banks.investor_id = :borrower_investor_id
                                AND 	investor_banks.investor_bankid = :borrower_investor_bank_id
								AND		investors.investor_id = :borrower_investor_id2
								AND 	investors.user_id = users.user_id"	;	
									
			$paramArray			=	["borrower_investor_id"	 		=>$borinv_id ,
									 "borrower_investor_id2"		=>$borinv_id ,
									 "borrower_investor_bank_id"	=>$borinvbankid 
									];
			$borinvrow		= 	$this->dbFetchWithParam($editinfosql,$paramArray);
			if (count($borinvrow) > 0) {			
					$this->bank_name			=	$borinvrow[0]->bank_name;
					$this->bank_code			=	$borinvrow[0]->bank_code;
					$this->branch_code			=	$borinvrow[0]->branch_code;
					$this->bank_account_number	=	$borinvrow[0]->bank_account_number;
					$this->name					=	$borinvrow[0]->name;
					$this->user_type_name		=	$borinvrow[0]->user_type_name;
					$this->investor_id			=	$borinvrow[0]->investor_id;
					$this->investor_bankid		=	$borinvrow[0]->investor_bankid;
					$this->bank_statement_url	=	$borinvrow[0]->bank_statement_url;
			}
		}		
	}
	/***Approve button*****/ 
	public function updateborrowerinvestorbankapprove($postArray){
		
		if($postArray)
		{
			$bor_bankid			= $postArray['bor_bankid'];
			$bor_id				= $postArray['bor_id'];
			$inv_bankid			= $postArray['inv_bankid'];
			$inv_id				= $postArray['inv_id'];
			$usertype			= $postArray['usertype'];	
			
			
			if($usertype == "Borrower"){			
				$bor_sql	="UPDATE borrower_banks 
										SET 										
										active_status= 
										CASE 
											WHEN 
												borrower_bankid IN ({$bor_bankid})
												AND borrower_id IN ({$bor_id	 })
											THEN 1 
											ELSE 0 
											END,
										verified_status= 
										CASE 
											WHEN 
												borrower_bankid IN ({$bor_bankid})
												AND borrower_id IN ({$bor_id	 }) 
											THEN 1 
											ELSE verified_status  
										END";
				
				$result	=	$this->dbExecuteSql($bor_sql);
				
				if($result)
				{
					return 1;
					 
				}						
			}else{			
				$inv_sql	= "UPDATE investor_banks 
									SET 
									active_status= 
									CASE 
										WHEN 
											investor_bankid IN ({$inv_bankid })
											AND investor_id IN ({$inv_id})	 
										THEN 1 
										ELSE 0 
										END,
										verified_status= CASE 
										WHEN
											 investor_bankid IN ({$inv_bankid })
											 AND investor_id IN ({$inv_id})	 
										THEN 1 
										ELSE verified_status  
									END";
					
				$result	=	$this->dbExecuteSql($inv_sql);				
				if($result)
				{
					return 1;
				}
			}		
		}		
	}
	/*****reject button*****/
	public function deleteborrowerinvestorbankrecord($postArray){
		if($postArray)
		{
			$bor_bankid	= $postArray['bor_bankid'];
			$bor_id		= $postArray['bor_id'];
			$inv_bankid	= $postArray['inv_bankid'];
			$inv_id		= $postArray['inv_id'];
			$usertype	= $postArray['usertype'];	
			
			if($usertype == "Borrower"){				
				$where	 = array('borrower_bankid' =>"{$bor_bankid}",
									'borrower_id'  =>"{$bor_id}");				
				$result  =	$this->dbDelete('borrower_banks', $where);					
				if($result){
					return 1;
				}		
			}else{
				$where	= array('investor_bankid' =>"{$inv_bankid}",
									'investor_id' =>"{$inv_id}");				
				$result =	$this->dbDelete('investor_banks', $where);	
				//echo "<pre>",print_r($result),"</pre>"; die;
				if($result){
					return 1;
				}		
			}			
		}
	}
	
}
