<?php namespace App\models;
class AdminChallengeQuestionsModel extends TranWrapper {
	
	public $securityque_list	= array();
	public $listids 			= array();
	
	public function getSecurityQuestions(){
		
		$security_sql			= 	"SELECT slno,challenge_id,
											challenge_text 
									FROM challenge_questions";
							
		$result					=	$this->dbFetchAll($security_sql);
		
		$this->securityque_list = 	$result;		
	}	
	
	public function updateSecurityQuestions($postArray) {
				
		if (isset($postArray["questions"])) {
			$newRows = $postArray["questions"];			
			$numRows = count($newRows['question_list']);
		}else {
			$newRows = array();
			$numRows = 0;
		}
		
		$rowIndex = 0;
		$questionIds  = array();
	
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {			
		
			$id			= $newRows['id'][$rowIndex];
			
			$delete_check = $postArray['delete_check'];
			
			if ($id == 0) {							
				$update = false;		 		
			} else {
				$update = true;				
			}
			$slno		= $rowIndex+1;
			$questions	= $newRows['question_list'][$rowIndex];
			
			// Construct the data array
			$dataArray = array(	'challenge_text' => $questions,
								'slno'	=> $slno );				
				
			/*update/insert*/						
			if ($update) {
				if($delete_check == 0){
						$whereArray	=	[ "challenge_id"	=> $id];
						$this->dbUpdate('challenge_questions', $dataArray, $whereArray);
					}
					$questionIds[]	=	$id;	
				
			} else {
				$id	 =  $this->dbInsert('challenge_questions', $dataArray, true);
				$questionIds[]	=	$id;	
			}			
		}
			
		/*Check before delete*/	
		$idArray_sql	=	"SELECT 
								challenge_id 
								FROM challenge_questions";
		
		$count_id		=	$this->dbFetchAll($idArray_sql);
		
		foreach($count_id as $row){
			$this->listids[]=$row->challenge_id;
		}
		
		$deletedids 		= array_diff($this->listids,$questionIds);
		
		$whereId		=	implode(",", $deletedids);		
	 
		$sql			=	"SELECT COUNT(*) 
								FROM	user_challenges
								WHERE	challenge_id in ({$whereId}) ";	
						
		$count			=	$this->dbFetchOne($sql);	
		
		if ($count > 0) {
			$this->errorText	=	"Challenge question marked for deletion is already in use. Cannot delete";
			return -1;
		}else{	
		/** Questions will be deleted**/		
			$where	=	[ "whereNotIn" 	=>	["column" => 'challenge_id',
											 "valArr" =>$questionIds]];		
			$this->dbDelete('challenge_questions', $where);
		}
		return 1;		
	}	
}
