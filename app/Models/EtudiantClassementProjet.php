<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtudiantClassementProjet extends Model
{
    use HasFactory;

    protected $table = 'etudiants_x_classements_projets';
	public $timestamps = FALSE;
    public $incrementing = false;
    protected $primaryKey = ['projet', 'etudiant', 'annee_scolaire'];

    protected $fillable = [
        'etudiant',
        'annee_scolaire',
        'projet',
        'classement_prio',
        'rang'
    ];
}
