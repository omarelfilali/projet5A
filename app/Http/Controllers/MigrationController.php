<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Projet;
use App\Models\Personnel;
use App\Models\Etudiant;
use App\Models\Exterieur2;
use App\Models\FicheInternationale;
use App\Models\AnneeScolaire;
use App\Models\ProjetMotCle;
use App\Models\Parametrage;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Support\Arr;
use Adldap\Laravel\Facades\Adldap;

class MigrationController extends Controller
{

    public function samy(){

        // $response = Http::get("https://data.education.gouv.fr/api/records/1.0/search/?dataset=fr-en-calendrier-scolaire&q=&sort=-start_date&refine.zones=Zone+B&refine.location=Nantes&refine.description=D%C3%A9but+des+Vacances+d%27%C3%89t%C3%A9");
        // dd($response);
        dd(AnneeScolaire::getAnneeActuelle());

        $projet = Projet::find(5);
        dd($projet->getFiliereCible());

        $etudiants = DB::table("inscriptions3")->get();
        foreach ($etudiants as $etudiant) {

            // INSERT INTO langue(nom) VALUES("Anglais"),("Italien"),("Arabe"),("Francais"),("Allemand"),("Espagnol"),("Japonais"),("Suedois"),("Chinois"),("Latin"),("Russe"),("Portugais"),("Malais"),("Brésilien"),("Norvégien"),("Danois"),("Breton"),("Espéranto"),("Wolof"),("Néerlandais"),("Polonais"),("Gabonais"),("Libanais"),("Catalan"),("Fondjomekwet"),("Turc"),("Occitan"),("Vietnamien"),("Khmer"),("Cinghalais"),("Bassa (cameroun)"),("Féfé (cameroun)"),("Coréen"),("Alsacien"),("Bambara"),("Corse"),("Mandarin"),("Fon"),("Goun"),("Tchétchène"),("Tamoul"),("Yoruba"),("Amazigh"),("Tahitien"),("Arabe tunisien"),("Roumain"),("Sri Lankais"),("Grec"),("Moore"),("Kabyle");
            $langues = [];
            $niveaux_langues_phrase = ["Notions", "Comprise", "Courante"];
            $niveaux_langues_chiffre = ["1", "3", "5"];

            $langue1 = str_replace($niveaux_langues_phrase, $niveaux_langues_chiffre, $etudiant->langue_1);
            $langue2 = str_replace($niveaux_langues_phrase, $niveaux_langues_chiffre, $etudiant->langue_2);
            $langue3 = str_replace($niveaux_langues_phrase, $niveaux_langues_chiffre, $etudiant->langue_3);

            $langues[1] = explode("££", $langue1);
            $langues[2] = explode("££", $langue2);
            $langues[3] = explode("££", $langue3);

            foreach ($langues as $langue) {

                if ($langue[0] != ""){

                    if ($langue[1] == ""){
                        $langue[1] = 2;
                    }
                    if ($langue[2] == ""){
                        $langue[2] = 2;
                    }
                    if ($langue[3] == ""){
                        $langue[3] = 2;
                    }

                    $id_langue = DB::table("langue")->whereNom(ucwords(strtolower($langue[0])))->first();
                    if(!$id_langue){
                        dd($etudiant);
                    }

                    DB::table("DE_langues")->insert([
                        "utilisateur" => $etudiant->id,
                        "langue" => $id_langue->id,
                        "niveau_lue" => $langue[1],
                        "niveau_parlee" => $langue[2],
                        "niveau_ecrite" => $langue[3]
                    ]);
                }
            }
        }

        dd("ok");

        $personnel = DB::table("personnels")->get();
        dd($personnel);

        foreach ($personnel as $p) {

            $p->nom = ucwords(strtolower($p->nom));
            $p->prenom = ucwords(strtolower($p->prenom));

            if (Str::contains($p->nom, "'") || Str::contains($p->prenom, "'")){
                $p->nom = implode("'", array_map('ucfirst', explode("'", $p->nom)));
                $p->prenom = implode("'", array_map('ucfirst', explode("'", $p->prenom)));
            }

            if (Str::contains($p->nom, "-") || Str::contains($p->prenom, "-")){
                $p->nom = implode("-", array_map('ucfirst', explode("-", $p->nom)));
                $p->prenom = implode("-", array_map('ucfirst', explode("-", $p->prenom)));
            }

            DB::table("personnels")->whereId($p->id)->update([
                "nom" => $p->nom,
                "prenom" => $p->prenom
            ]);
        }



        dd($personnel);

        $login = cas()->user();
        $user = Personnel::whereUid($login)->first();

        $test = "MatHieU RaULT";
        dd(ucwords(strtolower($test)));

        dd(Role::getRoleIdByPrefix("ALU"));
        dd(Personnel::getUsersByRole("RESPPROJETS_3A")->first()->uid);


        //? Update or create
        // Parametrage::updateOrCreate(
        //     ['module' => 7, 'cle' => "Mathieu"],
        //     ['valeur' => "Mathieu est un h2"]
        // );


        //? Insérer des données dans une table pivot depuis une autre table (BONNE VERSION)
        // $projet = Projet::find(1);

        // $mots_cles = [new ProjetMotCle(["mot_cle" => "concombre"]),
        //               new ProjetMotCle(["mot_cle" => "salutt"])
        //             ];
        // $projet->mots_cles()->saveMany($mots_cles);
        // dd("yes");

        //? Utilisation des données récupérées depuis un pivot
        // $projets = Projet::with("encadrants")->first();
        // dd($projets->encadrants[0]->pivot->nb_heures_enseignement);

        //? Insérer des données dans une table pivot depuis une autre table
        // $projet = Projet::find(2);
        // $tableau = [];
        // $tableau[34] = ['nb_heures_enseignement' => 99];
        // $tableau[35] = ['nb_heures_enseignement' => 98];
        // $projet->encadrants()->attach($tableau);

        //? Je sais pas trop quoi faire de ça :
        // $projet = Projet::find(2);
        // $tableau["zineb.kabbab"][] = ['annee_scolaire' => "2016-2017"];
        // $tableau["zineb.kabbab"][] = ['annee_scolaire' => "2017-2018"];

        // foreach ($tableau as $id => $valeurs) {
        //     foreach ($valeurs as $valeur){
        //         $annee_scolaire = $valeur['annee_scolaire'];
        //         $projet->etudiants()->attach($id, ['annee_scolaire' => $annee_scolaire]);
        //     }
        // }
    }

