<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetMotCle extends Model
{
    use HasFactory;

    protected $table = 'projet_mots_cles';
	public $timestamps = FALSE;
    public $incrementing = false;
    protected $primaryKey = ['projet', 'mot_cle'];

    protected $fillable = [
        'mot_cle'
    ];

}
