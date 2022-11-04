<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjetDocuments extends Model
{
    use HasFactory;

    protected $table = 'projet_documents';
	public $timestamps = FALSE;
    protected $primaryKey = "id";
    protected $keyType = 'int';

    protected $fillable = [
        'projet',
        'nom',
        'lien',
        'type',
        'est_visible'
    ];

    
}
