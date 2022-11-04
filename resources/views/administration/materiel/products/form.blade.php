@extends('layouts/default-admin')

{{-- <style>
	.product-img{
		margin: 10px;
		width: 115px;
		height: 115px;
		line-height: 115px;
		text-align: center;
	    border-radius: 10px;
		border: solid 2px #c3c3c3bd;
		background: white;
		display: inline-block;
	}

	.product-img:hover {
		border: solid 2px #dd4b39;
		box-shadow:0 1px 1px rgba(0,0,0,0.05),0 2px 2px rgba(0,0,0,0.05),0 4px 4px rgba(0,0,0,0.05),0 8px 8px rgba(0,0,0,0.05),0 16px 16px rgba(0,0,0,0.05),0 32px 32px rgba(0,0,0,0.05);
	}

	.product-img > img{
		max-width: 100%;
	    max-height: 100%;
	    position: relative;
	    padding: 5px;
	}

	.fav-btn {
		position: absolute;
	    background-color: white;
	    border: solid 2px #d2d2d2;
	    z-index: 2;
	}

	.fav-check, .fav-check:hover {
		position: absolute;
		background-color: white;
		border: solid 2px #dda139;
	    z-index: 2;
	}

	.fav-btn:hover {
		border: solid 2px #dda139;
		background-color: white;
	    z-index: 2;
	}

	.fav-icon {
		top: -2px !important;
		color: #f1f1f1;
	}

	.fav-check > .fav-icon, .fav-check > .fav-icon:hover {
		color: #fbdb83;
	}

	.fav-icon:hover {
		color: #fbdb83;
	}
</style> --}}

<style>
	img[data-dz-thumbnail] {
		width: 90%;
		height: 90%;
		margin: auto;

		object-fit: contain;
		}

	div.dz-filename{
		display: none;
	}

	div.dz-size{
		display: none;
	}
</style>

