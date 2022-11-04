<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventaireEmprunt;
use App\Models\Personnel;
use App\Models\Etudiant;
use App\Models\InventaireFiltre;
use App\Models\InventaireType;
use App\Models\InventaireProduitFiltre;
use App\Models\InventaireProduit;
use App\Models\InventaireProduitReference;
use App\Models\InventaireEmpruntProduit;
use App\Models\InventaireEmpruntHistorique;
use App\Models\InventairePanier;
use App\Models\InventaireLignePanier;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth as Auth;

class APIController extends Controller
{
    public function etudiant(Request $r){
        $etudiant = Etudiant::where('id', $r->id)->firstOrFail();
        $array = array();
        $array["id"] = $etudiant->login;
        $array["nom"] = $etudiant->nom;
        $array["prenom"] = $etudiant->prenom;
        // $array["promo"] = $etudiant->promo;
        $array["photo"] = $etudiant->photoURL;
        return response()->json($array, 200);
    }

    public function produits_references(Request $r){
        $references = InventaireProduitReference::select('numero_serie', 'id', 'status')->where('produit_id', $r->id)->get();
        $array = $references->toArray();
        $index = 0;
        foreach ($references as $r){
            $array[$index]["dispo"] = $r->empruntActif() != null ? false : ($r->status == 0 ? true : false);
            $index++;
        }
        return response()->json($array, 200);
    }

    public function types_filtres(Request $r){
        $filtres = InventaireFiltre::select('id', 'nom', 'valeur_type', 'unite')->where('type_id', $r->id)->get();
        $array = $filtres->toArray();
        return response()->json($array, 200);
    }

    public function type(Request $r){
        $type = InventaireType::select('nom', 'technicien_id', 'category_id')->where('id', $r->id)->firstOrFail();
        $array = $type->toArray();
        return response()->json($array, 200);
    }

    public function produits_filtres(Request $r){
        $produit = InventaireProduit::findOrFail($r->id);
        $filtres = InventaireFiltre::select('id', 'nom', 'valeur_type', 'unite')->where('type_id', $produit->type->id)->get();
        $array = $filtres->toArray();
        $index = 0;
        foreach ($filtres as $f){
            $filtreproduit = InventaireProduitFiltre::where("produit_id", $produit->id)->where('filtre_id', $f->id)->first();
            if ($filtreproduit == null){
                $array[$index]["valeur"] = "";
            }
            else {
                $array[$index]["valeur"] = $filtreproduit->valeur;
            }
            $index++;
        }
        return response()->json($array, 200);
    }

    public function emprunts_recherche(Request $r){
        $keyword = $r->keyword;
        $demandes = InventaireEmprunt::get();
        $array = [];
        $index = 0;
        foreach ($demandes as $d){
            $values = array($d->etudiant->nomprenom, $d->articles->first()->reference->produit->nom, $d->articles->first()->reference->produit->type->nom);
            foreach ($values as $v){
                if (str_contains(strtolower(trim($v)), strtolower(trim($keyword)))){
                    $array[$index++] = $d->id;
                    break;
                }
            }
        }
        return response()->json($array, 200);
    }

    public function produits_recherche(Request $r){
        $keyword = $r->keyword;
        $produits = InventaireProduit::get();
        $array = [];
        $index = 0;
        foreach ($produits as $p){
            $values = array($p->nom, $p->type->nom);
            foreach ($values as $v){
                if (str_contains(strtolower(trim($v)), strtolower(trim($keyword)))){
                    $array[$index++] = $p->id;
                    break;
                }
            }
        }
        return response()->json($array, 200);
    }

    public function historique_recherche(Request $r){
        $produit = InventaireProduit::findOrFail($r->id);
        $references = InventaireProduitReference::where('produit_id', $produit->id)->get('id')->toArray();
        $emprunts = InventaireEmprunt::where('rendu_date', '!=', null)->where('status', '>=', 5)->get('id')->toArray();
        $history = InventaireEmpruntProduit::whereIn('reference_id', $references)->whereIn('emprunt_id', $emprunts)->get();

        $keyword = $r->keyword;
        $array = [];
        $index = 0;
        foreach ($history as $h){
            $values = array($h->emprunt->etudiant->nomprenom, $h->reference->numero_serie, $h->emprunt->dateRendu(), $h->emprunt->dateDebut(), $h->emprunt->dateFin());
            foreach ($values as $v){
                if (str_contains(strtolower(trim($v)), strtolower(trim($keyword)))){
                    $array[$index++] = $h->id;
                    break;
                }
            }
        }
        return response()->json($array, 200);
    }

