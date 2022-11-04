<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Parental\HasParent;

class Candidat extends Utilisateur
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

        // Lors de la création d'un nouvel utilisateur de type candidat
        // On prédéfinit certaines données si certains champs sont insérés vides
        static::creating(function($candidat){
            $candidat->id = $candidat->id ?? parent::generateNewId("can");
            $candidat->photo = $candidat->photo ?? 'trombinoscope/candidat/default.png';
            $candidat->cas = 1;
        });
    }

    public function impersonate($utilisateur) {
        //...
    }
}
