<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireType extends Model
{
    use HasFactory;

	protected $table = 'inventaire_types';
	public $timestamps = FALSE;

	protected $fillable = [
        'nom',
		'technicien_id',
		'category_id',
    ];

	public function technicien()
	{
		return $this->hasOne('App\Models\Personnel', 'id' , 'technicien_id');
	}

	public function categorie()
	{
		return $this->hasOne('App\Models\InventaireCategorie', 'id' , 'category_id');
	}

	public function filtres()
    {
        return $this->hasMany('App\Models\InventaireFiltre', 'type_id' , 'id');
    }

	public function produits()
	{
		return $this->hasMany('App\Models\InventaireProduit', 'type_id' , 'id');
	}

	public function marques($in_stock = null) {
		$produits = $this->produits;
        if ($in_stock) {
            $produits = $produits->filter(function($p) {
                return $p->nombreStock > 0;
            });
        }
		$array = array();
		foreach($produits as $produit) {
			array_push($array, $produit->marque);
		}
		return array_unique($array);
	}
}
