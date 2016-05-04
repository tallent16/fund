<?php 
namespace App\Http\Middleware;

use Closure;
use InvBal;
class InvestorMiddleWare {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
    {
        if ($request->user() == null){
            return redirect('auth/login');
        }

        if ($request->user()->usertype != 2)
        {
            abort(403);
        }
		$profileStatus	=	InvBal::checkProfileStatus();
		if($profileStatus	==	0	||	$profileStatus	==INVESTOR_STATUS_NEW_PROFILE
									||	$profileStatus	==INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL
									||	$profileStatus	==INVESTOR_STATUS_COMMENTS_ON_ADMIN) {
			if($request->url()	!=	url('investor/profile')) {
				return redirect()->to('investor/profile');
			}
		}
		
        return $next($request);
    }

}
