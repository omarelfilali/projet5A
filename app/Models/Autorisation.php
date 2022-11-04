<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorisation extends Model
{
    use HasFactory;

	protected $table = 'autorisations';
	public $timestamps = FALSE;

	protected $fillable = [
		'id_personnel',
		'auth_modif',
    ];
}
