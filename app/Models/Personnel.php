<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Parental\HasParent;

use App\Models\Utilisateur;

class Personnel extends Utilisateur
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

        // Lors de la création d'un nouvel utilisateur de type Personnel
        // On prédéfinit certaines données si certains champs sont insérés vides
        static::creating(function($personnel){
            $personnel->id = $personnel->id ?? parent::generateNewId("prs");
            $personnel->photo = $personnel->photo ?? 'trombinoscope/personnel/default.png';
            $personnel->cas = 1;
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

    public function categories()
    {
        return $this->hasMany('App\Models\PersonnelMaterielCategorie', 'personnel_id' , 'id');
    }

    public function demandes_wifi()
    {
      return $this->hasMany('App\Models\Si_demandes_wifi', 'demandeur' , 'id');
    }

    public function projets(){
        return $this->belongsToMany('App\Models\Projet', 'projets_x_encadrants', 'encadrant', 'projet')->withPivot('nb_heures_enseignement','role');
    }

    public function statuts()
    {
        return $this->hasMany('App\Models\PersonnelStatut', 'personnel_id' , 'id');
    }

    public function autorisation()
    {
        return $this->hasOne('App\Models\Autorisation', 'id_personnel', 'id');
    }



    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public function getEmailAttribute()
    {
        return "{$this->identifiant}";
    }

    public function getNomPrenomAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function admin()
    {
        return $this->hasRole('Administrateur');
    }

    public static function getTechniciens(){
        $type_id = PersonnelStatutType::where('prefix', 'TECH')->firstOrFail()->id;
        $techniciens_id = PersonnelStatut::where('statut_id', $type_id)->get('personnel_id')->toArray();
        $techniciens = Personnel::whereIn('id', $techniciens_id)->get();
        return $techniciens;
    }

    public function isTechnicien(){
        $type_id = PersonnelStatutType::where('prefix', 'TECH')->firstOrFail()->id;
        return $technicien = PersonnelStatut::where('statut_id', $type_id)->where('personnel_id', $this->id)->exists();
    }

    public function isRespMateriel(){
        $type_id = PersonnelStatutType::where('prefix', 'RESPMAT')->firstOrFail()->id;
        return $technicien = PersonnelStatut::where('statut_id', $type_id)->where('personnel_id', $this->id)->exists();
    }

    public function isRespAdministratif(){
        $type_id = PersonnelStatutType::where('prefix', 'RESPADMIN')->firstOrFail()->id;
        return $technicien = PersonnelStatut::where('statut_id', $type_id)->where('personnel_id', $this->id)->exists();
    }

    public static function getRespAdministratifs(){
        $type_id = PersonnelStatutType::where('prefix', 'RESPADMIN')->firstOrFail()->id;
        $responsables_ids = PersonnelStatut::where('statut_id', $type_id)->get('personnel_id')->toArray();
        $responsables = Personnel::whereIn('id', $responsables_ids)->get();
        return $responsables;
    }

    public static function getRespMateriels(){
        $type_id = PersonnelStatutType::where('prefix', 'RESPMAT')->firstOrFail()->id;
        $responsables_ids = PersonnelStatut::where('statut_id', $type_id)->get('personnel_id')->toArray();
        $responsables = Personnel::whereIn('id', $responsables_ids)->get();
        return $responsables;
    }

    // Retourne la liste des enseignants + techniciens
    public static function getEncadrants(){
        $encadrants = Personnel::where('del', '0')
            ->where('date_fin', '>=', date('Y-m-d'))
            ->where('emploi_principal', 'ensim')
            ->where(function ($query) {
                $query->where('activite_ens', '1')
                    ->orWhere('activite_techn', '1');
            })
            ->whereHas('autorisation', function ($query) {
				$query->where('auth_modif', '1');
			})
            ->orderby('nom', 'ASC')->get();
        return $encadrants;
    }

    public function getPhotoURLAttribute(){
        if (strlen($this->photo) == 0){
            return asset('photos/empty.png');
        }
        else {
            return "http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/{$this->photo}";
        }
    }

}
