<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelMaterielCategorie extends Model
{
    use HasFactory;
	
	protected $table = 'personnels_materiels_categories';
	public $timestamps = FALSE;
	
	protected $fillable = [
        'personnel_id',
		'categorie_id',
    ];
	
	public function categorie()
	{
		return $this->hasOne('App\Models\InventaireCategorie', 'id' , 'categorie_id'); 
	}

	public function resp_materiel()
	{
		return $this->hasOne('App\Models\Personnel', 'id' , 'personnel_id'); 
	}
}