    public function exterieursToPersonnels(){

        $personnel = DB::table("personnels")->get();

        foreach ($personnel as $p) {

            $p->nom = ucwords(strtolower($p->nom));
            $p->prenom = ucwords(strtolower($p->prenom));

            if (Str::contains($p->nom, "'") || Str::contains($p->prenom, "'")){
                $p->nom = implode("'", array_map('ucfirst', explode("'", $p->nom)));
                $p->prenom = implode("'", array_map('ucfirst', explode("'", $p->prenom)));
            }

            if (Str::contains($p->nom, "-") || Str::contains($p->prenom, "-")){
                $p->nom = implode("-", array_map('ucfirst', explode("-", $p->nom)));
                $p->prenom = implode("-", array_map('ucfirst', explode("-", $p->prenom)));
            }

            DB::table("personnels")->whereId($p->id)->update([
                "nom" => $p->nom,
                "prenom" => $p->prenom
            ]);
        }

        // $personnels = Personnel::select("prenom","nom")->orderBy('prenom')->get();
        $exterieurs = DB::table('projet_encadrant')->where("id_encadrant", "null")->orderBy('prenom')->get();
        // $tableauPersonnels = [];
        $avoidRepeat = [];

        // foreach($personnels as $personnel){
        //     $personnel->prenom = iconv('UTF-8','ASCII//TRANSLIT',trim(ucfirst(trans(Str::lower($personnel->prenom)))));
        //     $personnel->nom = iconv('UTF-8','ASCII//TRANSLIT',trim(ucfirst(trans(Str::lower($personnel->nom)))));
        //     $fiche = ["prenom" => $personnel->prenom, "nom" => $personnel->nom];
        //     $tableauPersonnels[] = $fiche;
        // }

        foreach($exterieurs as $exterieur){
            dd($exterieurs);
            $exterieur->prenom = iconv('UTF-8','ASCII//TRANSLIT',trim(ucfirst(trans(Str::lower($exterieur->prenom)))));
            $exterieur->nom = iconv('UTF-8','ASCII//TRANSLIT',trim(ucfirst(trans(Str::lower($exterieur->nom)))));

            $fiche = [
                "prenom" => $exterieur->prenom,
                "nom" => $exterieur->nom,
                "courriel_pro" => $exterieur->mail,
                "tel_pro1" => $exterieur->telephone,
                "employeur" => $exterieur->structure,
            ];

            if($fiche["prenom"] != null || $fiche['nom'] != null){
                $avoidRepeat[] = $fiche;
            }
        }

        $avoidRepeat = array_unique($avoidRepeat, SORT_REGULAR);

        // $result = array_diff($avoidRepeat, $tableauPersonnels);
        // dd($result);

        foreach ($avoidRepeat as $newExterieur) {
            $token = Str::random(20);
            $newExterieur = Personnel::create([
                'prenom' => $newExterieur["prenom"],
                'nom' => $newExterieur["nom"],
                'type' => "ext",
                'courriel_pro' => $newExterieur["mail"],
                'tel_pro1' => $newExterieur["telephone"],
                'employeur' => $newExterieur["structure"],
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
            ]);
        }
    }

