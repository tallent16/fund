<?php namespace App\Http\Middleware;

use Closure;
use session;
use App;
use Config;

class Language {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(Session::has('locale')){
         $locale = Session::get('locale',config::get('app.locale'));

		}else{
         $locale = 'en';


		}
		App::setLocale($locale);
		return $next($request);
	}

}