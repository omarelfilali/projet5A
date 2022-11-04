<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exterieur extends Model
{
    use HasFactory;

    protected $table = 'personnels';
    public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'int';

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

    public function getInitiales(){

        $initiales = "";

        if($this->prenom && $this->nom){
            $initiales = $this->prenom[0].$this->nom[0];
        }

        return $initiales;
    }

    public function getNomPrenomAttribute(){

        if($this->prenom && $this->nom){
            return $this->nom. ' ' . $this->prenom;
        }
    }

    public function getPrenomNomAttribute(){

        if($this->prenom && $this->nom){
            return "{$this->prenom} {$this->nom}";
        }
    }

    public static function getExterieurs(){
        $exterieurs = Personnel::whereType("ext")->get();
        return $exterieurs;
    }
}
