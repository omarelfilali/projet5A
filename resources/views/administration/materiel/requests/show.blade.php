@extends('layouts/default-admin')

@section('css')
	@if ($type != "RESPM")
		<link rel="stylesheet" href="{{ asset('/css/workflow.css') }}">
		@vite(['resources/css/admin.css','resources/js/admin.js'])
	@endif
@endsection

@section('content')


<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - Demande</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Accueil</a></li>
				<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
				<li class="breadcrumb-item active">Demande</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
		<div class="container-fluid">

			@if ($type != "RESPM")
			<div class="row">
                <div class="col-12">
                    <ul id="progressbar">
						<li {!! $demande->status == -1 ? ' class="current"' : ($demande->status == -2 ? 'class="cancelled"' : 'class="active"') !!} id="validation-ins"><strong>{{ __('msg.insurance_validation') }}</strong></li>
						<li {!! $demande->status == 0 ? ' class="current"' : ($demande->status == 6 || $demande->status == 7 ? ' class="cancelled"' : (($demande->status > 0 && $demande->status <= 5) || ($demande->status > 7) ? 'class="active"' : '')) !!} id="validation-enc"><strong>{{ __('msg.supervisor_validation') }}</strong></li>
						<li {!! $demande->status == 1 ? ' class="current"' : ($demande->status == 8  || $demande->status == 9 ? ' class="cancelled"' :(($demande->status > 1 && $demande->status <= 5) || ($demande->status > 9) ? 'class="active"' : '')) !!} id="validation-tech"><strong>{{ __('msg.technician_validation') }}</strong></li>
						<li {!! $demande->status == 2 ? ' class="current"' : ($demande->status == 10 || $demande->status == 11 ? ' class="cancelled"' :(($demande->status > 2 && $demande->status <= 5) || ($demande->status > 11) ? 'class="active"' : '')) !!} id="validation-adm"><strong>{{ __('msg.admin_resp_validation') }}</strong></li>
						<li {!! $demande->status == 3 ? ' class="current"' : ($demande->status == 12 ? ' class="cancelled"' :(($demande->status > 3 && $demande->status <= 5) || ($demande->status > 12) ? 'class="active"' : '')) !!} id="a-recup"><strong>{{ __('msg.to_pick_up') }}</strong></li>
						<li {!! $demande->status == 4 ? ' class="current"' : ($demande->status == 13 ? ' class="cancelled"' :(($demande->status > 4 && $demande->status <= 5) || ($demande->status > 13) ? 'class="active"' : '')) !!} id="en-pret"><strong>{{ __('msg.borrowed') }}</strong></li>
						<li {!! $demande->status == 5 ? ' class="active"' : '' !!} id="ret"><strong>{{ __('msg.returned') }}</strong></li>
					</ul>
                </div>
            </div>
			@endif

			<div class="row">
				<div class="col-md-6">
					<div class="card card-primary card-outline">
						<div class="card-body box-profile">
							<div id="profil" class="tile">
                                <div class="photo-profil"><img src="{{$demande->etudiant->photoURL}}" alt="{{$demande->etudiant->nomprenom}}"></div>
                            </div>
							<h3 class="profile-username text-center">{{$demande->etudiant->nomprenom}}</h3>
							<p class="text-muted text-center">{{ __('msg.student_in') }} {{ $demande->etudiant->promo }}</p>

							<ul class="list-group list-group-unbordered mb-3">
								<li class="list-group-item"><a>{{$type == "RESPM" ? __('msg.created_the_masc') : __('msg.created_the_fem') }} <span class="float-right badge bg-gray">{{ $demande->created_at->format('d/m/Y à H:i') }}</span></a></li>
								<li class="list-group-item"><a>{{$type == "RESPM" ? __('msg.updated_the_masc') : __('msg.updated_the_fem') }} <span class="float-right badge bg-gray">{{ $demande->updated_at->format('d/m/Y à H:i') }}</span></a></li>
								<li class="list-group-item"><a>{{$type != "RESPM" ? __('msg.desired_period') : __('msg.period') }} <span class="float-right badge bg-gray">{{ __('msg.date_from') }} {{ $demande->dateDebut() }} {{ __('msg.date_to') }} {{ $demande->dateFin() }}</span></a></li>
								@if ($type != "RESPM")
									<li class="list-group-item"><a>{{ __('msg.associated_supervisors') }}
										@foreach ($demande->encadrants as $encadrant)
										<span class="float-right badge bg-gray">{{ $encadrant->personnel->nomprenom }}</span>
										@endforeach
									</a></li>
									<li class="list-group-item"><a>{{ __('msg.associated_technician') }} <span class="float-right badge bg-gray">{{ $demande->technicien->nomprenom }}</span></a></li>
								@endif
								@if ($type == "RESPA")
								<li class="list-group-item"><a>{{__('msg.student_insurance')}}<span class="float-right badge bg-gray" style="cursor: pointer" onclick="window.open('{{ asset($assurance->assurance) }}', '_blank')"><i class="fas fa-eye"></i></span></a></li>
								@endif
								<p class="mt-4" style="padding: 0px 20px">
									{{ $demande->description }}
								</p>
							</ul>
						</div>
					</div>
					@if(!auth()->user()->isRespAdministratif() || $isEncadrant)
						@include('administration.materiel.requests.show_articles')
					@endif
					@if(auth()->user()->id == $demande->technicien_id && $demande->status < 5 && $demande->status > -2)
						@include('administration.materiel.requests.show_history')
					@endif
				</div>
				<div class="col-md-6">
					@if ($type != "RESPM" && isset($action))
						<div class="card card-warning">
							<div class="card-header with-border">
								<h3 class="card-title"><i class="icon danger fas fa-exclamation-triangle" style="margin-right: 8px"></i>{{$action}}</h3>
							</div>
							<div style="padding: 20px">
								<form method="POST" action={{ route('administration.materiel.requests.action', ['id' => $demande->id]) }}>
									{{ method_field('PATCH') }}
									@csrf
									@if ($demande->status == -1)

									<label>Attestation</label>
									<button type="button" class="btn btn-block btn-primary" onclick="window.open('{{ asset($assurance->assurance) }}', '_blank')">Voir l'attestation</button>
									<br/>

									<label>Dates de validité</label>
									<br/>
									<div class="form-group">
										<input type="text" name="timerangeendins" class="form-control" id="daterange" value="{{ __('msg.date_from') }} {{ $demande->etudiant->derniereAssurance()->dateDebut() }} {{ __('msg.date_to') }} {{ $demande->etudiant->derniereAssurance()->dateFin() }}" disabled/>
									</div>
									<br/>
									@endif
									<div class="form-group">
										<label>{{ __('msg.comment') }}</label>
										<textarea class="form-control" id="commentaire" name="commentaire" rows="3" placeholder="Facultatif"></textarea>
									</div>
									<div class="row">
										@if ($demande->status >= 3)
											<button type="submit" style="width: 100%" name="action" value="accept" class="btn btn-block btn-success">{{ __('msg.yes') }}</button>
										@else

											<div class="col-6">
												<button type="button" onclick="confirmerActionEmprunt()" class="btn btn-block btn-success">{{ __('msg.yes') }}</button>
												<button style="display:none" id="confirmerActionEmpruntBtn" type="submit" name="action" value="accept"></button>

											</div>
											<div class="col-6">
												<button type="button" onclick="refuserActionEmprunt()" class="btn btn-block btn-danger">{{ __('msg.no') }}</button>
												<button style="display:none" id="refuserActionEmpruntBtn" type="submit" name="action" value="refuse"></button>
											</div>

										@endif
									</div>
									@error('action')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</form>
							</div>
						</div>
					@endif
					@if(auth()->user()->id == $demande->technicien_id && $demande->status < 5 && $demande->status > -2)
						@include('administration.materiel.requests.show_technicien_edit')
					@elseif (auth()->user()->isRespAdministratif() || $isEncadrant)
						@include('administration.materiel.requests.show_history')
					@endif
					@if(auth()->user()->isRespAdministratif() && !$isEncadrant)
						@include('administration.materiel.requests.show_articles')
					@endif
					@if ($type == "RESPM" && $demande->status == 4)
						<div class="card card-warning">
							<div class="card-header with-border">
								<h3 class="box-title">{{ __('msg.possible_actions') }}</h3>
							</div>
							<div class="card-body">
								<strong><li>{{ __('msg.reservation_endtime_change') }}</li></strong>
								<div class="form-group @error('timerangeend') has-error @enderror">
									<form method="POST" action={{ route('administration.materiel.respmateriel.emprunts.periode.update', ['id' => $demande->id]) }} style="display:flex" autocomplete="off">
										{{ method_field('PATCH') }}
										@csrf
										<input type="text" name="timerangeend" class="form-control group-edit float-right" id="datepicker"/>
										<button style="margin-left: 3px;" type="submit" class="btn btn-primary btn-flat btn-edit">{{ __('msg.apply') }}</button>
									</form>
									@error('timerangeend')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
								<strong><li style="margin-bottom: 3px">{{ __('msg.others_actions') }}</li></strong>
								<div class="form-group">
									<form method="POST" action={{ route('administration.materiel.respmateriel.emprunts.rendu', ['id' => $demande->id]) }} style="display:flex">
										{{ method_field('PATCH') }}
										@csrf
										<button style="width: 100%" type="submit" class="btn btn-primary btn-flat btn-edit">{{ __('msg.mark_as_returned') }}</button>
									</form>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</section>



