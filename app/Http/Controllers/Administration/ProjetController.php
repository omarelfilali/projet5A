<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\AnneeScolaire;
use App\Models\Etudiant;

// A virer
use App\Models\EtudiantProjet;

use App\Models\Projet;
use App\Models\Encadrant;
use App\Models\Exterieur;
use App\Models\Personnel;
use App\Models\Parametrage;
use App\Models\Specialite;

// A virer
// use App\Models\ProjetMotCle;
use App\Models\ProjetConvention;
// use App\Models\ProjetDocuments;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Storage;

class ProjetController extends Controller{
    public function ajouter(){
        $encadrants = Encadrant::getActifs();
        $exterieurs = Exterieur::getExterieurs();
        $etudiants = Etudiant::select('nom', 'prenom', 'login')->get();
        $filieres = Specialite::getFilieres();
        $options = Specialite::getOptions();

        $types_encadrant = Projet::getTypes("type_encadrant");
        $types_cadrage = Projet::getTypes("type_cadrage");
        $types_projet = Projet::getTypes("type_projet");

        return view('administration/projets/prop_proj', compact('encadrants','exterieurs','etudiants', 'types_encadrant', 'types_cadrage', 'types_projet', 'filieres','options'));
    }

    public function testEncadrants(Request $request){
        if(Str::contains(Projet::getStatuts()[0]->tags, "type_encadrant")){
            dd("yes");
        }else{
            dd("no");
        }
        dd(Encadrant::getActifs());
        dd(Exterieur::getExterieurs());
        dd($request);
    }

