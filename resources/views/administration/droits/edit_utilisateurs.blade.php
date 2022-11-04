@extends('layouts/default-admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Roles de {{$utilisateur->nomPrenom}}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
    
      {{-- <form method="POST" action={{route('administration.materiel.staff.respmateriels.update', ['id' => $utilisateur->id]) }}>
        {{ method_field('PATCH')}}
        @csrf --}}
        
        <div class="form-group">
          <label>(Table : utilisateurs_x_roles)</label>
          <select id="categories" name="categories[]" class="form-control" multiple="" data-placeholder="Sélectionnez une ou plusieurs catégories" style="width: 100%;">
            @foreach($all_roles as $role)
              <option value='{{ $role}}'> {{ $role }}</option>
            @endforeach
          </select>
        </div>
      
        <div style="text-align: center;">
            <button type="submit" class="btn btn-primary">Enregistrer les permissions</button>
            <a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.materiel.staff.respmateriels') }}>{{ __('msg.cancel') }}</a></td>
        </div>
            
      {{-- </form> --}}

    </div>
  </div>
</section>



@endsection
