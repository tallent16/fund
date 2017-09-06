<?php namespace App\Http\Middleware;

use Closure;
use BorProfile;
use Session;
class BorrowerMiddleWare {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
       
        if ($request->user() == null) {
            return redirect('auth/login');
        }
        if ($request->user()->usertype != 1) {
           abort(403);
        }
		$profileStatus	=	BorProfile::checkProfileStatus();
		$LoanAllowingStatus	=	BorProfile::getBorrowerLoanAllowingStatus();
		if($profileStatus	==	BORROWER_STATUS_COMMENTS_ON_ADMIN){
			if (!$request->session()->has('notification_seen')) {
				$request->session()->put('notification','Creator Profile Correction Reqiured');
			}
		}
		if($profileStatus	==	0	||	$profileStatus	==BORROWER_STATUS_NEW_PROFILE
									||	$profileStatus	==BORROWER_STATUS_SUBMITTED_FOR_APPROVAL
									||	$profileStatus	==BORROWER_STATUS_COMMENTS_ON_ADMIN) {
			if($request->url()	!=	url('creator/profile')) {
				return redirect()->to('creator/profile');
			}
		}
		if($LoanAllowingStatus	==	0	) {
			if($request->url()	==	url('creator/create_project')) {
				return redirect()->to('creator/profile');
			}
		}
		
        return $next($request);
    }

}
