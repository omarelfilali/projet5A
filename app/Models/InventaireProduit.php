<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InventaireEmprunt;

class InventaireProduit extends Model
{
  use HasFactory;

  protected $table = 'inventaire_produits';
  public $timestamps = TRUE;

  protected $fillable = [
    'nom',
    'marque',
    'type_id',
    'numero_modele',
    'fiche_technique',
    'masked',
    'default_img'
  ];

  public function type()
  {
    return $this->hasOne('App\Models\InventaireType', 'id' , 'type_id');
  }

  public function filtres()
  {
    return $this->hasMany('App\Models\InventaireProduitFiltre', 'produit_id' , 'id');
  }

  public function getImagesAttribute()
  {
    return $this->hasMany('App\Models\InventaireProduitImage', 'produit_id' , 'id')->get();
  }

  public function getImagesSecondairesAttribute()
  {
      if (isset($this->imagePrincipale)){
          return $this->hasMany('App\Models\InventaireProduitImage', 'produit_id' , 'id')->where('id', '!=', $this->imagePrincipale->id)->get();
      }
      else {
          return collect();
      }
  }

  public function getImagePrincipaleAttribute()
  {
      if (isset($this->default_img)){
          return $this->hasMany('App\Models\InventaireProduitImage', 'produit_id' , 'id')->where('id', $this->default_img)->first();
      }
      else {
          return $this->hasMany('App\Models\InventaireProduitImage', 'produit_id' , 'id')->first();
      }
  }

  public function getImageParDefautAttribute()
  {
      if ($this->hasMany('App\Models\InventaireProduitImage', 'produit_id' , 'id')->count() == 0){
          return asset('photos/no_image.png');
      }
      else {
          return $this->getImagePrincipaleAttribute()->image;
      }
  }

  public function references()
  {
    return $this->hasMany('App\Models\InventaireProduitReference', 'produit_id' , 'id');
  }

  public function getMaxStockAttribute()
  {
    return $this->references->count();
  }

  public function getNombreStockAttribute()
  {
    $i = 0;
    foreach($this->references as $ref){
      $exist = false;
      $non_disponible = false;
      foreach($ref->emprunts as $emp){
        $exist = true;
        if(!($ref->status == 0 && $emp->emprunt->disponible())){
          $non_disponible = true;
        }
      }
      if (!$exist && $ref->status == 0){
          $i++;
      }
      else if ($exist && !$non_disponible){
          $i++;
      }
    }
    return $i;
  }

  public function getReferencesDisponiblesAttribute()
  {
    $refs = array();
    foreach($this->references as $ref){
      $exist = false;
      foreach($ref->emprunts as $emp){
        $exist = true;
        if($ref->status == 0 && $emp->emprunt->disponible()){
          array_push($refs, $ref);
        }
      }
      if (!$exist && $ref->status == 0){
          array_push($refs, $ref);
      }
    }
    return $refs;
  }

  public function getEnStockAttribute()
  {
    return $this->getNombreStockAttribute() > 0 ? TRUE : FALSE;
  }

}
