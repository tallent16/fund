<?php 
namespace App\models;
use Hash;
use Session;
class ManagePasswordModel extends TranWrapper {
	
	public $userId			= "";	
	public $challengeid		= "";
	
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

		$username_sql				= "SELECT username 
									   FROM users 
									   WHERE user_id = '".$userId."' ";
									   
		$this->username				=	$this->dbFetchOne($username_sql);
		
		$sql				=	"SELECT usertype 
									FROM	users
									WHERE	user_id = {$userId}";
			
		$checkuser_type		=	$this->dbFetchOne($sql);		
		
		if($checkuser_type == 1){
			if($passwordtype == "Change Password"){
				$slug	="password_wrong_borrower";
			}else{
				$slug 	="answer_wrong_borrower";
			}
		}else{			
			if($passwordtype == "Change Password"){
				$slug	= "password_wrong_investor";
			}else{
				$slug	= "answer_wrong_investor";
			}		
		}
		
		
		//$mailContents		= 	$moneymatchSettings[0]->change_password_mail_alert;
	
		//$mailContents		= 	"Dear Admin, <br>[username] have entered 3 times wrong passwords<br> sincerely,					[application_name]";
		$moneymatchSettings = $this->getMailSettingsDetail();
		
		//$mailContents		= 	$mailcontent;
		
		//$mailSubject		= 	"Warning - Unsuccessful attempts to access account";
		$fields 			= array('[username]','[application_name]');
		$replace_array 		= array();
		
		$replace_array 		= 	array( $this->username, $moneymatchSettings[0]->application_name);
							
		$new_content 		= 	str_replace($fields, $replace_array, $mailContents);
		
		
		//$template			=	"emails.wrongPasswordAttemptTemplate";

		$count = 0;
		$count = session::set('crud_count', session::get('crud_count', 0) + 1);
		if(session::get('crud_count') >= 3){
			
		/*	$msgarray 	=	array(	"content" => $new_content);			
			$msgData 	= 	array(	"subject" => $moneymatchSettings[0]->application_name." - ".$mailSubject, 
							"from" => $moneymatchSettings[0]->mail_default_from,
							"from_name" => $moneymatchSettings[0]->application_name,
							"to" => $moneymatchSettings[0]->admin_email,
							"cc" => $moneymatchSettings[0]->admin_email,
							"live_mail" => $moneymatchSettings[0]->send_live_mails,
							"template"=>$template);
	
			$mailArry	=	array(	"msgarray"=>$msgarray,
									"msgData"=>$msgData);
			$this->sendMail($mailArry);*/
			$this->sendMailByModule($slug,$borrUserInfo->email,$fields,$replace_array);
			
		}	
	}	
}
