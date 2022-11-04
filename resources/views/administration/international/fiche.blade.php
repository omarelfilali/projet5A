@extends('layouts/default-admin')

@section('content')

<link rel="stylesheet" href="{{ asset('/css/materiel/workflow.css') }}">

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Départ international</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('administration.international.sejours')}}">International</a></li>
                <li class="breadcrumb-item active">Fiche séjour</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-end">
            <div class="col-md-10">
                <ul id="progressbar">
                    <li class="active" id="validation-ins"><strong>Séjour demandé</strong></li>
                    <li class="{{$statut->valeur == "accepte" ? 'active' : ($statut->valeur == "annule" || $statut->valeur == "refuse" ? 'cancelled' : '') }}" id="validation-ins"><strong>Acceptation du Pôle RI</strong></li>
                    <li class="" id="validation-ins"><strong>Départ confirmé</strong></li> <!-- current | cancelled -->
                    <li class="" id="validation-ins"><strong>Validation du séjour</strong></li>
                    <li class="" id="validation-ins"><strong>Paiement de la bourse</strong></li>
                </ul>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div id="profil" class="tile">
                            <div class="photo-profil"><img src="{{$infosEtu->getPhotoURLAttribute()}}" alt=""></div>
                        </div>

                        <h3 class="profile-username text-center">{{$infosEtu->prenom}} {{$infosEtu->nom}}</h3>

                        <p class="text-muted text-center">{{ __('msg.student_in') }} {{ $infosEtu->promo }} </p>
                        <p class="text-muted text-center">Nationalité : {{$infosEtu->nationalite}}</p>

                        <p><b>Expérience internationale :</b> {{$infosEtu->getExperienceInternationale()}} jours</p>

                        <!-- /.card-header -->
                        <div class="progress mb-3">
                            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%">
                                <span class="sr-only" id="nb-jours">{{$infosEtu->getExperienceInternationale()}}</span>
                            </div>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">

                            <li class="list-group-item">
                                <b>Type de séjour</b> <span class="float-right"><b>{{ucfirst($project->type)}}</b></span>
                            </li>
                            <li class="list-group-item">
                                <b>Dates</b> <span class="float-right">Du {{$project->getDateDebut()}} au {{$project->getDateFin()}}</span>
                            </li>

                            @if ($entreprise)
                            <li class="list-group-item">
                                <b>Organisme</b> <span class="float-right">{{$entreprise->nom}}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Adresse</b> <span class="float-right">{{$entreprise->adresse}}, {{$entreprise->cp}} {{$entreprise->ville}}, {{strtoupper($entreprise->pays)}}</span>
                            </li>
                            @endif
                            <!--<li class="list-group-item">
                                <b>Encadrant</b> <span class="float-right">Martin Larsen</span>
                            </li>-->
                            <!--<li class="list-group-item">
                                <b>Bourse.s</b> <span class="float-right">ENSIM le 12/04/2022<br/>EUR le 15/04/2022</span>
                            </li>-->
                        </ul>

                        <p><b>Remarques de l'étudiant</b></p>
                        <p>{{$project->remarques_etudiant}}</p>
                        <hr/>
                        @if($project->type !== "semestre")
                        <div class="overflow-auto">
                            <p><b>Compte rendu d'expérience</b></p>
                            <p>{{$project->compte_rendu}}</p>
                        </div>
                        <hr/>
                        @endif
                        <a href="#" class="btn btn-info float-center"><b>Retrouver tous les séjours de l'étudiant</b></a>

                    </div>
                    <!-- /.card-body -->
                </div>
                    <!-- /.card -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Fichiers</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Date dépôt</th>
                                    <th width="5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($project->type == "stage")
                                <tr>
                                    <td>Convention de stage</td>
                                    <td></td>
                                    <td class="text-left py-0 align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>rib.pdf</td>
                                    <td>49.8005 kb</td>
                                    <td class="text-left py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lettre_motivation.pdf</td>
                                    <td>50.5190 kb</td>
                                    <td class="text-left py-0 align-middle">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-6">

                @if ($project->type == "semestre")

                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title"><i class="icon danger fas fa-exclamation-triangle" style="margin-right: 8px"></i> Semestre en attente de validation</h3>
                        </div>
                        <div class="card-body">
                            <p><b>Classement de l'étudiant :</b></p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    1 - Chicoutimi - Canada
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    2 - AUF-ITC - Institut de Technologie du Cambodge
                                </label>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label>Ajouter un commentaire :</label>
                                <textarea class="form-control" rows="2" placeholder="Remarque facultative..."></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-danger">Refuser</button>
                                <button type="submit" class="btn btn-success">Accepter</button>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title"><i class="icon danger fas fa-exclamation-triangle" style="margin-right: 8px"></i> Séjour en attente de validation</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Ajouter une remarque :</label>
                                <textarea class="form-control" rows="3" placeholder="Remarque facultative..."></textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-danger">Refuser</button>
                                <button type="submit" class="btn btn-success">Accepter</button>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">ADMINISTRATIF</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                        <p><b>Note d'anglais : 10/20</b></p>
                        <p><b>Note du TOEIC :  {{$infosEtu->toeic}}</b></p>

                        <hr/>

                        <p><b>Bourse ENSIM</b></p>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" id="customCheckbox1" checked disabled>
                                <label for="customCheckbox1" class="custom-control-label">Demandée le 13/04/2021</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" id="customCheckbox1" checked disabled>
                                <label for="customCheckbox1" class="custom-control-label">Validée CA ENSIM le 25/05/2021</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" id="customCheckbox1" checked disabled>
                                <label for="customCheckbox1" class="custom-control-label">Validée CA Université le 19/07/2021</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" id="customCheckbox1">
                                <label for="customCheckbox1" class="custom-control-label">Payée</label>
                            </div>
                        </div>

                        <p><b>Bourse EUR</b></p>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="checkbox" id="customCheckbox1" checked disabled>
                                <label for="customCheckbox1" class="custom-control-label">Demandée le 13/04/2021</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <p>Autres bourses demandées et/ou accordées :</p>
                            <p>ERASMUS (demandée), CNOUS (accordée)</p>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Retour</a>
                <input type="submit" value="Enregistrer" class="btn btn-success float-right">
            </div>
        </div>

    </div>
</section>
<!-- /.content -->


<script type="text/javascript">
    $(document).ready(function() {

        $nbJours = $("#nb-jours").first().html();
        var pourcentage = $nbJours * 100 / 57; // 57 étant le nombre de jours pour valider l'expérience
        $bar = $("#progress-bar");

        $(".progress-bar").animate({
            width:pourcentage+'%'
        }, 500);

        if(pourcentage>0 && pourcentage<100){
            $bar.addClass("progress-bar-striped progress-bar-animated bg-warning");
        }

        if(pourcentage>=100){
            $bar.addClass("bg-success");
        }
    });
</script>


@endsection
