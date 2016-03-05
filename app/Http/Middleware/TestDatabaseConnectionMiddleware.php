<?php namespace App\Http\Middleware;

use Closure;
use DB;
use Log;
class TestDatabaseConnectionMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		try{
			if(DB::connection()->getDatabaseName()) {
				return $next($request);
			}
		}catch(\PDOException $e){
			Log::error($e->getMessage());
			abort(401);
		}
	}

}
