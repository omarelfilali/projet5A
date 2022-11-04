<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Models\Etudiant;
use App\Models\FicheInternationale;
use App\Models\InternationalStatut;

class InternationalController extends Controller{

    public function show($id) {
      $etudiant = Etudiant::where("login", $id)->first();
        if ($etudiant){
          $photoEtudiant = $etudiant->getPhotoURLAttribute();

          $infosEtu = Etudiant::select("id","prenom","nom", "nationalite", "promo")->where("login", $id)->first();

          return view('administration.international.fiche', ['photoEtudiant' => $photoEtudiant,'infosEtu' => $infosEtu]);

        }else{
          dd("vegedream");
        }
    }

    public function show_fiche($id) {

      $project = FicheInternationale::findOrFail($id);

      $infosEtu = Etudiant::select("id","login","prenom","nom", "nationalite","photo","promo")->where("id", $project->etudiant)->first();

      $entreprise = Entreprise::where("id", $project->entreprise)->first();

      $statut = InternationalStatut::where("fiche_internationale", $id)->first();

      return view('administration.international.fiche', ['project' => $project, 'infosEtu' => $infosEtu, 'entreprise' => $entreprise, 'statut' => $statut]);

    }

    public function dashboard() {
      
      return view('administration.international.dashboard', []);

    }

    public function sejours() {

      $sejoursInternationaux = FicheInternationale::whereNot('type','dispense')->orderBy('date_maj', 'DESC')->get();

      return view('administration.international.sejours', ['sejoursInternationaux' => $sejoursInternationaux]);

    }

    public function index_dispense() {

      $demandesDispenses = FicheInternationale::join('international_statuts', 'fiche_internationale.id', '=', 'international_statuts.fiche_internationale')->where('type', 'dispense')->orderBy('date_creation', 'DESC');

      $dispensesEnAttente = (clone $demandesDispenses)->where('valeur',"soumis")->get();
      $dispensesAccepte = (clone $demandesDispenses)->where('valeur',"accepte")->get();
      $dispensesRefusee = (clone $demandesDispenses)->where('valeur',"refuse")->where('valeur',"annule")->get();
      
      return view('administration.international.dispenses', ['dispensesEnAttente' => $dispensesEnAttente, 'dispensesAccepte' => $dispensesAccepte, 'dispensesRefusee' => $dispensesRefusee]);

    }
}
