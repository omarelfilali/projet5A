<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventairePanierEncadrant extends Model
{
    use HasFactory;
	
	protected $table = 'inventaire_paniers_encadrants';
	public $timestamps = FALSE;

	protected $fillable = [
        'panier_id',
        'personnel_id',
    ];

}
