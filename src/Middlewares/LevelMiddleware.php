<?php

namespace Foushua\Authorization\Middlewares;

use Closure;
use Foushua\Authorization\Exceptions\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param int $level
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $level)
    {
        if (Auth::guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        if (! $request->user()->level() >= $level) {
            throw UnauthorizedException::forLevel();
        }

        return $next($request);
    }
}
