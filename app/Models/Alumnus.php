<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Parental\HasParent;

class Alumnus extends Utilisateur
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

        // Lors de la création d'un nouvel utilisateur de type Alumnus
        // On prédéfinit certaines données si certains champs sont insérés vides
        static::creating(function($alumnus){
            $alumnus->id = $alumnus->id ?? parent::generateNewId("alu");
            $alumnus->photo = $alumnus->photo ?? 'trombinoscope/alumnus/default.png';
            $alumnus->cas = 1;
        });
    }

    public function impersonate($utilisateur) {
        //...
    }
}
