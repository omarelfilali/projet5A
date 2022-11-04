@extends('layouts.default-mat')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/fancybox-properties.css') }}">
<style>

@media screen and (min-width: 1000px) {
    .product-img {
        width: 300px;
        height: 300px;
        line-height: 300px;
        text-align: center;
        background: white;
        display: inline-block;
        vertical-align:top;
    }
}
@media screen and (max-width: 1000px) {
    .product-img {
        width: 100px;
        height: 100px;
        line-height: 100px;
        text-align: center;
        background: white;
        display: inline-block;
        vertical-align:top;
        margin-left: -15px!important;
    }
}


.mini-product-img.last>img:before {
    background: rgba(255,255,255,0.75);
    content: ' ';
    z-index: 20;
    top: 0;
    left: 0;
}

.mini-product-img {
    width: 90px;
    height: 90px;
    line-height: 90px;
    text-align: center;
    background: white;
    display: inline-block;
    vertical-align:top;
}

.product-img > img, .mini-product-img> img{
    max-width: 100%;
    max-height: 100%;
    position: relative;
    padding: 5px;
}

.addtocart {
    background: #f4f4f4;
    position: absolute;
    top: 260px;
    right: 25px;
    width: 400px;
    height: 240px;
    border-radius: 10px;
}

.addtocartbtn {
    bottom: 0;
    position: absolute;
}

.form-control {
     width: calc(100%) !important;
     max-width: calc(100%) !important;
     min-width: calc(100%) !important;
}
</style>

@endsection

