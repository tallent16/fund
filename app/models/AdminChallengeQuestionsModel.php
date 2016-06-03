<?php namespace App\models;
class AdminChallengeQuestionsModel extends TranWrapper {
	
	public $securityque_list	= array();
	
	public function getSecurityQuestions(){
		
		$security_sql			= "SELECT codelist_code,codelist_value 
									FROM codelist_details 
									WHERE codelist_id=32 
									ORDER by ABS(codelist_code) ";
							
		$result					=  $this->dbFetchAll($security_sql);
		
		$this->securityque_list = $result;
		
	}
}
