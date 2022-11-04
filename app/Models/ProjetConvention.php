<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetConvention extends Model
{
    use HasFactory;

    protected $table = 'projet_convention';
	public $timestamps = FALSE;
    protected $primaryKey = "projet";
    protected $keyType = 'int';

    protected $fillable = [
        'projet',
        'statut_convention',
        'statut_facturation',
        'retribution_financiere',
        'autres_retributions',
        'commentaire'
    ];
}
