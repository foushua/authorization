<?php

namespace Foushua\Authorization\Middlewares;

use Closure;
use Foushua\Authorization\Exceptions\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        if (! $request->user()->hasRole($role)) {
            throw UnauthorizedException::forRoles();
        }

        return $next($request);
    }
}
