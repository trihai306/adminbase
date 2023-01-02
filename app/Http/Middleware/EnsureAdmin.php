<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if ($request->user() && !$request->user()->is_admin) {
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
