<?php namespace App\Http\Middleware;

use Closure;
use BorProfile;
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
		if($profileStatus	==	0	||	$profileStatus	==BORROWER_STATUS_NEW_PROFILE
									||	$profileStatus	==BORROWER_STATUS_SUBMITTED_FOR_APPROVAL
									||	$profileStatus	==BORROWER_STATUS_COMMENTS_ON_ADMIN) {
			if($request->url()	!=	url('borrower/profile')) {
				return redirect()->to('borrower/profile');
			}
		}
		if($LoanAllowingStatus	==	0	) {
			if($request->url()	==	url('borrower/applyloan')) {
				return redirect()->to('borrower/profile');
			}
		}
		
        return $next($request);
    }

}
