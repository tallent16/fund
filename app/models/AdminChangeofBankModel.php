<?php namespace App\models;
class AdminChangeofBankModel extends TranWrapper {
	
	public 	$bank_lists = array();
	/****List the borrower/investor bank Entries***/
	public function getborrowerinvestorbanks(){
		
		$boin_sql = "SELECT 
							borrower_banks.borrower_id,
							borrower_banks.borrower_bankid,
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
			}
			
		}else{
			$editinfosql	= "SELECT  investor_banks.investor_id,
									   investor_banks.investor_bankid,
									   investor_banks.bank_name,
									   investor_banks.bank_code,
									   investor_banks.branch_code,
									   investor_banks.bank_account_number,
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
			}
		}		
	}
	public function updateborrowerinvestorbankapprove($postArray){
		if($postArray)
		{
			$bor_bankid	= $postArray['bor_bankid'];
			$bor_id		= $postArray['bor_id'];
			$inv_bankid	= $postArray['inv_id'];
			$inv_id		= $postArray['inv_bankid'];
			$usertype	= $postArray['usertype'];	
			
			if($usertype == "Borrower"){
				//~ echo "<pre>",print_r($usertype),"</pre>";
			$borupdatesql	="UPDATE borrower_banks 
									SET active_status= CASE 
										WHEN 
											borrower_bankid in {$bor_bankid}
											AND borrower_id IN {$bor_id	 }
										THEN 1 
										ELSE 0 
										END,
										verified_status= CASE 
										WHEN 
											borrower_bankid in {$bor_bankid}
											AND borrower_id IN {$bor_id	 } 
										THEN 1 
										ELSE verified_status  
										END";
			}else{
			$invupdatesql	= "UPDATE investor_banks 
								SET active_status= CASE 
									WHEN 
										investor_bankid in {$inv_bankid }
										AND investor_id IN {$inv_id}	 
									THEN 1 
									ELSE 0 
									END,
									verified_status= CASE 
									WHEN
										 investor_bankid in {$inv_bankid }
										 AND investor_id IN {$inv_id}	 
									THEN 1 
									ELSE verified_status  
									END";
			}		
		}		
	}
}
