<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use Session;

class Personnel extends Authenticatable
{
    use HasFactory;
    use HasRoles;

    protected $table = 'personnels';
    public $timestamps = FALSE;
    protected $primaryKey = "uid";
    protected $keyType = 'string';
    protected $guard_name ='etudiant';

    protected $fillable = [
        'prenom',
        'nom',
        'photo',
        'admin',
        'identifiant',
        'del',
        'date_fin',
        'emploi_principal',
        'activite_ens',
        'activite_techn',
        'type',
        'courriel_pro',
        'tel_pro1',
        'employeur',
        'token',
        'flag',
        'uid',
        'date_naiss',
        'adresse_perso',
        'adresse_pro',
        'cle_salle',
        'fonction',
        'responsabilites',
        'labo',
        'remarques_admin',
        'remarques_perso',
        'date_connexion',
        'date_fin',
        'date_modif'
    ];

    public function demandes_wifi()
    {
      return $this->hasMany('App\Models\Si_demandes_wifi', 'demandeur' , 'id');
    }

    // public function roles()
    // {
    //     return $this->belongsToMany('App\Models\Role', 'utilisateurs_x_roles', "utilisateur", "role");
    // }

    public function projets(){
        return $this->belongsToMany('App\Models\Projet', 'projets_x_encadrants', 'encadrant', 'projet')->withPivot('nb_heures_enseignement','role');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\PersonnelMaterielCategorie', 'personnel_id' , 'id');
    }

    public function statuts()
    {
        return $this->hasMany('App\Models\PersonnelStatut', 'personnel_id' , 'id');
    }

    public function autorisation()
    {
        return $this->hasOne('App\Models\Autorisation', 'id_personnel', 'id');
    }

    public function getEmailAttribute()
    {
        return "{$this->identifiant}";
    }

    public function admin()
    {
        return "{$this->admin}";
    }

    // public static function getUsersByRole($role){
    //     $users = Personnel::select("uid")
    //     ->join("utilisateurs_x_roles", "utilisateurs_x_roles.utilisateur", "personnels.uid")
    //     ->join("role", "role.id", "utilisateurs_x_roles.role")
    //     ->where("role.prefix", $role)->get();
    //     return $users;
    // }

    //! Utilisé uniquement lors de la connexion OU pour récupérer les permissions d'autres utilisateurs
    // Pour récupérer ses propres permissions, merci d'utiliser Session::get('permissions');
    // public function getPermissions(){
    //     $permissionsFromRoles = DB::table("utilisateurs_x_roles")
    //     ->join("roles_x_permissions", "roles_x_permissions.role", "utilisateurs_x_roles.role")
    //     ->join("permission", "permission.id", "roles_x_permissions.permission")
    //     ->select("permission.prefix AS permission")->distinct("permission.prefix")
    //     ->where("utilisateur", $this->uid)->get()->pluck("permission")->all();

    //     $permissionsFromUser = DB::table("utilisateurs_x_permissions")
    //     ->join("permission", "permission.id", "utilisateurs_x_permissions.permission")
    //     ->select("permission.prefix AS permission")->distinct("permission.prefix")
    //     ->where("utilisateur", $this->uid)->get()->pluck("permission")->all();

    //     $permissions = array_unique(array_merge($permissionsFromRoles, $permissionsFromUser));
    //     return $permissions;
    // }

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

    // public static function getGuard(){
    //     return Auth::guard('personnel');
    // }

    public function getPhotoURLAttribute(){
        if (strlen($this->photo) == 0){
            return asset('photos/empty.png');
        }
        else {
            return "http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/{$this->photo}";
        }
    }
}
