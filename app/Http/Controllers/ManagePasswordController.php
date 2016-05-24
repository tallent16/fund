<?php 
namespace App\Http\Controllers;  
use	\App\models\ManagePasswordModel;
use Request;
use Session;
class ManagePasswordController extends MoneyMatchController {
	
	public function __construct() {			
		$this->init();
	}
	
	//Additional initiate model
	public function littleMoreInit() {
		$this->managePasswordModel	=	new ManagePasswordModel;
	}
	
	public function resetPasswordAction() { 
		return view('resetpassword');			
	}  
	
	//checks the email address exists or not
	public function checkEmailavailable(Request $request) {
		
		$emailAddress	=	Request::input('EmailAddress');
		
		if($this->user->CheckUserEmail($emailAddress))
			echo "true" ;
		else
			echo "false"; 
	}
	
	public function forgotPasswordAction() { 
	    $email_id 		 = "";	
	    $passwordtype 	 = "";
	    if(isset($_REQUEST['EmailAddress'])) {
			$email_id		 = $_REQUEST['EmailAddress'];	
			$passwordtype	 = $_REQUEST['passwordtype'];
		}else{
			$email_id		 = session()->get('sess_email');	
			$passwordtype	 = session()->get('sess_type');	
			if(	$email_id== ""){
				return redirect()->route("reset");
			}
				Session::forget('sess_email');
				Session::forget('sess_type');
		}
		
		
		$secretQuestion  = $this->managePasswordModel->getSecretQuestion($email_id,$passwordtype);
				
		$withArry		=	array("modelresetpass"=>$this->managePasswordModel);
		
		return view('forgotpassword')
					->with($withArry);
		
	}
	public function submitChangePasswordAction() { 

		$postArray			=	Request::all();				
		$userId				= 	$postArray['userid'];
		$passwordtype	 	= 	$postArray['passwordtype'];
		$newpass			= 	$postArray['password'];
		$confirmpass		= 	$postArray['ConfirmPassword'];		
		$oldPassword		=	$postArray['oldpassword'];		
		$result				=	$this->managePasswordModel->saveChangedPassword($passwordtype, $userId, $newpass, $confirmpass, $oldPassword,'');
		if($result != 1 )	{			
				session()->put('sess_email',$postArray['EmailAddress']);
				session()->put('sess_type',$postArray['passwordtype']);
				return redirect()->route("get.change")->with("failure","You have entered, Wrong! Old Password");
		}
		else{				
				session()->put('submit', 'New Password changed Successfully');
				return redirect('/auth/login');
		}		
	}
	
	public function submitForgotPasswordAction() { 
		
		$postArray			=	Request::all();				
		$userId				= 	$postArray['userid'];
		$passwordtype	 	= 	$postArray['passwordtype'];
		$newpass			= 	$postArray['password'];
		$confirmpass		= 	$postArray['ConfirmPassword'];		
		$secretanswer		=	$postArray['secretanswer'];	
		$result				=	$this->managePasswordModel->saveChangedPassword($passwordtype, $userId, $newpass, $confirmpass, '',$secretanswer);
		if($result != 1 )	{			
			session()->put('sess_email',$postArray['EmailAddress']);
			session()->put('sess_type',$postArray['passwordtype']);
			return redirect()->route("get.forgot")->with("failure","You have entered, Wrong! Security Answer");
		}
		else{				
			session()->put('submit', 'New Password Changed Successfully');
			return redirect('/auth/login');
		}		
	}
	
	
}
