@extends('layouts/default-admin')

@section('content')

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - Ajouter un type de produit</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Accueil</a></li>
				<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
				<li class="breadcrumb-item active">Ajouter un type produit</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
	<div class="container-fluid">
		<div class="card card-primary">
			<form method="POST" action={{ $edit_type ? route('administration.materiel.types.update_type', ['id' => $type->id]) : route('administration.materiel.types.create_type') }}>
				{{ $edit_type ? method_field('PATCH') : method_field('PUT')}}
				@csrf
				<div class="card-header with-border">
					<h3 class="card-title">{{ trans_choice('msg.information', 2) }}</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group @error('type_name') has-error @enderror">
								<label>{{ __('msg.type_name') }}</label>
								<div class="input-group" data-children-count="1" style="width: 100%;">
									<input id="type_name" name="type_name" type="text" class="form-control" placeholder="Ex: Smartphone, Tablette...">
								</div>
								@error('type_name')
									<span class="help-block">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group @error('technicien_id') has-error @enderror">
								<label>{{ trans_choice('msg.technician', 1) }}</label>
								<select id="technicien_id" name="technicien_id" class="form-control " style="width: 100%;" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
									<option value=''>--{{__('msg.select')}}--</option>
									@foreach ($techniciens as $t)
										<option value={{ $t->id }}>{{$t->nomprenom}}</option>
									@endforeach
								</select>
								@error('technicien_id')
									<span class="help-block">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group @error('category_id') has-error @enderror">
								<label>{{ trans_choice('msg.category', 1) }}</label>
								<select id="category_id" name="category_id" class="form-control " style="width: 100%;" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
									<option value=''>--{{__('msg.select')}}--</option>
									@foreach ($categories as $c)
										<option value={{ $c->id }}>{{$c->nom}}</option>
									@endforeach
								</select>
								@error('category_id')
									<span class="help-block">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div style='text-align: center;'>
						@if ($edit_type)
							<button type="submit" class="btn btn-primary">{{ __('msg.save_modif') }}</button>
							<a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.materiel.types.index'); }}>{{ __('msg.cancel') }}</a></td>

						@else
							<button type="submit" class="btn btn-success">{{ __('msg.add_the_type') }}</button>
						@endif
					</div>
				</div>
			</form>
		</div>

		@if ($edit_type)
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="card-title">{{ trans_choice('msg.specification', 2) }}</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive no-padding">
						<table class="table table-hover">
							<tbody>
								<tr>
									<th style="width: 30%">{{ trans_choice('msg.name', 1) }}</th>
									<th style="width: 20%">{{ __('msg.value_type') }}</th>
									<th style="width: 20%">{{ trans_choice('msg.detail', 2) }}</th>
									<th style="width: 20%">{{ trans_choice('msg.action', 2) }}</th>
								</tr>
								@foreach ($type->filtres as $f)
									<tr>
										<td>{{ $f->nom }}</td>
										<td>
											@switch($f->valeur_type)
												@case(0)
													{{ __('msg.binary') }}
													@break
												@case(1)
													{{ __('msg.numeric') }}
													@break
												@case(2)
													{{ __('msg.alphanumeric') }}
													@break
											@endswitch
										</td>
										<td>{{ $f->unite }}</td>
										<td>
											<form style="display:inline;" method="POST" action={{ route('administration.materiel.types.show_filter', ['id' => $type->id, 'filter_id' => $f->id]) }}>
												{{ method_field('GET') }}
												@csrf
												<button style="margin-left: 5px" type="submit" class="btn btn-warning btn-sm">{{ __('msg.edit') }}</button>
											</form>
											<form style="display:inline;" method="POST" action={{ route('administration.materiel.types.delete_filter', ['id' => $type->id, 'filter_id' => $f->id]) }}>
												{{ method_field('DELETE') }}
												@csrf
												<button style="margin-left: 5px" type="submit" class="btn btn-danger btn-sm">{{ __('msg.delete') }}</button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="card-header">
						<h3 class="card-title">{{ $edit_filter ? __('msg.edit_spec') : __('msg.add_spec') }}</h3>
					</div>
					<form method="POST" action={{ $edit_filter ? route('administration.materiel.types.update_filter', ['id' => $type->id, 'filter_id' => $filter->id]) : route('administration.materiel.types.add_filter', ['id' => $type->id]) }}>
						{{ $edit_filter ? method_field('PATCH') : method_field('PUT')}}
						@csrf
						<input type="hidden" name="ignore_type_modif" value="1">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group @error('filter_name') has-error @enderror">
									<label>{{ trans_choice('msg.name', 1)}}</label>
									<div class="input-group" data-children-count="1" style="width: 100%;">
										<input id="filter_name" name="filter_name" type="text" class="form-control" placeholder="Ex: RAM, batterie..."
										@if (count($errors) > 0)
											value = '{{ old('filter_name') }}'
										@elseif ($edit_filter)
											value = '{{ $filter->nom }}'
										@endif
										>
									</div>
									@error('filter_name')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ __('msg.value_type') }}</label>
									<select id="dataType" name="dataType" class="form-control" style="width: 100%;" data-placeholder='--{{__('msg.select')}}--' data-select2-id="2" tabindex="-1" aria-hidden="true">
										<option value=''>--{{__('msg.select')}}--</option>
										<option value="0">{{ __('msg.binary') }}</option>
										<option value="1">{{ __('msg.numeric') }}</option>
										<option value="2">{{ __('msg.alphanumeric') }}</option>
									</select>
									@error('dataType')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>{{ trans_choice('msg.unit', 1)}}</label>
									<div class="input-group" data-children-count="1" style="width: 100%;">
										<input id="unit" name="unit" type="text" value = '{{ $edit_filter ? $filter->unite : '' }}' class="form-control" placeholder="Ex: Go, mAh...">
									</div>
									@error('unit')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
						<div style='text-align: center;'>
							@if ($edit_filter)
								<button type="submit" class="btn btn-primary">{{ __('msg.save_modif') }}</button>
								<a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.materiel.types.show_type', ['id' => $type->id]) }}>{{ __('msg.cancel') }}</a></td>
							@else
								<button type="submit" class="btn btn-success">{{ __('msg.add_spec') }}</button>
							@endif
						</div>
					</form>
				</div>
			</div>
		@endif
		</div>
