@extends('layouts/default-admin')


@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">International</h1>
                <ol class="breadcrumb ">
                    <li class="breadcrumb-item"><a href="./admin-international">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="./admin-international">International</a></li>
                    <li class="breadcrumb-item active">Dispenses</li>
                </ol>
            </div><!-- /.col -->

            <div class="col-sm-6">

                <div class="form-group float-sm-right">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa fa-calendar"></i></span>
                        <input class="date-picker form-control" name="range-date-dispenses" id="range-date-dispenses">
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

</section>

<section class="content">

            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Dispenses en attente <span class="badge badge-warning right">{{ count($dispensesEnAttente) }}</span></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th style="width:25%">Etudiant</th>
                                <th style="width:25%">Promo</th>
                                <th style="width:25%">Date de la demande</th>
                                <th style="width:25%">Action</th>
                            </tr>

                            @foreach ($dispensesEnAttente as $dispense)

                            <tr class="elem-row">
                                <td>{{$dispense->etudiant()->nomPrenom}}</td>
                                <td>{{$dispense->etudiant()->promo}}</td>
                                <td>le {{$dispense->getDateCreation()}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAttenteDispense">Voir la demande</button>
                                    <form method="POST" action="" style="display:contents">
                                        <button onclick="" type="button" class="btn btn-success btn-sm" >Accepter</button>
                                        <button style="display:none" id="" name="action" type="submit"  value="accept"></button>
                                    </form>
                                    <form method="POST" action="" style="display:contents">
                                        <button onclick="" type="button" class="btn btn-danger btn-sm">Refuser</button>
                                        <button style="display:none" id="" name="action" type="submit" value="refuse"></button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-success card-outline collapsed-card">

                <div class="card-header">
                    <h3 class="card-title">Dispenses acceptées <span class="badge badge-success right">{{ count($dispensesAccepte) }}</span></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th style="width:20%">Etudiant</th>
                                <th style="width:20%">Promo</th>
                                <th style="width:20%">Date de la demande</th>
                                <th style="width:20%">Date acceptation</th>
                                <th style="width:20%">Action</th>
                            </tr>
                            @foreach ($dispensesAccepte as $dispense)

                            <tr class="elem-row">
                                <td>{{$dispense->etudiant()->nomPrenom}}</td>
                                <td>{{$dispense->etudiant()->promo}}</td>
                                <td>le {{$dispense->getDateCreation()}}</td>
                                <td>le </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal2Dispense">Voir la demande</button>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card card-danger card-outline collapsed-card">

                <div class="card-header">
                    <h3 class="card-title">Dispenses refusées / annulées <span class="badge badge-danger right">{{ count($dispensesRefusee) }}</span></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th style="width:20%">Etudiant</th>
                                <th style="width:20%">Promo</th>
                                <th style="width:20%">Date de la demande</th>
                                <th style="width:20%">Date du refus</th>
                                <th style="width:20%">Action</th>
                            </tr>
                            @foreach ($dispensesRefusee as $dispense)

                            <tr class="elem-row">
                                <td>{{$dispense->etudiant()->nomPrenom}}</td>
                                <td>{{$dispense->etudiant()->promo}}</td>
                                <td>le {{$dispense->getDateCreation()}}</td>
                                <td>le </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal2Dispense">Voir la demande</button>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="modalAttenteDispense" tabindex="-1" aria-labelledby="modalAttenteDispense" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Aymane RIZKE</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="profil" class="tile">
                                        <div class="photo-profil"><img src="http://e-www3-t1-dev.univ-lemans.fr/images/login-bg1.png" alt=""></div>
                                    </div>
                                    <h3 class="profile-username text-center"></h3>
                                    <p><b>Nationalité : </b>Marocaine</p>
                                    <p><b>Cursus avant l'ENSIM : </b>Double diplome de l'ENSA FES</p>
                                </div>
                                <div class="col-md-8">
                                    <p><b>Justificatifs : </b><a href="">Bulletins de notes</a></p>
                                    <p><b>Demande : </b>Bonjour, je suis Aymane RIZKE je suis admis à l'ENSIM via une convention de double diplôme, mon école d'origine est l'ENSA de Fès ( École Nationale des sciences appliquées) là où j'ai étudié 2 ans de classes préparatoires et 2 ans dans le cycle ingénieur. Vous trouverez ci-joint tous les relevés de notes de mon cursus supérieurs.</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer align-center">

                            <textarea class="form-control" id="commentaire_dispense" rows="3" placeholder="Commentaire :"></textarea>

                            <div class="form-group">
                                <button type="button" class="btn btn-success">Accepter</button>
                                <button type="button" class="btn btn-danger">Refuser</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal2Dispense" tabindex="-1" aria-labelledby="modal2Dispense" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Prénom NOM</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="profil" class="tile">
                                        <div class="photo-profil"><img src="http://e-www3-t1-dev.univ-lemans.fr/images/login-bg1.png" alt=""></div>
                                    </div>
                                    <h3 class="profile-username text-center"></h3>
                                    <p><b>Nationalité : </b>Marocaine</p>
                                    <p><b>Cursus avant l'ENSIM : </b>Double diplome de l'ENSA FES</p>
                                </div>
                                <div class="col-md-8">
                                    <p><b>Justificatifs : </b><a href="">Bulletins de notes</a></p>
                                    <p><b>Commentaire : </b>Bonjour, je suis Aymane RIZKE je suis admis à l'ENSIM via une convention de double diplôme, mon école d'origine est l'ENSA de Fès ( École Nationale des sciences appliquées) là où j'ai étudié 2 ans de classes préparatoires et 2 ans dans le cycle ingénieur. Vous trouverez ci-joint tous les relevés de notes de mon cursus supérieurs.</p>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer align-center">
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                Vous avez accordé la dispense le 07/06/2022
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fa-solid fa-pen-to-square"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalToggleLabel2">Modifier la décision</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vous modifiez votre décision, souhaitez-vous accepter ou refuser la dispense de Aymane RIZKE ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-sm btn-success" >Accepter</button>
                        <button type="button" class="btn btn-sm btn-danger" >Refuser</button>

                    </div>
                  </div>
                </div>
              </div>


    </section>


<script type="text/javascript">
    $( document ).ready(function() {

        $(".date-picker").flatpickr({
            mode: "range",
            locale: "fr",
            allowInput: true,
            dateFormat: "d/m/Y",
        });
    });
</script>

@endsection
