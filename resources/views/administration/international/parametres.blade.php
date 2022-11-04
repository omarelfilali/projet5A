@extends('layouts/default-admin')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">International - Paramètres</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{route('administration.international.dashboard')}}">International</a></li>
                <li class="breadcrumb-item active">Paramètres</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">PROJET GENERAL</h3>
                    </div>
                    <div class="card-body">

                        <div>
                            <label>Nombre de jours pour valider l'expérience : </label>
                            <input type="number" name="duree-experience" value="57"/>
                        </div>

                        <div>
                            <label>Session en cours : </label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                    <label class="form-check-label" for="inlineRadio1">n°1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                    <label class="form-check-label" for="inlineRadio2">n°2</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">BOURSE</h3>
                    </div>
                    <div class="card-body">
                        <label>Date CA ENSIM : </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input class="date-picker form-control" name="date-ca-ensim" id="date-ca-ensim">
                        </div>


                        <label>Date CA Le Mans Université : </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input class="date-picker form-control" name="date-ca-univ" id="date-ca-univ">
                        </div>


                        <label>Pointage des bourses par : </label>
                        <select class="form-control">
                            <option>Prénom NOM</option>
                            <option>Prénom NOM</option>
                            <option>Prénom NOM</option>
                            <option>Prénom NOM</option>
                            <option>Prénom NOM</option>
                            <option>Prénom NOM</option>
                        </select>
                    </div>
                </div>
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">SEMESTRE</h3>
                    </div>
                    <div class="card-body">
                        <label>Figer le semestre à partir du :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input class="date-time-picker form-control" name="date-semestre-fini" id="date-semestre-fini">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript">
    $( document ).ready(function() {

        $(".date-picker").flatpickr({
            locale: "fr",
            allowInput: true,
            dateFormat: "d-m-Y",
        });

        $(".date-time-picker").flatpickr({
            locale: "fr",
            allowInput: true,
            enableTime: true,
            dateFormat: "d-m-Y H:i",
        });

    });
</script>

@endsection
