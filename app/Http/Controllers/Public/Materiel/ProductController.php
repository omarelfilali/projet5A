<?php

namespace App\Http\Controllers\Public\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventaireProduit;
use App\Models\InventaireCategorie;
use App\Models\InventairePanier;
use App\Models\InventaireType;
use App\Models\Etudiant;

class ProductController extends Controller
{
	public function show_products(Request $request, $category = null) {

		$categories = InventaireCategorie::where('visible', 1)->get();
		$categories = $categories->sortByDesc(function($category){
			return $category->number_of_products();
		});

		//On récupère tous les produits qui ne sont pas masqués
		$products = InventaireProduit::where('masked', 0);

		// On regarde si une catégorie est sélectionnée
		$selected_category = null;
		if ($category != null) {
			$selected_category = InventaireCategorie::where('nom', $category)
				->where('visible', 1)
				->first();
			// Affiche uniquement les produits de la catégorie sélectionnée
			if ($selected_category != null) {
				$products->whereHas('type', function ($query) use ($selected_category) {
					$query->where('category_id', $selected_category->id);
				});
			}
		} else {
			//Sinon on récupère les produits de toutes les catégories visibles
			$products->whereHas('type.categorie', function ($query) {
				$query->where('visible', 1);
			});
		}

		// Si un type de produit est sélectionné
		$product_type = $request->query('product_type');
		$selected_type = null;
		if ($product_type != null) {
			$selected_type = InventaireType::find($product_type);
			if ($selected_type != null) {
				$products->where('type_id', $product_type);
			}
		}


		//Récupération finale des produits
		$products = $products->get();


		// Si on affiche uniquement les produits en stock
		$in_stock = $request->query('in_stock');
		if ($in_stock == "true") {
			$products = $products->filter(function($p) {
				return $p->nombreStock > 0;
			});
		}

		// Gestion des types sélectionnables
		$selectable_types = InventaireType::whereHas('categorie', function ($query) use ($selected_category){
			$query->where('visible', 1);
			if ($selected_category != null) {
				$query->where('category_id', $selected_category->id);
			}
		})->get();

		return view('public.materiel.products.index')
			->with('products', $products)
			->with('categories', $categories)
			->with('selected_category', $selected_category)
			->with('selectable_types', $selectable_types)
			->with('panier', $this->getPanier())
			->with('selected_type', $selected_type)
			->with('in_stock', $in_stock);

	}

    public function show_product($id) {
		$product = InventaireProduit::findOrFail($id);

		return view('public.materiel.products.show')
			->with('product', $product)
			->with('panier', $this->getPanier());
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
						$ligne->save();
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
