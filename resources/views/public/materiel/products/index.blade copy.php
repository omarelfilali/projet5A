@extends('layouts.default-mat')

@section('css')
<style>
	.product-img {
		width: 100%;
		height: 200px;
		line-height: 200px;
		text-align: center;
		background: white;
		display: inline-block;
		vertical-align:top;
	}

	.product-img > img{
		max-width: 100%;
	    max-height: 100%;
	    position: relative;
	    padding: 5px;
	}

	.page-container {
		padding: 20px;
	}

	.ui.link.cards{
		margin-bottom: 10px;
	}

	.column-produits {
		display: inline-block;
		vertical-align:top;
	}

	@media screen and (min-width: 1000px) {
		.column-filtres {
			width: 300px;
			display: inline-block;
			vertical-align:top;
			margin-right: 15px;
		}

		.column-produits {
			width: calc(100% - 320px);
		}

		.filtres.fixed {
			 padding-top: 15px;
			 width: 300px;
			 z-index: 1 !important;
		 }
	}

	@media screen and (max-width: 1000px) {
		.filtres.fixed {
    		width: calc(100% - 40px);
			z-index: 10 !important;
		 }
	}

	.field>label {
		font-family: Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;
	}

	.delete.icon {
		color: black;
	}

</style>
@endsection

@section('content')
@include('partials.inventoryheader')

<div class="page-container">
	<div class="column-filtres">
			<div class="filtres">
				<div class="content">
					<div class="ui accordion" style="margin-bottom: 20px">
  					<div class="title" style="padding: 0px">
						<h3 class="ui top attached header" style="width: 100%">
							Filtres
						</h3>
					</div>
					<div class="content" style="padding: 0px">
						<div class="ui attached segment ui form" style="width: 100%">
							<div class="ui input" style="width: 100%">
							  <input type="text" name="searchbar" id="searchbar" placeholder="Rechercher...">
							</div>
							<hr/>

							@if (count($selectable_types) > 0)
								<div class="field">
									<label style="">Type de produits</label>
									<select id="product_type" class="ui dropdown">
										<option value="all">Tous les types</option>
										@foreach ($selectable_types as $type)
											@if (count($type->produits) > 0)
												<option value="{{ $type->id}}">{{ $type->nom }} ({{count($type->produits)}})</option>
											@endif
										@endforeach
									</select>
								</div>
							@endif

							<div class="field">
								<label style="">En stock uniquement</label>
								<div class="inline field">
									<div class="ui toggle checkbox">
										<input id="in_stock" type="checkbox" @if($in_stock != null) checked @endif 'tabindex="0" class="hidden">
									</div>
								</div>
							</div>

							@if($selected_type != null)

								@if(count($selected_type->marques($in_stock)) > 1)
									<div class="field">
										<label style="">Marques</label>
										<select id="marque" multiple="" class="ui dropdown">
											<option value="">Sélectionner une marque</option>
											@foreach ($selected_type->marques($in_stock) as $marque)
												<option value="{{$marque}}">{{$marque}}</option>
											@endforeach
										</select>
									</div>
								@endif

								@if(count($selected_type->filtres) > 0)
									@foreach($selected_type->filtres as $filtre)
										@switch($filtre->valeur_type)

											{{-- Type Binaire --}}
												@case(0)
													<div class="field">
														<label style="">{{ $filtre->nom }}</label>
														<div class="inline field">
															<div class="ui toggle checkbox">
																<input id="filter-{{$filtre->id}}" type="checkbox" tabindex="0" class="hidden">
															</div>
														</div>
													</div>
													@break

											{{-- Type Numerique --}}
											@case(1)
												@if ($filtre->valeur_max($in_stock) !=  $filtre->valeur_min($in_stock))
													<div class="field">
														<label style="">{{ $filtre->nom }} ({{$filtre->unite}})</label>
														<div class="multi-range-field my-5 pb-5" style="margin: 0px !important">
															<input id="filter-{{$filtre->id}}" class="multi-range" type="range" />
														</div>
													</div>
													<input type="hidden" id="mdb-{{$filtre->id}}-min" value={{$filtre->valeur_min($in_stock)}}>
													<input type="hidden" id="mdb-{{$filtre->id}}-max" value={{$filtre->valeur_max($in_stock)}}>
												@endif
												@break

											{{-- Type Alphanumerique --}}
											@case(2)
												<div class="field">
													<label style="">{{ $filtre->nom }}</label>
													<select id="filter-{{$filtre->id}}" multiple="" class="ui dropdown">
														<option value="">Sélectionner une valeur</option>
														@foreach ($filtre->liste_valeur($in_stock) as $valeur)
															<option value="{{$valeur}}">{{$valeur}}</option>
														@endforeach
													</select>
												</div>
												@break

										@endswitch
									@endforeach
								@endif
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="column-produits">
		@if (count($products) == 0)
			<div>La recherche n'a donné aucun résultat</div>
		@endif
		<div class="ui link cards">
			@foreach ($products as $p)
				<a href="{{ route('products.show', ['id' => $p->id])}}">
					<div class="card" id="product-{{$p->id}}">
						<div class="image product-img">
							<img src="{{ asset('storage/module_materiel/' . $p->imageParDefaut) }}"/>
						</div>
						<div class="content">
							<a class="header" href="{{ route('products.show', ['id' => $p->id])}}">{{ $p->nom }}</a>
							<div class="meta">
								<span>{{ $p->type->nom }}</span>
							</div>
						</div>
						<div class="extra content">
							@if ($p->enStock)
								<a class="ui green label" href="{{ route('products.show', ['id' => $p->id])}}">En stock</a>
							@else
							<a class="ui red label" href="{{ route('products.show', ['id' => $p->id])}}">Indisponible</a>
							@endif

						</div>
					</div>
				</a>
			@endforeach
		</div>
	</div>
