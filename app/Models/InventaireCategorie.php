<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireCategorie extends Model
{
    use HasFactory;
	
	protected $table = 'inventaire_categories';
	public $timestamps = FALSE;

	protected $fillable = [
        'nom',
        'visible',
    ];

    public function responsables() {
        return $this->hasMany('App\Models\PersonnelMaterielCategorie', 'categorie_id' , 'id');
    }

    public function product_types() {
        return $this->hasMany('App\Models\InventaireType', 'category_id' , 'id');
    }

    public function number_of_products() {
        $product_nb = 0;
        foreach ($this->product_types as $product_type) {
            $product_nb += $product_type->produits->count();
        }
        return $product_nb;
    }
}