    public function postProj(Request $request){
        // $path = storage_path('app/tmp/uploads/');
        // $newPath = storage_path('app/module_projets/documents/');

        // dd($request);

        // if($request->prio === "non"){
        //     $request->prio = 0;
        // }else{
        //     $request->prio = 1;
        // }

        // if($request->confid === "non"){
        //     $request->confid = 0;
        // }else{
        //     $request->confid = 1;
        // }


        //creation de la référence du projet (composition : AA + P + motcle + HHMMSS; exemple "22Pmotcle102632")
        $cd = Carbon::now();
        $minYear = substr($cd->year, -2);
        $dateToConvert = [$cd->month, $cd->day, $cd->hour, $cd->minute, $cd->second];

        $newDate = [];
        foreach($dateToConvert as $dateUnit){
            $dateUnit = strval($dateUnit);
            if(strlen($dateUnit) == 1){
                $dateUnit = '0' . $dateUnit;
            }
            array_push($newDate, $dateUnit);
        }

        $ref = $minYear . 'P' . 'motcle' . $cd->hour . $cd->minute . $cd->second;

        // mise en de la String filière

        // $filiere = $request->specialite;
        // if($filiere === "info" || $filiere === "a&i"){
        //     $filiere = strtoupper($filiere);
        // }else{
        //     $filiere = ucfirst($filiere);
        // }

        //? Création du nouveau projet
        $projet = Projet::create([
            'reference' => $ref,
            'titre' => $request->nomProj,
            'projet_parent' => NULL,
            'entreprise_partenaire' => NULL,
            'resume' => $request->resume,
            'infos_complementaires' => $request->remarque,
            'annee_inge' => $request->annee_inge,
            'annee_scolaire' => AnneeScolaire::getAnneeActuelle(),
            'est_prioritaire' => $request->has("est_prioritaire")?1:0,
            'nb_places' => $request->nbEtudiants,
            'etat' => 'attente',
            'type_cadrage' => $request->cadrage,
            'est_confidentiel' => $request->has("est_confidentiel")?1:0,
            'budget' => $request->budget
        ]);

        $idprojet = Projet::select('id','reference')->where('reference', $ref)->first()->id;

        // if($request->nom !== null){
        //      $personnel = Personnel::find($request->nom);
        //      $personnel->projets()->attach($idprojet, ['encadrant' => $personnel->id, 'nb_heures_enseignement' => 15, 'statut' => 1, 'est_porteur_principal' => 0]);
        // }

        //? Pour insérer les encadrants rattachés au projet :
        $new_encadrants = $request->encadrants;
        foreach ($new_encadrants as $encadrant) {

            // Si c'est un nouvel encadrant
            if ($encadrant["id"] == "new"){
                // Création d'un nouveau personnel de type extérieur
                $token = Str::random(20);
                $newExterieur = Encadrant::create([
                    'prenom' => $encadrant["prenom"],
                    'nom' => $encadrant["nom"],
                    'type' => "ext",
                    'courriel_pro' => $encadrant["mail"],
                    "token" => $token,
                    "flag" => 0,
                    "uid" => $token,
                    "date_naiss" => "2000-01-01",
                    "photo" => "",
                    "adresse_perso" => "",
                    "adresse_pro" => "",
                    "cle_salle" => "",
                    "fonction" => "",
                    "responsabilites" => "",
                    "labo" => 0,
                    "remarques_admin" => "",
                    "remarques_perso" => "",
                    "date_connexion" => "2000-01-01",
                    "date_fin" => "2040-01-01",
                    "date_modif" => "2000-01-01",
                    "type" => "ext"
                ]);

                $projet->encadrants()->attach($newExterieur->id, ['type_encadrant' => intval($encadrant["type_encadrant"]), 'est_porteur_principal' => intval($encadrant["porteur_principal"]), 'nb_heures_enseignement' => intval($encadrant["nb_heures_enseignement"])]);
            }
            // Autre : Si l'encadrant existe déjà
            else{
                // Si c'est un personnel qui existe bien (càd que le select n'est pas vide) alors on insert
                // (normalement y'a quand même la vérif en front pour bloquer l'envoi du formulaire)
                if($encadrant["id"] != null){
                    $projet->encadrants()->attach(intval($encadrant["id"]), ['type_encadrant' => intval($encadrant["type_encadrant"]), 'est_porteur_principal' => intval($encadrant["porteur_principal"]), 'nb_heures_enseignement' => intval($encadrant["nb_heures_enseignement"])]);
                }
            }
        }

        //? Insertion des spécialités rattachées au projet
        if ($request->has("specialites")){
            $projet->specialites()->attach($request->specialites);
        }

        //? Insertion des mots-clés rattachés au projet
        if ($request->has("mots_cles")){
            $projet->mots_cles()->createMany($request->mots_cles);
        }

        //? Insertion des types définis au projet (RECHERCHE, LOCAL...)
        if ($request->has("types")){
            $projet->types()->attach($request->types);
        }

        //? Création d'une convention associée au projet si demandé lors de la création de la fiche projet
        if ($request->has("retribution")){
            $projet->convention()->create([
                'statut_convention' => 1,
                'statut_facturation' => 3,
                'retribution_financiere' => 0,
            ]);
        }

        if ($request->has('documents')){
            foreach($request->documents as $document){
                Storage::move('tmp/uploads/' . $document, 'module_projets/documents/' . $document);
                $projet->documents()->create(['nom' => $document, 'lien' => 'storage/module_projets/documents/' . $document, 'type' => 1, 'est_visible' => 1]);
            }
        }

        // if($request->has('retribution')){
        //     if($request->retribution === "oui"){
        //         ProjetConvention::create([
        //             'projet' => $idprojet,
        //             'etat_convention' => 'Attente rédaction',
        //             'retribution_financiere' => 0
        //         ]);
        //     }
        // }

        // $allowedImgExtension=['jpg','png','jpeg'];

        // if($request->hasFile('inputImage')){
        //     foreach($request->file('inputImage') as $image){
        //         $extension = $image->getClientOriginalExtension();
        //         if(in_array($extension, $allowedImgExtension)){
        //             $filename = $image->store('projets_illustrations');
        //         }
        //         ProjetDocuments::create([
        //             'projet' => $idprojet,
        //             'nom' => $image->hashName(),
        //             'lien' => 'projets_illustrations/'.$image->hashName(),
        //             'type' => 1,
        //             'est_visible' => 1
        //         ]);
        //     }
        // }

        // if($request->hasFile(('diapoRessource'))){
        //     $diapo = $request ->file('diapoRessource');
        //     $diapo = $diapo[0];
        //     $extension = $diapo->getClientOriginalExtension();
        //     if($extension == 'pdf'){
        //         $filename = $diapo->store('projets_illustrations');
        //     }
        //     ProjetDocuments::create([
        //         'projet' => $idprojet,
        //         'nom' => $diapo->hashName(),
        //         'lien' => 'projets_illustrations/'.$diapo->hashName(),
        //         'type' => 1,
        //         'est_visible' => 1
        //     ]);
        // }

        return redirect('/administration/projets');

    }

    public function edit($id){

        $projet = Projet::with("encadrants")->with("documents")->findOrFail($id);

        $etudiants = Etudiant::where("etudiant","oui")
        ->where("motif_sortie","")
        ->where("statut_delete",0)
        ->orderby('nom','ASC')
        ->get();

        $allEncadrants = Personnel::getEncadrants();

        return view('administration/projets/edit', compact('projet', 'etudiants', 'allEncadrants'));
    }

