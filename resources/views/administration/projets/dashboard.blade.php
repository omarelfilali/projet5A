@extends('layouts/default-admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-11">
                <h1 class="m-0">Tous les projets</h1>
                {{ Breadcrumbs::render() }}
            </div><!-- /.col -->
            <div class="col-sm-1">
                <button class="filter_dashboard float-right btn bg-primary"><i
                        class="fas fa-filter"></i></button>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-direction-row justify-content-center col-12">
                        <div class="card col-8 p-0 filtre-panel">
                            <div
                                class="card-header bg-light d-flex justify-content-between align-items-center header_filtre">
                                <h3 class="card-title">Filtres</h3>
                                <button class="croix_filtre btn"><i class="fas fa-xmark"></i></button>
                            </div>
                            <div class="card-body">
                                <div class="row d-flex flex-wrap">
                                    <div class="col-sm-3 col1_filtre d-flex flex-column justify-content-center"
                                        style="min-width: 150px;">
                                        <div class="annee_filtre row mb-2">
                                            <label class="col-5" for="input_annee">Promo : </label>
                                            <select name="input_annee" class="col-6" id="select_promo">
                                                <option value="">Toutes</option>
                                                <option value="3A">3A</option>
                                                <option value="4A">4A</option>
                                                <option value="5A">5A</option>
                                            </select>
                                        </div>
                                        <div class="elements_filtre row">
                                            <label class="col-5" for="input_elements">Filière : </label>
                                            <select name="input_elements" class="col-6" id="select_filiere">
                                                <option value="">Toutes</option>
                                                <option value="ai">A&I</option>
                                                <option value="info">INFO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col2_filtre d-flex flex-column justify-content-center"
                                        style="min-width: 150px;">
                                        <div class="promo_filtre row  mb-2">
                                            <label class="col-5" for="input_promo">Année scolaire : </label>
                                            <select name="input_promo" class="col-6" id="select_annee">
                                                <option value="">Toutes</option>
                                                <option value="2022-2023">2022-2023</option>
                                                <option value="2021-2022">2021-2022</option>
                                                <option value="2020-2021">2020-2021</option>
                                                <option value="2016-2017">2016-2017</option>
                                            </select>
                                        </div>
                                        <div class="only-perso row">
                                            <label class="col-7" for="input_onlyperso">Seulement mes projets</label>
                                            <div class="col"><input type="checkbox" name="input_onlyperso" id="input_onlyperso" value=""></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 row" style="min-width: 250px;">
                                        <div class="col-2">
                                            <p>Etat : </p>
                                        </div>
                                        <div class="col-10 row checkboxs_filtre">
                                            <div class="col-6">
                                                <div class="checkbox_filtre d-flex">
                                                    <input type="checkbox" name="checkbox_filtre_attente" class="checkbox_statut" value="attente">
                                                    <label class="ml-2 attente" for="checkbox_filtre_attente">En attente</label>
                                                </div>
                                                <div class="checkbox_filtre d-flex">
                                                    <input type="checkbox" name="checkbox_filtre_soumis" class="checkbox_statut" value="soumis">
                                                    <label class="ml-2 soumis" for="checkbox_filtre_soumis">Soumis</label>                                               </div>
                                                <div class="checkbox_filtre d-flex">
                                                    <input type="checkbox" name="checkbox_filtre_pourvu" class="checkbox_statut" value="pourvu">
                                                    <label class="ml-2 pourvu" for="checkbox_filtre_pourvu">Pourvu</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="checkbox_filtre d-flex">
                                                    <input type="checkbox" name="checkbox_filtre_nonpourvu" class="checkbox_statut" value="nonpourvu">
                                                    <label class="ml-2 nonpourvu" for="checkbox_filtre_nonpourvu">Non pourvu</label>
                                                </div>
                                                <div class="checkbox_filtre d-flex">
                                                    <input type="checkbox" name="checkbox_filtre_termine" class="checkbox_statut" value="termine">
                                                    <label class="ml-2 termine" for="checkbox_filtre_termine" class="termine">Terminé</label>
                                                </div>
                                                <div class="checkbox_filtre d-flex">
                                                    <input type="checkbox" name="checkbox_filtre_annule" class="checkbox_statut" value="annule">
                                                    <label class="ml-2 annule" for="checkbox_filtre_annule" class="annule">Annulé ou supprimé</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-hover table_dashboard_proj">
                                <thead>
                                    <tr class="">
                                        <th><input class="main_check form-check ms-auto me-0 mb-0" type="checkbox"></th>
                                        <th>Référence</th>
                                        <th>Titre</th>
                                        <th>Promo</th>
                                        <th>Année</th>
                                        <th>Filière</th>
                                        <th>Confid.</th>
                                        <th>État</th>
                                        <th>Encadrants</th>
                                        <th>Étudiants</th>
                                        <th width="120px">Déposé le</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($projets as $projet)

                                    @if($projet->etat === "non pourvu")
                                        @php $etat = "nonpourvu" @endphp
                                    @else
                                        @php $etat = "$projet->etat" @endphp
                                    @endif

                                    <tr>
                                        <td class="border-{{$etat}}"  data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="Projet {{$projet->etat}}"><input class="checkbox_dashboard" type="checkbox"></td>
                                        <td>{{$projet->reference}}</td>
                                        <td>{{$projet->titre}}</td>
                                        <td>{{$projet->annee_scolaire}}</td>
                                        <td>{{$projet->annee_inge}}</td>
                                        <td>
                                            <span style="display:none">{{$projet->getFiliereCible()}}</span>

                                            @php $options = ""; @endphp

                                            @foreach ($projet->specialites as $specialite)
                                                @php $options .= $specialite->acronyme; @endphp
                                                @if (!$loop->last)
                                                    @php $options.=", ";  @endphp
                                                @endif
                                            @endforeach

                                            @if($projet->getFiliereCible()=="transversal")
                                                <img src="/images/pictogramme_AI.svg" width="25px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$options}}">
                                                <img src="/images/pictogramme_Informatique.svg" width="25px" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$options}}">
                                            @else
                                                <img src="/images/pictogramme_{{$projet->getFiliereCible()}}.svg" width="25px"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                                title="{{$options}}">
                                            @endif

                                            {{-- @foreach ($projet->specialites as $specialite)
                                                {{$specialite->acronyme}}
                                                @if (!$loop->last),@endif
                                            @endforeach --}}
                                        </td>
                                        <td>
                                            @if($projet->est_confidentiel==1)
                                                <span class="badge bg-success">{{ __('msg.yes') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('msg.no') }}</span>
                                            @endif
                                        </td>
                                        <td>{{$projet->etat}}</td>
                                        <td>
                                            <div class="encadrants">
                                                @foreach ($projet->encadrants as $encadrant)
                                                <span>{{$encadrant->prenomNom}}</span>
                                                <div class="initiales" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$encadrant->prenomNom}}">
                                                    <p>{{$encadrant->getInitiales()}}</p>
                                                </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="etudiants">

                                                @php
                                                $nombreMaxBulles = 3;
                                                @endphp

                                                @for ($i = 0; $i < $nombreMaxBulles; $i++)
                                                    @if ((isset($projet->etudiants[$i]) && $i<=4))
                                                        <span>{{$projet->etudiants[$i]->prenomNom}}</span>
                                                        <div class="initiales-etudiants" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$projet->etudiants[$i]->prenomNom}}">
                                                            <p>{{$projet->etudiants[$i]->getInitiales()}}</p>
                                                        </div>
                                                    @endif
                                                @endfor

                                                @if (count($projet->etudiants) > $nombreMaxBulles)

                                                    @if(count($projet->etudiants)==$nombreMaxBulles+1)

                                                        <span>{{$projet->etudiants[$nombreMaxBulles]->prenomNom}}</span>
                                                        <div class="initiales-etudiants" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$projet->etudiants[$nombreMaxBulles]->prenomNom}}">
                                                            <p>{{$projet->etudiants[$nombreMaxBulles]->getInitiales()}}</p>
                                                        </div>

                                                    @else

                                                        @php $nomsEtudiants = ""; @endphp

                                                        @for ($i=$nombreMaxBulles; $i < count($projet->etudiants); $i++)
                                                            @php
                                                            $nomsEtudiants .= $projet->etudiants[$i]->prenomNom . "<br/>";
                                                            @endphp
                                                        @endfor

                                                        <div class="initiales-etudiants" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$nomsEtudiants}}">
                                                            <p>+@php echo count($projet->etudiants) - $nombreMaxBulles; @endphp </p>
                                                        </div>


                                                    @endif


                                                @endif

                                            </div>
                                        </td>
                                        <td class="col-actions">
                                            <span class="date_depot">{{$projet->date_creation->format('d/m/Y')}}</span>

                                            <span class="actions">
                                                <a href="{{route('public.projets.show_proj', $projet->id)}}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="Voir le projet"><i class="fas fa-file file_action"></i></a>

                                                <a href="{{route('administration.projets.edit', $projet->id)}}" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="Modifier le projet"><i class="fas fa-edit edit_action"></i></a>
                                                @if($projet->etat !== "pourvu" && $projet->etat !== "termine" )

                                                <form style="display:inline;" method="POST" action="{{ route('administration.projets.delete', ['id' => $projet->id]) }}">
                                                    {{--  --}}
                                                    {{ method_field('DELETE') }}
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{ __('msg.delete') }} le projet"><i class="fas fa-xmark xmark_action"></i></button>
                                                </form>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script type="text/javascript" src="{{ asset('js/avatarscolors.js') }}"></script>

