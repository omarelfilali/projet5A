<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\EtudiantAssurance;
use App\Models\FicheInternationale;
use Illuminate\Support\Facades\DB;

class Etudiant extends Authenticatable
{
    use HasFactory;

	protected $table = 'inscriptions2';
	public $timestamps = FALSE;
    protected $primaryKey = "login";
    protected $keyType = 'string';

	protected $fillable = [
        'nom',
        'prenom',
        'login',
        'photo',
        'promo',
        'mail_UDM'
    ];

    public function getEmailAttribute()
    {
      return "{$this->mail_UDM}";
    }

    public function getNomPrenomAttribute()
    {
      return "{$this->nom} {$this->prenom}";
    }

    public function getPrenomNomAttribute()
    {
      return "{$this->prenom} {$this->nom}";
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

    public function assurances()
    {
      return $this->hasMany('App\Models\EtudiantAssurance', 'etudiant_uid' , 'login');
    }

    public function demandes()
    {
      return $this->hasMany('App\Models\InventaireEmprunt', 'etudiant_uid' , 'login');
    }

    public function derniereAssurance() {
     // return $this->assurances()->orderByDesc('date_debut')->first();
     return $this->assurances->last();
    }

    public function projets()
    {
        return $this->belongsToMany('App\Models\Projet', 'etudiants_x_projets', "etudiant", "projet")->withPivot('annee_scolaire');
    }

    public function getClassementProjet($id_projet)
    {      
        $rang = EtudiantClassementProjet::where("etudiant", $this->id)->where("projet", $id_projet)->first();

        return $rang;
    }

    public function projetsInternationaux()
    {
      return $this->hasMany('App\Models\FicheInternationale', 'etudiant' , 'id');
    }

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

    public function getUidAttribute()
    {
      return "{$this->login}";
    }

    public function getPhotoURLAttribute(){
        if (strlen($this->photo) == 0){
            return asset('photos/empty.png');
        }
        else {
            return "http://e-www3-t1.univ-lemans.fr/data/etudiants/photos_badges_universite/{$this->photo}";
        }
    }

    public static function getGuard(){
        return Auth::guard('etudiant');
    }

    public function getInitiales(){

      $initiales = "";
      
      if($this->prenom && $this->nom){
          $initiales = $this->prenom[0].$this->nom[0];
      }

      return $initiales;
  }
}
