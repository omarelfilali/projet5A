<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelStatut extends Model
{
    use HasFactory;

	protected $table = 'personnels_statuts';
	public $timestamps = FALSE;

	protected $fillable = [
        'personnel_id',
		'statut_id',
    ];

    public function type()
    {
        return $this->hasOne('App\Models\PersonnelStatutType', 'id' , 'statut_id');
    }
}
