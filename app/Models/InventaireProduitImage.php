<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireProduitImage extends Model
{
    use HasFactory;
	
	protected $table = 'inventaire_produits_images';
	public $timestamps = FALSE;
	
	protected $fillable = [
        'produit_id',
		'image',
    ];
}
