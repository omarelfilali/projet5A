<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Parental\HasParent;

use App\Models\Utilisateur;

class Etudiant extends Utilisateur
{

    /*
    |--------------------------------------------------------------------------
    | Initialisation / Configuration
    |--------------------------------------------------------------------------
    */

    use HasFactory;
    use HasParent;
    protected $guarded = [];

    public static function boot(){
        parent::boot();

        // Lors de la création d'un nouvel utilisateur de type Etudiant
        // On prédéfinit certaines données si certains champs sont insérés vides
        static::creating(function($etudiant){
            $etudiant->id = $etudiant->id ?? parent::generateNewId("etu");
            $etudiant->photo = $etudiant->photo ?? 'trombinoscope/etudiant/default.png';
            $etudiant->cas = 1;
        });
    }

    public function impersonate($utilisateur) {
        //...
    }



    /*
    |--------------------------------------------------------------------------
    | Tables relationnelles
    |--------------------------------------------------------------------------
    */

    public function assurances()
    {
      return $this->hasMany('App\Models\EtudiantAssurance', 'etudiant_uid' , 'id');
    }

    public function demandes()
    {
      return $this->hasMany('App\Models\InventaireEmprunt', 'etudiant_uid' , 'id');
    }

    public function projets()
    {
        return $this->belongsToMany('App\Models\Projet', 'etudiants_x_projets', "etudiant", "projet")->withPivot('annee_scolaire');
    }

    public function projetsInternationaux()
    {
      return $this->hasMany('App\Models\FicheInternationale', 'etudiant' , 'id');
    }



    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getExperienceInternationale(){
        $projets_internationaux = self::projetsInternationaux();

        // Cette requête fait l'addition (sum) des jours compris entre la date_début et la date_fin parmis tous les projets réalisés et validés (terminés).
        $nb_jours = $projets_internationaux->selectRaw('sum(DATEDIFF(date_fin, date_debut)) AS nb_jours')
        ->join('international_statuts', 'fiche_internationale.id', 'international_statuts.fiche_internationale')
        ->where("champ", "realisation_projet")->where("valeur", "valide")->first()->nb_jours;

        if ($nb_jours == null) {
            $nb_jours = 0;
        }

        return $nb_jours;
    }

    public function getPhotoURLAttribute(){
        if (strlen($this->photo) == 0){
            return asset('photos/empty.png');
        }
        else {
            return "http://e-www3-t1.univ-lemans.fr/data/etudiants/photos_badges_universite/{$this->photo}";
        }
    }

    public function getClassementProjet($id_projet)
    {      
        $rang = EtudiantClassementProjet::where("etudiant", $this->id)->where("projet", $id_projet)->first();

        return $rang;
    }

    public function derniereAssurance() {
      // return $this->assurances()->orderByDesc('date_debut')->first();
      return $this->assurances->last();
    }

    public function getLogoSpecialite()
    {
      
      if ($this->optionSp == "1" || $this->optionSp == "11" || $this->optionSp == "12") {
        $specialite = "AI";
      }elseif ($this->optionSp == "2" || $this->optionSp == "21" || $this->optionSp == "22") {
        $specialite = "Informatique";
      }else{
        $specialite = "AI";
      }

      return "../../images/pictogramme_$specialite.svg";

      // return "../../images/pictogramme_$this->optionSp.svg";
    }


}