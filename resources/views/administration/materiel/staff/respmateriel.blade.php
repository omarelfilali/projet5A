@extends('layouts/default-admin')

@section('content')

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - Responsable matériel</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Accueil</a></li>
				<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
				<li class="breadcrumb-item active">Responsable matériel</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
		<div class="container-fluid">
			<div class="card card-success">
				<form method="POST" action={{ $edit_mode ? route('administration.materiel.staff.respmateriels.update', ['id' => $resp->id]) : route('administration.materiel.staff.respmateriels.add') }}>
					{{ $edit_mode ? method_field('PATCH') : method_field('PUT')}}
					@csrf
					<div class="card-header with-border">
						<h3 class="card-title">{{ $edit_mode ? __('msg.edit_mat_resp') : __('msg.add_mat_resp') }}</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group @error('personnel_id') has-error @enderror">
									<label>{{ __('msg.mat_resp_name') }}</label>
									<select id="personnel_id" name="personnel_id" class="form-control" style="width: calc(100% - 117px);" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
										<option value=''>--{{__('msg.select')}}--</option>
										@foreach ($personnels as $p)
											<option value={{ $p->uid }}>{{ $p->nomprenom }}</option>
										@endforeach
										@if ($edit_mode)
											@foreach ($allResps as $r)
												@if ($r->nomprenom == $resp->nomprenom)
													<option selected value={{ $r->uid }}>{{$r->nomprenom}}</option>
												@endif
											@endforeach
										@endif
									</select>
									@error('personnel_id')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('categories') has-error @enderror">
									<label>{{ trans_choice('msg.supervised_category', 2) }}</label>
									<select id="categories" name="categories[]" class="form-control select2" multiple="" data-placeholder="Sélectionnez une ou plusieurs catégories" style="width: 100%;">
										@foreach ($categories as $c)
											<option value='{{ $c->id}}'> {{ $c->nom }}</option>
										@endforeach
									</select>
									@error('categories')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-12">
								<div style="text-align: center;">
									@if ($edit_mode)
										<button type="submit" class="btn btn-primary">{{ __('msg.save_modif') }}</button>
										<a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.materiel.staff.respmateriels') }}>{{ __('msg.cancel') }}</a></td>
									@else
										<button type="submit" class="btn btn-success">{{ __('msg.add_resp') }}</button>
									@endif
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="card card-primary">
				<div class="card-header with-border">
				<h3 class="card-title">{{ trans_choice('msg.mat_resp', 2) }}</h3>
				</div>
					<div class="card-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody><tr>
						<th style="width: 40%">{{ trans_choice('msg.name', 1) }}</th>
						<th style="width: 40%">{{ trans_choice('msg.category', 2) }}</th>
						<th style="width: 20%">{{ trans_choice('msg.action', 2) }}</th>
						</tr>
						@foreach ($allResps as $r)
						<tr>
						<td>{{ $r->prenom }} {{ $r->nom }}</td>
						<td>
						@foreach ($r->categories as $c)
							<li>{{ $c->categorie->nom }}</li>
						@endforeach
						</td>
						<td>
							<form style="display:inline;" method="POST" action={{ route('administration.materiel.staff.respmateriels.show', ['id' => $r->id]) }}>
									{{ method_field('GET') }}
									@csrf
									<button style="margin-left: 5px" type="submit" class="btn btn-warning btn-sm">{{ __('msg.edit') }}</button>
								</form>
								<form style="display:inline;" method="POST" action={{ route('administration.materiel.staff.respmateriels.delete', ['id' => $r->id]) }}>
									{{ method_field('DELETE') }}
									@csrf
									<button style="margin-left: 5px" type="submit" class="btn btn-danger btn-sm">{{ __('msg.delete') }}</button>
								</form>
						</td>
						</tr>
						@endforeach
					</tbody></table>
					</div>
			</div>
		</div>
	</section>

<script type="module">

	$(document).ready(function() {
		display_selected_resp();
		display_selected_categories();
	});

	function display_selected_resp() {
		var selected_id;
		@if (old('personnel_id', null) != null)
			selected_id = "{{ old('personnel_id') }}";
		@elseif ($edit_mode)
			selected_id = "{{ $resp->uid }}"
		@endif

		$('#personnel_id').val(selected_id);
		$('#personnel_id').trigger('change');
	}

	function display_selected_categories() {

		var selected_ids = [];
		@if (count($errors) > 0)
			@for( $i =0; $i < count(old('categories', [])); $i++)
				selected_ids.push(@json(old('categories.'.$i)))
			@endfor
		@elseif ($edit_mode)
			selected_ids = @json($selected_categories)
		@endif

		$('#categories').val(selected_ids);
		$('#categories').trigger('change');
	}

	</script>
@endsection
