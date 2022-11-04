@extends('layouts/default-admin')

@section('content')

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Matériel - Responsable administratif</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="#">Accueil</a></li>
				<li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Materiel</a></li>
				<li class="breadcrumb-item active">Responsable administratif</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</section>

<section class="content">
		<div class="container-fluid">
			<div class="card card-success">
				<form method="POST" action={{ route('administration.materiel.staff.respadministratifs.add') }}>
					{{ method_field('PUT')}}
					@csrf
					<div class="card-header with-border">
						<h3 class="card-title">{{ __('msg.add_admin_resp') }}</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group @error('personnel_id') has-error @enderror">
									<label>{{ __('msg.admin_resp_name') }}</label>
									<select name="personnel_id" class="form-control" style="width: calc(100% - 117px);" data-placeholder='--{{__('msg.select')}}--' data-select2-id="1" tabindex="-1" aria-hidden="true">
										<option value=''>--{{__('msg.select')}}--</option>
										@foreach ($personnels as $p)
											<option value={{ $p->uid }}>{{$p->nomprenom}}</option>
										@endforeach
									</select>
									@error('personnel_id')
										<span class="help-block">{{ $message }}</span>
									@enderror
								</div>
							</div>
							<div class="col-md-12">
								<div style="text-align: center;">
									<button type="submit" class="btn btn-success">{{ __('msg.add_resp') }}</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="card card-primary">
				<div class="card-header with-border">
				<h3 class="card-title">{{ trans_choice('msg.admin_resp', 2) }}</h3>
				</div>
					<div class="card-body table-responsive no-padding">
					<table class="table table-hover">
						<tbody><tr>
						<th style="width: 80%">{{ trans_choice('msg.name', 1) }}</th>
						<th style="width: 20%">{{ trans_choice('msg.action', 1) }}</th>
						</tr>
						@foreach ($allResps as $r)
						<tr>
							<td>{{ $r->prenom }} {{ $r->nom }}</td>
							<td>
								<form method="POST" action={{ route('administration.materiel.staff.respadministratifs.delete', ['id' => $r->id]) }}>
									{{ method_field('DELETE')}}
									@csrf
									<button type="submit" class="btn btn-danger">{{ __('msg.delete') }}</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody></table>
					</div>
			</div>
		</div>
	</section>

@endsection
