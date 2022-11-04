<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalStatut extends Model
{
    use HasFactory;
    protected $table = 'international_statuts';
    public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'int';

    protected $fillable = [
        'fiche_internationale',
        'champ',
        'valeur',
        'date'
    ];
}
