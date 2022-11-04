<?php

namespace App\Http\Middleware;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth as Auth;

use Closure;

class IsTechnicien
{
    public function handle($request, Closure $next)
    {

        if(Auth::guard('personnel')->check() && Auth::guard('personnel')->user()->isTechnicien()){
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
