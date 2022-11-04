<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\FicheInternationale;
use App\Models\Entreprise;

class InternationalController extends Controller
{
    public function index(){
		  return view('public.international.index');
      // Si étudiant, alors on redirige vers sa propre fiche internationale

      // Sinon, si personnel on redirige vers le module International de l'administration
    }

    public function show($id)
    {
      $etudiant = Etudiant::where("login", $id)->first();
        if ($etudiant){
          $entreprises = Entreprise::where("del", 0)->get();
          $etudiant = Etudiant::where("login", $id)->first();
          return view('public.international.fiche', compact('etudiant','entreprises'));

        }else{
          dd("vegedream");
        }
    }

    public function create_fiche(Request $request){
      dd(cas()->user());
      dd($request);
    }
}
