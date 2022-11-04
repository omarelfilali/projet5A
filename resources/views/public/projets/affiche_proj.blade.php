@extends('layouts/default')
@section('content')
@include('partials/menu-proj')

<div class="container mt-4 mb-4">
    <div class="row">

        @foreach($projetsEtudiant->projets as $projet)
        <div class="col-6">
            <h2 class="proj_annee">Projet {{$projet->annee_inge_cible}} : {{$projet->annee_scolaire}}</h2>
            
            <div class="container_infoprojs tile">
                <div class="infoprojs_content">
                    
                    <h5 class="fw-bolder">{{$projet->titre}}</h5>
                    
                    <div class="content-desc container_info">
                        <p class="opacity-75" title="Résumé du projet">{!!nl2br($projet->resume)!!}</p>
                    </div>

                    <div class="row intervenants">
                        <div class="col">
                            <p class="fw-bold">Encadrants</p>
                            <div class="encadrants">  <!--encadrants_proj participants_proj-->
                                @foreach ($projet->encadrants as $encadrant)
                                    <div class="initiales" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$encadrant->prenomNom}}">
                                        <p>{{$encadrant->getInitiales()}}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col">
                            <p class="fw-bold">Etudiants</p>
                            <div class="etudiants etudiants_proj participants_proj">
                                @foreach ($projet->etudiants as $etudiant)
                                    <div class="initiales-etudiants" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$etudiant->prenomNom}}">
                                        <p>{{$etudiant->getInitiales()}}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bouton_proj right">
                    <a href="{{route('public.projets.show_proj', $projet->id)}}" class="btn btn-sm btn-ensim" title="Voir le projet">
                        <i class="fas fa-file file_action"></i> Voir le projet
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/avatarscolors.js') }}"></script>

<script>
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endsection