<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    public $timestamps = FALSE;
    protected $table = 'role';
    protected $fillable = [
        "prefix",
        "nom",
        "role_parent"
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'roles_x_permissions', "role", "permission");
    }

    public static function getRoleIdByPrefix($prefix){
        $roleId = Role::wherePrefix($prefix)->value('id');
        return $roleId;
    }

}