</div>

@endsection

@section('js')
<script type="module">

function updateSearch() {
	// basic url without parameters
	url = location.protocol + '//' + location.host + location.pathname + '?'

	product_type = $('#product_type').val()
	if (product_type != null && product_type != "all") {
		url += "product_type=" + product_type + "&"
	}

	if ($('#in_stock').is(":checked")) {
		url += "&in_stock=true&"
	}

	// reload page
	document.location.href = url;
}

$(document).ready(function() {
	$('.ui.accordion').accordion();

	$('.ui.accordion .title').click(function(e) {
		var viewport_width = window.innerWidth;
		if (viewport_width > 1000)
		{
			e.stopImmediatePropagation();
		}
	});

	var viewport_width = window.innerWidth;
	if (viewport_width < 1000){
		$('.ui.accordion').accordion("option", "active", 0);
	}
	else {
		$('.ui.accordion').accordion("option", "active", 1);
	}

	window.addEventListener('resize', function() {
		var viewport_width = window.innerWidth;
		var viewport_height = window.innerHeight;

		if (viewport_width < 1000){
			$('.ui.accordion').accordion("option", "active", 0);
		}
		else {
			$('.ui.accordion').accordion("option", "active", 1);
		}

		$('.filtres .accordion .content').css( "max-height", (viewport_height-30)+"px" );

		console.log($('.filtres').height() + " // " + viewport_height);

		if ($('.filtres').height() + 20 > viewport_height){
			$('.filtres .accordion .content').css( "overflow-y", "scroll");
		}
		else {
			$('.filtres .accordion .content').css( "overflow-y", "visible");
		}
	});

	$('.filtres').visibility({
		type: 'fixed',
	});

	$('.ui.checkbox').checkbox();
	$('select.dropdown').dropdown();

	$('#marque').change(function() {
		applyFrontFilters();
	})

	$('#searchbar').on("input", function() {
		applyFrontFilters();
	})

	@if($selected_type != null && count($selected_type->filtres) > 0)

		let computeStepResult;
		@foreach($selected_type->filtres as $filtre)

			$('#filter-{{$filtre->id}}').change(function() {
				applyFrontFilters();
			})

			@switch($filtre->valeur_type)

				{{-- Type Binaire --}}
					@case(0)

						@break

				{{-- Type Numerique --}}
				@case(1)
					computeStepResult = computeStep({{ $filtre->valeur_min($stock_in ?? false)}}, {{ $filtre->valeur_max($stock_in ?? false)}})
					$('#filter-{{$filtre->id}}').mdbRange({
						width: '100%',
						value: {
							min: computeStepResult.min,
							max: computeStepResult.max,
						},
						single: {
							active: true,
							multi: {
								active: true,
								counting: true,
								countingTarget: ['#mdb-{{$filtre->id}}-min', '#mdb-{{$filtre->id}}-max'],
								rangeLength: 2,
								value: {
									step: computeStepResult.step
								},
							},
						}
					});
					@break

				{{-- Type Alphanumerique --}}
				@case(2)

					@break

			@endswitch
		@endforeach
	@endif

	getFilterBack();

	$('#product_type').change(function() {
		updateSearch();
	});

	$('#in_stock').change(function() {
		updateSearch();
	});
});

