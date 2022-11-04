<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventairePanier extends Model
{
    use HasFactory;
	
	protected $table = 'inventaire_paniers';
	public $timestamps = FALSE;

	protected $fillable = [
        'etudiant_uid',
    ];

    public function lignes() {
        return $this->hasMany('App\Models\InventaireLignePanier', 'panier_id' , 'id');
    }

    public function nbTotalArticles() {
        $articles = 0;
        foreach ($this->lignes as $ligne) {
            $articles += $ligne->quantite;
        }
        return $articles;
    }

    public function estVide() {
        return count($this->lignes) == 0;
    }

    public function nbArticles($id_produit) {
        $article = $this->lignes->firstWhere('produit_id', $id_produit);
        if ($article != null) {
            return $article->quantite;
        }
        return 0;
    }
}
