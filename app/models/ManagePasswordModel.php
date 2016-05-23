<?php 
namespace App\models;
use Hash;
class ManagePasswordModel extends TranWrapper {
	
	public $userId			= "";	
	public $challengeid		= "";
	
	public function getSecretQuestion($email,$passwordtype){
		
		$this->typepassword			=	$passwordtype;	
			
		$userid_sql 				=  	"SELECT user_id
										FROM users 
										WHERE email = '".$email."' ";
									
		$this->userId				=	$this->dbFetchOne($userid_sql);
					
		if ($this->userid < 0) {
				return -1;
		}
			
		$challengeid_sql			= 	"SELECT challenge_id
										FROM user_challenges 
										WHERE user_id = '".$this->userId	."' ";
									
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
	
	public function saveChangedPassword($passwordtype, $userId, $newpass, $confirmpass, $oldPassword,$secretanswer){
			
		if ($passwordtype == "Change Password") {
				return $this->changePassword($userId, $oldPassword,$confirmpass);
		}else{ 
				return $this->forgotPassword($userId,$secretanswer,$confirmpass);
			
		}
	}
	
	public function changePassword($userId, $oldPassword,$confirmpass){
		$retval = $this->checkOldPassword($userId, $oldPassword);
			if ($retval < 0){
				echo "Password not match";
			}
			else{
				$dataArray 	   = array('password'	=> Hash::make($confirmpass));
				$whereArry	   = array("user_id"	=> "{$userId}");
				$result 	   = $this->dbUpdate('users', $dataArray, $whereArry );
										
				if($result < 0){
					return -1;
				}else{
					//echo "change password updated successfully";
					return 1;
				}
				
				
			}
	}
	
	public function checkOldPassword($userId, $oldPassword){
		$oldpassword_sql 			=  	"SELECT password
										FROM users 
										WHERE user_id = '".$userId."' ";
									
		$this->oldpassword			=	$this->dbFetchOne($oldpassword_sql);
		
		if(Hash::check($oldPassword, $this->oldpassword))
		{
			return 1;
		}else{
			return -1;
		}			
	}
	
	public function forgotPassword($userId,$secretanswer,$confirmpass){
		
		$returnquestion		=  $this->checkSecretAnswer($userId,$secretanswer);
		
			if ($returnquestion > 0){
				$dataArray 	   = array('password'	=> Hash::make($confirmpass));
				$whereArry	   = array("user_id"	=> "{$userId}");
				$result 	   = $this->dbUpdate('users', $dataArray, $whereArry );

				if($result < 0){
					return -1;
				}else{
					return 1;
					//echo "forgot password updated successfully";
				}
				
			}else{
				
				echo "wrong answer";
			
			}
	}
		
	public function checkSecretAnswer($userId,$secretanswer){
		$challengeid_sql			= 	"SELECT challenge_id
										FROM user_challenges 
										WHERE user_id = '".$userId."' ";
										
		$this->challengeid			=	$this->dbFetchOne($challengeid_sql);
										
		$answer_sql					=	"SELECT challenge_answer 
										FROM user_challenges 
										WHERE challenge_id = '".$this->challengeid."'
										AND user_id = '".$userId."' ";
									
		$this->answer				=	$this->dbFetchOne($answer_sql);
		echo $this->answer.'dfgdfg'.	$secretanswer.'anser';	
		if($this->answer != $secretanswer)
		{
			return -1;
		}else{
			return 1;
		}
	}
	
	
}

