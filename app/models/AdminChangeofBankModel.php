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
						AND 	investors.user_id = users.user_id ";
			
		$res = 	$this->dbFetchAll($boin_sql);
		$this->bank_lists = $res;
		
	}
	/****Edit Approve Screen***/
	public function getborrowerinvestorbankinfo($usertype,$borinv_id,$borinvbankid){
		
		if($usertype == "Borrower"){
			$editinfosql	= "SELECT  borrower_banks.bank_name,
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
			}
			
		}else{
			$editinfosql	= "SELECT  investor_banks.bank_name,
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
			}
		}		
	}
}
//~ echo "<pre>",print_r($usertype),"</pre>";
