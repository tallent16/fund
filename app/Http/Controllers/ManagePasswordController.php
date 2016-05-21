<?php 
namespace App\Http\Controllers;  
use	\App\models\ManagePasswordModel;
use Request;
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
		
		$secretQuestion  = $this->managePasswordModel->getSecretQuestion($email_id,$passwordtype);
		
		if($secretQuestion < 0){
			echo 'No Secret Question';
			return -1;
		}
		$withArry		=	array("modelresetpass"=>$this->managePasswordModel);
		
		return view('forgotpassword')
					->with($withArry);
		
	}
	public function submitPasswordAction() { 
		$submitted		=	false;
			if (Request::isMethod('post')) {
				$postArray			=	Request::all();
				//echo '<pre>',print_r($postArray),'</pre>';
				$userId				= 	$postArray['userid'];
				$passwordtype	 	= 	$postArray['passwordtype'];
				$newpass			= 	$postArray['password'];
				$confirmpass		= 	$postArray['confirmpassword'];		
				$secretanswer		=	$postArray['secretanswer'];		
				$oldPassword		=	$postArray['oldpassword'];		
				$result				=	$this->managePasswordModel->saveChangedPassword($passwordtype, $userId, $newpass, $confirmpass, $oldPassword,$secretanswer);
				$submitted			=	true;
			}		
		if($submitted ==	true)	{
			//echo "submitted";
			return redirect('auth/login');
		}
	}
}
