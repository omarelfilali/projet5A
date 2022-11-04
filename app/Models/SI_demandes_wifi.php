<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Carbon;

class SI_demandes_wifi extends Model
{
    use HasFactory;

    protected $table = 'SI_demandes_wifi';
	public $timestamps = FALSE;

	protected $fillable = [
        'demandeur',
		'usager',
        'duree',
        'raison',
        'validation',
        'date_demande'
    ];

    public function personnel()
    {
        return $this->belongsTo('App\Models\Personnel', 'demandeur' , 'id');
    }

    public function getDateDemande(){
        return Carbon::parse($this->date_demande)->format('d/m/Y à H:i');
    }

    public function getDemandeur(){
        return $this->personnel()->first()->NomPrenom;
    }

    //* Fonctions get pour récupérer les paramètres de ce module
    //? Le chiffre 8 correspond au module Informatique dans la table Module
    public static function getParametre($cle=""){
        if ($cle){
            $parametre = Parametrage::whereModule('8')->whereCle($cle)->first();
            return $parametre;
        }else{
            $parametres = Parametrage::whereModule('8')->get();
            return $parametres;
        }
    }

}
