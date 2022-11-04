<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EtudiantAssurance extends Model
{
    use HasFactory;

	protected $table = 'etudiants_assurances';
	public $timestamps = TRUE;

	protected $fillable = [
        'etudiant_uid',
		'date_debut',
        'date_fin',
        'assurance',
        'valide'
    ];

    // public function etudiant()
    // {
    //     return $this->hasOne('App\Models\Etudiant', 'login' , 'etudiant_uid');
    // }

    public function etudiant()
    {
        return $this->hasOne('App\Models\Etudiant', 'id' , 'etudiant_uid');
    }

    protected $dates = ['date_debut', 'date_fin'];

    public function dateDebut(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->date_debut)->format('d/m/Y');
    }

    public function dateFin(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->date_fin)->format('d/m/Y');
    }

    public function dateDebutCarbon(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->date_debut);
    }

    public function dateFinCarbon(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->date_fin);
    }
}