    public function update_projet(Request $request, $id){

        $projet = Projet::findOrFail($id);

        if($request->prio == "on"){
            $request->prio = 1;
        }else{
            $request->prio = 0;
        }

        if($request->confid == "on"){
            $request->confid = 1;
        }else{
            $request->confid = 0;
        }

        $filiere = $request->specialite;
        if($filiere === "info" || $filiere === "a&i"){
            $filiere = strtoupper($filiere);
        }else{
            $filiere = ucfirst($filiere);
        }

        // Mise à jour des infos du projet
        $projet->titre = $request->nomProj;
        $projet->resume = $request->resume;
        $projet->infos_complementaires = $request->remarque;
        // $projet->annee_inge_cible = $request->annee_inge_cible;
        $projet->annee_scolaire = $request->annee_scolaire;
        $projet->etat = $request->etat;
        $projet->est_prioritaire = $request->prio;
        $projet->est_confidentiel = $request->confid;
        $projet->cadrage = $request->cadrage;
        $projet->budget = $request->budget;
        $projet->nb_places = $request->nbEtudiants;

        $projet->save();

        // Mise à jour des mots clés
        if($request->mots_cles){
            $projet->mots_cles()->delete();
            $projet->mots_cles()->createMany($request->mots_cles);
        }

        // Mise à jour des étudiants du projet
        if($request->etudiants){
            $projet->etudiants()->syncWithPivotValues($request->etudiants, ['annee_scolaire' => $request->annee_scolaire]);
        }

        // Mise à jour des encadrants du projet
        if($request->encadrants){
            $projet->encadrants()->syncWithPivotValues($request->etudiants, ['annee_scolaire' => $request->annee_scolaire]);
        }

        //Suppression des photos
        // if ($request->deletePhotoIds != null) {
        //     foreach($request->deletePhotoIds as $id) {
        //         ProjetDocuments::where('id', $id)
        //             ->where('projet', $projet->id)
        //             ->delete();
        //     }
        // }

        // Mise à jour des images d'illustration'
        if ($request->hasFile('photos')) {
            $allowedfileExtension = ['jpg','png','jpeg'];
            $files = $request->file('photos');
            foreach($files as $file){
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if($check) {

                    $filename = $file->store('projets_illustrations');

                    ProjetDocuments::create([
                        'projet' => Projet::select('id','reference')->where('id', $id)->first()->id,
                        'nom' => $file->hashName(),
                        'lien' => 'projets_illustrations/'.$file->hashName(),
                        'type' => 1,
                        'est_visible' => 1
                    ]);
                }
            }
        }

        // toastr()->success(__('validation.product.updated.success'));

        $etudiants = Etudiant::where("etudiant","oui")
        ->where("motif_sortie","")
        ->where("statut_delete",0)
        ->orderby('nom','ASC')
        ->get();

        return view('administration/projets/edit', ['projet' => $projet, 'etudiants' => $etudiants]);
    }

    public function delete($id){

        $projet = Projet::findOrFail($id);
        $projet->delete();

        toastr()->success(__('validation.projet.deleted.success'));

        return redirect()->route('administration.projets.dashboard');
    }

    public function projets() {

        $projets = Projet::with("encadrants")->with("specialites")->get();

        // function getRandomString($n) {
        //     $characters = 'abcdefghijklmnopqrstuvwxyz';
        //     $randomString = '';

        //     for ($i = 0; $i < $n; $i++) {
        //         $index = rand(0, strlen($characters) - 1);
        //         $randomString .= $characters[$index];
        //     }

        //     return $randomString;
        // }

        // function getRandomInt($n) {
        //     $characters = '0123456789';
        //     $randomString = '';

        //     for ($i = 0; $i < $n; $i++) {
        //         $index = rand(0, strlen($characters) - 1);
        //         $randomString .= $characters[$index];
        //     }

        //     return $randomString;
        // }

        // foreach($projets as $projet){
        //     $minA = substr($projet->annee_scolaire, 2, 2);
        //     $motcle;
        //     if(strpos($projet->reference, '_')){
        //         $arr = explode("_", $projet->reference);
        //         if($arr[1] !== ''){
        //          $motcle = (($arr[1]));
        //         }else{
        //             $motcle = getRandomString(7);
        //         }
        //     }else{
        //         $motcle = getRandomString(7);
        //     }
        //     $time = getRandomInt(6);

        //     $projet->reference = $minA . 'P' . $motcle . $time;
        //     $projet->save();
        // }

        return view('administration/projets/dashboard', ['projets' => $projets]);

    }


