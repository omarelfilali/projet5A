<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireEmpruntProduit extends Model
{
  use HasFactory;

  protected $table = 'inventaire_emprunts_produits';
  public $timestamps = FALSE;

  protected $fillable = [
    'emprunt_id',
    'reference_id',
  ];

  public function reference()
  {
    return $this->hasOne('App\Models\InventaireProduitReference', 'id' , 'reference_id');
  }

  public function emprunt()
  {
    return $this->hasOne('App\Models\InventaireEmprunt', 'id' , 'emprunt_id');
  }
}
