<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\InventaireProduit;
use App\Models\InventaireEmpruntProduit;
use App\Models\InventaireProduitReference;
use App\Models\InventaireEmprunt;
use App\Models\InventaireType;
use App\Models\InventaireProduitImage;
use App\Models\InventaireProduitFiltre;
use App\Models\InventaireReferenceFichier;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
	public function index() {
		$title = trans_choice('msg.product', 2);
		$small_title = __('msg.manage');
		$products = InventaireProduit::where('masked', 0)->get();

		return view('administration.materiel.products.index')
		->with('datatable', true)
		->with('title', $title)
		->with('small_title', $small_title)
		->with('products', $products);
	}

	public function add() {
		$title = trans_choice('msg.product', 2);
		$small_title = __('msg.add');
		$types = InventaireType::get();
		$edit_mode = false;
		$brands = $this->getAllBrands();

		return view('administration.materiel.products.form')
		->with('title', $title)
		->with('small_title', $small_title)
		->with('types', $types)
		->with('edit_mode', $edit_mode)
		->with('brands', $brands);
	}

	public function create(Request $request) {

		$rules = [
			'name' => [
				'required',
				'string',
				'unique:inventaire_produits,nom',
			],
			'brand' => [
				'required',
				'string',
			],
			'product_type' => [
				'required',
				'integer',
				'exists:inventaire_types,id',
			],
			'model_nb' => [
				'required',
				'string',
			],
			'inputPhotos' => [

			],
			'inputSheet' => [

			],
		];

		// Ajout des règles de validation pour chaque filtre
		if ($request->has('product_type')) {
			$type = InventaireType::find($request->product_type);
			if ($type != null) {
				foreach($type->filtres as $f) {
					$key = "filtre". $f->id;
					$filter_rules = [
						'required',
					];
					switch ($f->valeur_type) {
						//Valeur binaire
						case 0:
							array_push($filter_rules, 'integer', 'between:1,2');
							break;
						//Valeur numérique
						case 1:
							array_push($filter_rules, 'integer');
							break;
						//Valeur alphanumérique
						case 2:
							array_push($filter_rules, 'string');
							break;
					}
					$rules[$key] = $filter_rules;
				}
			}
		}

		$messages = [
			'name.unique' => __('validation.product.name_unavailable'),
			'product_type.exists' => __('validation.not_found.type'),
		];

		$validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.product.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

		$type_id = $request->product_type;

		// Création du produit
		$product = InventaireProduit::create([
			'nom' => $request->name,
			'marque' => ucfirst(strtolower($request->brand)),
			'type_id' => $type_id,
			'numero_modele' => $request->model_nb,
			'fiche_technique' => '',
		]);

		// Ajout des caractéristiques
		$type = InventaireType::findOrFail($type_id);
		foreach ($type->filtres as $filtre) {
			$filter_id = $filtre->id;
			$filter_value = $request->{'filtre' . $filter_id};
			InventaireProduitFiltre::create([
				'produit_id' => $product->id,
				'filtre_id' => $filter_id,
				'valeur' => $filter_value,
			]);
		}

		// Ajout des photos
		if ($request->hasFile('photos')) {
			$allowedfileExtension=['jpg','png','jpeg'];
			$files = $request->file('photos');
			foreach($files as $file){
				$extension = $file->getClientOriginalExtension();
				$check = in_array($extension, $allowedfileExtension);
				if($check) {
					$filename = $file->store('photos');
					$photo = InventaireProduitImage::create([
						'produit_id' => $product->id,
						'image' => $filename,
					]);
				}
			}
		}

		// Ajout de la fiche technique
		if ($request->hasFile('sheet')) {
			$allowedfileExtension=['pdf'];
			$extension = $request->file('sheet')->getClientOriginalExtension();
			$check = in_array($extension, $allowedfileExtension);
			if($check) {
				$filename = $request->sheet->store('sheets');
				$product->fiche_technique = $filename;
				$product->save();
			}
		}

		toastr()->success(__('validation.product.added.success'));
		return redirect()->route('administration.materiel.products.index');
	}

  public function show_product($id) {
	$product = InventaireProduit::findOrFail($id);
    $title = trans_choice('msg.product', 2);
	$small_title = __('msg.edit');
    $types = InventaireType::get();
	$edit_mode = true;
	$brands = $this->getAllBrands();

    return view('administration.materiel.products.form')
		->with('title', $title)
		->with('small_title', $small_title)
		->with('types', $types)
		->with('edit_mode', $edit_mode)
		->with('brands', $brands)
		->with('product', $product);
  }

  public function update_product(Request $request, $id) {

	$product = InventaireProduit::findOrFail($id);

	$rules = [
		'name' => [
			'required',
			'string',
			\Rule::unique('inventaire_produits', 'nom')->ignore($id),
		],
		'brand' => [
			'required',
			'string',
		],
		'product_type' => [
			'required',
			'integer',
			'exists:inventaire_types,id',
		],
		'model_nb' => [
			'required',
			'string',
		],
		'inputPhotos' => [

		],
		'mainPhoto' => [
			'integer'
		],
		'inputSheet' => [

		],
	];

	// Ajout des règles de validation pour chaque filtre
	if ($request->has('product_type')) {
		$type = InventaireType::find($request->product_type);
		if ($type != null) {
			foreach($type->filtres as $f) {
				$key = "filtre". $f->id;
				$filter_rules = [
					'required',
				];
				switch ($f->valeur_type) {
					//Valeur binaire
					case 0:
						array_push($filter_rules, 'integer', 'between:1,2');
						break;
					//Valeur numérique
					case 1:
						array_push($filter_rules, 'integer');
						break;
					//Valeur alphanumérique
					case 2:
						array_push($filter_rules, 'string');
						break;
				}
				$rules[$key] = $filter_rules;
			}
		}
	}

	$messages = [
		'name.unique' => __('validation.product.name_unavailable'),
		'product_type.exists' => __('validation.not_found.type'),
	];

	$validator = \Validator::make($request->all(), $rules, $messages);

	if ($validator->fails()) {
		toastr()->error(__('validation.product.updated.error'));
		return redirect()->back()->withInput()->withErrors($validator);
	}

	$type_id = $request->product_type;

	// Mise à jour des infos du produit
	$product->nom = $request->name;
	$product->marque = ucfirst(strtolower($request->brand));
	$product->type_id = $type_id;
	$product->default_img = $request->mainPhoto;
	$product->numero_modele = $request->model_nb;
	$product->save();

	//Suppression des anciennes caractéristiques
	InventaireProduitFiltre::where('produit_id', $product->id)->delete();

	// Mise à jour des caractéristiques
	$type = InventaireType::findOrFail($type_id);
	foreach ($type->filtres as $filtre) {
		$filter_id = $filtre->id;
		$filter_value = $request->{'filtre' . $filter_id};
		InventaireProduitFiltre::create([
			'produit_id' => $product->id,
			'filtre_id' => $filter_id,
			'valeur' => $filter_value,
		]);
	}
	//Suppression des photos
	if ($request->deletePhotoIds != null) {
		foreach($request->deletePhotoIds as $id) {
			InventaireProduitImage::where('id', $id)
				->where('produit_id', $product->id)
				->delete();
		}
	}

	// Mise à jour des photos
	if ($request->hasFile('photos')) {
		$allowedfileExtension=['jpg','png','jpeg'];
		$files = $request->file('photos');
		foreach($files as $file){
			$extension = $file->getClientOriginalExtension();
			$check = in_array($extension, $allowedfileExtension);
			if($check) {
				$filename = $file->store('photos');
				$photo = InventaireProduitImage::create([
					'produit_id' => $product->id,
					'image' => $filename,
				]);
			}
		}
	}

	// Mise à jour de la fiche technique
	if ($request->hasFile('sheet')) {
		$allowedfileExtension=['pdf'];
		$extension = $request->file('sheet')->getClientOriginalExtension();
		$check = in_array($extension, $allowedfileExtension);
		if($check) {
			$filename = $request->sheet->store('sheets');
			$product->fiche_technique = $filename;
			$product->save();
		}
	}

    toastr()->success(__('validation.product.updated.success'));
	return redirect()->route('administration.materiel.products.index');
  }

  public function history($id) {
    $product = InventaireProduit::findOrFail($id);

    $user = Personnel::getGuard()->user();
    $categories = $user->categories->map(function ($c) {
        return $c->categorie->id;
    })->toArray();
    if (!$user->isTechnicien() && !($user->isRespMateriel() && in_array($product->type->category_id, $categories))){
        abort(403, 'Unauthorized action.');
        return;
    }

    $title = $product->nom;
    $small_title = __('msg.history');
    $references = InventaireProduitReference::where('produit_id', $product->id)->get('id')->toArray();
    $emprunts = InventaireEmprunt::where('rendu_date', '!=', null)->where('status', '>=', 5)->get('id')->toArray();
    $history = InventaireEmpruntProduit::whereIn('reference_id', $references)->whereIn('emprunt_id', $emprunts)->get();

    return view('administration.materiel.products.history')
		->with('datatable', true)
		->with('title', $title)
		->with('small_title', $small_title)
		->with('product', $product)
		->with('history', $history);
  }

  public function delete_product($id) {

	$product = InventaireProduit::findOrFail($id);

	// Suppression impossible si le produit possède des références
	if (count($product->references) > 0) {
		flash(__('validation.product.deleted.error.reference'))->error();
		return redirect()->back()->withInput();
	}

    $product->delete();
    toastr()->success(__('validation.product.deleted.success'));
	return redirect()->route('administration.materiel.products.index');
  }

  public function resp_stocks() {
    $title = __('msg.stocks');
    $small_title = __('msg.visualize');

	$categories = auth()->user()->categories->map(function ($c) {
		return collect($c->categorie_id);
	})->toArray();

	$types = InventaireType::whereIn('category_id', $categories)->select('id')->get()->toArray();
	$products = InventaireProduit::whereIn('type_id', $types)->where('masked', 0)->paginate(10);

	return view('administration.materiel.products.index')
		->with('datatable', true)
		->with('title', $title)
		->with('lite', true)
		->with('small_title', $small_title)
		->with('products', $products);
  }

  public function stock($id) {
	$product = InventaireProduit::findOrFail($id);
    $title = $product->nom;
  	$small_title = __('msg.stocks');
	$stocks = InventaireProduitReference::where('produit_id', $id)->get();
	$edit_mode = false;
	$ensim_ids = $this->getAllEnsimIds();

	return view('administration.materiel.products.stock')
		->with('datatable', true)
		->with('title', $title)
		->with('small_title', $small_title)
		->with('product', $product)
		->with('edit_mode', $edit_mode)
		->with('ensim_ids', $ensim_ids);
  }

  	public function show_ref($id, $ref_id) {
		$title = trans_choice('msg.product', 2);
		$small_title = __('msg.edit');
		$product = InventaireProduit::findOrFail($id);
		$stocks = InventaireProduitReference::where('produit_id', $id)->get();
		$edit_mode = true;
		$reference = InventaireProduitReference::where('id', $ref_id)->firstOrFail();
		$ensim_ids = $this->getAllEnsimIds();

		return view('administration.materiel.products.stock')
			->with('title', $title)
			->with('small_title', $small_title)
			->with('product', $product)
			->with('reference', $reference)
			->with('edit_mode', $edit_mode)
			->with('ensim_ids', $ensim_ids);
  	}

  public function add_ref(Request $request, $id) {

	$product = InventaireProduit::findOrFail($id);

	$rules = [
		'serialnumber' => [
			'required',
			'string',
			'unique:inventaire_produits_references,numero_serie,NULL,id,produit_id,'.$id,
		],
		'ensim_id' => [
			'required',
			'string',
			'regex:/^(E-)[a-zA-Z0-9-]{1,18}$/',
			'unique:inventaire_produits_references,ensim_id',
		],
		'stockage' => [
			'required',
			'string',
		],
		'status' => [
			'required',
			'integer',
			'between:0,3',
		],
	];

	$messages = [
		'serialnumber.unique' => __('validation.reference.serial_nb_unavailable'),
		'ensim_id.unique' => __('validation.reference.ensim_id_unavailable'),
		'ensim_id.regex' => __('validation.reference.ensim_id_wrong_format'),
	];

	$validator = \Validator::make($request->all(), $rules, $messages);

	if ($validator->fails()) {
		toastr()->error(__('validation.reference.added.error'));
		return redirect()->back()->withInput()->withErrors($validator);
	}

	$reference = InventaireProduitReference::create([
		'produit_id' => $id,
		'numero_serie' => $request->serialnumber,
		'stockage' => $request->stockage,
		'status' => $request->status,
		'ensim_id' => $request->ensim_id,
		'details' => $request->details ?? "",
	]);

	//Ajout des documents
	if ($request->docs_info != null) {
		$files = $request->file('documents');
		foreach($request->docs_info as $doc) {
			$doc = json_decode($doc);
			$file = array_filter($files, function($elem) use($doc){
				return $elem->getClientOriginalName() == $doc->fichier;
			})[0];
			if (empty($doc->nom)) {
				$doc->nom = $file->getClientOriginalName();
			}
			if (strlen($doc->nom) > 35) {
				$doc->nom = substr($doc->nom, 0, 35);
			}
			$filename = $file->store('documents');
			InventaireReferenceFichier::create([
				'reference_id' => $reference->id,
				'nom' => $doc->nom ?? $file->getClientOriginalName(),
				'fichier' => $filename,
			]);
		}
	}

	toastr()->success(__('validation.reference.added.success'));
	return redirect()->route('administration.materiel.products.stocks', $id);
  }

  public function update_ref(Request $request, $id, $ref_id) {

	$product = InventaireProduit::findOrFail($id);
	$ref = InventaireProduitReference::findOrFail($ref_id);

	$rules = [
		'serialnumber' => [
			'required',
			'string',
			\Rule::unique('inventaire_produits_references', 'numero_serie')->where(function($query) use ($id, $ref_id) {
				$query->where('produit_id', $id)
				->where('id', "!=", $ref_id);
			})
		],
		'ensim_id' => [
			'required',
			'string',
			'regex:/^(E-)[a-zA-Z0-9-]{1,18}$/',
			\Rule::unique('inventaire_produits_references', 'ensim_id')->ignore($ref_id),
		],
		'stockage' => [
			'required',
			'string',
		],
		'status' => [
			'required',
			'integer',
			'between:0,3',
		],
	];

	$messages = [
		'serialnumber.unique' => __('validation.reference.serial_nb_unavailable'),
		'ensim_id.unique' => __('validation.reference.ensim_id_unavailable'),
		'ensim_id.regex' => __('validation.reference.ensim_id_wrong_format'),
	];

	$validator = \Validator::make($request->all(), $rules, $messages);

	if ($validator->fails()) {
		toastr()->error(__('validation.reference.updated.error'));
		return redirect()->back()->withInput()->withErrors($validator);
	}


	// Suppression ou renommage des anciens docs
	$docsToKeep = array();
	if ($request->docs_info != null) {
		foreach ($request->docs_info as $doc) {
			$doc = json_decode($doc);
			if ($doc->id_fichier != null) {
				array_push($docsToKeep, $doc->id_fichier);
			}
		}
	}
	foreach ($ref->fichiers as $doc) {
		if (in_array($doc->id, $docsToKeep)) {
			$file = json_decode(array_values(array_filter($request->docs_info, function($elem) use($doc){
				$elem = json_decode($elem);
				return $elem != NULL && $elem->id_fichier == $doc->id;
			}))[0]);
			if (!empty($file->nom)) {
				$doc->nom = $file->nom;
				$doc->save();
			}
		} else {
			Storage::delete(asset($doc->fichier));
			$doc->delete();
		}
	}


	// Ajout des nouveaux documents
	if ($request->docs_info != null) {
		$files = $request->file('documents');
		foreach($request->docs_info as $doc) {
			$doc = json_decode($doc);
			if (!empty($doc->id_fichier)) {
				continue;
			}
			$file = array_filter($files, function($elem) use($doc){
				return $elem->getClientOriginalName() == $doc->fichier;
			})[0];
			if (empty($doc->nom)) {
				$doc->nom = $file->getClientOriginalName();
			}
			if (strlen($doc->nom) > 35) {
				$doc->nom = substr($doc->nom, 0, 35);
			}
			$filename = $file->store('documents');
			InventaireReferenceFichier::create([
				'reference_id' => $ref->id,
				'nom' => $doc->nom,
				'fichier' => $filename,
			]);
		}
	}

	$reference = InventaireProduitReference::where('id', $ref_id)->firstOrFail();
	$reference->numero_serie = $request->serialnumber;
	$reference->stockage = $request->stockage;
	$reference->status = $request->status;
	$reference->ensim_id = $request->ensim_id;
	$reference->details = $request->details ?? "";
	$reference->save();

	toastr()->success(__('validation.reference.updated.success'));
	return redirect()->route('administration.materiel.products.stocks', $id);
  }

  public function delete_ref($id, $ref_id) {

	$product = InventaireProduit::findOrFail($id);
	$reference = InventaireProduitReference::where('id', $ref_id)->firstOrFail();

	// Suppression impossible si la référence est liée à des emprunts
	if (count($reference->emprunts) > 0) {
		flash(__('validation.reference.deleted.error.loan'))->error();
		return redirect()->back()->withInput();
	}

	$reference->delete();
	toastr()->success(__('validation.reference.deleted.success'));
	return redirect()->route('administration.materiel.products.stocks', $id);
  }

  public function getAllBrands() {
	$brands = InventaireProduit::distinct()->orderBy('marque', 'ASC')->get('marque')->toArray();
	$array = array();
	foreach($brands as $brand) {
		array_push($array, $brand['marque']);
	}
	return $array;
  }

  public function getAllEnsimIds() {
	$ensim_ids = InventaireProduitReference::distinct()->orderBy('ensim_id', 'ASC')->get('ensim_id')->toArray();
	$array = array();
	foreach($ensim_ids as $id) {
		array_push($array, $id['ensim_id']);
	}
	return $array;
  }
}
