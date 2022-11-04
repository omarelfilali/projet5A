<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetType extends Model
{
    use HasFactory;

    protected $table = 'projet_types';
	public $timestamps = FALSE;
    public $incrementing = false;
    protected $primaryKey = ['projet', 'type'];

    protected $fillable = [
        'projet',
        'type'
    ];

    
}
