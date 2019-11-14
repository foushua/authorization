<?php

namespace Foushua\Authorization\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Foushua\Authorization\Exceptions\UnauthorizedException;

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
        if (Auth::guest()) throw UnauthorizedException::notLoggedIn();
        if (!$request->user()->level() >= $level) throw UnauthorizedException::forLevel();

        return $next($request);
    }

}
