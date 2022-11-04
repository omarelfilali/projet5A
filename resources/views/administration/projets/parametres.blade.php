@extends('layouts/default-admin')

@section('content')


<div class="content_ajout_proj">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1 class="m-0">Paramètres projet</h1>
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{route('administration.projets.dashboard')}}">Projets</a>
                        </li>
                        <li class="breadcrumb-item active">Paramètres</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action={{ route('administration.projets.parametres.add') }}>
                {{ method_field('PUT')}}
		        @csrf
                <div class="row">

                    <div class="col-md-6">

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Gestion des droits</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Responsable des projets 3A </label> <br><span style="color: green; font-weight: bold">(ça fonctionne !)</span>

                                    <select class="form-control" name="responsable3A" autocomplete="off">
                                        <option value=""></option>
                                        @foreach ($personnels as $p)
                                            <option value={{ $p->uid }} {{($responsableProjets3A) ? (($responsableProjets3A->uid == $p->uid) ? "selected=selected" : "" ) : ""}}>{{$p->nomprenom}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label>Responsable des projets 4A et 5A</label>
                                    <select class="form-control" name="responsable4A5A" autocomplete="off">
                                        <option value=""></option>
                                        @foreach ($personnels as $p)
                                            <option value={{ $p->uid }} {{($responsableProjets4A5A) ? (($responsableProjets4A5A->uid == $p->uid) ? "selected=selected" : "" ) : ""}}>{{$p->nomprenom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Suivi IPREX : </label>
                                    <select class="select2 gestion-droits" name="responsableIPREX" multiple="multiple" data-placeholder="Sélection des gestionnaires IPREX" style="width: 100%;">
                                        @foreach ($personnels as $p)
                                            <option value={{ $p->uid }}>{{$p->nomprenom}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Périodes</h3>
                                <div class="card-tools">

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Date de dépôt des projets :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>

                                        <input class="date-picker form-control" name="periodeDepot" id="periodeDepot" value="{{$periodeDepot->valeur}}">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Date des voeux des étudiants :</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input class="date-picker form-control" name="periodeVoeux" id="periodeVoeux" value="{{$periodeVoeux->valeur}}">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="submit" value="Enregistrer" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $( document ).ready(function() {

        $(".date-picker").flatpickr({
            mode: "range",
            locale: "fr",
            allowInput: true,
            dateFormat: "d-m-Y",
        });

        $('.gestion-droits').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style'
        });

    });
</script>

@endsection
