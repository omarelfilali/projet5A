@extends('layouts/default-admin')

@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Informatique - Paramètres</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="{{route('administration.informatique.wifi')}}">Informatique</a></li>
                    <li class="breadcrumb-item active">Paramètres</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">

            <form method="POST" action={{ route('administration.informatique.parametres.add') }}>
                {{ method_field('PUT')}}
		        @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">CODE WIFI</h3>
                            </div>
                            <div class="card-body">

                                <div>
                                    <label>Code WIFI du mois en cours : </label>
                                    <input type="text" class="form-control" name="codeWifi" value="{{$codeWifi->valeur}}"/>
                                </div>

                                {{-- <div>
                                    <label>Modèle mail : </label>
                                    <textarea name="mail_code_wifi" class="form-control" rows="5"/></textarea>
                                </div> --}}

                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center">
                        <input type="submit" value="Enregistrer" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </section>

<aside class="control-sidebar control-sidebar-dark">
</aside>


@endsection
