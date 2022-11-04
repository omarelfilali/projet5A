<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventaireType;
use App\Models\InventaireFiltre;
use App\Models\InventaireCategorie;
use App\Models\Personnel;
use App\Models\InventaireProduitFiltre;

class TypeController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Type
	|--------------------------------------------------------------------------
	*/
	public function index() {
		$title = trans_choice('msg.product_type', 2);
		$small_title = __('msg.manage');
		$types = InventaireType::get();

		return view('administration.materiel.types.index')
			->with('title', $title)
			->with('small_title', $small_title)
			->with('types', $types);
	}

	public function add_type() {
		$title = trans_choice('msg.product_type', 2);
		$small_title = __('msg.add');
		$edit_type = false;
		$edit_filter = false;
		$categories = InventaireCategorie::get();
		$techniciens = Personnel::getTechniciens();

		return view('administration.materiel.types.form')
			->with('title', $title)
			->with('small_title', $small_title)
			->with('edit_type', $edit_type)
			->with('edit_filter', $edit_filter)
			->with('categories', $categories)
			->with('techniciens', $techniciens);
	}

	public function create_type(Request $request) {

		$rules = [
			'type_name' => [
				'required',
				'string',
				'unique:inventaire_types,nom',
			],
			'technicien_id' => [
				'required',
				'string',
				function ($attribute, $value, $fail) {
					$personnel = Personnel::where('id', $value)->first();
					if($personnel == null || !$personnel->isTechnicien()) {
						$fail(__('validation.not_found.technician'));
					}
				},
			],
			'category_id' => [
				'required',
				'integer',
				'exists:inventaire_categories,id',
			]
		];

		$messages = [
			'type_name.unique' => __('validation.type.name_unavailable'),
			'category_id.exists' => __('validation.not_found.category'),
		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.type.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

		$type = InventaireType::create([
			'nom' => $request->type_name,
			'technicien_id' => $request->technicien_id,
			'category_id' => $request->category_id
		]);

		toastr()->success(__('validation.type.added.success'));
		return redirect()->route('administration.materiel.types.show_type', $type->id);
	}

	public function show_type($id) {

		$type = InventaireType::findOrFail($id);

		$title = trans_choice('msg.product_type', 2);
		$small_title = __('msg.edit');
		$edit_type = true;
		$edit_filter = false;
		$categories = InventaireCategorie::get();
		$techniciens = Personnel::getTechniciens();

		return view('administration.materiel.types.form')
			->with('title', $title)
			->with('small_title', $small_title)
			->with('edit_type', $edit_type)
			->with('edit_filter', $edit_filter)
			->with('categories', $categories)
			->with('techniciens', $techniciens)
			->with('type', $type);
	}

	public function update_type(Request $request, $id) {

		$type = InventaireType::findOrFail($id);

        $rules = [
			'type_name' => [
				'required',
				'string',
				\Rule::unique('inventaire_types', 'nom')->ignore($id),
			],
			'technicien_id' => [
				'required',
				'integer',
				function ($attribute, $value, $fail) {
					$personnel = Personnel::where('id', $value)->first();
					if($personnel == null || !$personnel->isTechnicien()) {
						$fail(__('validation.not_found.technician'));
					}
				},
			],
			'category_id' => [
				'required',
				'integer',
				'exists:inventaire_categories,id',
			]
		];

		$messages = [
			'type_name.unique' => __('validation.type.name_unavailable'),
			'category_id.exists' => __('validation.not_found.category'),
		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.type.updated.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

		// Mise à jour si tout est ok
		$type->nom = $request->type_name;
		$type->technicien_id = $request->technicien_id;
		$type->category_id = $request->category_id;
		$type->save();

		toastr()->success(__('validation.type.updated.success'));
		return redirect()->route('administration.materiel.types.show_type', $id);
	}

	public function delete_type($id) {
		$type = InventaireType::findOrFail($id);

		//Suppression impossible si le type de produit comporte des produits
		if (count($type->produits) > 0) {
            flash(__('validation.type.deleted.error.product'))->error();
            return redirect()->back()->withInput();
        }

		// Suppression OK
		$type->delete();
		// Suppression des caractéristiques/filtres liés au type
		InventaireFiltre::where('type_id', $id)->delete();
		toastr()->success(__('validation.type.deleted.success'));
		return redirect()->route('administration.materiel.types.index');
	}


	/*
	|--------------------------------------------------------------------------
	| Filter - Category
	|--------------------------------------------------------------------------
	*/
	public function add_filter(Request $request, $id) {

		$type = InventaireType::findOrFail($id);

		$rules = [
			'filter_name' => [
				'required',
				'string',
				'unique:inventaire_types_filtres,nom,NULL,id,type_id,'.$id,
			],
			'dataType' => [
				'required',
				'integer',
				'between:0,2'
			],
			'unit' => [

			]
		];

		$messages = [
			'filter_name.unique' => __('validation.filter.name_unavailable'),
		];

		$validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.filter.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

		$filter = InventaireFiltre::create([
			'type_id' => $id,
			'nom' => $request->filter_name,
			'valeur_type' => $request->dataType,
			'unite' => $request->unit ?? '',
		]);

		toastr()->success(__('validation.filter.added.success'));
		return redirect()->route('administration.materiel.types.show_type', $id);
	}

	public function show_filter($id, $filter_id) {

		$type = InventaireType::findOrFail($id);
		$filter = InventaireFiltre::findOrFail($filter_id);

		$title = trans_choice('msg.product_type', 2);
		$small_title = __('msg.manage');
		$edit_type = true;
		$edit_filter = true;
		$categories = InventaireCategorie::get();
		$techniciens = Personnel::getTechniciens();

		return view('administration.materiel.types.form')
			->with('title', $title)
			->with('small_title', $small_title)
			->with('edit_type', $edit_type)
			->with('categories', $categories)
			->with('techniciens', $techniciens)
			->with('filter', $filter)
			->with('type', $type)
			->with('edit_filter', $edit_filter);
	}

	public function update_filter(Request $request, $id, $filter_id) {

		$type = InventaireType::findOrFail($id);
		$filter = InventaireFiltre::findOrFail($filter_id);

		$rules = [
			'filter_name' => [
				'required',
				'string',
				\Rule::unique('inventaire_types_filtres', 'nom')->where(function($query) use ($id, $filter_id) {
					$query->where('type_id', $id)
					->where('id', "!=", $filter_id);
				})
			],
			'dataType' => [
				'required',
				'integer',
				'between:0,2'
			],
			'unit' => [

			]
		];

		$messages = [
			'filter_name.unique' => __('validation.filter.name_unavailable'),
		];

		$validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.filter.updated.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

		$filter->nom = $request->filter_name;
        $filter->valeur_type = $request->dataType;
        $filter->unite = $request->unit ?? '';
        $filter->save();

		toastr()->success(__('validation.filter.updated.success'));
		return redirect()->route('administration.materiel.types.show_type', $id);
	}

	public function delete_filter($id, $filter_id) {

		$type = InventaireType::findOrFail($id);
		$filter = InventaireFiltre::findOrFail($filter_id);
		$filter->delete();
		// Suppression de la caractéristique sur tous les produits associés
		InventaireProduitFiltre::where('filtre_id', $filter_id)->delete();

		toastr()->success(__('validation.filter.deleted.success'));
		return redirect()->route('administration.materiel.types.show_type', $id);
	}

}
