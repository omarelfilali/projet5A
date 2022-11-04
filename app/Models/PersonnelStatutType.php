<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelStatutType extends Model
{
    use HasFactory;

	protected $table = 'personnels_statuts_types';
	public $timestamps = FALSE;

	protected $fillable = [
		'nom',
    ];
}
