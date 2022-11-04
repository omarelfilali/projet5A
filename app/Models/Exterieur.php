<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Parental\HasParent;

use App\Models\Utilisateur;

class Exterieur extends Utilisateur
{
    use HasFactory;
    use HasParent;
    protected $guarded = [];

    public static function boot(){
        parent::boot();

        // Lors de la création d'un nouvel utilisateur de type Exterieur
        // On prédéfinit certaines données si certains champs sont insérés vides
        static::creating(function($exterieur){
            $exterieur->id = $exterieur->id ?? parent::generateNewId("ext");
            $exterieur->photo = $exterieur->photo ?? 'trombinoscope/exterieur/default.png';
            $exterieur->cas = 0;
        });
    }

    public function impersonate($utilisateur) {
        //...
    }


}