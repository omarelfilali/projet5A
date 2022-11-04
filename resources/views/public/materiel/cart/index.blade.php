@extends('layouts.default-mat')

@section('css')
<style>
	.input{ font-size:1.3em; padding:.5em; }
	.form-control {
	    min-width: 150px !important;
		width: 150px;
	}
	.ui.middle.aligned.divided.list > .item {
		padding-top: 10px;
		padding-bottom: 10px;
	}
</style>
@endsection

@section('content')
@include('partials.inventoryheader')

<div class="page-container" style="padding-top: 20px">
<h1>Mon panier</h1>
	<div class="page">
		@if ($panier->estVide())
			<div>Votre panier est vide</div>
		@endif
		<div class="ui middle aligned divided list" style="padding: 25px">
			@foreach ($panier->lignes as $ligne)
				<div class="item">
					<img class="ui avatar rounded image desktop-only" src="{{ asset($ligne->produit->ImageParDefaut) }}"/>
					<div class="content">
						<span style="font-size: 18px;">{{ $ligne->produit->nom }}</span>
						@if ($ligne->produit->enStock)
							<span class="ui green horizontal label  mobile-only">En stock</span>
						@else
							<span class="ui red horizontal label  mobile-only">Indisponible</span>
						@endif
						<br class="mobile-only"/>
						<br/>
						<select name="quantite" onchange="new_quantity_selected(this,{{$ligne->produit->id}})" class="form-control mobile-only" style="padding-top: 5px; padding-bottom: 5px">
							@for ($i = 0; $i <= $ligne->produit->nombreStock; $i++)
								<option value="{{ $i }}" @if ($ligne->quantite == $i) selected @endif>{{ $i }} @if ($i==0) (Supprimer) @endif</option>
							@endfor
						</select>
						<div class="ui red tiny button mobile-only" onclick="remove_product({{$ligne->produit->id}})">Supprimer</div>

						@if ($ligne->produit->enStock)
							<span class="ui green horizontal label desktop-only">En stock</span>
						@else
							<span class="ui red horizontal label desktop-only">Indisponible</span>
						@endif
					</div>
					<div class="right floated content desktop-only">
						<select name="quantite" onchange="new_quantity_selected(this,{{$ligne->produit->id}})" class="form-control">
							@for ($i = 0; $i <= $ligne->produit->nombreStock; $i++)
								<option value="{{ $i }}" @if ($ligne->quantite == $i) selected @endif>{{ $i }} @if ($i==0) (Supprimer) @endif</option>
							@endfor
						</select>
						<div class="ui red button" onclick="remove_product({{$ligne->produit->id}})">Supprimer</div>
					</div>
				</div>
			@endforeach
		</div>

		<a href="{{route('public.materiel.cart.validation')}}">
			<center><button type="submit" class="ui green button">Valider le panier</button></center>
		</a>
	</div>
</div>

@endsection

@section('js')
<script>
	$('select[name="quantite"]')
	  .dropdown()
	;
	function display_update_btn(id_produit) {
		document.getElementById('btn_quantity_' + id_produit).style.visibility = "visible";
	}

	function new_quantity_selected(select, id_produit) {
		if (select.value == 0) {
			remove_product(id_produit)
		} else {
			update_product_quantity(select, id_produit)
		}
	}

	function update_product_quantity(select, id_produit) {
        $.ajax({
            type: "PATCH",
            url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/panier/ligne/quantite') : url('api/panier/ligne/quantite') }}",
            data: {
                id_produit: id_produit,
				quantite: select.value
            },
            success: function(data) {
				document.getElementById('lblCartCount').innerHTML = data.nbTotalArticles;
            },
			error: function(data) {
				location.reload();
			}
        });
    }

	function remove_product(id_produit) {
        $.ajax({
            type: "DELETE",
            url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/panier/ligne') : url('api/panier/ligne') }}",
            data: {
                id_produit: id_produit,
            },
            success: function(data) {
				location.reload();
            },
			error: function(data) {
				location.reload();
			}
        });
    }

</script>
@endsection
