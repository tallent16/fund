<?php

namespace Bican\Roles\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use BorProfile;
use Illuminate\Http\RedirectResponse;

class VerifyRole
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
		if (array_key_exists('role', $actions)) {
			$role = $actions['role'];
            if (BorProfile::checkRole($role)) {
				return $next($request);
			}
			return new RedirectResponse(url('/'));
		}
		return $next($request);
    }
}
