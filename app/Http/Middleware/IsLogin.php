<?php

namespace App\Http\Middleware;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Support\Facades\Auth;


use Closure;


class IsLogin
{
    public function handle($request, Closure $next)
    {

		if(Auth::guard('utilisateur')->check()){
            return $next($request);
        }

		// if (!cas()->authenticate()){
		// 	return redirect()->route('login');
		// }

        // if(Auth::guard('personnel')->check()){
		// 	if (Auth::guard('personnel')->user()->uid != cas()->user()){
		// 		return redirect()->route('login');
		// 	}
        //     return $next($request);
        // }

        // if(Auth::guard('etudiant')->check()){
		// 	if (Auth::guard('etudiant')->user()->uid != cas()->user()){
		// 		return redirect()->route('login');
		// 	}
        //     return $next($request);
		// }

		else {
			return redirect()->route('auth');
		}
	}
}
