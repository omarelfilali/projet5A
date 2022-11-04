<?php

namespace App\Http\Controllers\Public\Materiel;

use Illuminate\Http\Request;
use App\Models\InventaireProduitReference;
use Auth;

class QRCodeController extends Controller
{
    public function index($ref_id) {
		$ref = InventaireProduitReference::findOrFail($ref_id);

		if(Auth::guard('personnel')->user() != null && Auth::guard('personnel') ->user()->isTechnicien()) {
			return redirect()->route('administration.materiel.products.stocks', ['id' => $ref->produit->id, 'search' => $ref->ensim_id]);
		} else {
			return redirect()->route('products.show', ['id' => $ref->produit->id, 'search' => $ref->ensim_id]);
		}
	
	}
}
