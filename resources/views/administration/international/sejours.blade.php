@extends('layouts/default-admin')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <button class="filter_dashboard float-right m-3 btn bg-primary"><i
                    class="fas fa-filter"></i></button>
                <h2 class="modal-title text-center pb-2">International</h2>
                <div class="d-flex flex-direction-row justify-content-center col-12">
                    <div class="card col-10 p-0 filtre-panel">
                        <div class="card-body">
                            <div class="row d-flex flex-wrap">
                                <div class="col-sm-3 col1_filtre d-flex flex-column justify-content-center">
                                    <div class="annee_filtre row mb-2">
                                        <label class="col-5" for="input_annee">Année : </label>
                                        <select name="select_annee" class="col-6" id="input_annee">
                                            <option value="toutes">Toutes</option>
                                            <option value="2022-2023">2022-2023</option>
                                            <option value="2021">2021-2022</option>
                                            <option value="2020">2020-2021</option>
                                            <option value="2019">2019-2020</option>
                                            <option value="...">...</option>
                                        </select>
                                    </div>
                                    <div class="promo_filtre row  mb-2">
                                        <label class="col-5" for="input_promo">Promo : </label>
                                        <select name="select_promo" class="col-6" id="input_promo">
                                            <option value="toutes">Toutes</option>
                                            <option value="1A">1A</option>
                                            <option value="2A">2A</option>
                                            <option value="3A">3A</option>
                                            <option value="4A">4A</option>
                                            <option value="5A">5A</option>
                                        </select>
                                    </div>


                                </div>
                                <div class="col-sm-4 col2_filtre d-flex flex-column justify-content-center">
                                    <div class="elements_filtre row">
                                        <label class="col-5" for="select_type">Type de séjour : </label>
                                        <select name="select_type" class="col-6" class="select_type">
                                            <option value="tout">Tout</option>
                                            <option value="stage">Stage</option>
                                            <option value="semestre">Semestre</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5 col2_filtre d-flex flex-column justify-content-center">
                                    <div class="elements_filtre row">
                                        <label class="col-5" for="input_elements">Demande de séjour : </label>
                                        <select name="input_elements" class="col-6" id="input_elements">
                                            <option value="soumis">Soumis</option>
                                            <option value="attente">En attente</option>
                                            <option value="accepte">Accepté</option>
                                            <option value="refuse">Refusé</option>
                                            <option value="annule">Annulé</option>
                                        </select>
                                    </div>

                                    <div class="elements_filtre row">
                                        <label class="col-5" for="input_elements">Réalisation du séjour : </label>
                                        <select name="input_elements" class="col-6" id="input_elements">
                                            <option value="pascommence">Pas commencée</option>
                                            <option value="encours">En cours</option>
                                            <option value="depart">Départ confirmé</option>
                                            <option value="valide">Validée</option>
                                            <option value="nonvalide">Non validée</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table id="tab-international" class="table table-bordered table-striped table_dashboard_proj">
                            <thead>
                                <tr>
                                    <th width="3%"><input class="main_check form-check" type="checkbox"></th>
                                    <th>Etudiant</th>
                                    <th>Type</th>
                                    <th>Destination</th>
                                    <th>Dates de séjour</th>
                                    <th>Etat</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($sejoursInternationaux as $sejour)

                                <tr>
                                    <td><input class="checkbox_dashboard" type="checkbox"></td>
                                    <td>{{$sejour->etudiant()->nomPrenom}}  </td>
                                    <td>{{$sejour->type}}</td>
                                    <td>
                                        @if($sejour->entreprise)
                                        {{$sejour->entreprise()->getDestination()}}
                                        @endif
                                    </td>
                                    <td>{{$sejour->getDateDebut()}} au {{$sejour->getDateFin()}}</td>
                                    <td>
                                        @switch ($sejour->getLastStatutProposition())
                                            @case("annule")
                                                <span class="badge badge-dark">Annulé</span>
                                                @break
                                            @case("soumis")
                                                <span class="badge badge-warning">Soumis</span>
                                                @break
                                            @case("accepte")

                                                @switch ($sejour->getLastStatutRealisation())
                                                    @case("valide")
                                                        <span class="badge badge-success">Validé</span>
                                                        @break
                                                    @case("depart_confirme")
                                                        <span class="badge badge-warning">Départ confirmé</span>
                                                        @break
                                                    @case("non_valide")
                                                        <span class="badge badge-danger">Non validé</span>
                                                        @break
                                                    @case("en_cours")
                                                        <span class="badge badge-warning">En cours</span>
                                                        @break
                                                @endswitch
                                                @break
                                            @case("refuse")
                                                <span class="badge badge-danger">Refusé</span>
                                                @break
                                        @endswitch

                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a class="btn btn-primary" href="./international-fiche/{{$sejour->id}}"><i class="fas fa-edit"></i></a>

                                            <a class="btn btn-dark" href="#"><i class="fas fa-envelope"></i></a>

                                            @if ($sejour->getLastStatutProposition()=="annule" || $sejour->getLastStatutProposition()=="soumis")
                                                <a class="btn btn-danger" href=""><i class="fas fa-trash"></i></a>
                                            @endif
                                        </div>
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

<script>
    $(function () {
      $('#tab-international').DataTable({
        "paging": true,
        "responsive": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": ["csv", "excel", "pdf", "print", "colvis"] //   "copy", "colvis"
      }).buttons().container().appendTo('#tab-international_wrapper .col-md-6:eq(0)');
    });
</script>


@endsection
