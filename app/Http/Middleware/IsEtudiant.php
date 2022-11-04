<?php

namespace App\Http\Middleware;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth;


use Closure;


class IsEtudiant
{
    public function handle($request, Closure $next)
    {

        if(Auth::guard('etudiant')->check()){
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
