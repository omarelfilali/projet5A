<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametrage extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    public $incrementing = false;
    protected $table = 'parametrage';
    protected $primaryKey = ['module', 'cle'];
    protected $fillable = [
        "module",
        "cle",
        "valeur",
        "resume"
    ];

    //! Les deux fonctions suivantes permettent de faire fonctionner les clés composites
    protected function getKeyForSaveQuery(){
        $primaryKeyForSaveQuery = array(count($this->primaryKey));

        foreach ($this->primaryKey as $i => $pKey) {
            $primaryKeyForSaveQuery[$i] = isset($this->original[$this->getKeyName()[$i]])
                ? $this->original[$this->getKeyName()[$i]]
                : $this->getAttribute($this->getKeyName()[$i]);
        }

        return $primaryKeyForSaveQuery;
    }

    protected function setKeysForSaveQuery($query){
        foreach ($this->primaryKey as $i => $pKey) {
            $query->where($this->getKeyName()[$i], '=', $this->getKeyForSaveQuery()[$i]);
        }
        return $query;
    }
}
