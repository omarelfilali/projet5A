<?php

namespace App\Http\Middleware;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth as Auth;

use Closure;


class IsPersonnel
{
    public function handle($request, Closure $next)
    {
		if (!cas()->authenticate()){
			return redirect()->route('login');
		}

        if(Auth::guard('personnel')->check()){
			if (Auth::guard('personnel')->user()->uid != cas()->user()){
				return redirect()->route('login');
			}
            return $next($request);
        }

        if(Auth::guard('etudiant')->check()){
			abort(403, 'Action non autorisée');
		}
		else {
			return redirect()->route('login');
		}
    }
}
