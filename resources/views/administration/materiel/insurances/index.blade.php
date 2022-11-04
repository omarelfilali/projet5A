@extends('layouts/default-admin')

@section('content')

<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12">
					<div class="card card-warning">
						<div class="card-header">
							<h3 class="card-title">{{ __('msg.insurances_awaiting_validation') }}</h3>
						</div>
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">
								<tbody><tr>
			                        <th style="width:25%">{{ trans_choice('msg.name', 1) }}</th>
									<th style="width:25%">{{ __('msg.start_date') }}</th>
									<th style="width:25%">{{ __('msg.end_date') }}</th>
									<th style="width:25%">{{ trans_choice('msg.action', 2) }}</th>
								</tr>
			                        @foreach ($demandesEnAttente as $d)
			    						<tr class="elem-row">
			    							<td>{{$d->etudiant->nomPrenom}}</td>
			    							<td>{{ $d->date_debut->format('d/m/Y à H:i') }}</td>
			                                <td>{{ $d->date_fin->format('d/m/Y à H:i') }}</td>
			                                <td>
			                                    <button style="margin-left: 5px" type="submit" onclick="window.open('{{ asset('storage/module_materiel/' . $d->assurance) }}', '_blank')" class="btn btn-primary btn-sm">Voir l'assurance</button>
												<form method="POST" action={{ route('administration.materiel.insurances.action', ['id' => $d->id]) }} style="display:contents">
									                {{ method_field('PATCH') }}
									                @csrf
																	<button style="margin-left: 5px" onclick="confirmerAccepterAssurance('{{$d->etudiant->nomPrenom}}', '{{ $d->date_debut->format('d/m/Y à H:i') }}', '{{ $d->date_fin->format('d/m/Y à H:i') }}', '{{$d->id}}')" type="button" class="btn btn-success btn-sm">Accepter</button>
									                <button style="display:none" id="confirmerAccepterAssuranceBtn{{$d->id}}" name="action" type="submit"  value="accept"></button>
									            </form>
												<form method="POST" action={{ route('administration.materiel.insurances.action', ['id' => $d->id]) }} style="display:contents">
													{{ method_field('PATCH') }}
													@csrf
													<button style="margin-left: 5px" onclick="confirmerAnnulerAssurance('{{$d->etudiant->nomPrenom}}', '{{ $d->date_debut->format('d/m/Y à H:i') }}', '{{ $d->date_fin->format('d/m/Y à H:i') }}', '{{$d->id}}')" type="button" class="btn btn-danger btn-sm">Refuser</button>
													<button style="display:none" id="confirmerAnnulerAssuranceBtn{{$d->id}}" name="action" type="submit" value="refuse"></button>
												</form>
			                                </td>
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
							<h3 class="card-title">{{ __('msg.insurances_active') }}</h3>
						</div>
						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">
								<tbody><tr>
									<th style="width:25%">{{ trans_choice('msg.name', 1) }}</th>
									<th style="width:25%">{{ __('msg.start_date') }}</th>
									<th style="width:25%">{{ __('msg.end_date') }}</th>
									<th style="width:25%">{{ trans_choice('msg.action', 1) }}</th>
								</tr>
			                        @foreach ($demandesValides as $d)
			                            <tr class="elem-row">
			                                <td>{{$d->etudiant->nomPrenom}}</td>
			                                <td>{{ $d->date_debut->format('d/m/Y à H:i') }}</td>
			                                <td>{{ $d->date_fin->format('d/m/Y à H:i') }}</td>
			                                <td>
			                                    <button style="margin-left: 5px" type="submit" onclick="window.open('{{ asset('storage/module_materiel/' . $d->assurance) }}', '_blank')" class="btn btn-primary btn-sm">Voir l'assurance</button>
			                                </td>
			                            </tr>
			                        @endforeach
			    			</tbody></table>
			    		</div>
			    	</div>
			    </div>
			</div>
			<div class="row">
			<div class="col-xs-12">
				<div class="card card-danger">
					<div class="card-header">
						<h3 class="card-title">{{ __('msg.insurances_expirated') }}</h3>
					</div>
					<div class="card-body table-responsive no-padding">
						<table class="table table-hover">
							<tbody><tr>
		                        <th style="width:25%">{{ trans_choice('msg.name', 1) }}</th>
								<th style="width:25%">{{ __('msg.start_date') }}</th>
								<th style="width:25%">{{ __('msg.end_date') }}</th>
								<th style="width:25%">{{ trans_choice('msg.action', 1) }}</th>
							</tr>
		                        @foreach ($demandesExpirees as $d)
		                            <tr class="elem-row">
		                                <td>{{$d->etudiant->nomPrenom}}</td>
		                                <td>{{ $d->date_debut->format('d/m/Y à H:i') }}</td>
		                                <td>{{ $d->date_fin->format('d/m/Y à H:i') }}</td>
		                                <td>
		                                    <button style="margin-left: 5px" type="submit" class="btn btn-primary btn-sm">Voir l'assurance</button>
		                                </td>
		                            </tr>
		                        @endforeach
		    			</tbody></table>
		    		</div>
		    	</div>
		    </div>
		</div>
		</div>
</section>

<script type="text/javascript">

	function confirmerAnnulerAssurance($etudiant, $date1, $date2, $id){
		setModalTitle("Êtes-vous sûr de refuser l'assurance ?");
		setModalContent("<b>Etudiant : </b>" + $etudiant + "</br><b>Date de début : </b>"+$date1 + "</br><b>Date de fin : </b>"+$date2);
		showModal("confirmerAnnulerAssuranceBtn"+$id);
	}

	function confirmerAccepterAssurance($etudiant, $date1, $date2, $id){
		setModalTitle("Êtes-vous sûr de valider l'assurance ?");
		setModalContent("<b>Etudiant : </b>" + $etudiant + "</br><b>Date de début : </b>"+$date1 + "</br><b>Date de fin : </b>"+$date2);
		showModal("confirmerAccepterAssuranceBtn"+$id);
	}
</script>

@endsection
