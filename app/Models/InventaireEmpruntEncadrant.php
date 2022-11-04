<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireEmpruntEncadrant extends Model
{
    use HasFactory;

	protected $table = 'inventaire_emprunts_encadrants';
	public $timestamps = FALSE;

	protected $fillable = [
        'emprunt_id',
        'personnel_id'
    ];

	public function personnel()
    {
        return $this->hasOne('App\Models\Personnel', 'id', 'personnel_id');
    }
}
