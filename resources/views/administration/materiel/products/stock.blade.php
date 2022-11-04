@extends('layouts/default-admin')

@section('content')

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - Gérer les stocks</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Accueil</a></li>
				<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
				<li class="breadcrumb-item active">Gestion des stocks</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12">
					<div class="card card-success" id="collapse-box">
						<form style="display:inline;" enctype="multipart/form-data" onsubmit="addHiddenFields()" method="POST" action={{ $edit_mode ? route('administration.materiel.products.update_ref', ['id' => $product->id, 'ref_id' => $reference->id]) : route('administration.materiel.products.add_ref', ['id' => $product->id]) }}>
							{{ $edit_mode ? method_field('PATCH') : method_field('PUT')}}
							@csrf
							<div class="card-header with-border">
								<h3 class="card-title">{{ $edit_mode ? "Modifier une référence" : "Ajouter une référence" }}</h3>
								<div class="card-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse">
										<i id="collapse-btn" class="fa"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group @error('serialnumber') has-error @enderror">
										<label>{{ __('msg.serial_nb') }}</label>
											<input type="text" name="serialnumber" id="serialnumber" class="form-control" placeholder="1B064H10491">
											@error('serialnumber')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
										<div class="form-group @error('stockage') has-error @enderror">
											<label>{{ __('msg.stockage_place') }}</label>
											<input type="text" name="stockage" id="stockage" class="form-control" placeholder="Armoire TD4">
											@error('stockage')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group @error('ensim_id') has-error @enderror">
											<label>Identifiant ENSIM</label>
											<input type="text" name="ensim_id" id="ensim_id" class="form-control" list="ensim_ids" placeholder="E-0000">
											<datalist id="ensim_ids">
												@foreach($ensim_ids as $id)
													<option value="{{$id}}" />
												@endforeach
											</datalist>
											@error('ensim_id')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
										<div class="form-group @error('status') has-error @enderror" style="margin-bottom: 0px;">
											<label>{{ __('msg.state') }}</label>
											<select name="status" id="status" class="form-control select2 select2-hidden-accessible" style="width: 100%;">
												<option value="0">{{ __('msg.in_stock') }}</option>
												<option value="1">{{ __('msg.under_reparation') }}</option>
												<option value="2">{{ __('msg.out_of_order') }}</option>
												<option value="3">Sorti d'inventaire</option>
											</select>
											@error('status')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group @error('details') has-error @enderror">
											<label>Détails</label>
											<input type="text" name="details" id="details" class="form-control" placeholder="Toute information complémentaire">
											@error('details')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>

										<label>{{ __('msg.file_uploading') }}</label>
										<div class="card-body table-responsive no-padding">
											<table class="table table-hover">
												<tbody id="documentsContainer"></tbody>
											</table>
										</div>
										<button style='margin-left: 5px; width:20%; min-width: 120px; margin-bottom: 5px' class='btn btn-primary btn-sm' type='button' onclick='addDocument()'>Ajouter un fichier</button>
										<div style="text-align: center;">
											@if ($edit_mode)
												<button type="submit" class="btn btn-primary">{{ __('msg.save_modif') }}</button>
												<a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.materiel.products.stocks', ['id' => $product->id]) }}>{{ __('msg.cancel') }}</a></td>
											@else
												<button type="submit" class="btn btn-success">{{ __('msg.add') }}</button>
											@endif
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>

					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">{{ __('msg.recorded_refs') }}</h3>
						</div>
						<div class="card-body table-responsive no-padding">
							<table id="datatable" class="table table-hover">
								<thead>
									<tr>
										<th style="width: 15%">Identifiant ENSIM</th>
										<th style="width: 15%">{{ __('msg.serial_nb') }}</th>
										<th style="width: 15%">{{ __('msg.state') }}</th>
										<th style="width: 15%">{{ __('msg.stockage_place') }}</th>
										<th style="width: 10%">{{ __('msg.inventory_date') }}</th>
										<th style="width: 10%">Détails</th>
										<th style="width: 20%">{{ trans_choice(__('msg.action'), 2) }}</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($product->references as $r)
									<tr class="elem-row" id="stock-{{$r->id}}">
										<td>{{ $r->ensim_id }}</td>
										<td>{{ $r->numero_serie }}</td>
										@switch($r->status)
											@case(0)
												@if($r->empruntActif() != null)
													@if ($r->empruntActif()->reserve())
														<td><span class="label label-primary">{{ __('msg.reserved') }}</span></td>
													@else
														<td><span class="label label-info">{{ __('msg.borrowed') }}</span></td>
													@endif
												@else
													<td><span class="label label-success">{{ __('msg.in_stock') }}</span></td>
												@endif
												@break
											@case(1)
												<td><span class="label label-warning">{{ __('msg.under_reparation') }}</span></td>
												@break
											@case(2)
												<td><span class="label label-danger">{{ __('msg.out_of_order') }}</span></td>
												@break
											@case(3)
												<td><span class="label bg-navy">Sorti d'inventaire</span></td>
												@break
										@endswitch
										<td>{{ $r->stockage }}</td>
										<td>{{ $r->created_at->format('d/m/Y') }}</td>
										<td>{{ $r->details }}</td>
										<td>
											{{-- <button style="margin-left: 5px; width:33%; min-width: 90px" type="button" class="btn btn-primary btn-sm" onclick="updateModalContent('{{$r->ensim_id}}', '{{ route('qrcode.index', ['ref_id' => $r->id]) }}')" data-bs-toggle="modal" data-backdrop="static" data-keyboard="false" data-bs-target="#qrcode_modal">QR Code</button> --}}
											<button style="margin-left: 5px; width:33%; min-width: 90px" type="button" class="btn btn-primary btn-sm action-qrcode" data-ensim-id="{{$r->ensim_id}}" data-url="{{ route('qrcode.index',['ref_id' => $r->id]) }}" data-bs-toggle="modal" data-backdrop="static" data-keyboard="false" data-bs-target="#qrcode_modal">QR Code</button>
											<a href="{{ route('administration.materiel.products.show_ref', ['id' => $product->id, 'ref_id' => $r->id]) }}">
												<button style="margin-left: 5px; width:33%; min-width: 90px" type="submit" class="btn btn-warning btn-sm">{{ __('msg.edit') }}</button>
											</a>
											<form style="display:inline;" method="POST" action={{ route('administration.materiel.products.delete_ref', ['id' => $product->id, 'ref_id' => $r->id]) }}>
												{{ method_field('DELETE') }}
												@csrf
												<button style="margin-left: 5px; width:33%; min-width: 90px" type="submit" class="btn btn-danger btn-sm">{{ __('msg.delete') }}</button>
											</form>
											@if($r->empruntActif() != null)
												<a href="{{ route('administration.materiel.requests.show', ['id' => $r->empruntActif()->id]) }}">
													<button  style="margin-left: 5px; width:33%; min-width: 90px" type="button" class="btn btn-primary btn-sm">Emprunt en cours</button>
												</a>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal -->
			{{-- <div class="modal fade" id="qrcode_modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ion-android-close"></span></button>
						<h4 class="modal-title" id="qrcode-ref"></h4>
					</div>
					<!-- Modal Body -->
					<div class="modal-body" style="text-align: center;">
						<div style="margin-bottom: 10px;" id="qrcode-img"></div>
						<a id="qrcode-link"></a>
					</div>
				</div>
			</div>
		</div> --}}
		<div class="modal fade" id="qrcode_modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="ion-android-close"></span></button>
						<h4 class="modal-title mt-0" id="qrcode-ref"></h4>
					</div>
					<!-- Modal Body -->
					<div class="modal-body" style="text-align: center;">
						<canvas id="qrcodeImg"></canvas>
						{{-- <div style="margin-bottom: 10px;" id="qrcode-img"></div> --}}
						<a class="d-block" id="qrcode-link"></a>
					</div>
				</div>
			</div>
		</div>
	</section>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script type="module">
	
	var ref_documents = [];

	$( document ).ready(function() {

		@if(!$edit_mode && count($errors) == 0)
			$('#collapse-box').addClass('collapsed-box');
			$('#collapse-btn').addClass('fa-plus');
		@else
		$('#collapse-btn').addClass('fa-minus');
		@endif

		display_searchbar();
		display_serial_nb();
		display_ensim_id();
		display_stockage();
		display_details();
		display_status();

		@if ($edit_mode)
			@foreach ($reference->fichiers as $doc)
				ref_documents.push({
					id_fichier: {{$doc->id}},
					nom: '{{$doc->nom}}',
					fichier: '{{ asset($doc->fichier) }}'
				})
			@endforeach
		@endif

		display_documents();


	});

	function updateModalContent(ensim_id, url) {
		$('#qrcode-link').html(url).attr("href", url);
		$('#qrcode-ref').html(ensim_id);
		$('#qrcodeImg').empty();

		console.log(url);

		// QRCode.toCanvas(qrcodeImg, url, function (error) {
		// 	if (error) console.error(error)
		// 	console.log('success!');
		// })

		QRCode.toCanvas(qrcodeImg, url, {
			errorCorrectionLevel: 'H',
			width: 300,
			}, function (err) {
			if (err) throw err
			console.log('done')
		})

		// var QR_CODE = new QRCode("qrcode-img", {
		// 	width: 220,
		// 	height: 220,
		// 	colorDark: "#000000",
		// 	colorLight: "#ffffff",
		// 	correctLevel: QRCode.CorrectLevel.H,
		// });
		// QR_CODE.makeCode(url);
		// setTimeout(() => {$('#qrcode-img').find('img').css('display', '');}, 100);
	}

	function onSearch(value, strictSearch) {
		$.ajax({
			type: "POST",
			url: "{{ env('WEBSITE_SSL') == true ? secure_url('api/stocks/recherche') : url('api/stocks/recherche') }}",
			data: {
				keyword: value,
				id: {{$product->id}},
				strictSearch: strictSearch,
			},
			success: function(data) {
				Array.prototype.forEach.call(elements, function(e) {
					if (e.id.includes("stock")){
						lineId = parseInt(e.id.replace("stock-", ""));
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

	function display_documents() {
		$('#documentsContainer').empty();
		if (ref_documents.length > 0) {
			$('#documentsContainer').html("<tr><th style='width: 40%'>Nom du fichier</th><th style='width: 40%'>Fichier</th><th style='width: 20%'>Actions</th></tr>");
			for (let i = 0; i < ref_documents.length; i++) {
				let doc = ref_documents[i];
				let tr = $("<tr></tr>").attr({ class: "elem-row" }).appendTo($('#documentsContainer'));
				let td1 = $("<td></td>").appendTo(tr);
				$("<input></input>").attr({
					type: "text",
					class: "form-control",
					placeholder: "Nom",
					value: doc.nom
				}).html(doc.nom).on('input',function(e){
					doc.nom = $(this).val();
				}).appendTo(td1);
				let td2 = $("<td></td>").appendTo(tr);
				if(doc.id_fichier != null && doc.id_fichier != "") {
					$("<a target='_blank' href='" + doc.fichier + "' download>" + doc.nom + "</a>").appendTo(td2);
				} else {
					$("<input></input>").attr({
						type: "file",
						name: "documents[]",
					}).on('input',function(e){
						const doc_max_size = 10 // Taille maximale de la fiche technique en Mo
						if(this.files[0].size > doc_max_size * 1048576){
							alert("Fichier trop volumineux : Taille max = " + doc_max_size + " Mo");
							this.value = "";
						} else {
							doc.fichier = e.target.files[0].name;
						}
					}).appendTo(td2);
				}
				let td3 = $("<td></td>").appendTo(tr);
				let btn = $("<button></button>").attr({
					style: "margin-left: 5px; width:45%; min-width: 90px",
					class: "btn btn-danger btn-sm",
					type: "button",
					onclick: "deleteElement(" + i + ")",
				}).appendTo(td3);
				btn.html("{{ __('msg.delete') }}");
			}
			let tr = $("<tr></tr>").attr({ class: "elem-row" }).appendTo($('#documentsContainer'));
			let td = $("<td></td>").appendTo(tr);
		}
	}

	function addDocument() {
		ref_documents.push({
			id_fichier: null,
			nom: null,
			fichier: null,
		})
		display_documents();
	}

	function deleteElement(index) {
		ref_documents.splice(index, 1);
		display_documents();
	}

	function addHiddenFields() {
		if (ref_documents.length > 0) {
			for (let i = 0; i < ref_documents.length; i++) {
				let ref = ref_documents[i];
				$("<input></input>").attr({
					type: "hidden",
					name: "docs_info[]",
					value: JSON.stringify(ref),
				}).appendTo($('#documentsContainer'));
			}
		}
		return true;
	}

	function display_serial_nb() {
		var sn = "";
		@if (count($errors) > 0)
			sn = "{{ old('serialnumber') }}"
		@elseif ($edit_mode)
			sn = "{{ $reference->numero_serie }}"
		@endif
		$('#serialnumber').val(sn);
	}

	function display_ensim_id() {
		var ei = "";
		@if (count($errors) > 0)
			ei = "{{ old('ensim_id') }}"
		@elseif ($edit_mode)
			ei = "{{ $reference->ensim_id }}"
		@endif
		$('#ensim_id').val(ei);
	}

	function display_stockage() {
		var stockage = "";
		@if (count($errors) > 0)
			stockage = "{{ old('stockage') }}"
		@elseif ($edit_mode)
			stockage = "{{ $reference->stockage }}"
		@endif
		$('#stockage').val(stockage);
	}

	function display_details() {
		var details = "";
		@if (count($errors) > 0)
			details = "{{ old('details') }}"
		@elseif ($edit_mode)
			details = "{{ $reference->details }}"
		@endif
		$('#details').val(details);
	}

	function display_status() {
		var status = 0;
		@if (count($errors) > 0)
			status = "{{ old('status') }}"
		@elseif ($edit_mode)
			status = "{{ $reference->status }}"
		@endif
		$('#status').val(status).change();
	}

	function display_searchbar() {
		var search = new URL(window.location.href).searchParams.get("search");
		if (search != null && search != "") {
			$('#search_bar').val(search);
			onSearch(search, true);
		}
	}

	$(".action-qrcode").click(function (e) { 
		var ensimId = $(this).data("ensim-id");
		var url = $(this).data("url");
		
		// updateModalContent(ensimId, `route('qrcode.index',['ref_id' => ${ref}])`);
		updateModalContent(ensimId, url);		
	});


</script>
@endsection
