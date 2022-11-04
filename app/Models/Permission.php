<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $table = 'permission';
    protected $fillable = [
        "prefix",
        "nom",
        "module"
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'roles_x_permissions', "permission", "role");
    }
}
