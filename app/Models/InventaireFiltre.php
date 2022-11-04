<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireFiltre extends Model
{
    use HasFactory;
	
	protected $table = 'inventaire_types_filtres';
	public $timestamps = FALSE;
	
	protected $fillable = [
        'type_id',
        'nom',
		'valeur_type',
		'unite',
    ];
	
	public function type()
    {
        return $this->hasOne('App\Models\InventaireType', 'id' , 'type_id'); 
    }

    public function filtres_produits()
    {
        return $this->hasMany('App\Models\InventaireProduitFiltre', 'filtre_id' , 'id'); 
    }

    public function valeur_min($in_stock = null) {
        $filtres_produits = $this->filtres_produits->filter(function($f) {
            return ($f->produit != null);
        });
        if ($in_stock) {
            $filtres_produits = $filtres_produits->filter(function($f) {
                return $f->produit->nombreStock > 0;
            });
        }
        $first = true;
        $min = 0;
        foreach($filtres_produits as $filtre_produit) {
            $valeur = $filtre_produit->valeur;
            if ($first) {
                $min = $valeur;
                $first = false;
            } else if ($valeur < $min) {
                $min = $valeur;
            }
        }
        return $min;
    }

    public function valeur_max($in_stock = null) {
        $filtres_produits = $this->filtres_produits->filter(function($f) {
            return ($f->produit != null);
        });
        
        if ($in_stock) {
            $filtres_produits = $filtres_produits->filter(function($f) {
                return $f->produit->nombreStock > 0;
            });
        }
        $first = true;
        $max = 0;
        foreach($filtres_produits as $i=>$filtre_produit) {
            $valeur = $filtre_produit->valeur;
            if ($first) {
                $max = $valeur;
                $first = false;
            } else if ($valeur > $max) {
                $max = $valeur;
            }
        }
        return $max;
    }

    public function liste_valeur($in_stock = null) {
        $filtres_produits = $this->filtres_produits->filter(function($f) {
            return ($f->produit != null);
        });
        if ($in_stock) {
            $filtres_produits = $filtres_produits->filter(function($f) {
                return $f->produit->nombreStock > 0;
            });
        }
        $array = array();
        foreach($filtres_produits as $filtre_produit) {
            $valeur = $filtre_produit->valeur;
            array_push($array, $valeur);
        }
        return array_unique($array);
    }
}
