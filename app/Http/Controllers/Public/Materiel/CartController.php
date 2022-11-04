<?php

namespace App\Http\Controllers\Public\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventaireProduit;
use App\Models\InventairePanier;
use App\Models\InventaireLignePanier;
use App\Models\Etudiant;
use App\Models\Personnel;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function show_cart() {
		$panier = $this->getPanier();

		return view('public.materiel.cart.index')
			->with('panier', $panier);
	}

    public function add_product(Request $request) {

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
            toastr()->error(__('validation.cart.add_product.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

		$panier = $this->getPanier();
		$produit = InventaireProduit::findOrFail($request->id_produit);

		//On vérifie que la quantité est bien en stock
		$nb_in_cart = $panier->nbArticles($request->id_produit);
		$nb_to_add = $request->quantite;
		if ($nb_in_cart + $nb_to_add > $produit->nombreStock) {
			toastr()->error("Erreur lors de l'ajout du produit");
            throw ValidationException::withMessages(['invalid_quantity' => "Nombre d'articles ajoutés trop élevé"]);
            return redirect()->back();
		}
		
		// Ajout du produit
		$ligne = InventaireLignePanier::where('panier_id', $panier->id)
			->where('produit_id', $request->id_produit)
			->where('quantite', '>', 0)
			->first();
		if ($ligne != null) {
			$ligne->quantite += $request->quantite;
			$ligne->save();
		} else {
			InventaireLignePanier::firstOrCreate([
				'panier_id' => $panier->id,
				'produit_id' => $request->id_produit,
				'quantite' => $request->quantite,
			]);
		}
		
		toastr()->success(__('validation.cart.add_product.success'));
		return redirect()->route('cart.index');
	}

	public function validate_cart() {
		
		$panier = $this->getPanier();

		// Vérification du panier
        if ($panier->nbTotalArticles() == 0){
            toastr()->error("Erreur lors de la validation du panier");
            throw ValidationException::withMessages(['invalid_cart' => "Le panier est vide"]);
            return redirect()->back()->withInput();
        }

		foreach($panier->lignes as $ligne) {
			if ($ligne->quantite > $ligne->produit->nombreStock) {
				toastr()->error("Erreur lors de la validation du panier");
            	throw ValidationException::withMessages(['invalid_cart' => "Certains articles ajoutés au panier ne sont plus disponibles. Les quantités ont été mises à jour automatiquement."]);
				return redirect()->back()->withInput();
			}
		}

		$encadrants = Personnel::getEncadrants();

		return view('cart.validation')
			->with('panier', $panier)
			->with('encadrants', $encadrants);
	}

	public function getPanier() {
		$id_etudiant = Etudiant::getGuard()->id();
		// Récupération ou création du panier
		$panier = InventairePanier::firstWhere('etudiant_uid', $id_etudiant);
		if($panier == null) {
			$panier = InventairePanier::firstOrCreate([
				'etudiant_uid' => Etudiant::getGuard()->id(),
			]);
		} else {
			// Vérification du panier
			$display_msg = false;
			foreach($panier->lignes as $ligne) {
				if ($ligne->quantite > $ligne->produit->nombreStock) {
					if ($ligne->produit->nombreStock == 0) {
						$ligne->delete();
					} else {
						$ligne->quantite = $ligne->produit->nombreStock;
					}
					$display_msg = true;
				}
			}
			if ($display_msg) {
				toastr()->error("Certains articles ajoutés au panier ne sont plus disponibles. Les quantités ont été mises à jour automatiquement.");
			}
		}
		return $panier;
	}

	

}
