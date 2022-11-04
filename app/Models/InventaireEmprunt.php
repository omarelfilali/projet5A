<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InventaireEmprunt extends Model
{
  use HasFactory;

  protected $table = 'inventaire_emprunts';
  public $timestamps = TRUE;

  protected $fillable = [
    'status',
    'debut_date',
    'fin_date',
    'rendu_date',
    'description',
    'etudiant_uid',
    'technicien_id',
    'sendmailbefore',
    'sendmailafter'
  ];

protected $dates = ['debut_date', 'fin_date'];

  // public function etudiant()
  // {
  //   return $this->hasOne('App\Models\Etudiant', 'login' , 'etudiant_uid');
  // }

  public function etudiant()
  {
    return $this->hasOne('App\Models\Etudiant', 'id' , 'etudiant_uid');
  }

  public function technicien()
  {
    return $this->hasOne('App\Models\Personnel', 'id' , 'technicien_id');
  }

  public function encadrants()
  {
    return $this->hasMany('App\Models\InventaireEmpruntEncadrant', 'emprunt_id' , 'id');
  }

  public function encadrants_id(){
      return $this->encadrants->map(function ($user) {
          return $user->personnel->id;
      })->toArray();
  }

  public function operations()
  {
    return $this->hasMany('App\Models\InventaireEmpruntHistorique', 'emprunt_id' , 'id');
  }

  public function articles()
  {
    return $this->hasMany('App\Models\InventaireEmpruntProduit', 'emprunt_id' , 'id');
  }

  public function assurance() {
      return $this->etudiant->assurances()
          ->where('etudiants_assurances.date_debut', '<=', $this->debut_date)
          ->where('etudiants_assurances.date_fin', '>=', $this->fin_date)
          ->orderBy('valide', 'DESC')
          ->first();
  }

  public function disponible()
  {
    return $this->status >= 5;
  }

  public function enPret()
  {
    return $this->status = 4;
  }

  public function reserve()
  {
    return $this->status <= 4;
  }

  public function empruntTermine()
  {
    return $this->rendu_date != null;
  }

  public function dateDebut(){
      return Carbon::createFromFormat('Y-m-d H:i:s', $this->debut_date)->format('d/m/Y');
  }

  public function dateFin(){
      return Carbon::createFromFormat('Y-m-d H:i:s', $this->fin_date)->format('d/m/Y');
  }

  public function dateDebutCarbon(){
      return Carbon::createFromFormat('Y-m-d H:i:s', $this->debut_date);
  }

  public function dateFinCarbon(){
      return Carbon::createFromFormat('Y-m-d H:i:s', $this->fin_date);
  }

  public function dateRendu(){
      if (!$this->empruntTermine()){
          return "/";
      }
      return Carbon::createFromFormat('Y-m-d H:i:s', $this->rendu_date)->format('d/m/Y');
  }
}
