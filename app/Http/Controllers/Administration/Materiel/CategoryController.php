<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventaireCategorie;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index() {
        $title = trans_choice('msg.category', 2);
        $small_title = __('msg.manage');
		$categories = InventaireCategorie::get();
        $edit_mode = false;
        return view('administration.materiel.categories.index')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('edit_mode', $edit_mode)
			->with('categories', $categories);
    }

    public function add(Request $request) {

        $rules = [
            'name' => [
                'required',
                'unique:inventaire_categories,nom'
            ],
            'visible' => 'required',
        ];

        $messages = [
            'name.unique' => __('validation.category.name_unavailable'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            toastr()->error(__('validation.category.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        //Si tout est OK
        InventaireCategorie::create([
            'nom' => $request->name,
            'visible' => $request->visible == 'on' ? 1 : 0
        ]);

        toastr()->success(__('validation.category.added.success'));
        return redirect()->route('administration.materiel.categories.index');
    }

    public function show($id) {
		$category = InventaireCategorie::findOrFail($id);
        $title = trans_choice('msg.category', 2);
        $small_title = __('msg.manage');
        $categories = InventaireCategorie::get();
        $edit_mode = true;

        return view('administration.materiel.categories.index')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('category', $category)
            ->with('edit_mode', $edit_mode)
			->with('categories', $categories);
    }

    public function update(Request $request, $id) {
        $category = InventaireCategorie::findOrFail($id);

        $rules = [
            'name' => [
                'required',
                \Rule::unique('inventaire_categories', 'nom')->ignore($id),
            ],
            'visible' => [
                'required',
                function ($attribute, $value, $fail) use ($category) {
                    //Modification impossible si on souhaite rendre visible
                    //une catégorie associée à un responsable matériel
					if($value == 'on' && count($category->responsables) > 0) {
						$fail(__('validation.category.updated.error.resp_materiel'));
					}
				},
            ],
        ];

        $messages = [
            'name.unique' => __('validation.category.name_unavailable'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            toastr()->error(__('validation.category.updated.error.generic'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Si tout est OK
        $category->visible = $request->visible == 'on' ? 1 : 0;
        $category->nom = $request->name;
        $category->save();

        toastr()->success(__('validation.category.updated.success'));
        return redirect()->route('administration.materiel.categories.index');
    }

    public function delete($id) {
        $category = InventaireCategorie::findOrFail($id);

        // Suppression impossible si la catégorie est liée à des responsables matériels
        if (count($category->responsables) > 0) {
            flash(__('validation.category.deleted.error.resp_materiel'))->error();
            return redirect()->back()->withInput();
        }

        // Suppression impossible si la catégorie est liée à des types de produit
        if (count($category->product_types) > 0) {
            flash(__('validation.category.deleted.error.product_type'))->error();
            return redirect()->back()->withInput();
        }

        // Suppression OK
        $category->delete();
        toastr()->success(__('validation.category.deleted.success'));
        return redirect()->route('administration.materiel.categories.index');
    }
}
