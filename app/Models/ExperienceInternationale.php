<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienceInternationale extends Model
{
    use HasFactory;
    protected $table = 'relinter_experience';
	public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'int';
}