</section>



<script type="module">

		$(document).ready(function() {
			display_selected_type_name();
			display_selected_technician();
			display_selected_category();

			@if ($edit_type)
				display_selected_filter_name();
				display_selected_data_type();
				display_selected_unit();
			@endif
		});

		function display_selected_type_name() {
			var type_name = "";

			@if (old('ignore_type_modif', null) != null)
				type_name = "{{ $type->nom }}"
			@elseif (count($errors) > 0)
				type_name = "{{ old('type_name') }}"
			@elseif ($edit_type)
				type_name = "{{ $type->nom }}"
			@endif

			$('#type_name').val(type_name);
		}

		function display_selected_technician() {
			var selected_id;
			@if (old('ignore_type_modif', null) != null)
				selected_id = "{{ $type->technicien_id }}"
			@elseif (count($errors) > 0)
				selected_id = "{{ old('technicien_id') }}"
			@elseif ($edit_type)
				selected_id = "{{ $type->technicien_id }}"
			@endif

			$('#technicien_id').val(selected_id);
			$('#technicien_id').trigger('change');
		}

		function display_selected_category() {
			var selected_id;
			@if (old('ignore_type_modif', null) != null)
				selected_id = "{{ $type->category_id }}"
			@elseif (count($errors) > 0)
				selected_id = "{{old('category_id')}}"
			@elseif ($edit_type)
				selected_id = "{{ $type->category_id }}"
			@endif

			$('#category_id').val(selected_id);
			$('#category_id').trigger('change');
		}

		function display_selected_filter_name() {
			var filter_name = "";
			@if (count($errors) > 0)
				filter_name = "{{ old('filter_name') }}"
			@elseif ($edit_filter)
				filter_name = "{{ $filter->nom }}"
			@endif

			$('#filter_name').val(filter_name);
		}

		function display_selected_data_type() {
			var data_type;
			@if (count($errors) > 0)
				data_type = {{ old('dataType') }}
			@elseif ($edit_filter)
				data_type = {{ $filter->valeur_type }}
			@endif

			$('#dataType').val(data_type);
			$('#dataType').trigger('change');
		}

		function display_selected_unit() {
			var unit = "";
			@if (count($errors) > 0)
				unit = "{{ old('unit') }}"
			@elseif ($edit_filter)
				unit = "{{ $filter->unite }}"
			@endif

			$('#unit').val(unit);
		}

	</script>
@endsection
