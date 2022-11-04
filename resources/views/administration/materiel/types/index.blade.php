@extends('layouts/default-admin')

@section('content')

<section class="content-header">
      <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-sm-6">
                  <h1 class="m-0">Matériel - Paramètres</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                  <li class="breadcrumb-item"><a href="{{route('administration.materiel.requests.index')}}">Matériel</a></li>
                  <li class="breadcrumb-item active">Gérer les types</li>
                  </ol>
              </div><!-- /.col -->
          </div><!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>

<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">{{ trans_choice('msg.type', 2) }}</h3>
						</div>

						<div class="card-body table-responsive no-padding">
							<table class="table table-hover">
								<tbody>
									<tr>
										<th style="width: 30%">{{ trans_choice('msg.name', 1) }}</th>
										<th style="width: 25%">{{ trans_choice('msg.technician', 1) }}</th>
										<th style="width: 25%">{{ trans_choice('msg.category', 1) }}</th>
										<th style="width: 20%">{{ trans_choice('msg.action', 2) }}</th>
									</tr>
									@foreach ($types as $t)
									<tr>
										<td>{{ $t->nom }}</td>
										<td>{{ $t->technicien->nomprenom }}</td>
										<td>{{ $t->categorie->nom }}</td>
										<td>
										<form style="display:inline;" method="POST" action={{ route('administration.materiel.types.show_type', ['id' => $t->id]) }}>
												{{ method_field('GET') }}
												@csrf
												<button type="submit" class="btn btn-warning btn-sm">{{ __('msg.edit') }}</button>
											</form>
											<form style="display:inline;" method="POST" action={{ route('administration.materiel.types.delete_type', ['id' => $t->id]) }}>
												{{ method_field('DELETE') }}
												@csrf
												<button type="submit" class="btn btn-danger btn-sm">{{ __('msg.delete') }}</button>
											</form>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


@endsection
