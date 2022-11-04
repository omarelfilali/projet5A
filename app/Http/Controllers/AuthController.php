<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Etudiant;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\DB;

use Adldap\Laravel\Facades\Adldap;

class AuthController extends Controller
{
	public function auth(){
		if (Auth::check()) {
			$user = Auth::user();
			return view('index')->with('user', $user);
		}else{
			return view('login');
		}
	}

	public function loginENSIM(Request $request){

		$utilisateur = Utilisateur::where("id", $request->id)->first();
		

		if($utilisateur->role == 1 || $utilisateur->role == 2 || $utilisateur->role == 4) { // Etudiants / Alumnis / Candidats
						
			$pass = substr(md5(strrev($request->password).'zJ7'),0,10);

		}elseif($utilisateur->role == 3 || $utilisateur->role == 5){ // Personnel ou Extérieur
			
			$pass = substr(md5($request->password.$request->password),0,15);
		
		}else{
			$pass = $request->password;
		}

		Auth::attempt([
			'id' => $request->id, 
			'password' => $pass,
			'cas' => function ($query) {
				$query->where('cas', '!=', '1');
		   }]);

		return redirect('/');
	}

    public function loginCAS() {
		// cas -> Central Authentication Service : système d'authentification de l'université
		cas()->authenticate();

		if (cas()->user() == NULL){
			abort(403, 'Authentification échouée');
		}
		else {
			// $personnel = Personnel::where("uid", cas()->user())->first();
			// $etudiant = Etudiant::where("login", cas()->user())->first();

			$utilisateur = Utilisateur::where("id", cas()->user())->first();

			// Initialisation des permissions

			// Récupération des infos utilisateurs depuis LDAP
			$infos_ldap = Adldap::search()->where('uid', '=', "$utilisateur->id")->first();
			
			if($infos_ldap['umAffectationEnCours']==TRUE){
				if ($utilisateur != null){
					Auth::guard('utilisateur')->loginUsingId($utilisateur->id);
				}
			}
			else {
				cas()->logout();
				abort(403, 'Accès refusé');
			}
		}
        return redirect('/');
    }

	public function logout(Request $request) {
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		cas()->logout();
	}
}
