<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Projet;
use App\Models\ProjetEncadrant;
use App\Models\Personnel;

class ProjetController extends Controller
{
    public function index(){
    $enattente = Projet::where("etat", "=", "attente")->get();
		return view('public.projets.relindus', ['projets'=>$enattente]);
    }

    public function voeux(){
      return view('public/projets/choix_proj');
    }

    public function projets_etu($id){
      
      $projetsEtudiant = Etudiant::with('projets')->where('login', $id)->first();
      
      return view('public/projets/affiche_proj', compact('projetsEtudiant'));
    }

    public function infos_proj($id){

      $projet = Projet::with("encadrants")->findOrFail($id);
      
      return view('public/projets/informations-proj', ['projet' => $projet]); //, 'encadrants' => $personnelsEncadrants
    }
}
