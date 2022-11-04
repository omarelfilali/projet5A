@extends('layouts/default-admin')

@section('content')

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - Catégories</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Accueil</a></li>
				<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
				<li class="breadcrumb-item active">Catégorie</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
		<div class="container-fluid">
			<div class="card">
				<form method="POST" action={{ $edit_mode ? route('administration.materiel.categories.update', ['id' => $category->id]) : route('administration.materiel.categories.add') }}>
					{{ $edit_mode ? method_field('PATCH') : method_field('PUT')}}
					@csrf
					<div class="card-header text-bg-warning">
						<h3 class="box-title">{{ $edit_mode ? __('msg.edit_category') : __('msg.add_category') }}</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-9">
								<div class="form-group @error('name') has-error @enderror">
									<label>{{ __('msg.category_name') }}</label>
									<div class="input-group" data-children-count="1" style="width: 100%;">
										<input id="name" type="text" class="form-control" name="name" placeholder="Ex: VAC, INFO">
									</div>
									@error('name')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group @error('visible') has-error @enderror">
									<label>{{ __('msg.visible') }}</label>
									<label style="display: block; margin-top: 3px; margin-left: 8px">
										<div class="checked" aria-checked="true" aria-disabled="false" style="position: relative;">
											<input type='hidden' value='0' name='visible'>
											<input name="visible" type="checkbox"
											@if (count($errors) > 0)
												{{ old('visible') == 'on' ? 'checked' : '' }}
											@elseif ($edit_mode)
												{{ $category->visible == 1 ? 'checked' : '' }}
											@endif
											style="position: absolute; ">
										</div>
									</label>
									@error('visible')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-12">
								<div style="text-align: center;">
									@if ($edit_mode)
										<button type="submit" class="btn btn-primary">{{ __('msg.save_modif') }}</button>
										<a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.materiel.categories.index') }}>{{ __('msg.cancel') }}</a></td>
									@else
										<button type="submit" class="btn btn-success">{{ __('msg.add_category') }}</button>
									@endif
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="card card-primary">
				<div class="card-header">
					<h3 class="box-title">{{ trans_choice('msg.category', 2) }}</h3>
				</div>
				<div class="card-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody><tr>
							<th style="width: 40%">{{ trans_choice('msg.category', 1) }}</th>
							<th style="width: 40%">{{ __('msg.visible') }}</th>
							<th style="width: 20%">{{ trans_choice('msg.action', 2) }}</th>
						</tr>
						@foreach ($categories as $c)
						<tr>
						<td>{{ $c->nom }}</td>
						<td>
							@if($c->visible==1)
								<span class="badge bg-success">{{ __('msg.yes') }}</span>
							@else
								<span class="badge bg-danger">{{ __('msg.no') }}</span>
							@endif
						</td>
						<td>
							<form style="display:inline;" method="POST" action={{ route('administration.materiel.categories.show', ['id' => $c->id]) }}>
								{{ method_field('GET') }}
								@csrf
								<button style="margin-left: 5px" type="submit" class="btn btn-warning btn-sm">{{ __('msg.edit') }}</button>
							</form>
							<form style="display:inline;" method="POST" action={{ route('administration.materiel.categories.delete', ['id' => $c->id]) }}>
								{{ method_field('DELETE') }}
								@csrf
								<button style="margin-left: 5px" type="submit" class="btn btn-danger btn-sm">{{ __('msg.delete') }}</button>
							</form>
						</tr>
						@endforeach
					</tbody></table>
				</div>
			</div>
		</div>


	</section>


<script type="module">

	$(document).ready(function() {
		display_name();
	});

	function display_name() {
		var name = "";
		@if (count($errors) > 0)
			name = "{{ old('name') }}"
		@elseif ($edit_mode)
			name = "{{ $category->nom }}"
		@endif

		$('#name').val(name);
	}

</script>

@endsection
