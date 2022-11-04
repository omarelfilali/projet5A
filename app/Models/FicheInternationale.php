<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InternationalStatut;
use App\Models\Etudiant;
use App\Models\Entreprise;
use Illuminate\Support\Carbon;

class FicheInternationale extends Model
{
    use HasFactory;
    protected $table = 'fiche_internationale';
    protected $primaryKey = "id";
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'etudiant',
        'annee_scolaire',
        'type',
        'entreprise',
        'date_debut',
        'date_fin',
        'compte_rendu',
        'remarques_etudiant',
        'remarques_ri',
        'date_creation',
        'date_maj'
    ];

    const CREATED_AT = 'date_creation';
    const UPDATED_AT = 'date_maj';

    public function etudiant()
    {
      return $this->belongsTo('App\Models\Etudiant', 'etudiant' , 'id')->first();
    }

    public function entreprise()
    {
        return $this->belongsTo('App\Models\Entreprise', 'entreprise' , 'id')->first();
    }

    public function getDateDebut(){
        return Carbon::parse($this->date_debut)->format('d/m/Y');
    }

    public function getDateFin(){
        return Carbon::parse($this->date_fin)->format('d/m/Y');
    }

    public function getDateCreation(){
        return Carbon::parse($this->date_creation)->format('d/m/Y');
    }

    public function getPeriode(){
        return Carbon::parse($this->date_debut)->diffInDays(Carbon::parse($this->date_fin));
    }

    public function getLastStatutProposition(){
        $statut = InternationalStatut::where("fiche_internationale", $this->id)->where("champ", "proposition_projet")->orderBy('date','DESC')->first();
        return $statut->valeur;
    }

    public function getLastStatutRealisation(){
        $statut = InternationalStatut::where("fiche_internationale", $this->id)->where("champ", "realisation_projet")->orderBy('date','DESC')->first();
        return $statut->valeur;
    }

    //? Utilisé pour la migration - SERA POTENTIELLEMENT A REVOIR / SUPPRIMER UNE FOIS LA MIGRATION EFFECTUEE
    public function migration_statut($champ, $statut){

        // Si on trouve un caractère au début, alors on le sépare de la date
        // Pour vérifier cela, on vérifie la longueur de la date :
        // Si celle-ci == 11, alors on sait qu'un caractère spécial se trouve en début de chaîne

        if (strlen($statut) == 11){
            // On sépare le caractère spécial de la date en 2 variables
            $valeur = substr($statut, 0,1);
            $date = substr($statut, 1);
        }

        //! Si il n'y a pas de date de renseignée, alors on met un statut "^" à une date "random"
        elseif(strlen($statut) == 0){
            $valeur = "^";
            $date = "2022-01-01";
        }

        // Sinon, on met le statut sur +
        else{
            $valeur = "+";
            $date = $statut;
        }

        // Puis on formate la date de manière à ce qu'elle soit correcte pour la base de données
        $date = str_replace("/","-", $date);
        $date = Carbon::parse($date)->format('Y-m-d');

        // Si le champ == "proposition_projet" :
        if ($champ == "proposition_projet") {
            // En fonction du symbole stocké dans la variable $valeur_statut, on le remplace par un mot (Refusé, Annulé...) :
            switch ($valeur) {
                case '^':
                    $valeur = "soumis";
                    break;

                case '~':
                    $valeur = "en_attente";
                    break;

                case '+':
                    $valeur = "accepte";
                    break;

                case '-':
                    $valeur = "refuse";
                    break;

                case '@':
                    $valeur = "annule";
                    break;

                default:
                    $valeur = "undefined";
                    break;
            }
        }

        // Si le champ = "realisation_projet" :
        if ($champ == "realisation_projet") {
            // En fonction du symbole stocké dans la variable $valeur_statut, on le remplace par un mot (Refusé, Annulé...) :
            switch ($valeur) {
                case '^':
                    $valeur = "en_cours";
                    break;

                case '!':
                    $valeur = "depart_confirme";
                    break;

                case '+':
                    $valeur = "valide";
                    break;

                case '-':
                    $valeur = "non_valide";
                    break;

                default:
                    $valeur = "undefined";
                    break;
            }
        }

        InternationalStatut::updateOrCreate([
            'fiche_internationale' => $this->id,
            'champ' => $champ,
            'valeur' => $valeur,
            'date' => $date
        ]);
    }
}
