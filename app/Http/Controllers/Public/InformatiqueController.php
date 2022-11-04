<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SI_demandes_wifi;
use Auth;
use App\Models\Personnel;
use App\Mail\WifiNouvelleDemande;

use Illuminate\Support\Facades\Mail;

use Adldap\Laravel\Facades\Adldap;

class InformatiqueController extends Controller
{

  public function show(){

    $user = Auth::user();
    
    if(Auth::user()->role == 4){ // étudiant
      
      $infos_ldap = Adldap::search()->where('uid', '=', Auth::user()->id)->first();
			
      return view('public.informatique.wifi', compact('infos_ldap'));

    }elseif(Auth::user()->role == 3 || Auth::user()->role == 5){ // personnel ou exterieur

      $demandes = SI_demandes_wifi::where("demandeur", $user->id)->orderBy("date_demande","DESC")->get();
      return view('public.informatique.wifi', compact('demandes'));

    }
  }

  public function create_demande(Request $request){

    $user = Personnel::getGuard()->user();

    SI_demandes_wifi::updateOrCreate(
        ['demandeur' => $user->id,'usager' => $request->usager, 'duree' => $request->duree, 'raison' => $request->raison, 'validation' => 0]
    );

    // ENVOI MAIL : on envoi le code wifi par mail 
    $demandeur = $user->nom . " " . $user->prenom;
    $mail = new WifiNouvelleDemande(route('administration.informatique.wifi'),$demandeur);
    // récupérer le mail de l'administrateur informatique;
    
    Mail::to("ophelie.guiller@univ-lemans.fr")->send($mail);

    
    return redirect()->route('public.informatique.show_demandes');
  }

  public function logiciels(){

    return view('public.informatique.liste_logiciels');
  }

}