    public function stocks_recherche(Request $r){
        $product = InventaireProduit::findOrFail($r->id);
        $array = [];
        $index = 0;
        foreach ($product->references as $ref){
            if ($r->strictSearch) {
                if ($ref->ensim_id == $r->keyword) {
                    $array[$index++] = $ref->id;
                }
            }
            else if (str_contains(strtolower(trim($ref->numero_serie)), strtolower(trim($r->keyword))) || str_contains(strtolower(trim($ref->ensim_id)), strtolower(trim($r->keyword)))){
                $array[$index++] = $ref->id;
            }
        }
        return response()->json($array, 200);
    }

    function delete_col(&$array, $key) {
        return array_walk($array, function (&$v) use ($key) {
            unset($v[$key]);
        });
    }

    public function edit_product_quantity(Request $request) {

		$rules = [
			'id_produit' => [
                'required',
				'int',
				'exists:inventaire_produits,id'
			],
			'quantite' => [
                'required',
				'int',
			],
		];

		$messages = [
           
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.cart.edit_product_quantity.error'));
            return response()->json($validator, 400);
        }

        //TODO vérifier que la quantité est en stock



		$panier = $this->getPanier();

		// Mise à jour de la quantité
		$ligne = InventaireLignePanier::where('panier_id', $panier->id)
			->where('produit_id', $request->id_produit)
			->first();
		$ligne->quantite = $request->quantite;
		$ligne->save();

        $array = array();
        $array["quantite"] = $ligne->quantite;
        $array["nbTotalArticles"] = $this->getPanier()->nbTotalArticles();
		return response()->json($array, 200);
	}

    public function remove_product(Request $request) {

		$rules = [
			'id_produit' => [
                'required',
				'int',
				'exists:inventaire_produits,id'
			],
		];

		$messages = [
           
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.cart.remove_product.error'));
            return response()->json($validator, 400);
        }

		$panier = $this->getPanier();

		// Supression de la ligne panier
		InventaireLignePanier::where('panier_id', $panier->id)
			->where('produit_id', $request->id_produit)
			->delete();

        return response()->json([], 200);
	}

    public function getPanier() {
		$id_etudiant = Etudiant::getGuard()->id();
		// Récupération ou création du panier
		$panier = InventairePanier::firstWhere('etudiant_uid', $id_etudiant);
		if($panier == null) {
			InventairePanier::firstOrCreate([
				'etudiant_uid' => Etudiant::getGuard()->id(),
			]);
		}
		return $panier;
	}

    // Vérifie que la dernière attestation déposée couvre la période d'emprunt passée en paramètre
    public function verification_presence_assurance(Request $r){
        $valid_assurance = false;
        $deb_emprunt = Carbon::parse($r->deb_emprunt);
        $fin_emprunt = Carbon::parse($r->fin_emprunt);
        $assurance = Etudiant::getGuard()->user()->derniereAssurance();

        if ($assurance != null) {
            $deb_assurance = Carbon::parse($assurance->date_debut);
            $fin_assurance = Carbon::parse($assurance->date_fin);
            if ($deb_assurance->lte($deb_emprunt) && $fin_assurance->gte($fin_emprunt)) {
                $valid_assurance = true;
            }
        }

        return response()->json($valid_assurance, 200);
    }

    // Vérifie que les dates d'attestation renseignées couvrent la période d'emprunt souhaitée
    public function verification_dates_assurance(Request $r){
        $result = false;
        $deb_emprunt = Carbon::parse($r->deb_emprunt);
        $fin_emprunt = Carbon::parse($r->fin_emprunt);
        $deb_assurance = Carbon::parse($r->deb_assurance);
        $fin_assurance = Carbon::parse($r->fin_assurance);

        if ($deb_assurance->lte($deb_emprunt) && $fin_assurance->gte($fin_emprunt)) {
                $result = true;
        }

        return response()->json($result, 200);
    }

}
