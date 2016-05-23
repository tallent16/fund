<?php

namespace Bican\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use BorProfile;
use Illuminate\Http\RedirectResponse;

class VerifyPermission
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param int|string $permission
     * @return mixed
     * @throws \Bican\Roles\Exceptions\PermissionDeniedException
     */
    public function handle($request, Closure $next)
    {
		$route = $request->route();
		$actions = $route->getAction();
		if (array_key_exists('permission', $actions)) {
			$permission = $actions['permission'];
			
			if ($this->auth->check() && $this->auth->user()->can($permission)) {
				return $next($request);
			}
			if (array_key_exists('redirect_back', $actions)) {
				return redirect()->route($actions['redirect_back'])
						->with('failure','You do not have permission to '.$actions['action_type']);
			}else{
				return \Redirect::to('/')
								->with('failure','You do not have permission to access');	
			}
		}
		return $next($request);
    }
}
