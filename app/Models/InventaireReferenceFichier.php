<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireReferenceFichier extends Model
{
    use HasFactory;

    protected $table = 'inventaire_produits_references_fichiers';
    public $timestamps = FALSE;

    protected $fillable = [
        'reference_id',
        'fichier',
        'nom',
    ];

    public function reference()
    {
        return $this->hasOne('App\Models\InventaireProduitReference', 'id' , 'reference_id');
    }

}
