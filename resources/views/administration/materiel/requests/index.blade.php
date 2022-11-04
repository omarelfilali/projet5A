@extends('layouts/default-admin')

@section('content')

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - {{ isset($small_title) ? " $small_title" : (isset($title) ? " $title" : "") }} </h1>
			</div><!-- /.col -->
			<div class="col-sm-6 d-flex flex-row-reverse">
				
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
		<div class="container-fluid">

			<div class="row text-right">
				<div class="form-group" style="width: 210px;display: inline-block;">
					<div class="input-group">
						<span class="input-group-text">
							<i class="fa fa fa-calendar"></i>
						</span>
						<input type="text" class="form-control group-edit date-picker" id="timerange"/>
					</div>
				</div>
			</div>
			<div class="row">
				@empty($categories)
				<div class="col-xs-12">
					<div class="card card-warning">
						<div class="card-header">
							<h3 class="card-title">{{ __('msg.requests_awaiting_validation') }}</h3>
						</div>
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">
								<tbody><tr>
									<th style="width:20%">{{ trans_choice('msg.name', 1) }}</th>
									<th style="width:25%">{{ trans_choice('msg.product', 2) }}</th>
									<th style="width:25%">{{ trans_choice('msg.status', 1) }}</th>
									<th style="width:15%">{{ __('msg.created_the_fem') }}</th>
									<th style="width:15%">{{ __('msg.updated_the_fem') }}</th>
								</tr>
								@foreach ($demandesEnAttente as $d)
									@if (!$admin && $technicien_encadrants_only)
										@php
											$isEncadrant = false
										@endphp
										@foreach ($d->encadrants as $e)
											@if ($e->personnel->id == Auth::user()->id)
												@php
													$isEncadrant = true
												@endphp
												@break
											@endif
										@endforeach

										@if (!$isEncadrant && $d->technicien_id != Auth::user()->id)
											@continue
										@endif
									@elseif (!$admin && !$technicien_encadrants_only && isset($categories))
											@if (!in_array($d->articles->first()->reference->produit->type->category_id, $categories))
												@continue
											@endif
									@elseif (!$admin)
										@break
									@endif
									<tr class='clickable-row elem-row' id="req-{{$d->id}}" data-href="{{ route((isset($categories) ? 'administration.materiel.respmateriel.emprunts.show' : 'administration.materiel.requests.show'), ['id' => $d->id]) }}">
										<td>{{$d->etudiant->nomPrenom}}</td>
										<td><li>{{$d->articles->first()->reference->produit->nom}}</li></td>
										<td>
											@switch ($d->status)
											@case(-1)
												{{-- @if (Auth::guard('personnel')->user()->isRespAdministratif()) --}}
												@if(auth()->user()->can('materiel.acces.respadmin'))
													<span class="badge text-bg-warning"><i style="padding-right: 5px" class="fas fa-exclamation-triangle"></i>{{ __('msg.required_action_details') }}<i style="padding-left: 5px" class="fas fa-exclamation-triangle"></i></span>
												@else
													<span class="badge text-bg-info" style="background-color: #a5a5a5 !important">{{ __('msg.awaiting_insurance_validation') }}</span>
												@endif
																								
												@break
											@case(0)
												@if (in_array(Auth::user()->id, $d->encadrants_id()))
													<span class="badge text-bg-warning"><i style="padding-right: 5px" class="fas fa-exclamation-triangle"></i>{{ __('msg.required_action_details') }}<i style="padding-left: 5px" class="fas fa-exclamation-triangle"></i></span>
												@else
													<span class="badge text-bg-info" style="background-color: #a5a5a5 !important">{{ __('msg.awaiting_supervisor_validation') }}</span>
												@endif
												@break
											@case(1)
												@if (Auth::user()->id == $d->technicien_id)
													<span class="badge text-bg-warning"><i style="padding-right: 5px" class="fas fa-exclamation-triangle"></i>{{ __('msg.required_action_details') }}<i style="padding-left: 5px" class="fas fa-exclamation-triangle"></i></span>
												@else
													<span class="badge text-bg-info" style="background-color: #a5a5a5 !important">{{ __('msg.awaiting_technician_validation') }}</span>
												@endif
												@break
											@case(2)
												{{-- @if (Auth::guard('personnel')->user()->isRespAdministratif()) --}}
												@if(auth()->user()->can('materiel.acces.respadmin'))
													<span class="badge text-bg-warning"><i style="padding-right: 5px" class="fas fa-exclamation-triangle"></i>{{ __('msg.required_action_details') }}<i style="padding-left: 5px" class="fas fa-exclamation-triangle"></i></span>
												@else
													<span class="badge text-bg-info" style="background-color: #a5a5a5 !important">{{ __('msg.awaiting_admin_resp_validation') }}</span>
												@endif
												@break
											@case(3)
												<span class="badge text-bg-info" style="background-color: #a5a5a5 !important">{{ __('msg.to_pick_up') }}</span>
												@break
											@default
												<span class="badge text-bg-danger">Erreur</span>
												@break
											@endswitch
										</td>
										<td>{{ $d->created_at->format('d/m/Y à H:i') }}</td>
										<td>{{ $d->updated_at->format('d/m/Y à H:i') }}</td>
									</tr>
								@endforeach
							</tbody>
							</table>
						</div>
					</div>
				</div>
				@endempty
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">{{ isset($categories) ? __('msg.ongoing_loans') : __('msg.ongoing_requests') }}</h3>
						</div>
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">
								<tbody><tr>
									<th style="width:20%">{{ trans_choice('msg.name', 1) }}</th>
									<th style="width:25%">{{ trans_choice('msg.product', 2) }}</th>
									<th style="width:25%">{{ trans_choice('msg.status', 1) }}</th>
									<th style="width:15%">{{ __('msg.created_the_masc') }}</th>
									<th style="width:15%">{{ __('msg.updated_the_masc') }}</th>
								</tr>
								@foreach ($demandesEnCours as $d)
									@if (!$admin && $technicien_encadrants_only)
										@php
											$isEncadrant = false
										@endphp
										@foreach ($d->encadrants as $e)
											@if ($e->personnel->id == Auth::user()->id)
												@php
													$isEncadrant = true
												@endphp
												@break
											@endif
										@endforeach

										@if (!$isEncadrant && $d->technicien_id != Auth::user()->id)
											@continue
										@endif
									@elseif (!$admin && !$technicien_encadrants_only && isset($categories))
											@if (!in_array($d->articles->first()->reference->produit->type->category_id, $categories))
												@continue
											@endif
									@elseif (!$admin)
										@break
									@endif
									<tr class='clickable-row elem-row' id="req-{{$d->id}}" data-href="{{ route((isset($categories) ? 'administration.materiel.respmateriel.emprunts.show' : 'administration.materiel.requests.show'), ['id' => $d->id]) }}">
										<td>{{$d->etudiant->nomPrenom}}</td>
										<td><li>{{$d->articles->first()->reference->produit->nom}}</li></td>
										<td>
											@switch ($d->status)
											@case(4)
												<span class="label label-info">{{ __('msg.to_return_the') }} {{$d->dateFin()}}</span>
												@break
											@default
												<span class="label label-danger">Erreur</span>
												@break
											@endswitch
										</td>
										<td>{{ $d->created_at->format('d/m/Y à H:i') }}</td>
										<td>{{ $d->updated_at->format('d/m/Y à H:i') }}</td>
									</tr>
								@endforeach
							</tbody></table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">{{ isset($categories) ? __('msg.finished_loans') : __('msg.finished_requests') }}</h3>
						</div>
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">
								<tbody><tr>
									<th style="width:20%">{{ trans_choice('msg.name', 1) }}</th>
									<th style="width:25%">{{ trans_choice('msg.product', 2) }}</th>
									<th style="width:25%">{{ trans_choice('msg.status', 1) }}</th>
									<th style="width:15%">{{ __('msg.created_the_masc') }}</th>
									<th style="width:15%">{{ __('msg.updated_the_masc') }}</th>
								</tr>
								@foreach ($demandesTerminees as $d)
									@if (!$admin && $technicien_encadrants_only)
										@php
											$isEncadrant = false
										@endphp
										@foreach ($d->encadrants as $e)
											@if ($e->personnel->id == Auth::user()->id)
												@php
													$isEncadrant = true
												@endphp
												@break
											@endif
										@endforeach

										@if (!$isEncadrant && $d->technicien_id != Auth::user()->id)
											@continue
										@endif
									@elseif (!$admin && !$technicien_encadrants_only && isset($categories))
											@if (!in_array($d->articles->first()->reference->produit->type->category_id, $categories))
												@continue
											@endif
									@elseif (!$admin)
										@break
									@endif
									<tr class='clickable-row elem-row' id="req-{{$d->id}}" data-href="{{ route((isset($categories) ? 'administration.materiel.respmateriel.emprunts.show' : 'administration.materiel.requests.show'), ['id' => $d->id]) }}">
										<td>{{$d->etudiant->nomPrenom}}</td>
										<td><li>{{$d->articles->first()->reference->produit->nom}}</li></td>
										<td>
											@switch ($d->status)
											@case(-2)
												<span class="label label-danger">{{ __('msg.refused_by_admin_resp') }}</span>
												@break
											@case(5)
												<span class="label label-success">{{ isset($categories) ? __('msg.returned_the_masc') : __('msg.returned_the_masc') }} {{$d->dateRendu()}}</span>
												@break
											@case(6)
												<span class="label label-danger">{{ __('msg.refused_by_supervisor') }}</span>
												@break
											@case(8)
												<span class="label label-danger">{{ __('msg.refused_by_technician') }}</span>
												@break
											@case(10)
												<span class="label label-danger">{{ __('msg.refused_by_admin_resp') }}</span>
												@break
											@default
												<span class="label label-danger">{{ __('msg.cancelled_by_technician') }}</span>
												@break
											@endswitch
										</td>
										<td>{{ $d->created_at->format('d/m/Y à H:i') }}</td>
										<td>{{ $d->updated_at->format('d/m/Y à H:i') }}</td>
									</tr>
								@endforeach
							</tbody></table>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>


<script type="module">
	function onSearch(value) {
		$.ajax({
			type: "POST",
			url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/emprunts/recherche') : url('api/emprunts/recherche') }}",
			data: {
				keyword: value
			},
			success: function(data) {
				Array.prototype.forEach.call(elements, function(e) {
					if (e.id.includes("req")){
						lineId = parseInt(e.id.replace("req-", ""));
						if (data.includes(lineId)){
							e.style="display: table-row";
						}
						else {
							e.style="display: none";
						}
					}
                });
			}
		});
	};

	$(".clickable-row").click(function() {
		window.location = $(this).data("href");
	});

</script>

@endsection
