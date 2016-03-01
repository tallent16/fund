<?php 
namespace App\Http\Middleware;

use Closure;

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
		
        return $next($request);
    }

}
