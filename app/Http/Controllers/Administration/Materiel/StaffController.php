<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\PersonnelStatut;
use App\Models\PersonnelStatutType;
use App\Models\InventaireCategorie;
use App\Models\PersonnelMaterielCategorie;

class StaffController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Responsables administratifs
    |--------------------------------------------------------------------------
    */
    public function show_resp_administratifs() {
        $title = trans_choice('msg.staff', 2);
        $small_title = trans_choice('msg.admin_resp', 2);
        $responsables = Personnel::getRespAdministratifs();
        $responsablesIds = $responsables->map(function($r) {
            return $r->id;
        })->toArray();
        $personnels = Personnel::whereNotIn('id', $responsablesIds)->get();

        return view('administration.materiel.staff.respadministratif')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('allResps', $responsables)
            ->with('personnels', $personnels);
    }

    public function add_resp_administratif(Request $request) {
        $rules = [
			'personnel_id' => [
				'required',
				'string',
				'exists:personnels,uid',
			],
		];

		$messages = [
			'personnel_id.exists' => __('validation.not_found.staff'),
		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.admin_resp.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $type_id = PersonnelStatutType::where('prefix', 'RESPADMIN')->firstOrFail()->id;
        $resp = Personnel::findOrFail($request->personnel_id);
        // Défini le statut de ce membre du personnel en tant que responsable administratif
        if ($resp != null) {
            PersonnelStatut::firstOrCreate([
                'personnel_id' => $resp->id,
                'statut_id' => $type_id
            ]);
        }

        toastr()->success(__('validation.admin_resp.added.success'));
        return redirect()->route('administration.materiel.staff.respadministratifs');
    }

    public function delete_resp_administratif($id) {
        $type_id = PersonnelStatutType::where('prefix', 'RESPADMIN')->firstOrFail()->id;
        $resp_statut = PersonnelStatut::where('statut_id', $type_id)->where('personnel_id', $id)->firstOrFail();
        $resp_statut->delete();

        toastr()->success(__('validation.admin_resp.deleted.success'));
        return redirect()->route('administration.materiel.staff.respadministratifs');
    }

    /*
    |--------------------------------------------------------------------------
    | Responsables matériels
    |--------------------------------------------------------------------------
    */
    public function show_resp_materiels() {
        $title = trans_choice('msg.staff', 2);
        $small_title = trans_choice('msg.mat_resp', 2);
        $responsables = Personnel::getRespMateriels();
        $responsablesIds = $responsables->map(function($r) {
            return $r->id;
        })->toArray();
        $personnels = Personnel::whereNotIn('id', $responsablesIds)->get();
        $categories = InventaireCategorie::where('visible', 0)->get();
        $edit_mode = false;

        return view('administration.materiel.staff.respmateriel')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('edit_mode', $edit_mode)
            ->with('categories', $categories)
            ->with('allResps', $responsables)
            ->with('personnels', $personnels);
    }

    public function show_resp_materiel($id) {
        $resp = Personnel::where('id', $id)->firstOrFail();
        $name = $resp->getNomPrenomAttribute();
        $selected_categories = $resp->categories()->get()->map(function($c) {
            return $c->categorie()->first()->id;
        })->toArray();

        $title = trans_choice('msg.staff', 2);
        $small_title = trans_choice('msg.mat_resp', 2);
        $responsables = Personnel::getRespMateriels();
        $responsablesIds = $responsables->map(function($r) {
            return $r->id;
        })->toArray();
        $personnels = Personnel::whereNotIn('id', $responsablesIds)->get();
        $categories = InventaireCategorie::where('visible', 0)->get();
        $edit_mode = true;

        return view('administration.materiel.staff.respmateriel')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('allResps', $responsables)
            ->with('categories', $categories)
            ->with('resp', $resp)
            ->with('edit_mode', $edit_mode)
            ->with('selected_categories', $selected_categories)
            ->with('personnels', $personnels);
    }

    public function add_resp_materiel(Request $request) {
        $rules = [
			'personnel_id' => [
				'required',
				'string',
				'exists:personnels,uid',
			],
            'categories' => [
				'required',
				'array',
				'min:1',
			],
            'categories.*' => [
				'required',
				'integer',
				'exists:inventaire_categories,id',
			],
		];

		$messages = [
            'categories.required' => __('validation.mat_resp.no_category_selected'),
			'personnel_id.exists' => __('validation.not_found.staff'),
            'personnel_id.exists' => __('validation.not_found.staff'),
		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.mat_resp.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $type_id = PersonnelStatutType::where('prefix', 'RESPMAT')->firstOrFail()->id;
        $resp = Personnel::findOrFail($request->personnel_id);

        // Défini le statut de ce membre du personnel en tant que responsable matériel
        if ($resp != null) {
            PersonnelStatut::firstOrCreate([
                'personnel_id' => $resp->id,
                'statut_id' => $type_id
            ]);

            foreach ($request->categories as $c) {
                PersonnelMaterielCategorie::firstOrCreate([
                    'personnel_id' => $resp->id,
                    'categorie_id' => $c
                ]);
            }
        }

        toastr()->success(__('validation.mat_resp.added.success'));
        return redirect()->route('administration.materiel.staff.respmateriels');
    }

    public function update_resp_materiel(Request $request, $id) {
        $rules = [
			'personnel_id' => [
				'required',
				'string',
				'exists:personnels,uid',
			],
            'categories' => [
				'required',
				'array',
				'min:1',
			],
            'categories.*' => [
				'required',
				'integer',
				'exists:inventaire_categories,id',
			],
		];

		$messages = [
            'categories.required' => __('validation.mat_resp.no_category_selected'),
			'personnel_id.exists' => __('validation.not_found.staff'),
            'categories.*.exists' => __('validation.not_found.category'),
		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.mat_resp.updated.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $type_id = PersonnelStatutType::where('prefix', 'RESPMAT')->firstOrFail()->id;
        $old_resp = Personnel::where('id', $id)->firstOrFail();
        $new_resp = Personnel::findOrFail($request->personnel_id);

        //Suppression des catégories associées
        PersonnelMaterielCategorie::where('personnel_id', $old_resp->id)->delete();

        // Si le nom a changé on met à jour les statuts
        if ($new_resp->id != $old_resp->id) {
            PersonnelStatut::firstOrCreate([
                'personnel_id' => $new_resp->id,
                'statut_id' => $type_id
            ]);
            PersonnelStatut::where('personnel_id', $old_resp->id)->where('statut_id', $type_id)->delete();
        }

        // Ajout des catégories
        foreach ($request->categories as $c) {
            $category = InventaireCategorie::find($c);
            PersonnelMaterielCategorie::firstOrCreate([
                'personnel_id' => $new_resp->id,
                'categorie_id' => $c
            ]);
        }

        toastr()->success(__('validation.mat_resp.updated.success'));
        return redirect()->route('administration.materiel.staff.respmateriels');
    }

    public function delete_resp_materiel($id) {
        //Suppression du statut
        $type_id = PersonnelStatutType::where('prefix', 'RESPMAT')->firstOrFail()->id;
        $resp_statut = PersonnelStatut::where('statut_id', $type_id)->where('personnel_id', $id)->firstOrFail();
        $resp_statut->delete();

        //Suppression des catégories associées
        PersonnelMaterielCategorie::where('personnel_id', $id)->delete();

        toastr()->success(__('validation.mat_resp.deleted.success'));
        return redirect()->route('administration.materiel.staff.respmateriels');
    }

    /*
    |--------------------------------------------------------------------------
    | Techniciens
    |--------------------------------------------------------------------------
    */
    public function show_techniciens() {
        $title = trans_choice('msg.staff', 2);
        $small_title = trans_choice('msg.technician', 2);
        $techniciens = Personnel::getTechniciens();
        $techniciensIds = $techniciens->map(function($t) {
            return $t->id;
        })->toArray();
        $personnels = Personnel::whereNotIn('id', $techniciensIds)->get();

        return view('administration.materiel.staff.technicien')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('techniciens', $techniciens)
            ->with('personnels', $personnels);
    }

    public function add_technicien(Request $request) {
        $rules = [
			'personnel_id' => [
				'required',
				'string',
				'exists:personnels,uid',
			],
		];

		$messages = [
			'personnel_id.exists' => __('validation.not_found.staff'),
		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.technician.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $type_id = PersonnelStatutType::where('prefix', 'TECH')->firstOrFail()->id;
        $technicien = Personnel::findOrFail($request->personnel_id);
        // Défini le statut de ce membre du personnel en tant que technicien
        if ($technicien != null) {
            PersonnelStatut::firstOrCreate([
                'personnel_id' => $technicien->id,
                'statut_id' => $type_id,
            ]);
        }

        toastr()->success(__('validation.technician.added.success'));
        return redirect()->route('administration.materiel.staff.techniciens');
    }

    public function delete_technicien($id) {
        $type_id = PersonnelStatutType::where('prefix', 'TECH')->firstOrFail()->id;
        $technicien_statut = PersonnelStatut::where('statut_id', $type_id)->where('personnel_id', $id)->firstOrFail();
        $technicien_statut->delete();

        toastr()->success(__('validation.technician.deleted.success'));
        return redirect()->route('administration.materiel.staff.techniciens');
    }
}
