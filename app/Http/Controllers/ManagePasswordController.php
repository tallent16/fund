<?php 
namespace App\Http\Controllers;  
use	\App\models\ManagePasswordModel;

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
	
	public function forgotPasswordAction() { 
	    $email_id 		 = "";	
	    $passwordtype 	 = "";
		$email_id		 = $_REQUEST['EmailAddress'];	
		$passwordtype	 = $_REQUEST['passwordtype'];
		
		$secretQuestion = $this->managePasswordModel->getSecretQuestion($email_id,$passwordtype);
		
		if($secretQuestion < 0){
			echo 'No Secret Question';
			return -1;
		}
		$withArry	=	array("modelresetpass"=>$this->managePasswordModel);	
		return view('forgotpassword')
					->with($withArry);
					
		$submitted	=	false;
		if (Request::isMethod('post')) {
			$postArray			=	Request::all();
			$userId				= 	$postArray['userid'];
			$newpass			= 	$postArray['newpassword'];
			$confirmpass		= 	$postArray['confirmpassword'];
			$secretquestion		=	$postArray['secretquestion'];
			$secretanswer		=	$postArray['secretanswer'];			
			$result				=	$this->managePasswordModel->saveChangedPassword($passwordtype, $userId, $newPassword, $confirmPassword, $oldPassword="",$secretquestion="",$secretanswer="");
			$submitted			=	true;
		}
		
	}
	
}
