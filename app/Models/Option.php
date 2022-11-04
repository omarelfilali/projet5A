<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth as Auth;
use App\Models\EtudiantAssurance;

class Option extends Authenticatable
{
    use HasFactory;

	protected $table = 'inventaire_options';
	public $timestamps = FALSE;
    protected $primaryKey = "field";
    protected $keyType = 'string';

	protected $fillable = [
        'value'
    ];
}
