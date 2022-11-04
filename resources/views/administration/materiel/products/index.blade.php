@extends('layouts/default-admin')

@section('css')
<style>
.dataTables_paginate {
  width: 100%;
  text-align: center!important;
}
</style>
@endsection

@section('content')

	<!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-11">
                    <h3 class="m-0">{{ trans_choice('msg.product', 2) }}</h3>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

	<section class="content ">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						{{-- <div class="card-header">
							<h3 class="box-title">{{ trans_choice('msg.product', 2) }}</h3>
						</div> --}}

						<div class="card-body">
							<table id="datatable" class="table table-hover">
								<thead>
									<tr>
										<th style="width: 30%">{{ trans_choice('msg.name', 1) }}</th>
										<th style="width: 25%">{{ trans_choice('msg.type', 1) }}</th>
										<th style="width: 15%">{{ __('msg.in_stock') }}</th>
										<th style="width: 30%">{{ trans_choice('msg.action', 2) }}</th>
									</tr>
								</thead>
								<tbody>
								@foreach ($products as $p)
								<tr class="elem-row" id="prod-{{$p->id}}">
									<td>{{ $p->nom }}</td>
									<td>{{ $p->type->nom }}</td>
									<td>
										@if ($p->enStock)
											<span class="badge bg-success">{{ __('msg.yes') }}</span> ({{$p->nombreStock}}/{{$p->maxStock}})
										@else
											<span class="badge bg-danger">{{ __('msg.no') }}</span> (0/{{$p->maxStock}})
										@endif
									</td>
									<td>
										<form style="display:inline;" method="POST" action={{ isset($lite) ? route('administration.materiel.respmateriel.stocks.history', ['id' => $p->id]) : route('administration.materiel.products.history', ['id' => $p->id]) }}>
											{{ method_field('GET') }}
											@csrf
											<button style="margin-left: 5px" type="submit" class="btn btn-primary btn-sm">{{ __('msg.see_history') }}</button>
										</form>
										@empty ($lite)
										<form style="display:inline;" method="POST" action={{ route('administration.materiel.products.stocks', ['id' => $p->id]) }}>
											{{ method_field('GET') }}
											@csrf
											<button style="margin-left: 5px" type="submit" class="btn btn-primary btn-sm">{{ __('msg.manage_stock') }}</button>
										</form>
										<form style="display:inline;" method="POST" action={{ route('administration.materiel.products.show', ['id' => $p->id]) }}>
											{{ method_field('GET') }}
											@csrf
											<button style="margin-left: 5px" type="submit" class="btn btn-warning btn-sm">{{ __('msg.edit') }}</button>
										</form>
										<form style="display:inline;" method="POST" action={{ route('administration.materiel.products.delete_product', ['id' => $p->id]) }}>
											{{ method_field('DELETE') }}
											@csrf
											<button style="margin-left: 5px" type="submit" class="btn btn-danger btn-sm">{{ __('msg.delete') }}</button>
										</form>
										@endempty
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
	</section>

@endsection
