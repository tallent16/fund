<?php 
namespace App\Http\Controllers;  
use Auth;  
use Request;
use BorProfile;
class CustomAuthController extends MoneyMatchController {
	/**
	 * The Guard implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Guard
	 */
	protected $auth;

	/**
	 * The registrar implementation.
	 *
	 * @var \Illuminate\Contracts\Auth\Registrar
	 */
	protected $registrar;

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct() {
		$this->middleware('guest', ['except' => 'getLogout']);
	}
	
	public function getLogin() { 
	
		return view('login'); //or just use the default login page  
	}  
  
    public function postLogin(Request $request)	{  
	
		
        $email = Request::input('email');  
        $password = Request::input('password');  
                
        if(!isset($email)) {
			$email="";
		}
        if(!isset($password)) {
			$password="";
		}
              
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 2,'email_verified' => 1 ])) {  
            //echo "success";  
            $userType			=	Auth::user()->usertype;
           
            /*If the user is borrower then check the status,
             *Status is deleted or reject not allow logout and thrown error
             */ 
             if($userType	==	USER_TYPE_BORROWER) {
				$profileStatus	=	BorProfile::checkProfileStatus();
				if( ($profileStatus	==	BORROWER_STATUS_DELETED)
					|| ( $profileStatus	==	BORROWER_STATUS_REJECTED ) ) {
					Auth::logout();
					return redirect($this->loginPath())
							->withErrors(['email' => "You cannot access the account"]);
				}
			}
			
			return redirect()->intended($this->redirectPath());
        }else {  
		
            return redirect($this->loginPath())
					->withErrors(['email' => $this->getFailedLoginMessage(),]);
        }  
    }
     
	/**
	 * Get the failed login message.
	 *
	 * @return string
	 */
	protected function getFailedLoginMessage() {
		return 'These credentials do not match our records.';
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()	{
		
		Auth::logout();
		return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath() {
		
		if (property_exists($this, 'redirectPath')) {
			return $this->redirectPath;
		}
		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/customRedirectPath';
	}

	/**
	 * Get the path to the login route.
	 *
	 * @return string
	 */
	public function loginPath() {
		return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
	}  
}
