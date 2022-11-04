@extends('layouts/default-admin')

@section('content')

<style>
.dataTables_paginate {
  width: 100%;
  text-align: center!important;
}
</style>

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - Historique produit</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Accueil</a></li>
				<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
				<li class="breadcrumb-item active">Historique produit</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">{{ trans_choice('msg.loan', 2) }}</h3>
						</div>

						<div class="card-body table-responsive no-padding">
							<table id="datatable" class="table table-hover">
								<thead>
									<tr>
										<th style="width: 30%">{{ trans_choice('msg.student', 1) }}</th>
										<th style="width: 20%">{{ trans_choice('msg.status', 1) }}</th>
										<th style="width: 25%">{{ __('msg.serial_nb') }}</th>
										<th style="width: 25%">{{ __('msg.loan_period') }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($history as $e)
										<tr class="elem-row" id="hist-{{$e->id}}">
											<td>{{$e->emprunt->etudiant->nomprenom}}</td>
											<td><span class="label label-success">{{ __('msg.returned_on') }} {{$e->emprunt->dateRendu()}}</span></td>
											<td>{{ $e->reference->numero_serie }}</td>
											<td>Du {{$e->emprunt->dateDebut()}} au {{$e->emprunt->dateFin()}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
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
			url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/historique/recherche') : url('api/historique/recherche') }}",
			data: {
				keyword: value,
				id: {{$product->id}}
			},
			success: function(data) {
				Array.prototype.forEach.call(elements, function(e) {
					if (e.id.includes("hist")){
						lineId = parseInt(e.id.replace("hist-", ""));
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
	}
</script>
@endsection
