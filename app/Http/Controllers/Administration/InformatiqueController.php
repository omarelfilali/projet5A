<?php

namespace App\Http\Controllers\Administration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SI_demandes_wifi;
use App\Models\Parametrage;
use App\Mail\WifiEnvoiCode;

use Illuminate\Support\Facades\Mail;

class InformatiqueController extends Controller
{
    //

    public function wifi() {

        $demandesEnAttente = SI_demandes_wifi::where("validation", 0)->orderBy("date_demande", 'DESC')->get();
        $demandesAccepte = SI_demandes_wifi::where("validation", 1)->orderBy("date_demande", 'DESC')->get();
        $demandesRefuse = SI_demandes_wifi::where("validation", -1)->orderBy("date_demande", 'DESC')->get();
      
        return view('administration.informatique.wifi', compact('demandesEnAttente','demandesAccepte','demandesRefuse'));
    }

    public function wifi_action(Request $request) {
        
        switch ($request['action_wifi']) {
            case "accepte":  

                $codeWifi = SI_demandes_wifi::getParametre("codeWifi");

                // ENVOI MAIL : on envoi le code wifi par mail 
                $mail = new WifiEnvoiCode($codeWifi->valeur);
                // récupérer le mail du demandeur
                Mail::to("ophelie.guiller@univ-lemans.fr")->send($mail);
                
                SI_demandes_wifi::where('id', $request['id'])->update(['validation' => 1]);
                

            break;

            case "refuse":
                SI_demandes_wifi::where('id', $request['id'])->update(['validation' => -1]);
            break;

            case "annule":
                SI_demandes_wifi::where('id', $request['id'])->update(['validation' => 0]);
            break;
                
        }

        return redirect()->route('administration.informatique.wifi');
    }

    public function parametre(){

        $codeWifi = SI_demandes_wifi::getParametre("codeWifi");
        
        return view('administration/informatique/parametres', compact('codeWifi'));
    }

    public function add_parametre(Request $request){

        Parametrage::updateOrCreate(
            ['module' =>  8,'cle' => "codeWifi"],
            ['valeur' => $request->codeWifi, 'resume' => '']
        );

        return redirect()->route('administration.informatique.parametres');
    }
}