    public function migrationProjets(){
        //! Décommenter lors de la migration sur la vraie BDD
        //! Permet de remplacer les anciennes filiaires par les nouvelles (important car lien avec la table ORIENTATION);
        //? DB::table('projet')->where('filiere', 'VAC')->update(['filiere' => "A&I"]);

        $old_projets = DB::table('projet')->get();

        //* Boucle pour ajouter tous les projets dans la nouvelle table NEW_projet et autres nouvelles tables associées
        foreach ($old_projets as $index => $old_projet){

            // Cette variable permet de remettre au bon format l'année scolaire du projet
            // On passe alors de "20162017" (ne fonctionne pas avec la nouvelle BDD) à "2016-2017" (fonctionne)
            $CORRECTIF_annee = substr($old_projet->annee, 0, 4). "-" . substr($old_projet->annee, 4);

            // Si la reference du projet est vide alors on génère une chaîne de 50 caractères randoms
            if($old_projet->reference == ""){
                $old_projet->reference = Str::random(50);
            }

            // Si l'année ingé est vide, alors on met "Toutes"
            if($old_projet->annee_inge == ""){
                $old_projet->annee_inge = "Toutes";
            }

            // Permet de rattacher l'id de l'entreprise en fonction du nom détécté. Nécessitera sûrement des changements à faire à la main
            // lors du passage de la vraie BDD
            switch ($old_projet->partenaire) {
                case 'ENSIM':
                    $entreprise = 547;
                    break;

                case 'LAUM':
                    $entreprise = 588;
                    break;

                default:
                    $entreprise = null;
                    break;
            }

            // Permet de migrer plusieurs champs vers l'unique champ résumé si le projet n'en contient pas déjà
            $resume = "";

            if ($old_projet->resume == ""){
                if($old_projet->situation_actuelle != ""){
                    $resume = "Situation actuelle :\r\n{$old_projet->situation_actuelle}\r\n\r\n";
                }

                if($old_projet->objectif_besoin != ""){
                    $resume = $resume . "Objectifs : \r\n{$old_projet->objectif_besoin}\r\n\r\n";
                }

                if($old_projet->outils != ""){
                    $resume = $resume . "Outils / documents à produire: \r\n{$old_projet->outils}\r\n\r\n";
                }

                if($old_projet->clients_finaux != ""){
                    $resume = $resume . "Clients finaux : \r\n{$old_projet->clients_finaux}\r\n\r\n";
                }

                if($old_projet->impacts != ""){
                    $resume = $resume . "Impacts du projet : \r\n{$old_projet->impacts}\r\n\r\n";
                }

                if($old_projet->limites_contraintes != ""){
                    $resume = $resume . "Limites et contraintes : \r\n{$old_projet->limites_contraintes}\r\n\r\n";
                }

                if($old_projet->mesures != ""){
                    $resume = $resume . "Mesures démontrant le succès du projet : \r\n{$old_projet->mesures}\r\n\r\n";
                }

                if($old_projet->autres_considerations != ""){
                    $resume = $resume . "Autres considérations : \r\n{$old_projet->autres_considerations}";
                }
            }else{
                $resume = $old_projet->resume;
            }

            // Si le projet n'a pas de nb_places défini (ce qui NORMALEMENT ne doit pas être le cas) alors on met 99 places temporairement
            if ($old_projet->nb_places == null){
                $old_projet->nb_places = 99;
            }

            // Traduction du type de cadrage en int
            switch ($old_projet->cadrage) {
                case 'Convention ENSIM':
                    $old_projet->cadrage = 7;
                    break;

                case 'Ne sait pas':
                    $old_projet->cadrage = 9;
                    break;

                case 'Pas de cadrage envisagé':
                    $old_projet->cadrage = null;
                    break;

                case 'Contrat IPREX':
                    $old_projet->cadrage = 8;
                    break;

                default:
                    $old_projet->cadrage = null;
                    break;
            }

            // Création du projet dans la nouvelle table NEW_projet
            $projet = Projet::create([
                'id' => $old_projet->id,
                'reference' => $old_projet->reference,
                'titre' => $old_projet->titre,
                'entreprise_partenaire' => $entreprise,
                'resume' => empty($resume) ? null : $resume,
                'infos_complementaires' => empty($old_projet->info_complementaire) ? null : $old_projet->info_complementaire,
                'annee_inge' => $old_projet->annee_inge,
                'annee_scolaire' => $CORRECTIF_annee,
                'est_prioritaire' => $old_projet->est_prioritaire,
                'nb_places' => $old_projet->nb_places,
                'etat' => $old_projet->etat,
                'type_cadrage' => $old_projet->cadrage,
                'est_confidentiel' => $old_projet->est_confidentiel,
                'budget' => empty($old_projet->budget) ? null : $old_projet->budget,
            ]);

            if($old_projet->nature != "" && $old_projet != null){
                switch (rtrim($old_projet->nature)) {
                    case 'LOCAL':
                        $old_projet->nature = 3;
                        break;

                    case 'RECH':
                        $old_projet->nature = 4;
                        break;

                    case 'INDUS':
                        $old_projet->nature = 5;
                        break;

                    case 'EXT':
                        $old_projet->nature = 6;
                        break;
                }

                //? Ajout du type de projet dans la table projet_type
                $projet->types()->attach($old_projet->nature);
            }

            //? Ajout des spécialités ciblées par le projet
            if($old_projet->specialite != null && $old_projet->specialite != ""){
                $specialites = explode(",", $old_projet->specialite);
                foreach ($specialites as $specialite) {
                    switch ($specialite) {

                        // Si la spécialité = VA
                        case '11':
                            $projet->specialites()->attach(3);
                            break;

                        // Si la spécialité = C&I
                        case '12':
                            $projet->specialites()->attach(4);
                            break;

                        // Si la spécialité = ASTRE
                        case '21':
                            $projet->specialites()->attach(5);
                            break;

                        // Si la spécialité = IPS
                        case '22':
                            $projet->specialites()->attach(6);
                            break;

                        default:
                            dd("Erreur, vérifier si les spécialités sont au bon format");
                            break;
                    }
                }
            }elseif ($old_projet->filiere != null && $old_projet->filiere != "") {
                switch ($old_projet->filiere) {
                    case 'VAC':
                        $projet->specialites()->attach(3);
                        $projet->specialites()->attach(4);
                        break;

                    case 'INFO':
                        $projet->specialites()->attach(5);
                        $projet->specialites()->attach(6);
                        break;

                    case 'Transversal':
                        $projet->specialites()->attach(3);
                        $projet->specialites()->attach(4);
                        $projet->specialites()->attach(5);
                        $projet->specialites()->attach(6);
                        break;
                }
            }else{
                dd("Erreur, le projet n'a ni spécialités ni filiere...");
            }

            //? Ajout de la convention du projet dans la table projet_convention (pour les projets concernés)
            if ($old_projet->etat_convention != "" || $old_projet->etat_facturation != "" || $old_projet->budget_retribution != "" && $old_projet->budget_retribution != 0 || $old_projet->commentaire_retribution != ""){
                $CORRECTIF_budget = intval(preg_replace('/[^0-9]+/', '', $old_projet->budget_retribution), 10);
                if($old_projet->etat_convention == "Convention signée"){
                    $old_projet->etat_convention = 2;
                }else{
                    $old_projet->etat_convention = 1;
                }

                $projet->convention()->create([
                    "statut_convention" => $old_projet->etat_convention,
                    "statut_facturation" => 3,
                    "retribution_financiere" => $CORRECTIF_budget,
                    "commentaire_retribution" => $old_projet->commentaire_retribution
                ]);
            }

            //? Ajout des étudiants impliqués dans les projets dans la table etudiants_x_projets (ne migre pas les classements des projets par les étudiants)
            $old_projet_etudiants = DB::table('projet_etudiant')->where("id_projet", $projet->id)->get();

            foreach ($old_projet_etudiants as $index => $old_projet_etudiant) {
                $CORRECTIF_annee = substr($old_projet_etudiant->annee_projet, 0, 4). "-" . substr($old_projet_etudiant->annee_projet, 4);
                $etudiant = Etudiant::select("login")->where("id", $old_projet_etudiant->id_etudiant)->first();
                try{
                    $projet->etudiants()->attach($etudiant->login, ['annee_scolaire' => $CORRECTIF_annee]);
                }catch(\Exception $e){}
            }

            //? Ajout des encadrants de projet dans la table projets_x_encadrants
            //! Si ça bug c'est probablement que l'id de l'encadrant n'existe plus dans la table personnel (le id 20 notamment)
            $old_encadrants = DB::table('projet_encadrant')->where("id_projet", $projet->id)->get();

            foreach ($old_encadrants as $encadrant) {
                $encadrant->prenom = trim($encadrant->prenom);
                $encadrant->nom = trim($encadrant->nom);

                //? Nouveau format des rôles des encadrants avant insertion
                $is_porteur = 0;
                switch ($encadrant->role) {
                    case 'Encadrant / porteur ':
                        $encadrant->role = 1;
                        $is_porteur = 1;
                        break;

                    case 'ref':
                        $encadrant->role = 2;
                        break;

                    case 'encadrant':
                        $encadrant->role = 1;
                        break;

                    default:
                        $encadrant->role = 1;
                        break;
                }

                if ($encadrant->id_encadrant != 0){
                    try{
                        $projet->encadrants()->attach($encadrant->id_encadrant, ['nb_heures_enseignement' => $encadrant->nbHeuresEnseignement, 'type_encadrant' => $encadrant->role, 'est_porteur_principal' => $is_porteur]);
                    }catch(\Exception $e){}
                }else{
                    $findEncadrant = DB::table('personnels')->where("prenom", "like", "%".$encadrant->prenom."%")->where("nom","like","%".$encadrant->nom."%")->first();
                    if ($findEncadrant == null){
                        dd($encadrant);
                    }

                    try{
                        $projet->encadrants()->attach($findEncadrant->id, ['nb_heures_enseignement' => $encadrant->nbHeuresEnseignement, 'type_encadrant' => $encadrant->role, 'est_porteur_principal' => 0]);
                    }catch(\Exception $e){}
                }
            }


        }

        //? Cette partie la permet de définir les encadrants porteurs de projet

        //V2

        $projets = Projet::all();

        foreach ($projets as $projet) {
            $aucunPorteur = true;
            $nbPorteurs = 0;
            $encadrants = DB::table('projets_x_encadrants')->whereProjet($projet->id)->get();

            foreach ($encadrants as $encadrant) {
                if ($encadrant->est_porteur_principal == 1){
                    $aucunPorteur = false;
                    $nbPorteurs++;
                }
            }

            if ($nbPorteurs>1){
                DB::table('projets_x_encadrants')->whereProjet($projet->id)->update(['est_porteur_principal' => 0]);
                $aucunPorteur = true;
            }

            if ($aucunPorteur){
                DB::table('projets_x_encadrants')->whereProjet($projet->id)->limit(1)->update(['est_porteur_principal' => 1]);
            }
        }

    }

