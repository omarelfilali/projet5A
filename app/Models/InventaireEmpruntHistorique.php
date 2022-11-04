<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireEmpruntHistorique extends Model
{
    use HasFactory;

	protected $table = 'inventaire_emprunts_historique';
	public $timestamps = TRUE;

	protected $fillable = [
        'emprunt_id',
        'personnel_id',
        'commentaire',
		'titre',
        'role'
    ];

    public function emprunt()
    {
      return $this->hasOne('App\Models\InventaireEmprunt', 'id' , 'emprunt_id');
    }

    public function personnel()
    {
      return $this->hasOne('App\Models\Personnel', 'id' , 'personnel_id');
    }
}
