<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireLignePanier extends Model
{
    use HasFactory;
	
	protected $table = 'inventaire_paniers_produits';
	public $timestamps = FALSE;

	protected $fillable = [
        'panier_id',
        'produit_id',
		'quantite',
    ];

    public function panier()
    {
        return $this->hasOne('App\Models\InventairePanier', 'id' , 'panier_id'); 
    }

    public function produit()
    {
        return $this->hasOne('App\Models\InventaireProduit', 'id' , 'produit_id'); 
    }
}
