<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeInge extends Model
{
    use HasFactory;

    protected $table = 'annee_inge';
	public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'char';

    protected $fillable = [
        'id',
        'cycle',
    ];
}