@section('content')
@include('partials.inventoryheader')
<div class="page-container" style="padding: 20px">
    <div style="display: inline-block;vertical-align: top;">
        <div class="product-img"  style="display: inline-block">
            <img src="{{ asset('storage/module_materiel/' . $product->imageParDefaut) }}"  onclick="showFancy()"/>
        </div>
    </div>
    <div class="desktop-only" style="display: inline-block; padding-top: 25px; width: calc(100% - 300px - 400px - 20px);">
        <h1 style="text-align:left !important">{{ $product->nom }}</h1>
        <h4>{{ $product->type->nom }}</h4>

        <div style="padding-top: 40px">
            @php $count = 0 @endphp
            <div class="flex flex-wrap">

            @foreach ($product->imagesSecondaires as $image)
                @if ($count < 3)
                <a class="mini-product-img" onclick="showFancy()">
                    <img class="rounded" src="{{ asset($image->image) }}" />
                </a>
                @endif
                @php $count++ @endphp
            @endforeach
            @if ($product->imagesSecondaires->count() > 3)
                <div class="mini-product-img last" onclick="showFancy()" style="display: inline-block">
                    <i class="huge plus square outline icon"></i>
                </div>
            @endif
            </div>
        </div>
    </div>

    <div class="mobile-only" style="display: inline-block; width: calc(100% - 100px);">
        <h1 style="text-align:left !important; font-size: 25px">{{ $product->nom }}</h1>
        <h4 style="font-size: 15px;">{{ $product->type->nom }}</h4>

        <div style="padding-top: 40px">
            @php $count = 0 @endphp
            <div class="flex flex-wrap">

            @foreach ($product->imagesSecondaires as $image)
                @if ($count < 3)
                <a class="mini-product-img" onclick="showFancy()">
                    <img class="rounded" src="{{ asset($image->image) }}" />
                </a>
                @endif
                @php $count++ @endphp
            @endforeach
            @if ($product->imagesSecondaires->count() > 3)
                <div class="mini-product-img last" onclick="showFancy()" style="display: inline-block">
                    <i class="huge plus square outline icon"></i>
                </div>
            @endif
            </div>
        </div>
    </div>

    <div class="mobile-only">
        <hr/>
        <form style="display:inline;" method="POST" action={{ route('cart.add_product') }}>
            {{ method_field('PATCH') }}
            @csrf
            <input name="id_produit" type=hidden value="{{ $product->id }}"></input>
            <div class="form-group @error('product_type') has-error @enderror" style="padding: 5px">
                <label><strong>Quantité</strong></label>
                <select name="quantite" class="form-control">
                    @for ($i = 1; $i <= $product->nombreStock - $panier->nbArticles($product->id); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            @if(Auth::guard('personnel')->check())
                <button type="submit" class="fluid ui mini red button" disabled>Seuls les étudiants peuvent ajouter au panier</button>
            @elseif (!$product->enStock)
                <button type="submit" class="fluid ui mini red button" disabled>Indisponible</button>
            @elseif ($product->nombreStock - $panier->nbArticles($product->id) == 0)
                <button type="submit" class="fluid ui mini primary button" disabled>Déjà au panier</button>
            @else
                <button type="submit" class="fluid ui mini primary button">Ajouter au panier</button>
            @endif
        </form>
    </div>

    <hr/>
    <div>
        @if (count($product->filtres) > 0)
            <h5>Caractéristiques techniques</h5>
            <table class="ui striped table">
              <thead>
                <tr>
                  <th>Caractéristique</th>
                  <th>Valeur</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($product->filtres as $spec)
                  <tr>
                      <td>{{ $spec->filtre->nom }}</td>
                      <td>{{ $spec->valeur }} {{ $spec->filtre->unite}}</td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
            <hr/>
        @endif
    </div>

    <h5>Ressources</h5>

    <div class="ui styled fluid accordion" style="margin-top: 15px">
        <div class="active title">
            <i class="dropdown icon"></i>
            Fiche technique
        </div>
        <div class="active content">
            <a class="ui labeled icon blue button" target="_blank" href="{{ asset($product->fiche_technique) }}">
            <i class="file pdf outline icon"></i>
            {{ __('msg.see_technical_sheet') }}
            </a>
        </div>
        @php $ref_files = false @endphp
        @foreach ($product->references as $ref)
            @if ($ref->fichiers->count() > 0)
                @php $ref_files = true @endphp
                @break
            @endif
        @endforeach
        @if ($ref_files)
            <div class="title">
                <i class="dropdown icon"></i>
                Autres documents
            </div>
            <div class="content">
                <table class="ui striped table">
                  <thead>
                    <tr>
                      <th>Référence</th>
                      <th>Documents</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($product->references as $ref)
                        @if ($ref->fichiers->count() > 0)
                        <tr>
                            <td>{{ $ref->ensim_id }}</td>
                            <td style="vertical-align: middle;">
                                @foreach ($ref->fichiers as $f)
                                    <a class="ui mini labeled icon blue button" target="_blank" href="{{ asset($f->fichier) }}">
                                        <i class="file pdf outline icon"></i>
                                        {{ $f->nom }}
                                  </a>
                                @endforeach
                                </td>
                        </tr>
                        @endif
                      @endforeach
                  </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="addtocart desktop-only">
        <form style="display:inline;" method="POST" action={{ route('cart.add_product') }}>
            {{ method_field('PATCH') }}
            @csrf
            <input name="id_produit" type=hidden value="{{ $product->id }}"></input>
            <div class="form-group @error('product_type') has-error @enderror" style="padding: 20px">
                <label><strong>Quantité</strong></label>
                <select name="quantite" class="form-control">
                    @for ($i = 1; $i <= $product->nombreStock - $panier->nbArticles($product->id); $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            @if(Auth::guard('personnel')->check())
                <button type="submit" class="addtocartbtn fluid ui red button" disabled>Seuls les étudiants peuvent ajouter au panier</button>
            @elseif (!$product->enStock)
                <button type="submit" class="addtocartbtn fluid ui red button" disabled>Indisponible</button>
            @elseif ($product->nombreStock - $panier->nbArticles($product->id) == 0)
                <button type="submit" class="addtocartbtn fluid ui primary button" disabled>Déjà au panier</button>
            @else
                <button type="submit" class="addtocartbtn fluid ui primary button">Ajouter au panier</button>
            @endif
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
$('select[name="quantite"]')
  .dropdown()
;

$('.ui.accordion')
  .accordion()
;

function showFancy(){
    Fancybox.show([
        @foreach ($product->images as $image)
        {
          src: "{{ asset($image->image) }}",
          type: "image",
        },
        @endforeach
    ],
    {
      animated: false,
      showClass: false,
      hideClass: false,
      click: false,
      dragToClose: false,
      Image: {
        zoom: false,
      },
      Toolbar: {
        display: [{ id: "counter", position: "center" }, "close"],
      },
    });
}

</script>
@endsection
