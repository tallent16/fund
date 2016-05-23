<?php namespace App\Http\Middleware;

use Closure;
use AdminAccess;
use Auth;
class AdminMiddleware {

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

        if ($request->user()->usertype != 3) {
            abort(403);
        }
		$rolesCnt	=	AdminAccess::checkUserRoles();
		if( $rolesCnt	==	0 ) {
			Auth::logout();
			return redirect("auth/login")
					->withErrors(['email' => "You have no roles to access"]);
		}
		
        return $next($request);
    }

}
