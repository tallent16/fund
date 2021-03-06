<?php 
namespace App\Http\Controllers;  
use Auth;  
use Request;
use Session;
class RegistrationController extends MoneyMatchController {

   public function __construct() {
		$this->middleware('guest', ['except' => 'getLogout']);
		$this->init();
		
	}

	public function littleMoreInit() {

	}
	//render the Registration page
	public function indexAction() {
		$this->user->getModuleSystemMessages();
		return view('register')->with(array("regMod"=>$this->user));
	}
	
	//render the Verification page
	public function verificationAction() {
		
		if(Session::get("register_user_type")	==	USER_TYPE_BORROWER)
			$verifiedMsg	=	$this->user->getSystemMessageBySlug("borrower_register_success");
		else
			$verifiedMsg	=	$this->user->getSystemMessageBySlug("investor_register_success");
		Session::forget("register_user_type");
		return redirect('auth/login')->with("verified",$verifiedMsg);
	}
	
	//checks the email address exists or not
	public function checkEmailavailability(Request $request) {
		
		$emailAddress	=	Request::input('EmailAddress');
	
		//~ echo $this->user->CheckUserEmail($emailAddress);
		if($this->user->CheckUserEmail($emailAddress))
			echo "false" ;
		else
			echo "true";
	}
	//checks the username exists or not
	public function CheckUserNameavailability(Request $request) {
		
		$username	=	Request::input('username');
	
		if($this->user->CheckUserName($username))
			echo "false" ;
		else
			echo "true";
	}
	
	//call submit action triggered
	public function submitAction(Request $request) {
		
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->user->processRegstration($postArray);
			
			if($result){
				switch($postArray['Userrole']){
					case 'Borrower':
						Session::put("register_user_type",USER_TYPE_BORROWER);
						break;
					case 'Investor':
						Session::put("register_user_type",USER_TYPE_INVESTOR);
						break;
				}
				return redirect('verification');	
			}else{
				$errMsg	=	$this->user->getSystemMessageBySlug("register_error");
				return redirect('register')->with("error",$errMsg);
			}
		}
	}
	
	//checks the activation status
	public function activationAction($activation) {
		
		if(!empty($activation) && isset($activation)) {
			$code	=	$activation;
			$result	=	$this->user->checkActivationCode($code);

			if($result) {
				$resultActivated	=	$this->user->checkCodeStatus($code);
				
				if($resultActivated) {
					$this->user->updateCodeStatus($code);
					$activationMsg	=	$this->user->getSystemMessageBySlug("register_activation_verified");
					return redirect('auth/login')->with("activation",$activationMsg);					
				}
				else{
					$this->user->updateCodeStatus($code);
					$activationMsg	=	$this->user->getSystemMessageBySlug("register_already_activated");
					return redirect('auth/login')->with("activation",$activationMsg);					
				}

			}
		}		
		return redirect('auth/login'); 
	}
}
