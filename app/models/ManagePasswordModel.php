<?php 
namespace App\models;
use Hash;
use Session;
class ManagePasswordModel extends TranWrapper {
	
	public $userId			= "";	
	public $challengeid		= "";
	public $successTxt		= "";
	
	public function getSecretQuestion($email,$passwordtype){
		
		$this->email				=	$email;	
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
				return $this->changePassword($userId, $oldPassword,$confirmpass,$passwordtype);
		}else{ 				
				return $this->forgotPassword($userId,$secretanswer,$confirmpass,$passwordtype);
			
		}
	}
	
	public function changePassword($userId, $oldPassword,$confirmpass,$passwordtype){
		$retval = $this->checkOldPassword($userId, $oldPassword);
			if ($retval < 0){				
				/****Mail Functionality************/
				$this->sendMailToAdmin($userId,$passwordtype);
				/****Mail Functionality************/
			}
			else{
				$dataArray 	   = array('password'	=> Hash::make($confirmpass));
				$whereArry	   = array("user_id"	=> "{$userId}");
				$result 	   = $this->dbUpdate('users', $dataArray, $whereArry );
										
				if($result < 0){
					return -1;
				}else{				
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
	
	public function forgotPassword($userId,$secretanswer,$confirmpass,$passwordtype){
		
		$returnquestion		   =  $this->checkSecretAnswer($userId,$secretanswer);
		
			if ($returnquestion > 0){
				$dataArray 	   = array('password'	=> Hash::make($confirmpass));
				$whereArry	   = array("user_id"	=> "{$userId}");
				$result 	   = $this->dbUpdate('users', $dataArray, $whereArry );

				if($result < 0){
					return -1;
				}else{
					return 1;
				}
				
			}else{
				/****Mail Functionality************/
				$this->sendMailToAdmin($userId,$passwordtype);
				/****Mail Functionality************/						
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
			
		if($this->answer != $secretanswer)
		{	
			return -1;
			
		}else{
			return 1;
		}
	}
	
	public function sendMailToAdmin($userId,$passwordtype){
		
		$username_sql		= "SELECT username 
									   FROM users 
									   WHERE user_id = '".$userId."' ";
									   
		$this->username		=	$this->dbFetchOne($username_sql);
		
		$sql				=	"SELECT usertype 
									FROM	users
									WHERE	user_id = {$userId}";
			
		$checkuser_type		=	$this->dbFetchOne($sql);	
		
		$sql				=	"SELECT email 
									FROM	users
									WHERE	user_id = {$userId}";
			
		$useremail			=	$this->dbFetchOne($sql);	
		
		if($checkuser_type == 1){
			if($passwordtype == "Change Password"){
				$slug	="password_wrong_borrower";
				$this->successTxt	=	$this->getSystemMessageBySlug($slug);
			}else{
				$slug 	="answer_wrong_borrower";
				$this->successTxt	=	$this->getSystemMessageBySlug($slug);
			}
		}else{			
			if($passwordtype == "Change Password"){
				$slug	= "password_wrong_investor";
				$this->successTxt	=	$this->getSystemMessageBySlug($slug);
			}else{
				$slug	= "answer_wrong_investor";
				$this->successTxt	=	$this->getSystemMessageBySlug($slug);
			}		
		}
		
		$moneymatchSettings = $this->getMailSettingsDetail();
		$fields 			= array('[username]','[application_name]');
		$replace_array 		= array();				
		$replace_array 		= array( $this->username, $moneymatchSettings[0]->application_name);

		$count = 0;
		$count = session::set('crud_count', session::get('crud_count', 0) + 1);
		if(session::get('crud_count') >= 3){						
			$this->sendMailByModule($slug,$useremail,$fields,$replace_array);			
		}	
	}	
}
