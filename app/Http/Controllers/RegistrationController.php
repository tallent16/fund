<?php 
namespace App\Http\Controllers;  
use Auth;  
use Request;

class RegistrationController extends MoneyMatchController {

   public function __construct() {
		$this->middleware('guest', ['except' => 'getLogout']);
		$this->init();
	}

	public function littleMoreInit() {

	}
	//render the Registration page
	public function indexAction() {
		return view('register');
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
				return redirect('verification');	
			}else{
				return redirect('register')->with("error","Error while Registering the information ");
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
					$msg="Your account is activated please login : <a href='".url()."/auth/login' >Click</a>"; 
				}
				else
				{
					$msg ="Your account is already active, no need to activate again";
					$msg =$msg." please login : <a href='".url()."/auth/login' >Click</a>";
				}

			}else{
				$msg ="Wrong activation code.";
			}
		}
		echo "<center><h3>".$msg."</h3></center>";
	}
}
