<?php namespace App\models;
class ManagePasswordModel extends TranWrapper {
	
	public $secretQuestion	= "";
	public $userId			= "";
	public $currentPassword	= "";
	
	public function getSecretQuestion($email,$passwordtype){
		
		$this->typepassword			=	$passwordtype;	
			
		$userid_sql 				=  	"SELECT user_id
										FROM users 
										WHERE email = '".$email."' ";
									
		$this->userid				=	$this->dbFetchOne($userid_sql);
					
		if ($this->userid < 0) {
				return -1;
		}
			
		$challengeid_sql			= 	"SELECT challenge_id
										FROM user_challenges 
										WHERE user_id = '".$this->userid	."' ";
									
		$this->challengeid			=	$this->dbFetchOne($challengeid_sql);
		
		$secretQuestion_sql 		= 	"SELECT codelist_value 
										FROM codelist_details
										WHERE codelist_id = 32
										AND	codelist_code = '".$this->challengeid."' ";
									
		$this->secretquestion		=	$this->dbFetchOne($secretQuestion_sql);
		
		if ($this->secretquestion < 0) {
				return -1;
		}
			
	}
	
	public function saveChangedPassword($passwordtype, $userId, $newPassword, $confirmPassword, $oldPassword="",$secretquestion="",$secretanswer=""){
		
		if ($passwordtype == "ChangePassword") {
		$retval = checkOldPassword($userId, $oldPassword);
			if ($reval < 0){
				return -1;
			}
			else{
				
				$updatesql			=	"UPDATE users 
										SET password = '".$confirmPassword."' 
										WHERE user_id = 	'".$userId."'	";
				
				
			}
		}else{
			$returnquestion		=  checksecretanswer($userId,$secretquestion,$secretanswer);
			if ($reval < 0){
				return -1;
			}
			else{
				
				$updatesql			=	"UPDATE users 
										SET password = '".$confirmPassword."' 
										WHERE user_id = 	'".$userId."'	";
				
				
			}
			
			
		}
		
	
	}
	
	public function checkOldPassword($userId, $oldPassword){
		$oldpassword_sql 			=  	"SELECT password
										FROM users 
										WHERE user_id = '".$userId."' ";
									
		$this->oldpassword			=	$this->dbFetchOne($oldpassword_sql);
		
		if($this->oldpassword == $oldPassword){
			return 1;
		}
		
	}
	
	public function checksecretanswer($userId,$secretquestion,$secretanswer){
		$challengeid_sql			= 	"SELECT challenge_id
										FROM user_challenges 
										WHERE user_id = '".$this->userid	."' ";
		$this->challengeid			=	$this->dbFetchOne($challengeid_sql);
										
		$secretanswer_sql 			=  	"SELECT password
										FROM users 
										WHERE user_id = '".$userId."' ";
	}
}
