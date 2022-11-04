@extends('layouts.default-mat')

<link rel="stylesheet" href="{{ asset('/css/workflow.css') }}">

<style>
	.product-img {
		width: 100%;
		height: 100px;
		line-height: 100px;
		text-align: center;
		background: white;
		display: inline-block;
		vertical-align:top;
	}

	.card {
		width: 190px !important;
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

</style>

@section('content')
@include('partials.inventoryheader')

<div class="pre-banniere">
    <div class="banniere">
        <i class="fas fa-angle-double-left" onclick="window.location.href = '{{route('public.materiel.products.index') }}'"></i>
        <p class="nomCategorieActuelle">Materiel</p>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-8  me-0 me-lg-4 mb-4">

			<h1>Mes demandes</h1>
			@if ($demandes->count() == 0)

			@else
	        <h4>Dernière demande (#{{$demandes->first()->id}})</h4>
	            <ul id="progressbar">
	            	<li {!! $demandes->first()->status == -1 ? ' class="current"' : ($demandes->first()->status == -2 ? 'class="cancelled"' : 'class="active"') !!} id="validation-ins"><strong>{{ __('msg.insurance_validation') }}</strong></li>
	            	<li {!! $demandes->first()->status == 0 ? ' class="current"' : ($demandes->first()->status == 6 || $demandes->first()->status == 7 ? ' class="cancelled"' : (($demandes->first()->status > 0 && $demandes->first()->status <= 5) || ($demandes->first()->status > 7) ? 'class="active"' : '')) !!} id="validation-enc"><strong>{{ __('msg.supervisor_validation') }}</strong></li>
	            	<li {!! $demandes->first()->status == 1 ? ' class="current"' : ($demandes->first()->status == 8  || $demandes->first()->status == 9 ? ' class="cancelled"' :(($demandes->first()->status > 1 && $demandes->first()->status <= 5) || ($demandes->first()->status > 9) ? 'class="active"' : '')) !!} id="validation-tech"><strong>{{ __('msg.technician_validation') }}</strong></li>
	            	<li {!! $demandes->first()->status == 2 ? ' class="current"' : ($demandes->first()->status == 10 || $demandes->first()->status == 11 ? ' class="cancelled"' :(($demandes->first()->status > 2 && $demandes->first()->status <= 5) || ($demandes->first()->status > 11) ? 'class="active"' : '')) !!} id="validation-adm"><strong>{{ __('msg.admin_resp_validation') }}</strong></li>
	            	<li {!! $demandes->first()->status == 3 ? ' class="current"' : ($demandes->first()->status == 12 ? ' class="cancelled"' :(($demandes->first()->status > 3 && $demandes->first()->status <= 5) || ($demandes->first()->status > 12) ? 'class="active"' : '')) !!} id="a-recup"><strong>{{ __('msg.to_pick_up') }}</strong></li>
	            	<li {!! $demandes->first()->status == 4 ? ' class="current"' : ($demandes->first()->status == 13 ? ' class="cancelled"' :(($demandes->first()->status > 4 && $demandes->first()->status <= 5) || ($demandes->first()->status > 13) ? 'class="active"' : '')) !!} id="en-pret"><strong>{{ __('msg.borrowed') }}</strong></li>
	            	<li {!! $demandes->first()->status == 5 ? ' class="active"' : '' !!} id="ret"><strong>{{ __('msg.returned') }}</strong></li>
	            </ul>

	            <div style="border-radius: 8px; background: #f3f3f3; padding-top: 10px; padding-right: 10px; padding-left: 10px;">
	                <table class="ui celled table" style="table-layout: fixed; width: 100%;">
	                  <tbody>
	                    <tr>
	                      <td style="width: 50%">Date de création de la demande</td>
	                      <td style="width: 50%">{{ $demandes->first()->created_at->format('d/m/Y à H:i') }}</td>
	                    </tr>
	                    <tr>
	                      <td>Période de l'emprunt</td>
	                      <td>{{ __('msg.date_from') }} {{ $demandes->first()->dateDebut() }} {{ __('msg.date_to') }} {{ $demandes->first()->dateFin() }}</td>
	                    </tr>
	                    <tr>
	                      <td>Encadrants</td>
	                      <td>
	                          <ul style="margin-bottom: 0">
	                              @php $first = true @endphp
	                              @foreach ($demandes->first()->encadrants as $encadrant)
	                                @if (!$first), @endif{{$encadrant->personnel->nomprenom}}
	                                @php $first = false @endphp
	                              @endforeach
	                          </ul>
	                      </td>
	                    </tr>
	                    <tr>
	                      <td>Description</td>
	                      <td style="overflow-wrap: break-word;">{{ $demandes->first()->description }}</td>
	                    </tr>
	                  </tbody>
	                </table>

					@if ($demandes->first()->operations->count() > 0)
						<table class="ui celled table">
							<tbody>
								<tr>
									<th style="width:20%">{{ __('msg.user') }}</th>
									<th style="width:60%">{{ __('msg.description') }}</th>
									<th style="width:20%">{{ __('msg.date') }}</th>
								</tr>
								@foreach ($demandes->first()->operations->sortByDesc("created_at") as $operation)
								<tr>
									<td>{{ $operation->personnel->nomprenom }} (<i>{{$operation->role}}</i>)</td>
									<td><b>{{ $operation->titre }} :</b></br>
										@if (Str::length($operation->commentaire) == 0)
										<i>{{ __('msg.no_comment') }}</i>
										@else
										<li>{{$operation->commentaire }}</li>
										@endif
									</td>
									<td>{{ $operation->created_at->format('d/m/Y à H:i') }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					@endif

	                <div class="ui link cards desktop-only">
	                    @foreach ($demandes->first()->articles as $a)
	                        @php
	                            $r = $a->reference;
	                            $p = $r->produit;
	                        @endphp
	                        <a href="{{ route('public.materiel.products.show', ['id' => $p->id])}}">
	                            <div class="card" id="product-{{$p->id}}">
	                                <div class="image product-img">
	                                    <img src="{{ asset('storage/module_materiel/' . $p->imageParDefaut) }}"/>
	                                </div>
	                                <div class="content">
	                                    <a class="header" href="{{ route('public.materiel.products.show', ['id' => $p->id])}}">{{ $p->nom }}</a>
	                                    <div class="meta">
	                                        <span>{{ $p->type->nom }}</span>
	                                    </div>
	                                </div>
	                                <div class="extra content">
	                                    <span>Référence : {{ $r->ensim_id }}</span>
	                                </div>
	                            </div>
	                        </a>
	                    @endforeach
	                </div>
					<table class="ui very basic collapsing celled table mobile-only" style="width: 100%;">
						<thead>
							<tr>
								<th>Articles de la demande</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($demandes->first()->articles as $a)
								@php
									$r = $a->reference;
									$p = $r->produit;
								@endphp
						  <tr>
							<td>
							  <a href="{{ route('public.materiel.products.show', ['id' => $p->id])}}">
								  <h4 class="ui image header">
									<img src="{{ asset('storage/module_materiel/' . $p->imageParDefaut) }}" class="ui mini rounded image">
									<div class="content">
									  {{ $p->nom }}
									  <div class="sub header">{{ $r->ensim_id }}
									</div>
								  </div>
							  </h4>
							  <a/>
						    </td>
						  </tr>
						  @endforeach
						</tbody>
				  </table>
	            </div>
	        <hr/>
	        <h4>Autres demandes</h4>
	        <div class="ui styled fluid accordion">
	            @php $first = true @endphp
	            @foreach ($demandes as $demande)
	                @if ($first)
	                    @php $first = false @endphp
	                    @continue;
	                @endif
	              <div class="title @if ($first) active @endif">
	                <i class="dropdown icon"></i>
	                Demande du {{ $demande->created_at->format('d/m/Y à H:i') }} (#{{$demande->id}})
	              </div>
	              <div class="content @if ($first) active @endif">
	                  <ul id="progressbar">
	                      <li {!! $demande->status == -1 ? ' class="current"' : ($demande->status == -2 ? 'class="cancelled"' : 'class="active"') !!} id="validation-ins"><strong>{{ __('msg.insurance_validation') }}</strong></li>
	                      <li {!! $demande->status == 0 ? ' class="current"' : ($demande->status == 6 || $demande->status == 7 ? ' class="cancelled"' : (($demande->status > 0 && $demande->status <= 5) || ($demande->status > 7) ? 'class="active"' : '')) !!} id="validation-enc"><strong>{{ __('msg.supervisor_validation') }}</strong></li>
	                      <li {!! $demande->status == 1 ? ' class="current"' : ($demande->status == 8  || $demande->status == 9 ? ' class="cancelled"' :(($demande->status > 1 && $demande->status <= 5) || ($demande->status > 9) ? 'class="active"' : '')) !!} id="validation-tech"><strong>{{ __('msg.technician_validation') }}</strong></li>
	                      <li {!! $demande->status == 2 ? ' class="current"' : ($demande->status == 10 || $demande->status == 11 ? ' class="cancelled"' :(($demande->status > 2 && $demande->status <= 5) || ($demande->status > 11) ? 'class="active"' : '')) !!} id="validation-adm"><strong>{{ __('msg.admin_resp_validation') }}</strong></li>
	                      <li {!! $demande->status == 3 ? ' class="current"' : ($demande->status == 12 ? ' class="cancelled"' :(($demande->status > 3 && $demande->status <= 5) || ($demande->status > 12) ? 'class="active"' : '')) !!} id="a-recup"><strong>{{ __('msg.to_pick_up') }}</strong></li>
	                      <li {!! $demande->status == 4 ? ' class="current"' : ($demande->status == 13 ? ' class="cancelled"' :(($demande->status > 4 && $demande->status <= 5) || ($demande->status > 13) ? 'class="active"' : '')) !!} id="en-pret"><strong>{{ __('msg.borrowed') }}</strong></li>
	                      <li {!! $demande->status == 5 ? ' class="active"' : '' !!} id="ret"><strong>{{ __('msg.returned') }}</strong></li>
	                  </ul>
	                  <div style="border-radius: 8px; background: #f3f3f3; padding-top: 10px; padding-right: 10px; padding-left: 10px;">
	                      <table class="ui celled table" style="table-layout: fixed; width: 100%;">
	                        <tbody>
	                          <tr>
	                            <td style="width: 50%">Date de création de la demande</td>
	                            <td style="width: 50%">{{ $demande->created_at->format('d/m/Y à H:i') }}</td>
	                          </tr>
	                          <tr>
	                            <td>Période de l'emprunt</td>
	                            <td>{{ __('msg.date_from') }} {{ $demande->dateDebut() }} {{ __('msg.date_to') }} {{ $demande->dateFin() }}</td>
	                          </tr>
	                          <tr>
	                            <td>Encadrants</td>
	                            <td>
	                                <ul style="margin-bottom: 0">
	                                    @php $first = true @endphp
	                                    @foreach ($demande->encadrants as $encadrant)
	                                      @if (!$first), @endif{{$encadrant->personnel->nomprenom}}
	                                      @php $first = false @endphp
	                                    @endforeach
	                                </ul>
	                            </td>
	                          </tr>
	                          <tr>
	                            <td>Description</td>
	                            <td style="overflow-wrap: break-word;">{{ $demande->description }}</td>
	                          </tr>
	                        </tbody>
	                      </table>

						  @if ($demande->operations->count() > 0)
							  <table class="ui celled table">
								  <tbody>
									  <tr>
										  <th style="width:20%">{{ __('msg.user') }}</th>
										  <th style="width:60%">{{ __('msg.description') }}</th>
										  <th style="width:20%">{{ __('msg.date') }}</th>
									  </tr>
									  @foreach ($demande->operations->sortByDesc("created_at") as $operation)
									  <tr>
										  <td>{{ $operation->personnel->nomprenom }} (<i>{{$operation->role}}</i>)</td>
										  <td><b>{{ $operation->titre }} :</b></br>
											  @if (Str::length($operation->commentaire) == 0)
											  <i>{{ __('msg.no_comment') }}</i>
											  @else
											  <li>{{$operation->commentaire }}</li>
											  @endif
										  </td>
										  <td>{{ $operation->created_at->format('d/m/Y à H:i') }}</td>
									  </tr>
									  @endforeach
								  </tbody>
							  </table>
						  @endif

	                      <div class="ui link cards desktop-only">
	                          @foreach ($demande->articles as $a)
	                              @php
	                                  $r = $a->reference;
	                                  $p = $r->produit;
	                              @endphp
	                              <a href="{{ route('products.show', ['id' => $p->id])}}">
	                                  <div class="card" id="product-{{$p->id}}">
	                                      <div class="image product-img">
	                                          <img src="{{ asset($p->imageParDefaut) }}"/>
	                                      </div>
	                                      <div class="content">
	                                          <a class="header" href="{{ route('products.show', ['id' => $p->id])}}">{{ $p->nom }}</a>
	                                          <div class="meta">
	                                              <span>{{ $p->type->nom }}</span>
	                                          </div>
	                                      </div>
	                                      <div class="extra content">
	                                          <span>Référence : {{ $r->ensim_id }}</span>


	                                      </div>
	                                  </div>
	                              </a>
	                          @endforeach
	                      </div>
						  <table class="ui very basic collapsing celled table mobile-only" style="width: 100%;">
						  <thead>
						    <tr>
						  	  <th>Articles de la demande</th>
						    </tr>
						  	</thead>
						  	<tbody>
								@foreach ($demande->articles as $a)
						  			@php
						  				$r = $a->reference;
						  				$p = $r->produit;
						  			@endphp
						  	  <tr>
								  <td>
		  						  <a href="{{ route('public.materiel.products.show', ['id' => $p->id])}}">
		  							  <h4 class="ui image header">
										
		  								<img src="{{ asset($p->imageParDefaut) }}" class="ui mini rounded image"> 
										{{-- lien à mettre ? : {{ asset('storage/module_materiel/' . $p->imageParDefaut) }} --}}
		  								<div class="content">
		  								  {{ $p->nom }}
		  								  <div class="sub header">{{ $r->ensim_id }}
		  								</div>
		  							  </div>
		  						  </h4>
		  						  <a/>
		  					    </td>
						  	  </tr>
						  	  @endforeach
						  	</tbody>
						  </table>
	                  </div>
	              </div>
	              @endforeach
	        </div>
			@endif
    	</div>
	</div>
</div>
@endsection

@section('js')
<script>
    $('.ui.accordion')
      .accordion()
    ;
</script>
@endsection