    public function affectation(){

        $projets = Projet::with("specialites")->where("annee_scolaire","2021-2022")
        // ->where("annee_inge_cible","4A")
        //->where("etat","soumis")
        //->orderby('specialite','ASC')
        // ->whereHas('specialites', function ($query) {
        //     $query->where('specialite','=',1);
        // })
        ->orderby('titre','ASC')
        ->get();


        // foreach($projets as $projet) {
        //     dd($projet->specialites);
        // }

        $etudiants = Etudiant::where("etudiant","oui")
        ->where("motif_sortie","")
        ->where("promo","4A")
        ->orderby('nom','ASC')
        ->get();

        return view('administration/projets/affectation', ['projets' => $projets, 'etudiants' => $etudiants]);
    }

    public function filtre_affectation(Request $request){

        $options = Specialite::getOptions()->where("filiere",1);

        $tab = array();
        foreach($options as $test){
            array_push($tab, $test->acronyme);
        }

        $projets = Projet::with("specialites")->where("annee_scolaire",$request->annee_scolaire)
        ->where("annee_inge_cible",$request->promo)
        //->orderby('filiere','ASC')
        // ->whereHas('specialites', function ($query) {
        //     $query->where('specialite','=',"VA");
        // })
        ->orderby('titre','ASC')
        ->get();

        $etudiants = Etudiant::where("etudiant","oui")
        ->where("motif_sortie","")
        ->where("promo",$request->promo)
        ->where("alternance",$request->cursus)
        ->orderby('nom','ASC')
        ->get();

        return view('administration/projets/affectation', ['projets' => $projets, 'etudiants' => $etudiants]);
    }

    public function parametre(){

        $periodeDepot = Projet::getParametre("periodeDepot");

        $periodeVoeux = Projet::getParametre("periodeVoeux");

        $personnels = Personnel::getEncadrants();

        $responsableProjets3A = Personnel::getUsersByRole("RESPPROJETS_3A")->first();
        $responsableProjets4A5A = Personnel::getUsersByRole("RESPPROJETS_4A5A")->first();

        return view('administration/projets/parametres',  compact('personnels','responsableProjets3A','responsableProjets4A5A', 'periodeDepot', 'periodeVoeux'));
    }

    public function add_parametre(Request $request){

        // $rules = [
		// 	'personnel_id' => [
		// 		'required',
		// 		'string',
		// 		'exists:personnels,uid',
		// 	],
		// ];

		// $messages = [
		// 	'personnel_id.exists' => __('validation.not_found.staff'),
		// ];

        // $validator = \Validator::make($request->all(), $rules, $messages);

        // if ($validator->fails()) {
        //     toastr()->error(__('validation.responsable.added.error'));
        //     return redirect()->back()->withInput()->withErrors($validator);
        // }

        // firstOrCreate ------------>$_COOKIE


        // Modification de la date de dépôt des projets
        Parametrage::updateOrCreate(
            ['module' =>  7,'cle' => "periodeDepot"],
            ['valeur' => $request->periodeDepot, 'resume' => '']
        );

        // Modification de la date des voeux des étudiants
        Parametrage::updateOrCreate(
            ['module' =>  7,'cle' => "periodeVoeux"],
            ['valeur' => $request->periodeVoeux, 'resume' => '']
        );

        // Modifier le responsable des projets 3A
        $idRoleResponsable3A = Role::getRoleIdByPrefix("RESPPROJETS_3A");

        if ($request->responsable3A != "") {
            DB::table("utilisateurs_x_roles")
            ->updateOrInsert(
                ['role' => $idRoleResponsable3A],
                ['utilisateur' => $request->responsable3A]
            );
        }else{
            DB::table("utilisateurs_x_roles")->whereRole($idRoleResponsable3A)->delete();
        }

        // Modifier le responsable des projets 4A 5A
        $idRoleResponsable4A5A = Role::getRoleIdByPrefix("RESPPROJETS_4A5A");

        if ($request->responsable4A5A != "") {
            DB::table("utilisateurs_x_roles")
            ->updateOrInsert(
                ['role' => $idRoleResponsable4A5A],
                ['utilisateur' => $request->responsable4A5A]
            );
        }else{
            DB::table("utilisateurs_x_roles")->whereRole($idRoleResponsable4A5A)->delete();
        }


        toastr()->success(__('validation.responsable.added.success'));

        return redirect()->route('administration.projets.parametres');
    }

    public function insertProj(){

    }
}