<script>
		function confirmerActionEmprunt(){
			setModalTitle("Êtes-vous sûr de confirmer cette étape ?");
			setModalContent("<b>Commentaire : </b>"+((document.getElementById("commentaire").value).length == 0 ? "<i>Aucun commentaire</i>" : document.getElementById("commentaire").value));
			showModal("confirmerActionEmpruntBtn");
		}

		function refuserActionEmprunt(){
			setModalTitle("Êtes-vous sûr de refuser cette étape et d'annuler la demande d'emprunt ?");
			setModalContent("<b>Commentaire : </b>"+((document.getElementById("commentaire").value).length == 0 ? "<i>Aucun commentaire</i>" : document.getElementById("commentaire").value));
			showModal("refuserActionEmpruntBtn");
		}

		elem = document.getElementById("timerangestart");
		if (elem != null){
			elem.value = "{{ $demande->debut_date->format('d-m-Y') }}";
		}
		elem = document.getElementById("timerangeend");
		if (elem != null){
			elem.value = "{{ $demande->fin_date->format('d-m-Y') }}";
		}
		$('#timerange').daterangepicker({
			"showCustomRangeLabel": false,
			"timePicker": false,
			"startDate": "{{ $demande->dateDebut() }}",
			"endDate": "{{ $demande->dateFin() }}",
			"locale": {
				"format": "DD/MM/YYYY",
				"separator": " - ",
				"applyLabel": "Appliquer",
				"cancelLabel": "Annuler",
				"fromLabel": "Du",
				"toLabel": "Au",
				"customRangeLabel": "Personnalisé",
				"daysOfWeek": [
					"Dim",
					"Lun",
					"Mar",
					"Mer",
					"Jeu",
					"Ven",
					"Sam"
				],
				"monthNames": [
					"Janvier",
					"Février",
					"Mars",
					"Avril",
					"Mai",
					"Juin",
					"Juillet",
					"Août",
					"Septembre",
					"Octobre",
					"Novembre",
					"Decembre"
				],
				"firstDay": 1
			}
		},
		function(start, end) {
			document.getElementById("timerangestart").value = start.format('DD-MM-YYYY');
			document.getElementById("timerangeend").value = end.format('DD-MM-YYYY');
		}
		);


	</script>
@endsection