function getFilterBack() {

	@if($selected_type != null)
		$('#product_type').val({{ $selected_type->id }});
		$('#product_type').trigger("change");
	@endif

}

function computeStep(min, max) {
	let coeff = 1;
	let maxcpy = max;
	if (maxcpy < 0.1) {
		while (maxcpy < 0.1) {
			maxcpy *= 10;
			coeff /= 10;
		}
	} else if (maxcpy > 1) {
		while (maxcpy > 1) {
			maxcpy /= 10;
			coeff *= 10;
		}
	}

	min = Math.floor(min / coeff) * coeff;
	max = Math.ceil(max / coeff) * coeff;

	return {
		min: min,
		max: max,
		step: max/100,
	};
}

function applyFrontFilters() {

	productsToHide = new Set();
	productsToShow = new Set();

	let show = true;
	let min, max, temp, checked;
	let values, marques;

	let searchFilter = $('#searchbar').val().toUpperCase();

	@foreach ($products as $p)

		/*********************** PRODUCT {{$p->id}} ******************/
		show = true;

		@if($selected_type != null)

			@if(count($selected_type->marques($in_stock)) > 1)
				marques = $('#marque').val();
				if (marques && marques.length > 0 && !marques.includes("{{$p->marque}}")) {
					show = false;
				}
			@endif

			@if(count($selected_type->filtres) > 0)
				@foreach($selected_type->filtres as $filtre)
					@switch($filtre->valeur_type)

						{{-- Type Binaire --}}
							@case(0)
								checked = $('#filter-{{$filtre->id}}').is(":checked");
								@foreach ($p->filtres as $spec)
									@if($spec->filtre_id == $filtre->id)
										if (checked && {{$spec->valeur}} != 1) {
											show = false;
										}
									@endif
								@endforeach
								@break

						{{-- Type Numerique --}}
						@case(1)
							@if ($filtre->valeur_max($in_stock) !=  $filtre->valeur_min($in_stock))
								min = parseFloat($('#mdb-{{$filtre->id}}-min').val());
								max = parseFloat($('#mdb-{{$filtre->id}}-max').val());
								if (min > max) {
									temp = max;
									max = min;
									min = temp;
								}
								@foreach ($p->filtres as $spec)
									@if($spec->filtre_id == $filtre->id)
										if ( {{$spec->valeur}} < min || {{$spec->valeur}} > max) {
											show = false;
										}
									@endif
								@endforeach
							@endif
							@break

						{{-- Type Alphanumerique --}}
						@case(2)
							values = $('#filter-{{$filtre->id}}').val();
							@foreach ($p->filtres as $spec)
								@if($spec->filtre_id == $filtre->id)
									if (values && values.length > 0 && !values.includes("{{$spec->valeur}}")) {
										show = false;
									}
								@endif
							@endforeach
							@break

					@endswitch
				@endforeach
			@endif
		@endif

		if(searchFilter != null && searchFilter != "") {
			if (!("{{$p->nom}}".toUpperCase().includes(searchFilter) ||
					"{{$p->marque}}".toUpperCase().includes(searchFilter) ||
					"{{$p->type->nom}}".toUpperCase().includes(searchFilter))) {
				show = false;
			}
		}

		if (show) {
			productsToShow.add({{$p->id}});
		} else {
			productsToHide.add({{$p->id}});
		}

	@endforeach

	productsToHide.forEach(function callback(key, value) {
		$("#product-" + value).hide();
	});
	productsToShow.forEach(function callback(key, value) {
		$("#product-" + value).show();
	});

}

</script>
@endsection
