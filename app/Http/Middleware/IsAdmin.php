<?php

namespace App\Http\Middleware;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth as Auth;

use Closure;

class IsAdmin
{
    public function handle($request, Closure $next)
    {

        if(Auth::guard('personnel')->check() && Auth::guard('personnel')->user()->admin() == 1){
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
