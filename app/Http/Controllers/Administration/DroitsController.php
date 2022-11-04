<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Utilisateur;

class DroitsController extends Controller
{
    
    public function utilisateurs() {

        $utilisateurs = Utilisateur::get();

        return view('administration.droits.utilisateurs', compact('utilisateurs'));
    }


    public function edit_utilisateurs($id) {

        $utilisateur = Utilisateur::where('id', '=', $id)->first();

        $all_roles = Role::all()->pluck('name');

        // get the names of the user's roles
        $roles_user = $utilisateur->getRoleNames(); 
        
        
        
        return view('administration.droits.edit_utilisateurs', compact('utilisateur', 'all_roles', 'roles_user'));
    }


    public function roles() {

        $all_roles = Role::all();
        
        return view('administration.droits.roles', compact('all_roles'));
    }

    public function show_roles($id) {

        $all_roles = Role::all();
        $role = Role::where('id', $id)->first();

        // récupère les permissions du rôle
        $permissions = $role->permissions;

        return view('administration.droits.roles', compact('all_roles', 'role', 'permissions'));
    }
}
