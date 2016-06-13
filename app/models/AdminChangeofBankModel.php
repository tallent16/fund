<?php namespace App\models;
class AdminChangeofBankModel extends TranWrapper {
	
	public $bank_lists = array();
	public	$inv_or_borr_id;
	public	$typePrefix;
	public	$userType;
	
	public function __construct($attributes = array()){	
		
		// This will be called only from the borrower / Investors' model so this will be investor or borrower
		$this->userType 		= 	$this->getUserType();
		$this->inv_or_borr_id	=	($this->userType == 1)? $this->getCurrentBorrowerID(): 
															$this->getCurrentInvestorID();
		$this->typePrefix		=	($this->userType == 1)? "borrower":
															"investor";															
		//echo	$this->typePrefix		;											
	}
		
	public function getborrowerinvestorbanks(){
		
		$boin_sql = "SELECT 
							borrower_bankid,
								(SELECT users.usertype as type
								FROM borrower_banks
								INNER JOIN borrowers
									ON borrower_banks.borrower_id = borrowers.borrower_id
								INNER JOIN users 
									ON borrowers.user_id = users.user_id ),
							borrower_id,
							bank_code,
							bank_name,
							branch_code	,
							bank_account_number
						FROM borrower_banks
					UNION ALL
						SELECT 
							investor_bankid,	
								(SELECT users.usertype as type
								FROM investor_banks
								INNER JOIN investors
									ON investor_banks.investor_id = investors.investor_id
								INNER JOIN users 
									ON investors.user_id = users.user_id),
							investor_id,
							bank_code,
							bank_name,
							branch_code,
							bank_account_number
						FROM investor_banks";
			
		$res = 	$this->dbFetchAll($boin_sql);
		$this->bank_lists = $res;
		
	}
}
