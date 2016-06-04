<?php namespace App\models;
class AdminChallengeQuestionsModel extends TranWrapper {
	
	public $securityque_list	= array();
	
	public function getSecurityQuestions(){
		
		$security_sql			= "SELECT challenge_id,challenge_text 
									FROM challenge_questions";
							
		$result					=  $this->dbFetchAll($security_sql);
		
		$this->securityque_list = $result;		
	}	
	
	public function updateSecurityQuestions($postArray) {
		print_r($postArray);
		if (isset($postArray["question"])) {
			$newRows = $postArray["question"];
			$numRows = count($newRows['question_list']);
		}else {
			$newRows = array();
			$numRows = 0;
		}
	
		$rowIndex = 0;
		$questionIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {			
			
			$id					= $newRows['id'][$rowIndex];
			if ($id > 0) {
				$questionIds[] = $id;
				$update = true;
			} else {
				$update = false;
			}
						
		}
		$slno						= $rowIndex+1;
		$questions					= $newRows['question_list'][$rowIndex];
					
		// Construct the data array
		$dataArray = array(								
						'slno'						=> $slno,
						'question'     				=> $questions);
							
		/*update/insert*/						
		if ($update) {
			$whereArray	=	[ "codelist_code"	=> $id,
							  "codelist_id"		=> 32,
							];
			$this->dbUpdate('codelist_details', $dataArray, $whereArray);
		} else {
			$id	 =  $this->dbInsert('codelist_details', $dataArray, true);
			$questionIds[]	=	$id;
		}
		
		/*Check before delete*/	
		$idArray = array();		
		
		$idArray	=	"SELECT user_id from user_challenges";
		
		$whereId	=	implode(",", $idArray);
		
		$sql		=	"SELECT COUNT(*) 
						FROM	user_challenges
						WHERE	challenge_id in ({$whereId}) ";						 
		$count		=	$this->dbFetchOne($sql);
		
		if ($count > 0) {
			$this->errorText	=	"Challenge question marked for deletion is already in use. Cannot delete";
			return -1;
		}else {
				
		/** Questions will be deleted**/		
		$where	=	[ "codelist_code"	=> $id,
						"whereNotIn" =>	["column" => 'codelist_code',
										 "valArr" => $questionIds]];
		
		$this->dbDelete('codelist_details', $where);
		return 1;		
		}
	}
}
