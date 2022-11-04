@extends('layouts/default-admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Droits par rôles</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
        
                <p class="text-bold">Rôles :</p>
                <ul>
                    @foreach($all_roles as $role)

                        <li onClick="">
                            
                            <form style="display:inline;" method="POST" action={{ route('administration.droits.roles.show', ['id' => $role->id]) }}>
                                {{ method_field('GET') }}
                                @csrf
                                {{$role->name}}
                                <button style="margin-left: 5px" type="submit" class="btn btn-warning btn-sm">{{ __('msg.edit') }}</button>
                            </form>
                            
                        </li>
                        
                    @endforeach
                </ul>
            </div>
        
            <div class="col-8">
                

                <p class="text-bold">Permissions du rôle {{$role->name}} :</p>
                <ul>

                    @foreach($permissions as $permission)

                        <li onClick="">{{$permission->name}} - {{$permission->description}}</li>
                        
                    @endforeach
                    
                </ul>
            </div>
        </div>

    </div>
  </section>
  

@endsection