<script type="module">
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    $(function () {
        var table = $('#example2').DataTable({
            paging: true,
            lengthChange: false,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            scrollCollapse: true,
            dom: 'Bfrtip',
            buttons: [
                "copy",
                "csv",
                "pdf",
                "print",
                {
                    extend: 'colvis',
                    columns: ':not(.noVis)'
                }
            ],
            'aaSorting': [[2, 'asc']],
            columnDefs: [
                {
                    targets: [0], // [0,-1] : pour 1ere et dernière colonne
                    orderable: false,
                    searchable: false
                }
                ,
                {
                    targets: 1,
                    className: 'noVis',
                    visible: false
                }
                ,
                {
                    targets: 6,
                    className: 'noVis',
                    visible: false
                },
                {
                    targets: 7,
                    className: 'noVis',
                    visible: false
                }
            ],
        })

        // A quoi ça sert ?
        // table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

        // Ne pas hésiter à s'inspirer de l'exemple suivant pour les filtres :
        // https://codepen.io/VeeruDasa/pen/mdPvJYO

        // Filtre SELECT - Promo
        $('#select_promo').on('change', function(e){
            var status = $(this).val();
            $('#select_promo').val(status);
            table.column(4).search(status).draw();
        });

        // Filtre SELECT - Filiere
        $('#select_filiere').on('change', function(e){
            var status = $(this).val();
            $('#select_filiere').val(status);
            table.column(5).search(status).draw();
        });

        // Filtre SELECT - Annee scolaire
        $('#select_annee').on('change', function(e){
            var status = $(this).val();
            $('#select_annee').val(status);
            table.column(3).search(status).draw();
        });

        // Filtre CHECKBOX - Mes projets

        // Filtre CHECKBOX - Statuts
        $('.checkbox_statut').on('change', function(e){
            var searchTerms = []
            $.each($('.checkbox_statut'), function(i,elem){
                if($(elem).prop('checked')){
                searchTerms.push("^" + $(this).val() + "$")
                }
            })
            table.column(7).search(searchTerms.join('|'), true, false, true).draw();
        });

    });

</script>

@endsection
