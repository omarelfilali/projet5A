<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Utilisateur;
use App\Models\Personnel;
use App\Models\Etudiant;
use App\Models\Exterieur;
use App\Models\Alumnus;
use App\Models\Candidat;

class PermissionsController extends Controller
{
    public function test(){

        dd(Utilisateur::all());
        $role = Role::findByName('Administrateur');
        $user = Utilisateur::whereId('sgracia')->first();

        $user->assignRole($role);
        $samy = Exterieur2::first();

        // Exterieur2::create([
        //     'old_id' => 0,
        //     'prenom' => 'bonjour',
        //     'nom' => 'test',
        //     'password' => 'aucun',
        //     'genre' => 1,
        //     'droit_image' => 1,
        //     'cas' => 0,
        //     'date_connexion' => now()
        // ]);



    }
}
