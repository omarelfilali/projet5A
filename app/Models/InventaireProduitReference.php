<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireProduitReference extends Model
{
    use HasFactory;

    protected $table = 'inventaire_produits_references';
    public $timestamps = TRUE;

    protected $fillable = [
        'produit_id',
        'ensim_id',
        'numero_serie',
        'stockage',
        'details',
        'status'
    ];

    public function produit()
    {
        return $this->hasOne('App\Models\InventaireProduit', 'id' , 'produit_id');
    }

    public function emprunts()
    {
        return $this->hasMany('App\Models\InventaireEmpruntProduit', 'reference_id' , 'id');
    }

    public function empruntActif(){
        $result = null;
        foreach($this->emprunts as $emp){
            if(!$emp->emprunt->disponible()){
                $result = $emp->emprunt;
            }
        }
        return $result;
    }

    public function fichiers() {
        return $this->hasMany('App\Models\InventaireReferenceFichier', 'reference_id' , 'id');
    }
}
