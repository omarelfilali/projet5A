<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Parental\HasChildren;

use App\Models\Candidat;
use App\Models\Alumnus;
use App\Models\Personnel;
use App\Models\Etudiant;
use App\Models\Exterieur;

use Session;

class Utilisateur extends Authenticatable
{

    /*
    |--------------------------------------------------------------------------
    | Initialisation / Configuration
    |--------------------------------------------------------------------------
    */

    use HasFactory;
    use HasRoles;
    use HasChildren;

    protected $table = 'utilisateur';

    // id correspond au login de l'utilisateur (ex : i190810)
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    // Pas de timestamps ni d'incrémention pour l'id
    public $timestamps = FALSE;
    public $incrementing = false;
    
    protected $guard_name ='utilisateur';

    // On définit la colonne role comme childColumn pour les tables
    // descendants de Utilisateur (Personnel, Etudiant, Exterieur, Alumnus, Candidat)
    protected $childColumn = 'role';
    protected $childTypes = [
        '1' => Candidat::class,
        '2' => Alumnus::class,
        '3' => Personnel::class,
        '4' => Etudiant::class,
        '5' => Exterieur::class,
    ];

    protected $fillable = [
        'id',
        'old_id',
        'prenom',
        'nom',
        'role',
        'type',
        'password',
        'genre',
        'mail',
        'photo',
        'droit_image',
        'securite_sociale',
        'date_creation',
        'date_connexion',
        'is_locked',
        'cas',
        'remember_token',
    ];




    /*
    |--------------------------------------------------------------------------
    | Tables relationnelles
    |--------------------------------------------------------------------------
    */




    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    public static function getGuard(){
        return Auth::guard('utilisateur');
    }

    public function getUidAttribute()
    {
      return "{$this->id}";
    }

    public function getNomPrenomAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getPrenomNomAttribute()
    {
      return "{$this->prenom} {$this->nom}";
    }

    public function getEmailAttribute()
    {
      return "{$this->mail}";
    }

    public function getInitiales(){

        $initiales = "";
        
        if($this->prenom && $this->nom){
            $initiales = $this->prenom[0].$this->nom[0];
        }
  
        return $initiales;
    }




    /*
    |--------------------------------------------------------------------------
    | Autre
    |--------------------------------------------------------------------------
    */

    public static function generateNewId($role){
        $id = $role . random_int(000000,999999);
        $alreadyExists = 1;

        while ($alreadyExists){
            if (Utilisateur::whereId($id)->first()){
                $id = $role . random_int(100000,999999);
            }else{
                $alreadyExists = 0;
            }
        }

        return $id;
    }
    
}
