<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AnneeScolaire extends Model
{
    use HasFactory;

    protected $table = 'annee_scolaire';
	public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'date_debut',
        'date_fin'
    ];

    public static function getAnneeActuelle(){
        $annee_scolaire = AnneeScolaire::where('date_debut', '<', Carbon::now())->where('date_fin', '>', Carbon::now())->first();

        if ($annee_scolaire == null){
            $annee_scolaire = AnneeScolaire::where('date_fin', '>', Carbon::now())->first();
        }

        return $annee_scolaire->id;
    }
}
