<?php

namespace App\Http\Controllers\Public\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\InventaireProduit;
use App\Models\InventairePanier;
use App\Models\InventaireEmprunt;
use App\Models\InventaireEmpruntProduit;
use App\Models\InventaireEmpruntEncadrant;
use App\Models\InventaireLignePanier;
use App\Models\Etudiant;
use App\Models\EtudiantAssurance;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function show_requests() {
        $demandes = Etudiant::getGuard()->user()->demandes->sortByDesc("created_at");
		return view('public.materiel.requests.index')
			->with('panier', $this->getPanier())
            ->with('demandes', $demandes);
	}

    public function show_request($id) {
		return view('public.materiel.requests.show')
			->with('panier', $this->getPanier());
	}

	public function create_request(Request $request) {

		$rules = [
			'deb_emprunt' => [
                'bail',
				'required',
				'date',
			],
			'fin_emprunt' => [
                'bail',
				'required',
				'date',
			],
			'motif' => [
				'required',
				'string',
				'min:50',
			],
			'encadrants' => [
				'required',
				'array',
				'min:1',
			],
            'encadrants.*' => [
				'required',
				'string',
				'exists:personnels,id',
			],
		];

		$messages = [
			'encadrants.min' => "Veuillez sélectionner au moins un encadrant",
			'encadrants.*.exists' => "Le personnel sélectionné n'existe pas",
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error('Erreur lors de la demande');
            return redirect()->back()->withInput()->withErrors($validator);
        }

		$panier = $this->getPanier();


		// Vérification du panier
		foreach($panier->lignes as $ligne) {
			if ($ligne->quantite > $ligne->produit->nombreStock) {
				toastr()->error("Erreur lors de la demande");
            	throw ValidationException::withMessages(['invalid_cart' => "Certains articles ajoutés au panier ne sont plus disponibles. Les quantités ont été mises à jour automatiquement."]);
            	return redirect()->back()->withInput()->withErrors($validator);
			}
		}

		// Vérification des dates
		$start_date = Carbon::parse($request->deb_emprunt)->startOfDay();
        $end_date = Carbon::parse($request->fin_emprunt)->startOfDay();

		// L'emprunt ne commence pas avant J+3
		if (Carbon::now()->addDays(3)->startOfDay()->gt($start_date)) {
            toastr()->error("Erreur lors de la demande");
            throw ValidationException::withMessages(['deb_emprunt' => "L'emprunt ne peut pas commencer avant 3 jours"]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

		// La deuxième date doit être après la première
        if ($start_date->isAfter($end_date)) {
            toastr()->error("Erreur lors de la demande");
            throw ValidationException::withMessages(['fin_emprunt' => __('validation.request.period.second_date_before')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

		// L'emprunt ne dépasse pas 200 jours
		if ($start_date->addDays(200)->isBefore($end_date)) {
            toastr()->error("Erreur lors de la demande");
            throw ValidationException::withMessages(['fin_emprunt' => 'La durée de l\'emprunt ne peut excéder 200 jours']);
            return redirect()->back()->withInput()->withErrors($validator);
        }

		// Ajout de l'assurance
		if ($request->hasFile('insurance')) {

			if(!($request->has('deb_assurance') && $request->has('fin_assurance'))) {
				toastr()->error("Erreur lors de la demande");
				throw ValidationException::withMessages(['fin_assurance' => "Vous devez renseigner les dates de validité de l'attestation"]);
				return redirect()->back()->withInput()->withErrors($validator);
			}

			// Vérification des dates
			$deb_assurance= Carbon::parse($request->deb_assurance)->startOfDay();
        	$fin_assurance = Carbon::parse($request->fin_assurance)->startOfDay();

			// La deuxième date doit être après la première
			if ($deb_assurance->isAfter($fin_assurance)) {
				toastr()->error("Erreur lors de la demande");
				throw ValidationException::withMessages(['fin_assurance' => __('validation.request.period.second_date_before')]);
				return redirect()->back()->withInput()->withErrors($validator);
			}

			// Enregistrement de l'assurance
			$allowedfileExtension=['pdf'];
			$extension = $request->file('insurance')->getClientOriginalExtension();
			$check = in_array($extension, $allowedfileExtension);
			if($check) {
				$filename = $request->insurance->store('insurances');
				$assurance = EtudiantAssurance::create([
					'etudiant_uid' => Etudiant::getGuard()->user()->uid,
					'date_debut' => $request->deb_assurance,
					'date_fin' => $request->fin_assurance,
					'assurance' => $filename,
					'valide' => 0
				]);
			}
		}

		// TODO VERIFIER LA VALIDITE DE L'ASSURANCE
		$valid_insurance = false;

		$panier = $this->getPanier();

		// Séparation en une commande par produit
		foreach($panier->lignes as $ligne) {
			if ($ligne->quantite > 0) {

				$demande = InventaireEmprunt::create([
					'status' => $valid_insurance ? 0 : -1,
					'debut_date' => $request->deb_emprunt,
					'fin_date' => $request->fin_emprunt,
					'description' => $request->motif,
					'etudiant_uid' => Etudiant::getGuard()->user()->uid,
					'technicien_id'  => $ligne->produit->type->technicien->id,
				]);

				$refs = array_slice($ligne->produit->referencesDisponibles, 0, $ligne->quantite);

				foreach($refs as $ref) {
					InventaireEmpruntProduit::create([
						'emprunt_id' => $demande->id,
						'reference_id' => $ref->id,
					]);
				}

				foreach($request->encadrants as $encadrant) {
					InventaireEmpruntEncadrant::create([
						'emprunt_id' => $demande->id,
						'personnel_id' => $encadrant,
					]);
				}
			}
		}


		// Supression de toutes les lignes panier
		InventaireLignePanier::where('panier_id', $panier->id)->delete();
		// Supression du panier
		InventairePanier::where('id', $panier->id)->delete();

		toastr()->success("Votre demande a bien été prise en compte");
		return redirect()->route('materiel.requests.index');
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
