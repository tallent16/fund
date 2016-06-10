<?php namespace App\models;
class AdminChangeofBankModel extends TranWrapper {
	public $bank_lists = array();
	public function getborrowerinvestorbanks(){
		$boin_sql = "SELECT *
						FROM borrower_banks
					UNION ALL
						SELECT *
						FROM investor_banks";
			
		$res = 	$this->dbFetchAll($boin_sql);
		$this->bank_lists = $res;
		
	}
}
