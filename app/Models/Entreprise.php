<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $table = 'entreprises';
	public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'int';

    protected $fillable = [
        'nom',
        'ville',
        'pays',
    ];

    public function projetsInternationaux()
    {
      return $this->hasMany('App\Models\FicheInternationale', 'entreprise' , 'id');
    }

    public function projets()
    {
      return $this->hasMany('App\Models\Projet', 'entreprise_partenaire' , 'id');
    }

    public function getDestination()
    {
      return "{$this->nom} - {$this->pays} ";
    }

}