@section('content')


	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Matériel - Ajouter un produit</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Accueil</a></li>
					<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
					<li class="breadcrumb-item active">Ajouter un produit</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</section>

	<section class="content">
		<div class="container-fluid">
			<form method="POST" enctype="multipart/form-data" action={{ $edit_mode ? route('administration.materiel.products.update', ['id' => $product->id]) : route('administration.materiel.products.add_product') }}>
				{{ $edit_mode ? method_field('PATCH') : method_field('PUT')}}
				@csrf
				<div class="row">
					<div class="col-md-12">
						<div class="card card-primary">
							<div class="card-header with-border">
								<h3 class="card-title">{{ __('msg.general_infos') }}</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group @error('name') has-error @enderror">
											<label>{{ trans_choice('msg.name', 1) }}</label>
											<div class="input-group" data-children-count="1" style="width: 100%;">
												<input type="text" name="name" class="form-control"
												@if (count($errors) > 0)
													value = '{{ old('name') }}'
												@elseif ($edit_mode)
													value = '{{ $product->nom }}'
												@endif
												>
											</div>
											@error('name')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
										<div class="form-group @error('product_type') has-error @enderror" data-children-count="1" data-select2-id="13">
											<label>{{ trans_choice('msg.product_type', 1) }}</label>
											<select name="product_type" id="cmbtype" class="form-control" data-placeholder='--{{__('msg.select')}}--' style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
												<option value=''>--{{__('msg.select')}}--</option>
												@foreach ($types as $t)
													<option
													@if (count($errors) > 0)
														@if ($t->id == old('product_type'))
															selected
														@endif
													@elseif ($edit_mode && $t->id == $product->type->id)
														selected
													@endif
													value={{ $t->id }}>{{$t->nom}}</option>
												@endforeach
											</select>
											@error('product_type')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group @error('brand') has-error @enderror">
											<label>{{ trans_choice('msg.brand', 1) }}</label>
											<div class="input-group" data-children-count="1" style="width: 100%;">
												<input type="text" id=brand" name="brand" list="brands" class="form-control"
												@if (count($errors) > 0)
													value = '{{ old('brand') }}'
												@elseif ($edit_mode)
													value = '{{ $product->marque }}'
												@endif
												>
												<datalist id="brands">
													@foreach($brands as $brand)
														<option value="{{$brand}}" />
													@endforeach
												</datalist>
											</div>
											@error('brand')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
										<div class="form-group @error('model_nb') has-error @enderror">
											<label>{{ __('msg.model_nb') }}</label>
											<div class="input-group" data-children-count="1" style="width: 100%;">
												<input name="model_nb" type="text" class="form-control"
												@if (count($errors) > 0)
													value = '{{ old('model_nb') }}'
												@elseif ($edit_mode)
													value = '{{ $product->numero_modele }}'
												@endif
												>
											</div>
											@error('model_nb')
												<span class="help-block">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="boxcarac" class="card card-primary" style="display: none;">
							<div class="card-header with-border">
								<h3 class="card-title">{{ trans_choice('msg.specific_spec', 2) }}</h3>
							</div>
							<div class="card-body">
								<div class="row" id="filtresBox">
									<!--JS CONTENT-->
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card card-primary">
							<div class="card-header with-border">
								<h3 class="card-title">{{ trans_choice('msg.image', 2) }}</h3>
							</div>
							{{-- padding: 8px; --}}
							<div style=" background:#7272720d">
								{{-- @if ($edit_mode)
									@if ($product->imagePrincipale)
									<input type="hidden" id="mainPhoto" name="mainPhoto" value="{{$product->imagePrincipale->id}}"></input>
									@endif
									@foreach ($product->images as $image)
										<div style="display: inline-block" id="block-{{ $image->id }}" >
											<a class="btn btn-social-icon btn-vk @if($image->id == $product->imagePrincipale->id) fav-check @else fav-btn @endif" id="fav-{{ $image->id }}" onclick="setMainImg({{$image->id}})"><i class="fa fa-fw fa-star fav-icon"></i></a>
											<div class="product-img" onclick="deleteConfirm('img{{$image->id}}')">
												<img src="{{ asset('storage/module_materiel/'. $image->image) }}"/>
											</div>
											<button type="button" style="display:none" id="img{{$image->id}}" onclick="hideImg({{$image->id}})"></button>
										</div>
									@endforeach
								@endif --}}

								@if ($edit_mode)
									<div class="dropzone dz-clickable" id="images-upload">
										<div>
											<h4 class="text-center">Cliquez pour ajouter une image</h4>
										</div>
										<div class="dz-default dz-message"><span>Déposez vos images ici</span></div>
									</div>
								@endif

							</div>
							{{-- <div class="card-body">
								<div id='deletePhotoDiv'></div>
								<div class="form-group @error('inputPhotos') has-error @enderror">
									<label for="inputPhotos">{{ __('msg.file_uploading') }} ({{ __('msg.mutiple_files_allowed') }})</label>
									<input type="file" id="inputPhotos" name="photos[]" multiple />
									@error('inputPhotos')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div> --}}
						</div>
					</div>
					<div class="col-md-6">
						<div class="card card-primary">
							<div class="card-header with-border">
								<h3 class="card-title">{{ __('msg.technical_sheet') }}</h3>
							</div>
							<div class="card-body">
								<div class="form-group @error('inputSheet') has-error @enderror">
									<label for="inputSheet">{{ __('msg.file_uploading') }}</label>
									@if ($edit_mode && $product->fiche_technique != null)
										<br/>
										<a href="{{ asset($product->fiche_technique) }}">{{ __('msg.see_technical_sheet') }}</a>
										<br/>
									@endif
									<input type="file" id="inputSheet" name="sheet">
									@error('inputSheet')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
				</div>
				<div style="text-align: center;">
					@if ($edit_mode)
						<button type="submit" class="btn btn-primary">{{ __('msg.save_modif') }}</button>
						<a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.materiel.products.index') }}>{{ __('msg.cancel') }}</a>
					@else
						<button type="submit" class="btn btn-success">{{ __('msg.add') }}</button>
					@endif
				</div>

					@foreach ($product->images as $image)
						<input type="hidden" name="images[]" data-new=0 id="{{ $image->id }}"  data-image="{{ $image->image }}"></input>
					@endforeach

			</form>
		</div>
	</section>

<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />


