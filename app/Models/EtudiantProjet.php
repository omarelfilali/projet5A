<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtudiantProjet extends Model
{
    use HasFactory;

    protected $table = 'etudiants_x_projets';
	public $timestamps = FALSE;
    public $incrementing = false;
    protected $primaryKey = ['etudiant', 'annee_scolaire', 'projet'];

    protected $fillable = [
        'etudiant',
        'annee_scolaire',
        'projet'
    ];
}