    public function migrationInternational(){
        $old_relinter_projets = DB::table('relinter_projets')->get();

        foreach ($old_relinter_projets as $index => $old_relinter_projet){

            // Ces variables permettent de mettre au bon format l'année scolaire du projet international
            // On passe alors de "2016" (ne fonctionne pas avec la nouvelle BDD) à "2016-2017" (fonctionne)
            $annee_n = $old_relinter_projet->annee;
            $annee_n1 = $old_relinter_projet->annee + 1;
            $annee_scolaire = "{$annee_n}-{$annee_n1}";

            if ($old_relinter_projet->annee == 0){
                $annee_scolaire = "undefined";
            }

            // Correction id de l'entreprise rattachée
            //! PAR CONTRE certaines entreprises sont renseignées sans id, comment on fait ?
            if ($old_relinter_projet->org_id == 0){
                $old_relinter_projet->org_id = null;
            }

            //! CETTE ENTREPRISE N'EXISTE PAS DONC ON MET PAS D'ENTREPRISE
            if ($old_relinter_projet->org_id == 1288){
                $old_relinter_projet->org_id = null;
            }

            //! Correction de la date de création
            if ($old_relinter_projet->creation_date == null || $old_relinter_projet->creation_date == "0000-00-00"){
                $old_relinter_projet->creation_date = null;
            }

            //! Correction des dates début et date fin de projet international
            if ($old_relinter_projet->date_debut == "0000-00-00"){
                $old_relinter_projet->date_debut = null;
            }
            if ($old_relinter_projet->date_fin == "0000-00-00"){
                $old_relinter_projet->date_fin = null;
            }

            //! CET ETUDIANT N'EXISTE PAS DONC ON SORT DE LA CREATION
            if ($old_relinter_projet->etu_id != 4823){
                $fiche_internationale = FicheInternationale::create([
                    'id' => $old_relinter_projet->id,
                    'etudiant' => $old_relinter_projet->etu_id,
                    'annee_scolaire' => $annee_scolaire,
                    'type' => $old_relinter_projet->type,
                    'entreprise' => $old_relinter_projet->org_id,
                    'date_debut' => $old_relinter_projet->date_debut,
                    'date_fin' => $old_relinter_projet->date_fin,
                    'compte_rendu' => $old_relinter_projet->cr_ri,
                    'remarques_etudiant' => $old_relinter_projet->remarques_etu,
                    'remarques_ri' => $old_relinter_projet->remarques,
                    'date_creation' => $old_relinter_projet->creation_date
                ]);

                //? Migration des statuts de projets dans une toute nouvelle table sous un nouveau format
                $fiche_internationale->migration_statut("proposition_projet", $old_relinter_projet->statut);
                $fiche_internationale->migration_statut("realisation_projet", $old_relinter_projet->validation);
            }
        }
    }