<script type="module">

	/////////////////////////////////////////
    // Ajouter des fichiers (documents, diapos...)
    /////////////////////////////////////////

    // Dropzone.autoDiscover = false;
    var uploadedDocumentMap = {}

    let imagesDropzone = new Dropzone("#images-upload", {
        url: "{{ route('store_tmp_file') }}",
        acceptedFiles: ".png, .jpg, .jpeg",
        addRemoveLinks: true,
        uploadMultiple: true,
        parallelUploads: 1,
        maxFilesize: 256,
        maxFiles: 10,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        paramName: "files",
        // autoProcessQueue:false,

        success: function (file, response) {
            $('form').append('<input type="hidden" name="images[]" data-new=1 value="' + response.name + '">');
			$(".dz-preview:last-child").attr("data-fancybox", "gallery");
			$(".dz-preview:last-child").attr("data-src", response.src);
            uploadedDocumentMap[file.name] = response.name;
        },

        error: function(file, response){
            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text("Une erreur s'est produite avec ce fichier");
        },

        removedfile: function (file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }        
			
			// Si l'image était déjà enregistrée
			if (jQuery.isPlainObject(file)){
				console.log("image déja présente");
				$(`input[name="images[]"]#${file.name}`).attr("data-del",1);
			}else{
				console.log("nouvelle image");
				$('form').find('input[name="images[]"][value="' + name + '"]').remove();
			}
			
			
			

            $.ajax({
                type:'POST',
                url:"{{ route('remove_tmp_file') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "name": name,
                },
                success:function(data){
                    console.log("ok");
                }
            });
        },
    });

	$("[name='images[]']").each(function(){

// Create the mock file:
var mockFile = { name: `${$(this).attr("id")}`, size: 1000 };
var url = `/storage/module_materiel/${$(this).data("image")}`;

// Call the default addedfile event handler
imagesDropzone.emit("addedfile", mockFile);
imagesDropzone.emit("thumbnail", mockFile, url);
imagesDropzone.emit("complete", mockFile);

$(".dz-preview:last-child").attr("data-fancybox", "gallery");
$(".dz-preview:last-child").attr("data-src", url);

imagesDropzone.files.push(mockFile);
});

	


	/////////////////////////////////////////
    // Autre
    /////////////////////////////////////////

  	$("#filtresBox").empty();

	var errors = @json($errors->messages());
	var olds = @json(old());
	var fields = [];


	Object.keys(olds).forEach(function (key){
		content = [];
		content["isError"] = errors[key] == null ? false : true;
		content["msg"] = errors[key] == null ? '' : errors[key][0];
		content["oldValue"] = olds[key];
		fields[key] = content;
	});

	@if ($edit_mode)
		var product_id = @json($product->id);
		var type_id = @json($product->type->id);
		displayFilters(product_id, "produits");
	@elseif (old("product_type") != null)
		var type_id = fields["product_type"].oldValue;
		displayFilters(type_id, "types");
	@endif

	// Mise à jour des caractéristiques lors du changement de type
	$('#cmbtype').on('select2:select', function (e) {
		var selected_type_id = e.params.data.id;
		if (typeof product_id !== 'undefined' && type_id == selected_type_id){
			displayFilters(product_id, "produits");
		}
		else {
			displayFilters(selected_type_id, "types");
		}
	});

	function displayFilters(type_id, type) {
		$.ajax({
			type: "POST",
			url: "",
			url: (type == "types" ? "{{ env('WEBSITE_SSL') == true ? secure_url('api/types/filtres') : url('api/types/filtres') }}" : "{{ env('WEBSITE_SSL') == true ? secure_url('api/produits/filtres') : url('api/produits/filtres') }}"),
			data: {
				id: type_id
			},
			success: function(data) {
				$("#filtresBox").empty();
				var i = 0;
				var colmd;
				if (data.length == 0){
					document.getElementById('boxcarac').style.display = "none";
				} else {
					document.getElementById('boxcarac').style.display = "";
					data.forEach(function(f) {
						if (i%(Math.ceil(data.length/2)) == 0){
							colmd = document.createElement("div");
							colmd.className="col-md-6";
							$("#filtresBox").append(colmd);
						}

						var field = null;

						for (const [key, value] of Object.entries(fields)) {
						  if (key == "filtre" + f.id){
							  field = value;
						  }
						}

						var formgroup = document.createElement("div");
						formgroup.className="form-group" + (field != null && field.isError ? " has-error" : "");
						colmd.append(formgroup);

						var label = document.createElement("label");
						label.innerHTML = f.nom + ([f.unite.length == 0 ? "" : " ("+f.unite+")"]);
						formgroup.append(label);

						var inputgroup = document.createElement("div");
						inputgroup.className="input-group";
						inputgroup.style="width: 100%";
						inputgroup.setAttribute('data-children-count', "1");
						formgroup.append(inputgroup);

						// Type de valeur numérique ou alphanumérique
						if (f["valeur_type"] != "0"){
							var inputtext = document.createElement("input");
							switch (f["valeur_type"]){
								case 1:
									inputtext.type="number";
									break;
								case 2:
									inputtext.type="text";
									break;
							}
							inputtext.name= "filtre" + f.id;
							inputtext.className= "form-control";
							@if ($edit_mode)
								inputtext.value = field != null ? field.oldValue : f.valeur;
							@endif
							inputgroup.append(inputtext);
						}

						//Type de valeur binaire
						else {
							var select = document.createElement("select");
							select.name= "filtre" + f.id;
							select.className="form-control select2";
							select.style="width: 100%";
							select.setAttribute('data-placeholder', "--{{__('msg.select')}}--");
							select.setAttribute('data-select2-id', "1");
							select.setAttribute('tabindex', "-1");
							select.setAttribute('aria-hidden', "true");
							inputgroup.append(select);

							var option1 = document.createElement("option");
							option1.value="";
							option1.innerHTML="--{{__('msg.select')}}--";

							var option2 = document.createElement("option");
							option2.value="1";
							option2.innerHTML="{{__('msg.yes')}}";

							var option3 = document.createElement("option");
							option3.value="2";
							option3.innerHTML="{{__('msg.no')}}";

							@if ($edit_mode)
								var selected_value = field != null ? field.oldValue : f.valeur
								if (selected_value == 1) {
									option2.selected = true;
								} else if (selected_value == 2){
									option3.selected = true;
								} else {
									option1.selected = true;
								}
							@endif

							select.append(option1, option2, option3);
						}
						if (field != null && field.isError){
							var helpblock = document.createElement("span");
							helpblock.className="help-block";
							helpblock.innerHTML=field.msg;
							formgroup.append(helpblock);
						}
						i++;
					});
				}
			}
		});
  	}

	function deleteConfirm(img){
        setModalTitle("Êtes-vous sûr de supprimer cette image ?");
        setModalContent("");
        showModal(img);
    }

	function hideImg(id) {
		img = document.getElementById("block-"+id);
		img.style.display = "none";
		let div = document.getElementById('deletePhotoDiv');
		let input = document.createElement("input");
		input.type = "hidden";
		input.name = "deletePhotoIds[]";
		input.value = id;
		div.appendChild(input);
	}

	function setMainImg(id) {
		var favBtns = document.getElementsByClassName('fav-check');
		Array.prototype.filter.call(favBtns, function(favBtn){
			favBtn.classList.remove("fav-check");
			favBtn.classList.add("fav-btn");
		});

		img = document.getElementById("fav-"+id);
		img.classList.remove("fav-btn");
		img.classList.remove("fav-check");
		img.classList.add("fav-check");

		var1 = document.getElementById("mainPhoto");
		var1.value = id;

	}

	$('#inputSheet').on("input", function() {
		const techn_sheet_max_size = 20 // Taille maximale de la fiche technique en Mo
		if(this.files[0].size > techn_sheet_max_size * 1048576){
			alert("Fichier trop volumineux : Taille max = " + techn_sheet_max_size + " Mo");
			this.value = "";
		};
	});

	$('#inputPhotos').on("input", function() {
		const photos_max_size = 0.512 // Taille maximale de la fiche technique en Mo
		for (let i = 0; i < this.files.length; i++) {
			if(this.files[i].size > photos_max_size * 1048576){
				alert("Fichier trop volumineux : Taille max = " + photos_max_size + " Mo");
				this.value = "";
				break;
			};
		}
	});

  </script>
@endsection
