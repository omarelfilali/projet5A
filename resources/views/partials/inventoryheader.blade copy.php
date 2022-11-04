<style>
	.menu-banner-bg {
		position: absolute;
		right: 0;
		width: calc(100% - 266px);
		height: 33px;
		clip-path: polygon(0% 0%, 0% 100%, 100% 100%, 100% 0%) !important;
		padding: 0 !important;
        background: rgb(244, 244, 244);
        box-shadow: none;
        z-index: -1;
	}
    .menu-banner {
		position: absolute;
		right: 0;
		width: calc(100% - 346px);
		height: 33px;
		padding: 0 !important;
        background: rgb(244, 244, 244, 0);
        box-shadow: none;
	}

	.right-page-button {
		height: 100%;
        position: relative;
		padding: 10px;
	    font-size: 16px;
	    color: black;
	}

	.right-page-button>i {
		margin-right: 5px;
	}

	.right-page-button:hover {
		color: black;
	}

    .ui.text.menu {
        font-size: 16px;
    }

    .right-page-header {
        display: inline-block;
		width: fit-content;
	    float: right;
	    top: 5px;
	    right: 20px;
	    position: relative;
    }

    .center-page-header {
        display: inline-block;
        width: 49%;
    }

    .category-one {
        padding: 15px !important;
        color: black !important;
		top: 8px;
    }

	.ui.flowing.basic.admission.popup {
		position: absolute;
		width: 100%;
	}

	.page-container {
		clear: both;
	}

	.badge {
		padding-left: 9px;
		padding-right: 9px;
		-webkit-border-radius: 9px;
		-moz-border-radius: 9px;
		border-radius: 9px;
		background-color: #2d3f79;
	}

	#lblCartCount {
		font-size: 12px;
		color: #fff;
		padding: 0 5px;
		vertical-align: top;
		margin-left: -10px;
	}

	#lblRequestsCount {
		font-size: 12px;
		color: #fff;
		padding: 0 5px;
		vertical-align: top;
		margin-left: -16px;
	}

</style>

<div class="banniere">
    <i onclick="window.open('http://e-www3-t1.univ-lemans.fr/' , '_self')" class="fas fa-angle-double-left"></i>
    <p onclick="window.open('{{ route('products.index') }}' , '_self')" style="cursor:pointer">
		Inventaire matériel
	</p>
</div>

<div class="menu-banner-bg banniere">
</div>
<div class="menu-banner desktop-only">
    <div class="center-page-header">
		<div class="ui text menu">
			<a class="category-one item" style="top: -6px">
				 @isset($selected_category) {{ $selected_category->nom}} @endisset
				 @empty($selected_category) Catégories @endempty
				 <i class="dropdown icon"></i>
			</a>
		</div>
		<div class="ui flowing basic admission popup">
			<div class="ui two column relaxed divided grid">
				@foreach ($categories as $category)
				  <!-- Si la catégorie est dans le top 3 des catégories -->
				  @if ($loop->index <= 2)
				  <div class="column">
					<h4 class="ui header" onclick="window.open('{{ route('products.category', ['category' => $category->nom])}}' , '_self')" style="cursor:pointer">{{ $category->nom }} ({{ $category->number_of_products() }})</h4>
					<div class="ui link list">
						@foreach ($category->product_types as $product_type)
						  <a href="{{route('products.category', ['category' => $category->nom])}}?product_type={{$product_type->id}}" class="item">{{ $product_type->nom }} ({{ count($product_type->produits) }})</a>
						@endforeach
					</div>
				  </div>
				  @endif
				@endforeach
			</div>
		</div>
	</div>
	@if(Auth::guard('etudiant')->check())
		<div class="right-page-header">
			<a class="right-page-button" href="{{ route('requests.index') }}">
					<i class="far fa-list-alt"></i>
					<span>Demandes</span>
			</a>
			<a class="right-page-button" href="{{ route('cart.index') }}">
					<i class="fas fa-shopping-basket"></i>
					<span class='badge' id='lblCartCount'> {{ $panier->nbTotalArticles() }} </span>
					<span>Panier</span>
			</a>
		</div>
	@elseif(Auth::guard('personnel')->check())
		<div class="right-page-header">
			<a class="right-page-button" href="{{ route('administration.materiel.requests.index') }}">
					<i class="fas fa-user-cog"></i>
					<span class='badge' id='lblRequestsCount'> {{ $demandes_attente }} </span>
					<span>Gestion des demandes</span>
			</a>
		</div>
	@endif
</div>