    public function migrationOldUsersToUtilisateur(){

        ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
        set_time_limit(300);
        
        //? Migration table personnels
        $personnels = DB::table("personnels")->get();
        
        foreach ($personnels as $personnel) {

            $personnel->nom = ucwords(strtolower($personnel->nom));
            $personnel->prenom = ucwords(strtolower($personnel->prenom));

            switch ($personnel->civilite) {
                case 'Mr':
                    $personnel->civilite = 1;
                    break;
                case 'Mme':
                    $personnel->civilite = 2;
                    break;
                default:
                    $personnel->civilite = 0;
                    break;
            }

            if($personnel->type == "ext"){
                $role_nom = "ext";
                $personnel->role = 5;
                $personnel->cas = 0;
            }else {
                $role_nom = "pers";
                $personnel->role = 3;
                $personnel->cas = 1;
            }

            $utilisateur = DB::table("utilisateur")->where('old_id', "=", $personnel->id )->where('role', "=", $personnel->role )->first();
            
            //? On importe tous les personnels sauf "Fiche Virtuelle : A Conserver"
            if($personnel->id !== 0){ 
                Utilisateur::updateOrCreate( 
                    ['old_id' => $personnel->id, 'role' => $personnel->role],
                    ['id' => isset($utilisateur->id) ? $utilisateur->id : (empty($personnel->uid) ? Utilisateur::generateNewId($role_nom) : $personnel->uid),
                    'old_id' => $personnel->id,
                    'prenom' => $personnel->prenom,
                    'nom' => $personnel->nom,
                    'role' => $personnel->role,
                    'password' => Hash::make($personnel->pass),
                    'genre' => $personnel->civilite,
                    'mail' => $personnel->courriel_pro,
                    'photo' => $personnel->photo,
                    'droit_image' => 0,
                    'securite_sociale' => !empty($personnel->num_insee) ? $personnel->num_insee : "",
                    'remember_token' => null,
                    'date_creation' => now(),
                    'date_connexion' => ($personnel->date_connexion == "0000-00-00 00:00:00") ? $personnel->date_connexion = "2000-01-01" : $personnel->date_connexion,
                    'is_locked' => ($personnel->del == 0 ? null : 1),
                    'cas' => $personnel->cas]
                );
            }
            
        }

        //? Migration table inscriptions2
        
        $users = DB::table("inscriptions2")->where('statut_delete','==','0')->get();

        foreach($users as $user){

            switch ($user->civilite) {
                case 'Mr':
                    $user->civilite = 1;
                    break;

                case 'Mme':
                    $user->civilite = 2;
                    break;

                default:
                    $user->civilite = 0;
                    break;
            }

            switch ($user->statut_delete) {
                case 0:
                    $user->statut_delete = null;
                    break;

                case 1:
                    $user->statut_delete = 1;
                    break;
            }
            
            if($user->date_constitution_dossier == "0000-00-00" || empty($user->date_constitution_dossier) || !isset($user->date_constitution_dossier)){
                $user->date_constitution_dossier = "2000-01-01";
            }

            //? Vérifie le type d'utilisateur : Etudiant / Candidat / Alumnus

            if($user->motif_sortie=="" && $user->etudiant=="oui"){ // ETUDIANT
                $role_nom = "etu";
                $role = 4;
                $droit_image = 0;
                $user->cas = 1;
            }elseif($user->motif_sortie!=="" && $user->etudiant=="oui"){ // ALUMNUS
                $role_nom = "alu";
                $role = 2;
                $droit_image = 0;
                $user->cas = 0;
            }else{
                $role_nom = "can";
                $role = 1;
                $droit_image = 0;
                $user->cas = 0;
            }

            $utilisateur2 = DB::table("utilisateur")->where('old_id', "=", $user->id )->where('role', "=", 4 )->first();

            if(isset($user->uuid_udm) && !empty($user->uuid_udm)){
                $infos_ldap = Adldap::search()->where('uid', '=', $user->uuid_udm)->first();

                if(isset($infos_ldap->umdroitimg[0])){
                    $droit_image = ($infos_ldap->umdroitimg[0] == TRUE ? 1 : 0);
                }else{
                    $droit_image = 0;
                }
            }else{
                $droit_image = 0;
            }
            
            Utilisateur::updateOrCreate(
                ['old_id' => $user->id, 'role' => 4],
                ['id' => isset($utilisateur2->id) ? $utilisateur2->id : (empty($user->uuid_udm) ? Utilisateur::generateNewId($role_nom) : $user->uuid_udm),
                'old_id' => $user->id,
                'prenom' => $user->prenom,
                'nom' => $user->nom,
                'role' => $role,
                'password' => Hash::make($user->mdp_hash),
                'genre' => $user->civilite,
                'mail' => $user->mail_UDM,
                'photo' => $user->photo,
                'droit_image' => $droit_image,
                'securite_sociale' => null,
                'remember_token' => null,
                'date_creation' => $user->date_constitution_dossier . " 00:00:00",
                'date_connexion' => $user->date_derniere_consultation,
                'is_locked' => ($personnel->del == 0 ? null : 1),
                'cas' => $user->cas]
            );

        }

    }

}
