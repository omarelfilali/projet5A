<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjetType;
use App\Models\EtudiantProjet;
use App\Models\ProjetEncadrant;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Carbon;

class Projet extends Model
{
    use HasFactory;

    protected $table = 'NEW_projet';
	// public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'reference',
        'titre',
        'projet_parent',
        'entreprise_partenaire',
        'resume',
        'infos_complementaires',
        'annee_inge',
        'filiere',
        'option',
        'annee_scolaire',
        'est_prioritaire',
        'nb_places',
        'etat',
        'type_cadrage',
        'est_confidentiel',
        'budget'
    ];

    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_maj';

    //! Liste des relations avec les autres tables
    public function entreprise()
    {
      return $this->belongsTo('App\Models\Entreprise','entreprise_partenaire', 'id');
    }

    public function encadrants()
    {
        return $this->belongsToMany('App\Models\Encadrant', 'projets_x_encadrants', 'projet', 'encadrant')->withPivot('type_encadrant','est_porteur_principal','nb_heures_enseignement');
    }

    public function etudiants()
    {
        return $this->belongsToMany('App\Models\Etudiant', 'etudiants_x_projets', 'projet', 'etudiant')->withPivot('annee_scolaire');
    }

    public function specialites()
    {
      return $this->belongsToMany('App\Models\Specialite', 'projets_x_specialites', 'projet', 'specialite');
    }

    public function types()
    {
      return $this->belongsToMany('App\Models\Type', 'projets_x_types', 'projet', 'type');
    }

    public function mots_cles()
    {
      return $this->hasMany('App\Models\ProjetMotCle', 'projet', 'id');
    }

    public function documents()
    {
      return $this->hasMany('App\Models\ProjetDocuments', 'projet', 'id');
    }

    public function convention()
    {
        return $this->hasOne('App\Models\ProjetConvention', 'projet', 'id');
    }

    //* Fonctions get pour récupérer des données
    // Permet de récupérer les types d'un projet (INDUS, RECHERCHE...)
    // public function get_types()
    // {
    //     $types = $this->hasMany(ProjetType::class, 'projet', 'id')->select("type")->get();
    //     foreach ($types as $key => $value) {
    //         $array_types[$key] = $value->type;
    //     }
    //     return $array_types;
    // }

    public function getDateCreation(){
        return Carbon::parse($this->date_creation)->format('d/m/Y à H:i');
    }

    // Permet de savoir si le projet cible la filière A&I / INFO / Transversal
    public function getFiliereCible(){

        $ai = false;
        $info = false;

        $specialites = $this->specialites()->get();

        foreach($specialites as $specialite){
            if($specialite->filiere == 1){
                $ai = true;
            }elseif($specialite->filiere == 2){
                $info = true;
            }
        }

        if($ai && $info){
            return "transversal";
        }elseif($info){
            return "Informatique";
        }elseif($ai){
            return "AI";
        }
    }

    //* Fonctions get pour récupérer les paramètres de ce module
    //? Le chiffre 7 correspond au module Projet dans la table Module
    public static function getParametre($cle=""){
        if ($cle){
            $parametre = Parametrage::whereModule('7')->whereCle($cle)->first();
            return $parametre;
        }else{
            $parametres = Parametrage::whereModule('7')->get();
            return $parametres;
        }
    }

    //* Fonctions get pour récupérer les statuts/attributions de ce module
    //? Le chiffre 7 correspond au module Projet dans la table Module
    public static function getTypes($tags=""){
        return Type::whereModule('7')->where("tags","like","%$tags%")->get();
    }

    //* Fonctions get pour récupérer les statuts/attributions de ce module
    //? Le chiffre 7 correspond au module Projet dans la table Module
    public static function getStatuts($tags=""){
        return Statut::whereModule('7')->where("tags","like","%$tags%")->get();
    }

}
