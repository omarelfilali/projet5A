@extends('default')

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
	:focus-visible {
		outline: none;
	}

	span.select2 {
		max-width: 100%;
	}
</style>
@endsection

@section('content')
@include('partials.inventoryheader')

<div class="page-container" style="padding-top: 20px">
	<h1>Informations sur la demande</h1>
	<center><h3 style="text-align: center">({{$panier->nbTotalArticles()}} articles)</h3>
	<form class="ui form panier-validation-form" method="POST" enctype="multipart/form-data" action={{route('materiel.requests.create')}} autocomplete="off">
		{{ method_field('PUT') }}
        @csrf
		<div class="form-group @error('encadrants') has-error @enderror">
			<label style="text-align: left"><b>Encadrants</b></label>
			<select id="encadrants" class="form-control select2 select2-hidden-accessible" data-placeholder='--{{__('msg.select')}}--'></select>
			<div id="encadrants_hidden"></div>
			<table class="ui celled table" style="display: none" id="show_encadrants_table">
				<thead class="desktop-only">
					<th style="width: 50%">Nom</th>
					<th style="width: 50%">Action</th>
				</thead>
				<tbody id="show_encadrants">

				</tbody>
				<tfoot>
				</tfoot>
			</table>
			@error('encadrants')
				<span class="help-block">{{ $message }}</span>
			@enderror
		</div>
		<div class="form-group">
			<label style="text-align: left"><b>Motif de l'emprunt (50 caractères min.)</b></label>
			<textarea id="motif" name="motif" class="form-control" rows="3"></textarea>
        </div>
		<div class="form-group @error('deb_emprunt') has-error @enderror @error('fin_emprunt') has-error @enderror">
            <label style="text-align: left"><b>Période d'emprunt</b></label>
                <input type="hidden" name="deb_emprunt" id="deb_emprunt"/>
                <input type="hidden" name="fin_emprunt" id="fin_emprunt"/>
                <input type="text" class="form-control group-edit" id="emprunt_range"/>
            @error('deb_emprunt')
            	<span class="help-block">{{ $message }}</span>
            @enderror
            @error('fin_emprunt')
            	<span class="help-block">{{ $message }}</span>
            @enderror
        </div>
		<div id="insurance_section" style="display: none">
			<div class="ui negative message">
				<div class="header">
					Attestation d'assurance requise
				</div>
				<p>Vous devez fournir une attestation d'assurance couvrant la période d'emprunt</p>
			</div>
			<div class="form-group @error('insurance') has-error @enderror">
				<label style="text-align: left" for="insurance"><b>Attestation d'assurance</b></label>
				<input type="file" id="insurance" name="insurance" accept="application/pdf">
				@error('insurance')
					<span class="help-block">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group @error('deb_assurance') has-error @enderror @error('fin_assurance') has-error @enderror">
				<label style="text-align: left"><b>Période de validité de l'assurance</b></label>
					<input type="hidden" name="deb_assurance" id="deb_assurance"/>
					<input type="hidden" name="fin_assurance" id="fin_assurance"/>
					<input type="text" class="form-control group-edit" id="assurance_range"/>
				@error('deb_assurance')
					<span class="help-block">{{ $message }}</span>
				@enderror
				@error('fin_assurance')
					<span class="help-block">{{ $message }}</span>
				@enderror
			</div>
			<p id="assurance_error" style="color: #d42d21 !important; font-weight: 700 !important; display: none">Les dates d'attestation ne couvrent pas la période d'emprunt</p>
		</div>
		<div style="text-align: center; padding: 10px">
				<button id="submitBtn" disabled type="submit" class="ui green fluid button">Valider et envoyer la demande</button>
		</div>
	</form></center>
</div>

@endsection

