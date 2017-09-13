<?php 
namespace App\Http\Controllers;  
use Auth;  
use Request;
use BorProfile;
use InvBal;
use AdminAccess;
use Session;
use DB;
use Lang;
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
              
        if (Auth::attempt(['email' => $email, 'password' => $password, 'status' => 2,'email_verified' => 1 ])
			|| Auth::attempt(['username' => $email, 'password' => $password, 'status' => 2,'email_verified' => 1 ]) ) {  
        
            $userType			=	Auth::user()->usertype;
              $id = Auth::id(); 
         
            /*If the user is borrower then check the status,
             *Status is deleted or reject not allow logout and thrown error
             */ 
             if($userType	==	USER_TYPE_ADMIN) {
				$rolesCnt	=	AdminAccess::checkUserRoles();
				if( $rolesCnt	==	0 ) {
					Auth::logout();
					return redirect($this->loginPath())
							->withErrors(['email' => "You have no roles to access"]);
				}
			}
			
             if($userType	==	USER_TYPE_BORROWER){

				
				$profileStatus	=	BorProfile::checkProfileStatus();
				//echo $profileStatus;die;
				$welcomeMessage	=	BorProfile::getWelcomeMessage();

				if( ($profileStatus	==	BORROWER_STATUS_DELETED)
					|| ( $profileStatus	==	BORROWER_STATUS_REJECTED ) ) {
					Auth::logout();
					return redirect($this->loginPath())
							->withErrors(['email' => "You cannot access the account"]);
				}
				if(Auth::user()->show_welcome_popup	==	1) {
					Session::put("show_welcome_popup","yes");
					Session::put("welcome_message",$welcomeMessage);
				}
				if(Auth::user()->login_status == 1) {
					if($profileStatus == 0){
              			return redirect('creator/profile');
					}
				} else {
					DB::table('users')->where('user_id',$id)->update(['login_status' => '1']);
					return redirect('page/help_page');
				}
			}
             if($userType	==	USER_TYPE_INVESTOR) {
       
             	$eth =  DB::table('investors')->select('eth')->where('user_id',$id)->first();
            /* print_r($eth);die;*/
             	if($eth){
             	Session::put("eth",$eth->eth);
                     }
				$profileStatus	=	InvBal::checkProfileStatus();
				$welcomeMessage	=	InvBal::getWelcomeMessage();
				if( ($profileStatus	==	INVESTOR_STATUS_DELETED)
					|| ( $profileStatus	==	INVESTOR_STATUS_REJECTED ) ) {
					Auth::logout();
					return redirect($this->loginPath())
							->withErrors(['email' => "You cannot access the account"]);
				}
				if(Auth::user()->show_welcome_popup	==	1) {
					Session::put("show_welcome_popup","yes");
					Session::put("welcome_message",$welcomeMessage);
					
				}
				if(Auth::user()->login_status == 0) {
					DB::table('users')->where('user_id',$id)->update(['login_status' => '1']);
					return redirect('page/help_page');
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
		$error_message = Lang::get('login.error_message');
		return $error_message;
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogout()	{
		
		Auth::logout();
		$this->sessionDestroy();
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
