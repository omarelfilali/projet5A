@extends('layouts.default-mat')

@section('content')
@include('partials.inventoryheader')

<style>
	.range{
		font-size: 12px;
		border: 2px solid #5b9cff;
		background: #0d6efd;
		text-align: center;
		border-radius: 7px;
		color: white;
		font-weight: bold;
		vertical-align: middle;
		padding: 1px;
		margin-left: 5px;
		cursor: default;
	}

	.search-force-hide, .stock-force-hide{
		display: none !important;
	}

	.card{
		cursor: pointer;
		transition: all 0.15s ease;
	}

	.card:hover{
		margin-top: -5px;
	}

	.product-img {
		width: 100%;
		height: 150px;
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

	.column-filtres{
		width: 350px;
	}

	@media screen and (max-width: 1000px) {
		.column-filtres {
    		width: 100%;
			z-index: 10 !important;
		 }
	}
</style>

<div class="page-container m-4">
	<div class="row">
		<div class="column-filtres mb-4">
			<div class="accordion">
				<div class="accordion-item">
				  <h2 class="accordion-header" id="panelsStayOpen-headingOne">
					<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
					  Filtres
					</button>
					
				  </h2>
				  <div class="accordion-collapse collapse show">
					<div class="accordion-body">
						<div>
							<input type="text" class="form-control mb-3" name="searchbar" id="searchbar" placeholder="Rechercher...">
							
							<hr/>

							{{-- @if (count($selectable_types) > 0) --}}
								<div class="mb-2">
									<label for="product_type" class="form-label">Type de produits</label>
									{{-- <select id="product_type" class="form-select">
										<option value="all">Tous les types</option>
										@foreach ($selectable_types as $type)
											@if (count($type->produits) > 0)
												<option {{ (request()->get('product_type') == $type->id) ? 'selected' : '' }} value="{{ $type->id}}">{{ $type->nom }} ({{count($type->produits)}})</option>
											@endif
										@endforeach
									</select> --}}
									<select id="product_type" class="form-select">
										<option onclick="window.open('{{ route('public.materiel.products.index')}}' , '_self')">Tous les types</option>
										@foreach ($categories as $category)
										<!-- Si la catégorie est dans le top 3 des catégories -->
										@if ($loop->index <= 2)
											<option style="font-size:16px; font-weight:bold;" onclick="window.open('{{ route('public.materiel.products.category', ['category' => $category->nom, 'type' => $category->id])}}' , '_self')" {{ (request()->get('type') == $category->id) ? 'selected' : '' }} style="cursor:pointer">{{ $category->nom }} ({{ $category->number_of_products() }})</option>
											@foreach ($category->product_types as $product_type)
												<option onclick="window.open('{{ route('public.materiel.products.category', ['category' => $product_type->categorie->nom, 'product_type' => $product_type->id])}}' , '_self')" {{ (request()->get('product_type') == $product_type->id) ? 'selected' : '' }} value="{{ $product_type->id}}">{{ $product_type->nom }} ({{count($product_type->produits)}})</option>
											@endforeach
										@endif
										@endforeach
									</select>
								</div>
							{{-- @endif --}}

							<div class="form-check form-switch">
								<label class="form-check-label" for="in_stock">En stock uniquement</label>
								<input class="form-check-input" type="checkbox" role="switch" id="in_stock" checked @if($in_stock != null) checked @endif 'tabindex="0" class="hidden">
							</div>
						
							@if($selected_type != null)

								@if(count($selected_type->marques($in_stock)) > 1)
									<div class="my-4">
										<label class="mb-2">Marques</label>
										<select id="filter-marque" multiple class="filter select2-multiple form-select mt-2">
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
													<div class="my-4">
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
												<div class="my-4">
													<p>
														<label class="form-label mb-0">{{ $filtre->nom }} ({{$filtre->unite}})</label>
														<input type="text" id="value-filter-{{$filtre->id}}" class="filter range" size="6" readonly>
													</p>
													<div class="slider-range" id="filter-{{$filtre->id}}" class="filter">
														<input type="hidden" id="filter-{{$filtre->id}}-min" value={{$filtre->valeur_min($in_stock)}}>
														<input type="hidden" id="filter-{{$filtre->id}}-max" value={{$filtre->valeur_max($in_stock)}}>
													</div>
												</div>
													{{-- <div class="my-4">
														<label class="form-label" style="">{{ $filtre->nom }} ({{$filtre->unite}})</label>
														<input type="range" class="form-range" id="filter-{{$filtre->id}}">
													</div>
													<input type="hidden" id="mdb-{{$filtre->id}}-min" value={{$filtre->valeur_min($in_stock)}}>
													<input type="hidden" id="mdb-{{$filtre->id}}-max" value={{$filtre->valeur_max($in_stock)}}> --}}
												@endif
												@break

											{{-- Type Alphanumerique --}}
											@case(2)
												<div class="my-4">
													<label class="mb-2">{{ $filtre->nom }}</label>
													<select id="filter-{{$filtre->id}}" multiple class="filter select2-multiple form-select mt-2">
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

		<div class="column-materiels col" id="liste-materiel">
			<div class="list row">
				@foreach ($products as $p)
				<div class="produit" style="width:300px">
					<a href="{{ route('public.materiel.products.show', ['id' => $p->id])}}" class="card mb-4">
						<div class="card-body">
						
							<div class="image product-img mb-2">
								<img src="{{ asset('storage/module_materiel/' . $p->imageParDefaut) }}"/>
							</div>

							<div class="mb-1">
								<p class="nom" style="font-size: 16px" >{{ $p->nom }}</p>
							</div>

							<div>
								<p class="badge bg-primary categorie">{{ $p->type->nom }}</p>
								@if ($p->enStock)
									<p class="badge bg-success" data-stock="1">En stock</p>
								@else
								<p class="badge bg-danger" data-stock="0">Indisponible</p>
								@endif
							</div>

							<div class="caracteristiques" style="display: none">
								{{-- Le data-type="2" ci-dessous correspond au type select (select2) --}}
								<input type="hidden" data-type="2" data-filtre="filter-marque" value="{{ $p->marque }}">
								@foreach ($p->filtres as $filtre)
									<input type="hidden" data-type="{{ $filtre->filtre->valeur_type }}" data-filtre="filter-{{ $filtre->filtre_id }}" value="{{ $filtre->valeur }}">
								@endforeach
							</div>

						</div>
					</a>
				</div>
				@endforeach
			</div>
		</div>

	</div>
</div>

<script type="module">
	$(document).ready(function () {

		// function updateSearch() {
		// 	// basic url without parameters
		// 	var url = location.protocol + '//' + location.host + location.pathname + '?'

		// 	let product_type = $('#product_type').val()
		// 	if (product_type != null && product_type != "all") {
		// 		url += "product_type=" + product_type + "&"
		// 	}

		// 	if ($('#in_stock').is(":checked")) {
		// 		url += "&in_stock=true&"
		// 	}

		// 	// reload page
		// 	document.location.href = url;
		// }

		$('#product_type').change(function() {
			updateSearch();
		});

		// Live search

		// var options = {
		// 	valueNames: ['nom','categorie'],
		// };

    	// var listeMateriel = new List('liste-materiel', options);

		// $('#searchbar').on('keyup', function() {
		// 	var searchString = $(this).val();
		// 	listeMateriel.search(searchString);
		// });

		// Barre de recherche des produits
		$('#searchbar').on('keyup', function() {
			var searchFilter = $(this).val().toUpperCase();
			let produits = $(".produit");

			// Si la barre de recherche n'est pas vide alors on fait la vérification
			if (searchFilter != null && searchFilter != ""){
				// Pour chaque produit, on cache/affiche en fonction de la vérification
				produits.each(function(){
					if ($(this).find(".nom").text().toUpperCase().includes(searchFilter)){
						$(this).removeClass("search-force-hide");
					}else{
						$(this).addClass("search-force-hide");
					}
				});
			}else{
				// Si la barre de recherche est vide alors on affiche tout
				produits.removeClass("search-force-hide");
			}
		});

		// Afficher / Cacher les produits en stock uniquement
		function afficherEnStocks(){
			if ($('#in_stock').is(":checked")){
				$("p[data-stock='0']").parents(".produit").addClass("stock-force-hide");
			}else{
				$("p[data-stock='0']").parents(".produit").removeClass("stock-force-hide");
			}
		}

		$('#in_stock').on('click', function() {
			afficherEnStocks();
		});

		// Select2 pour les champs à tags dans les filtres
		function actualiserRecherche(){
			// Mise en variable des produits et des fitres affichés
			let produits = $(".produit");
			let filtres = $(".filter");

			// On affiche tous les produits pour recommencer la vérification
			produits.show();

			// La variable data regroupe tous les différents filtres actifs
			// sous forme d'array multi-dimensionnel
			var filtresActifs = [];

			// Pour chaque filtre
			filtres.each(function(){

				// Si il s'agit d'un select2 de plusieurs tags :
				if ($(this).hasClass("select2-multiple")){
					let tags = $(this).select2('data');
					let filtreId = $(this).attr("id");
					let filtresArray = [];

					// Si le filtre est activé (contient des tags sélectionnés)
					if (tags.length != 0){

						// Alors on ajoute les tags dans un tableau
						tags.forEach(element => {
							filtresArray.push(element.text);
						});

						// Puis on ajoute ce nouveau tableau dans notre tableau principal,
						// en lui attribuant le nom du filtre (filtreId) pour y accéder facilement
						filtresActifs[filtreId] = filtresArray;
					}
				}

				// Si il s'agit d'un slider range
				else if ($(this).hasClass("range")){

					// On récupère l'id du filtre en le formattant
					let filtreId = $(this).attr("id").replace('value-','');

					// On récupère le range en le splittant en deux valeurs distinctes
					let range = $(this).val().split(" - ");

					// Ce qui nous donne deux variables, le min et le max :
					let min = range[0];
					let max = range[1];

					// Puis on envoi nos valeurs dans le tableau principal des filtres actifs
					filtresActifs[filtreId] = range;
				}
			});

			// Puis, pour chaque produit :
			produits.each(function(){
				// Visiblité du produit par défaut sur 1 (= visible)
				let visible = 1;
				let caracteristiques = $(this).find(".caracteristiques>input");

				// Pour chaque caractéristique du produit
				caracteristiques.each(function(){

					// On met en variable le nom du filtre actuellement vérifié
					let filtreCible = $(this).data("filtre");
					let filtreType = $(this).data("type");

					// Dans un premier temps, on vérifie si des options ont été sélectionnées pour le filtre actuel
					if (filtresActifs[filtreCible]){

						// En fonction du type de filtre (select, range, checkbox..)
						switch (filtreType) {
							// Si il s'agit d'un select : 
							case 2:
								// Si oui, on vérifie que les caractéristiques du produit actuellement vérifié
								// sont présentes dans le tableau du filtre correspondant
								// (En réalité, on vérifie si celles-ci sont ABSENTES du tableau)
								if (filtresActifs[filtreCible].includes($(this).val()) == false){
									// Si la caractéristique ne correspond pas aux critères sélectionnés par le filtre
									// alors on cache le produit (visible = 0)
									visible = 0;
									
									return false;
								}
								break;
						
							// Si il s'agit d'un range, alors :
							case 1:
								// Alors on vérifie que la valeur de la caractéristique du produit
								// est comprise entre le min et le max
								// (En réalité, on vérifie l'inverse et on cache le produit si c'est le cas)
								if (parseInt($(this).val()) < parseInt(filtresActifs[filtreCible][0])  || parseInt($(this).val()) > parseInt(filtresActifs[filtreCible][1])){
									// Si la caractéristique ne correspond pas aux critères sélectionnés par le filtre
									// alors on cache le produit (visible = 0)
									visible = 0;
									return false;
								}
								break;
						}

						
						
					}
				});

				// On cache le produit si celui-ci ne correspond pas aux critères
				if (visible == 0){
					$(this).hide();
				}

			});
		}

		// On initialise les select2-multiple
		$('.select2-multiple').select2({
			theme: 'bootstrap-5'
		});

		// En cas de changement sur le select-multiple, on actualise la recherche
		$('.select2-multiple').on("change", function(){
			actualiserRecherche();
		});

		// On actualise les produits selons les filtres lors du chargement de la page
		actualiserRecherche();
		afficherEnStocks();

		// Pour chaque slider range
		$(".slider-range").each(function(){
			// On met en variable le filtre concerné, le min et le max du range
			let filtre = $(this).attr("id");
			let min = parseInt($(this).children(`#${filtre}-min`).val());
			let max = parseInt($(this).children(`#${filtre}-max`).val());

			// Puis on met en variable les paramètres min/max actuels (pour conserver les réglages en cas de refresh)
			let actualMin = parseInt($(`#value-${filtre}`).val().split(" - ")[0]);
			let actualMax = parseInt($(`#value-${filtre}`).val().split(" - ")[1]);

			// Si on trouve aucune valeur dans le slider
			// Alors le slider aura pour valeur les min et max des caractéristiques du filtre
			if (isNaN(actualMin) || isNaN(actualMax)){
				actualMin = min;
				actualMax = max;
				$(`#value-${filtre}`).val(min + " - " + max);
			}

			let length = parseInt(actualMin.toString().length) + parseInt(actualMax.toString().length);
			$(`#value-${filtre}`).attr("size", length);

			// Puis on configure le range en fonction des paramètres obtenus précédemment
			$(this).slider({
				range: true,
				min: min,
				max: max,
				values: [actualMin, actualMax],
				// Lors du changement de position d'un des curseurs, on actualise
				slide: function( event, ui ) {
					let length = parseInt(ui.values[0].toString().length) + parseInt(ui.values[1].toString().length);
					$(`#value-${filtre}`).val( "" + ui.values[0] + " - " + ui.values[1]);
					$(`#value-${filtre}`).attr("size", length);
				},
				stop: function(event, ui){
					actualiserRecherche();
				}
			});
		});
	});
</script>

@endsection


