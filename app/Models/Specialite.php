<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    use HasFactory;

    protected $table = 'specialite';
	public $timestamps = FALSE;
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $fillable = [
        'acronyme',
        'nom',
        'filiere'
    ];

    public static function getFilieres(){
        return Specialite::where('filiere','=', null)->get();
    }

    public static function getOptions(){
        return Specialite::where('filiere','!=', null)->get();
    }

}
