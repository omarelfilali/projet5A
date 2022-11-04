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
                    <li class="breadcrumb-item active">Bourses</li>
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

            <div class="card">
                <div class="card-body">
                    <table id="tab-international-bourses" class="table table-hover table table-bordered table-striped table_dashboard_proj">
                        <thead>
                            <tr>
                                <th style="width:20%">Etudiant</th>
                                <th style="width:20%">Bourse</th>
                                <th style="width:20%">Date de la demande</th>
                                <th style="width:20%">Etat de la demande</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="elem-row">
                                <td>Nicolas POUPON</td>
                                <td>Bourse ENSIM</td>
                                <td>le 11/02/2022</td>
                                <td><span class="badge badge-warning">En attente de paiement</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDemandeBourse">Voir la demande</button>
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
                            <tr class="elem-row">
                                <td>Noé Berro</td>
                                <td>Bourse EUR</td>
                                <td>le 02/01/2022</td>
                                <td><span class="badge badge-secondary">Annulée</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDemandeBourse">Voir la demande</button>
                                </td>
                            </tr>
                            <tr class="elem-row">
                                <td>Mael PENICAUD</td>
                                <td>Bourse ENSIM</td>
                                <td>le 21/01/2022</td>
                                <td><span class="badge badge-warning">En attente CA univ</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDemandeBourse">Voir la demande</button>
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
                            <tr class="elem-row">
                                <td>Albane GRIL</td>
                                <td>Bourse ENSIM</td>
                                <td>le 07/06/2022</td>
                                <td><span class="badge badge-success">Payée</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDemandeBourse">Voir la demande</button>
                                </td>
                            </tr>
                            <tr class="elem-row">
                                <td>Axel Maczokiaw</td>
                                <td>Bourse ENSIM</td>
                                <td>le 02/01/2022</td>
                                <td><span class="badge badge-danger">Refusée</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDemandeBourse">Voir la demande</button>
                                </td>
                            </tr>
                            <tr class="elem-row">
                                <td>Maxime LEPAGE</td>
                                <td>Bourse ENSIM</td>
                                <td>le 07/06/2022</td>
                                <td><span class="badge badge-warning">En attente CA ENSIM</span></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDemandeBourse">Voir la demande</button>
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
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalDemandeBourse" tabindex="-1" aria-labelledby="modalDemandeBourse" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Demande de bourse</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div id="profil" class="tile">
                                        <div class="photo-profil"><img src="http://e-www3-t1-dev.univ-lemans.fr/images/login-bg1.png" alt=""></div>
                                    </div>
                                    <h3 class="profile-username text-center">Albane GRIL</h3>
                                    <p class="text-center">5A - 2020</p>
                                </div>
                                <div class="col-md-8">
                                    <p><b>Documents : </b><a href="">Lettre de motivation</a> | <a href="">RIB</a></p>
                                    <p><b>N° sécurité sociale : </b>297112458624 54</p>
                                    <p><b>Autres bourses demandées : </b>ERASMUS (demandée), CNOUS (accordée).</p>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer align-center">
                            <button type="button" class="btn btn-success" >Accepter</button>
                            <button type="button" class="btn btn-danger" >Refuser</button>

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

    $(function () {
      $('#tab-international-bourses').DataTable({
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#tab-international_wrapper .col-md-6:eq(0)');
    });
</script>

@endsection
