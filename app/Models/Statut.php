<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $table = 'statut';
    protected $primaryKey = 'id';
    protected $fillable = [
        "nom",
        "tags",
        "etape",
        "module",
    ];
}
