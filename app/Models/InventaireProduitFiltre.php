<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireProduitFiltre extends Model
{
    use HasFactory;
	
	protected $table = 'inventaire_produits_filtres';
	public $timestamps = FALSE;
	
	protected $fillable = [
        'produit_id',
        'filtre_id',
		'valeur',
    ];
	
	public function filtre()
    {
        return $this->hasOne('App\Models\InventaireFiltre', 'id' , 'filtre_id'); 
    }

    public function produit()
    {
        return $this->hasOne('App\Models\InventaireProduit', 'id' , 'produit_id'); 
    }

}