@section('js')
<script>

	$('#motif').on("input", function() {
		displaySubmitBtn();
	})

	$('#insurance').on("input", function() {
		const insurance_max_size = 3 // Taille maximale de l'assurance en Mo
		if(this.files[0].size > insurance_max_size * 1048576){
			alert("Fichier trop volumineux : Taille max = " + insurance_max_size + " Mo");
			this.value = "";
		}
		displaySubmitBtn();
	})

	let need_insurance = false;
	let insurance_cover = false;

	let not_selected_encadrants = [];
	@foreach ($encadrants as $e)
		not_selected_encadrants.push({
			id: {{ $e->id }},
			nomprenom: "{{ $e->nomprenom }}"
		})
	@endforeach

	let selected_encadrants = [];


	updateDisplay();

	$('#emprunt_range').daterangepicker({
		"showCustomRangeLabel": false,
		"autoUpdateInput": false,
		"timePicker": false,
		"minDate": "{{ \Carbon::now()->addDays(3)->format('d/m/Y') }}",
		"maxDate": "{{ \Carbon::now()->addMonths(10)->format('d/m/Y') }}",
		"drops": "up",
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
		verification_presence_assurance(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'));
		document.getElementById("deb_emprunt").value = start.format('DD-MM-YYYY');
		document.getElementById("fin_emprunt").value = end.format('DD-MM-YYYY');
	});


	$('#emprunt_range').on('apply.daterangepicker', function(ev, picker) {
	    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
	});

	$('#assurance_range').on('apply.daterangepicker', function(ev, picker) {
	    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
	});

	$('#assurance_range').daterangepicker({
		"showCustomRangeLabel": false,
		"autoUpdateInput": false,
		"timePicker": false,
		"minDate": "{{ \Carbon::now()->subMonths(12)->format('d/m/Y') }}",
		"maxDate": "{{ \Carbon::now()->addMonths(12)->format('d/m/Y') }}",
		"drops": "up",
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
		},
	},
	function(start, end) {
		let deb_emprunt = $('#deb_emprunt').val();
		let fin_emprunt = $('#fin_emprunt').val();
		let deb_assurance = start.format('DD-MM-YYYY');
		let fin_assurance = end.format('DD-MM-YYYY');
		verification_dates_assurance(deb_emprunt, fin_emprunt, deb_assurance, fin_assurance);
		document.getElementById("deb_assurance").value = deb_assurance;
		document.getElementById("fin_assurance").value = fin_assurance;
	});

	$('#encadrants').change(function() {
		let elemToRemove = not_selected_encadrants.filter(item => item.id == $('#encadrants').val())[0];
		const index = not_selected_encadrants.indexOf(elemToRemove);
		if (index > -1) {
			not_selected_encadrants.splice(index, 1);
		}
		selected_encadrants.push(elemToRemove);
		updateDisplay();
		displaySubmitBtn();
	})

	function updateDisplay() {

		//Création de champs cachés pour chaque encadrant sélectionné
		let encadrants_hidden = $('#encadrants_hidden');
		encadrants_hidden.empty();
		for (let i = 0; i < selected_encadrants.length; i++) {
			encadrants_hidden.html(encadrants_hidden.html() + "<input type='hidden' name='encadrants[]' value='" + selected_encadrants[i].id + "' />");
		}

		//Affichage des encadrants sélectionnés
		$('#show_encadrants').empty();
		$.each(selected_encadrants, function (i, encadrant) {
			document.getElementById("show_encadrants_table").style.display = "table";
			var tr = $('<tr>', {}).appendTo('#show_encadrants');
			var td1 = $('<td>', {
				text : encadrant.nomprenom,
			}).css("vertical-align","middle").appendTo(tr);
			var td2 = $('<td>', {
			}).appendTo(tr);
			$('<button>', {
				text : "Supprimer",
				id_encadrant: encadrant.id
			}).addClass("ui red mini button").click(function(e) {
				let id = $(e.target).attr('id_encadrant');
				let elemToRemove = selected_encadrants.filter(item => item.id == id)[0];
				const index = selected_encadrants.indexOf(elemToRemove);
				if (index > -1) {
					selected_encadrants.splice(index, 1);
				}
				not_selected_encadrants.push(elemToRemove);

				if (selected_encadrants.length == 0){
					document.getElementById("show_encadrants_table").style.display = "none";
				}
				updateDisplay();
				displaySubmitBtn();
			}).appendTo(td2);
		});

		//Mise à jour des options sélectionnables
		$('#encadrants').empty();
		$('#encadrants').append($('<option>', {
			value: '',
			text : "--{{__('msg.select')}}--"
		}));
		$.each(not_selected_encadrants, function (i, encadrant) {
			$('#encadrants').append($('<option>', {
				value: encadrant.id,
				text : encadrant.nomprenom
			}));
		});
	}

	function verification_presence_assurance(deb_emprunt, fin_emprunt) {
        $.ajax({
            type: "POST",
            url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/panier/verification_assurance') : url('api/panier/verification_assurance') }}",
            data: {
                deb_emprunt: deb_emprunt,
				fin_emprunt: fin_emprunt,
            },
            success: function(data) {
				if (data == true) {
					$('#insurance_section').hide();
					need_insurance = false;
					insurance_cover = false;
					$('#insurance').val('');
					$('#deb_assurance').val('');
					$('#fin_assurance').val('');
					$('#assurance_range').val('');
					displaySubmitBtn();
				} else {
					$('#insurance_section').show();
					need_insurance = true;
					insurance_cover = false;
					let deb_assurance = $('#deb_assurance').val();
					let fin_assurance = $('#fin_assurance').val();
					if (!deb_assurance) {
						displaySubmitBtn();
					} else {
						verification_dates_assurance(deb_emprunt, fin_emprunt, deb_assurance, fin_assurance);
					}

				}
            },
			error: function(data) {
				console.log(data);
			}
        });
    }

	function verification_dates_assurance(deb_emprunt, fin_emprunt, deb_assurance, fin_assurance) {
        $.ajax({
            type: "POST",
            url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/panier/verification_dates_assurance') : url('api/panier/verification_dates_assurance') }}",
            data: {
                deb_emprunt: deb_emprunt,
				fin_emprunt: fin_emprunt,
				deb_assurance: deb_assurance,
				fin_assurance: fin_assurance,
            },
            success: function(data) {
				console.log(data);
				if (data == true) {
					$('#assurance_error').hide();
					insurance_cover = true;
					displaySubmitBtn();
				} else {
					$('#assurance_error').show();
					insurance_cover = false;
					displaySubmitBtn();
				}
            },
			error: function(data) {
				console.log(data);
			}
        });
    }

	function displaySubmitBtn() {
		let display = true;
		let motif = $('#motif').val();

		if (selected_encadrants.length < 1) {
			display = false;
		} else if (!motif || motif.length < 50) {
			display = false;
		} else if (!$('#deb_emprunt').val()) {
			display = false;
		}

		if (need_insurance) {
			if (!insurance_cover) {
				display = false;
			} else if (!$('#insurance').val()) {
				display = false;
			}
		}

		$('#submitBtn').prop("disabled", !display);
	}

</script>
@endsection
