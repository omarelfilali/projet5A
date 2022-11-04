@extends('layouts/default-admin')

@section('content')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
<div class="content_ajout_proj">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div>
                    <h1 class="m-0">Ajouter un projet</h1>
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{route('administration.projets.dashboard')}}">Projets</a>
                        </li>
                        <li class="breadcrumb-item active">Ajout</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{route('administration.projets.postProj')}}" id="form_prop"
                enctype="multipart/form-data">
                @csrf
                <div class="partie_ajout part1_ajout form-part row" data-key="1">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Descriptif</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body descriptif" style="display: block;">

                                <div class="form-group">
                                    <label for="inputName">Nom du projet</label>
                                    <input name="nomProj" type="text" id="inputName" class="form-control" minlength="5" required>
                                </div>

                                <div class="form-group">
                                    <label for="inputDescription">Résumé</label>
                                    <textarea minlength="30" name="resume" id="inputDescription" class="form-control" rows="4"
                                        placeholder="Description d'un minimum de 30 caractères" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="mots_cles[][mot_cle]">Mots clés</label>
                                    <select class="form-control input-mots-cles select2-original" name="mots_cles[][mot_cle]" multiple="multiple" data-min-tags="3"></select>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="inputKeywords">Mots clés</label>
                                    <div class="content_inputmotcle p-0">
                                        <input name="" type="text" class="form-control border-0" id="inputKeywords">
                                        <button class="valid_motcle">Envoyer</button>
                                    </div>
                                    <ul class="list_keyword" name="motcle">
                                    </ul>
                                    <p class="font-weight-light">Entre 3 et 5 mots clés pour le projet.</p>
                                </div> --}}
                                <div class="form-group mb-0">
                                    <label for="document-upload">Ajouter un document</label>
                                    <div class="dropzone dz-clickable" id="document-upload">
                                        <div>
                                            <h3 class="text-center">Cliquez pour ajouter un document</h3>
                                        </div>
                                        <div class="dz-default dz-message"><span>Déposez vos documents ici</span></div>
                                    </div>
                                </div>

                                {{-- <div class="form-group mb-0">
                                    <label class="form-label" for="inputImage">Ajouter une image : (jpg, jpeg, png,
                                        gif)</label>
                                    <input type="file" name="inputImage[]" id="inputImage" class="form-control"
                                        multiple>
                                    <div class="projet-images">

                                    </div>
                                    <p class="font-weight-light">Vous pouvez ajouter plusieurs images en lien avec le
                                        projet.</p>
                                </div>

                                <div class="form-group mb-0">
                                    <label class="form-lavel mt-2" for="diapoRessource">Ajouter un diaporama
                                        :</label>
                                    <input type="file" name="diapoRessource[]" id="diapoRessource" class="form-control">
                                    <div class="projet-doc">

                                    </div>
                                </div> --}}

                                <p class="font-weight-light">Vous pouvez également ajouter un diaporama.</p>
                            </div>
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Remarques</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body remarque" style="display: block;">
                                <label for="remarqueTextarea">Remarques éventuelles</label>
                                <textarea id="remarque" name="remarque" class="form-control" id="remarqueTextarea"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        {{-- <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Encadrant</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body box-encadrants" style="display: block;">
                                <div class="card-body bg-light rounded main_encadrant_bloc">
                                    <div class="form-group">
                                        <label for="inputPorteur">Porteur principal du projet</label>
                                        <p>Rôle</p>
                                        <select name="porteur" id="inputPorteur" class="form-control">
                                            <option value="encadrant">Encadrants</option>
                                            <option value="partenaire">Partenaire industriel / extérieur</option>
                                        </select>
                                    </div>
                                    <div class="form-group nom_encadrant">
                                        <p>Nom</p>
                                        <select name="nom" id="inputPorteurNom" class="form-control">
                                            <option value=""></option>
                                            @foreach ($encadrants as $encadrant)
                                            @if ($encadrant->nomPrenom != "")
                                            <option class="initiales" value="{{$encadrant->uid}}">
                                                {{$encadrant->nomPrenom}}
                                            </option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="content_ext">
                                        <div class="form-group nom_bloc_partenaire">
                                            <p>Nom</p>
                                            <input name="nom_ext" type="text" id="porteur_nom_ext" class="form-control">
                                        </div>
                                        <div class="form-group email_bloc_partenaire">
                                            <p>Email</p>
                                            <input name="email" type="email" id="porteur_email_ext"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="supp_content" data-encadrant="{{$encadrants}}">
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="bouton-ajout-encadrant btn-lg btn btn-primary mt-sm-4"
                                        type="button">+</button>
                                </div>
                            </div>
                        </div> --}}


                        {{--
                            Bloc - Choix des encadrants du projet
                        --}}

                        <div class="card card-primary">

                            <div class="card-header">
                                <h3 class="card-title">Encadrants du projet</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body box-encadrants" style="display: block;">

                                <div class="card-body bg-light rounded main_encadrant_bloc encadrant-bloc" data-id="1">

                                    <div class="form-group">
                                        <label for="typeEncadrant">Porteur principal du projet</label>
                                        <input type="hidden" name="encadrants[1][porteur_principal]" value=1>
                                        <p>Type d'encadrant</p>
                                        <select name="encadrants[1][type_encadrant]" class="form-control type-encadrant">
                                            @foreach ($types_encadrant as $type_encadrant)
                                                <option data-type="{{$type_encadrant->nom}}" value="{{$type_encadrant->id}}">{{$type_encadrant->nom}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group encadrant-interne">
                                        <div class="row">
                                            <div class="col">
                                                <p>Utilisateur</p>
                                                <select name="encadrants[1][id]" id="inputPorteurNom" class="form-control selection-encadrant" required>
                                                    <option value=""></option>
                                                    @foreach ($encadrants as $encadrant)
                                                    @if ($encadrant->nomPrenom != "")
                                                    <option class="initiales" value="{{$encadrant->id}}">
                                                        {{$encadrant->nomPrenom}}
                                                    </option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <p>NB Heures d'enseignement</p>
                                                <input type="number" name="encadrants[1][nb_heures_enseignement]" step="0.5" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content_ext encadrant-exterieur" style="display:none;">
                                        <div class="row">
                                            <div class="col">
                                                <p>Utilisateur <span class="text-primary create-new-exterieur" style="cursor:pointer;">(La personne n'existe pas ?)</span></p>
                                                <select name="encadrants[1][id]" id="inputPorteurNom" class="form-control selection-encadrant" disabled required>
                                                    <option value=""></option>
                                                    @foreach ($exterieurs as $exterieur)
                                                    @if ($exterieur->nomPrenom != "")
                                                    <option class="initiales" value="{{$exterieur->id}}">
                                                        {{$exterieur->nomPrenom}}
                                                    </option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <p>NB Heures d'enseignement</p>
                                                <input type="number" name="encadrants[1][nb_heures_enseignement]" step="0.5" class="form-control" disabled>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group nom_bloc_partenaire">
                                            <p>Prénom</p>
                                            <input name="encadrants[1][prenom]" type="text" id="porteur_prenom_ext" class="form-control" disabled>
                                        </div>
                                        <div class="form-group nom_bloc_partenaire">
                                            <p>Nom</p>
                                            <input name="encadrants[1][nom]" type="text" id="porteur_nom_ext" class="form-control" disabled>
                                        </div>
                                        <div class="form-group email_bloc_partenaire">
                                            <p>Email</p>
                                            <input name="encadrants[1][mail]" type="email" id="porteur_email_ext" class="form-control" disabled>
                                        </div> --}}
                                    </div>
                                </div>

                                <div class="col-md-12 text-center ajouter-encadrant">
                                    <button class="bouton-ajout-encadrant btn-lg btn btn-primary mt-sm-4"
                                        type="button">+</button>
                                </div>

                                <template id="new-encadrant">
                                    <div class="card-body bg-light rounded encadrant-bloc" style='margin: 10px 0' data-id="§">

                                        <div class="form-group">
                                            <div class="btn float-right d-flex bouton-supp-encadrant"><i class="fas fa-xmark"></i></div>
                                            <label for="type-encadrant">Encadrant du projet</label>
                                            <input type="text" name="encadrants[§][porteur_principal]" value=0 style="display:none">
                                            <p>Type d'encadrant</p>
                                            <select name="encadrants[§][type_encadrant]" class="form-control type-encadrant">
                                                @foreach ($types_encadrant as $type_encadrant)
                                                        <option data-type="{{$type_encadrant->nom}}" value="{{$type_encadrant->id}}">{{$type_encadrant->nom}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group encadrant-interne">
                                            <div class="row">
                                                <div class="col">
                                                    <p>Utilisateur</p>
                                                    <select name="encadrants[§][id]" id="inputPorteurNom" class="form-control selection-encadrant" required>
                                                        <option value=""></option>
                                                        @foreach ($encadrants as $encadrant)
                                                            @if ($encadrant->nomPrenom != "")
                                                                <option class="initiales" value="{{$encadrant->id}}">
                                                                    {{$encadrant->nomPrenom}}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <p>NB Heures d'enseignement</p>
                                                    <input type="number" name="encadrants[§][nb_heures_enseignement]" step="0.5" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="content_ext encadrant-exterieur" style="display:none;">
                                            <div class="row">
                                                <div class="col">
                                                    <p>Utilisateur <span class="text-primary create-new-exterieur" style="cursor:pointer;">(La personne n'existe pas ?)</span></p>
                                                    <select name="encadrants[§][id]" id="inputPorteurNom" class="form-control selection-encadrant" disabled required>
                                                        <option value=""></option>
                                                        @foreach ($exterieurs as $exterieur)
                                                        @if ($exterieur->nomPrenom != "")
                                                        <option class="initiales" value="{{$exterieur->id}}">
                                                            {{$exterieur->nomPrenom}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <p>NB Heures d'enseignement</p>
                                                    <input type="number" name="encadrants[§][nb_heures_enseignement]" step="0.5" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>

                            </div>
                        </div>

                        {{--
                            Bloc - Choix de l'équipe d'étudiant attendue pour participer à ce projet
                        --}}

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Equipe d'étudiants visée</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body equipe" style="display: block;">
                                <div>
                                    <div>
                                        <label for="annee_inge">Année d'étude demandé</label>
                                        <select name="annee_inge" id="annee_inge" class="form-control mb-2" required>
                                            <option value="" selected>Selectionnez une année</option>
                                            <option value="3A">3ème année</option>
                                            <option value="4A">4ème année</option>
                                            <option value="5A">5ème année</option>
                                        </select>
                                    </div>

                                    <label class="mt-2 mb-2" for="specialite">Spécialité</label>
                                        <div class="row pl-3">
                                            <div class="row flex justify-content-between mb-2">
                                                @foreach ($filieres as $filiere)
                                                    <div class="form-check form-check-inline d-flex justify-content-center col-auto filiere">
                                                        <input class="form-check-input" type="radio" name="filiere" value="{{$filiere->id}}" required>
                                                        <label class="form-check-label">{{$filiere->nom}}</label>
                                                    </div>

                                                    @if ($loop->last)
                                                        <div class="form-check form-check-inline d-flex justify-content-center col-auto filiere">
                                                            <input class="form-check-input" type="radio" name="filiere" value="Transversal" required>
                                                            <label class="form-check-label">Transversal</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>

                                            @foreach ($options as $option)
                                                <div class="form-check form-check-inline justify-content-start option" style="display:none" data-filiere="{{$option->filiere}}">
                                                    <input class="form-check-input" type="checkbox" name="specialites[][specialite]" value="{{$option->id}}" required>
                                                    <label class="form-check-label" for="specialites[][specialite]">{{$option->nom}}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                    {{-- <div class="row d-flex flex-wrap radioElement pt-2 pb-2">
                                        <div
                                            class="col-5 form-check form-check-inline specialite d-flex justify-content-center">
                                            <input class="form-check-input inputSpecialite" type="radio"
                                                name="specialite" value="A&I" id="inputvac" selected>
                                            <label class="form-check-label color-ai" for="inputai">Acoustique &
                                                Instrumentation</label>
                                        </div>
                                        <div
                                            class="col form-check form-check-inline specialite d-flex justify-content-center">
                                            <input class="form-check-input inputSpecialite" type="radio"
                                                name="specialite" value="INFO" id="inputinfo">
                                            <label class="form-check-label color-info"
                                                for="inputinfo">Informatique</label>
                                        </div>
                                        <div
                                            class="col form-check form-check-inline specialite d-flex justify-content-center">
                                            <input class="form-check-input inputSpecialite" type="radio"
                                                name="specialite" value="Transversal" id="inputtrans">
                                            <label class="form-check-label" for="inputtrans">Transversal</label>
                                        </div>
                                    </div>
                                    <div class="options_spe">
                                        <label class="mb-2" for="option">Options :</label>
                                        <div class="row pl-5">
                                            <div class="form-check form-check-inline d-flex justify-content-start">
                                                <input class="form-check-input option" type="checkbox" name="option1"
                                                    value="" id="option1">
                                                <label class="form-check-label" for="option1"></label>
                                            </div>
                                            <div class="form-check form-check-inline d-flex justify-content-start">
                                                <input class="form-check-input option" type="checkbox" name="option2"
                                                    value="" id="option2">
                                                <label class="form-check-label" for="option2"></label>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="nbEtudiants row mt-3 mb-2">
                                        <div class="col-6">
                                            <label for="nbEtudiants">Nombre d'étudiants : </label>
                                            <div class="row">
                                                <div class="d-flex flex-row">
                                                    <input name="nbEtudiants" type="range" id="selectNbEtudiants"
                                                        class="custom-range btn" min="2" max="8"
                                                        oninput="this.nextElementSibling.value = this.value"
                                                        id="customRange1">
                                                    <output class="badge bg-primary">5</output>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-6">
                                            <label for="autreNbEtudiants ">AUTRE</label>
                                            <input type="number" name="autreNbEtudiants" class="form-control autreNbEtudiants">
                                        </div> --}}
                                    </div>
                                    <div class="form-group mb-0 border-top mt-4 pt-3">
                                        <input type="checkbox" name="ajouterEtudiants" id="ajouterEtudiants">
                                        <label for="ajouterEtudiants">Ajouter des étudiants au projet</label>
                                        <p class="font-weight-light">Il est possible d'ajouter des étudiants au projet
                                            directement lors de sa soumission. Il faut néanmoins éviter de trop le faire
                                            pour
                                            des raisons d'équité</p>
                                    </div>

                                    <div class="bloc_ajout_etu">
                                        <select class="select2 addNewStudents" name="addNewStudents" multiple="multiple"
                                            data-placeholder="Sélection des étudiants" style="width: 100%;">
                                            @foreach ($etudiants as $e)
                                            <option value={{$e->login}}>{{$e->prenom}} {{$e->nom}} ({{$e->login}})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="partie_ajout form-part part2_ajout" data-key="2">
                    <div class="d-flex justify-content-center">
                        <div class="card card-primary col-md-10 p-0">
                            <div class="card-header">
                                <h3 class="card-title">Etat du projet</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;">

                                <div class="bloc_conf">
                                    <div
                                        class="d-flex gap-3 justify-content-around align-items-center flex-wrap pt-2 pb-4 row">
                                        <div
                                            class="col d-flex gap-4 form-check switch align-items-center justify-content-center p-0 m-0">
                                            <p class="m-0 font-weight-bold">Prioritaire</p>
                                            <input value="1" type="checkbox" class="tgl tgl-skewed" name="est_prioritaire"
                                                id="prio">
                                            <label for="prio" class="mb-0 tgl-btn" data-tg-off="NON"
                                                data-tg-on="OUI"></label>
                                        </div>
                                        <div
                                            class="col d-flex gap-4 form-check switch align-items-center justify-content-center p-0 m-0">
                                            <p class="m-0 font-weight-bold">Retribution</p>
                                            <input value="1" type="checkbox" class="tgl tgl-skewed" name="retribution"
                                                id="retribution">
                                            <label for="retribution" class="mb-0 tgl-btn" data-tg-off="NON"
                                                data-tg-on="OUI"></label>
                                        </div>
                                        <div
                                            class="col d-flex gap-4 form-check switch align-items-center justify-content-center p-0 m-0">
                                            <p class="m-0 font-weight-bold">Confidentiel</p>
                                            <input value="1" type="checkbox" class="tgl tgl-skewed" name="est_confidentiel"
                                                id="confid">
                                            <label for="confid" class="mb-0 tgl-btn" data-tg-off="NON"
                                                data-tg-on="OUI"></label>
                                        </div>
                                    </div>
                                    {{-- <div
                                        class="d-flex gap-3 justify-content-around align-items-center flex-wrap pt-2 pb-4 row">
                                        <div
                                            class="col d-flex gap-4 form-check switch align-items-center justify-content-center p-0 m-0">
                                            <p class="m-0 font-weight-bold">Prioritaire</p>
                                            <input value="1" type="checkbox" class="tgl tgl-skewed" name="prio"
                                                id="prio">
                                            <label for="prio" class="mb-0 tgl-btn" data-tg-off="NON"
                                                data-tg-on="OUI"></label>
                                        </div>
                                        <div
                                            class="col d-flex gap-4 form-check switch align-items-center justify-content-center p-0 m-0">
                                            <p class="m-0 font-weight-bold">Retribution</p>
                                            <input value="non" type="checkbox" class="tgl tgl-skewed" name="retribution"
                                                id="retribution">
                                            <label for="retribution" class="mb-0 tgl-btn" data-tg-off="NON"
                                                data-tg-on="OUI"></label>
                                        </div>
                                        <div
                                            class="col d-flex gap-4 form-check switch align-items-center justify-content-center p-0 m-0">
                                            <p class="m-0 font-weight-bold">Confidentiel</p>
                                            <input value="non" type="checkbox" class="tgl tgl-skewed" name="confid"
                                                id="confid">
                                            <label for="confid" class="mb-0 tgl-btn" data-tg-off="NON"
                                                data-tg-on="OUI"></label>
                                        </div>
                                    </div> --}}
                                    <div class="bloc_admini row d-flex justify-content-center">
                                        <div class="border-bottom border-2 col-11"></div>
                                        <div class="col-5">
                                            <div class="form-group d-flex flex-column mt-3 gap-1">
                                                <label for="cadrage">Cadrage</label>
                                                <select class="form-control" name="cadrage" id="cadrageInput">
                                                    <option value="" selected="selected">Aucun cadrage envisagé</option>
                                                    @foreach ($types_cadrage as $type_cadrage)
                                                        <option value="{{$type_cadrage->id}}">{{$type_cadrage->nom}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col d-flex gap-4 form-check switch p-0 m-0">
                                                <p class="m-0 font-weight-bold">Ce projet necessite-t-il l'achat de
                                                    matériel ?</p>
                                                <input value="non" type="checkbox" class="tgl tgl-skewed" name="achat"
                                                    id="achat" value="coucou">
                                                <label for="achat" class="mb-0 tgl-btn" data-tg-off="NON"
                                                    data-tg-on="OUI"></label>
                                            </div>
                                            <div class="form-group pt-3 budget_box" style="display: none">
                                                <label for="budget">Budget : </label>
                                                <input type="text" name="budget" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group p-3 mt-4 select_type">

                                                @foreach ($types_projet as $type_projet)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" value="{{$type_projet->id}}" name="types[][type]" class="mr-2">{{$type_projet->nom}}
                                                        </label>

                                                        <p>
                                                            @if ($type_projet->nom == "RECHERCHE")
                                                            Le projet est associé à un thème ou une action de recherche
                                                            rattaché à un des laboratoires hébergés à Le Mans
                                                            Université.

                                                            @elseif ($type_projet->nom == "LOCAL")
                                                            Le projet est associé à un thème de travail local ou a une
                                                            des
                                                            activités pédagogiques de Le Mans Université.

                                                            @elseif ($type_projet->nom == "INDUSTRIEL")
                                                            Le contexte et la problématique du projet sont amenés par un
                                                            partenaire industriel.

                                                            @elseif ($type_projet->nom == "EXTERIEUR")
                                                            Le contexte et la problématique du projet sont amenés par un
                                                            partenaire extérieur à Le Mans Université non industriel
                                                            (association, artisan, particulier,...).

                                                            @endif

                                                        </p>
                                                    </div>
                                                @endforeach

                                                {{-- <div class="checkbox">
                                                    <label><input type="checkbox" value="RECH" name="types[][type]"
                                                            class="mr-2">Recherche</label>
                                                    <p>Le projet est associé à un thème ou une action de recherche
                                                        rattaché à un des laboratoires hébergés à Le Mans
                                                        Université.
                                                    </p>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" value="INT" name="types[][type]" class="mr-2">Local /
                                                        Interne</label>
                                                    <p>Le projet est associé à un thème de travail local ou a une
                                                        des
                                                        activités pédagogiques de Le Mans Université.</p>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" value="INDUS" name="types[][type]"
                                                            class="mr-2">Industriel</label>
                                                    <p>Le contexte et la problématique du projet sont amenés par un
                                                        partenaire industriel.</p>
                                                </div>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" value="EXT" name="types[][type]"
                                                            class="mr-2">Extérieur</label>
                                                    <p>Le contexte et la problématique du projet sont amenés par un
                                                        partenaire extérieur à Le Mans Université non industriel
                                                        (association, artisan, particulier,...).</p>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-10 border-top border-2 pt-3 mt-3 mb-3">
                                            <div class="form-group">
                                                <label for="commentaire_admini">Commentaire</label>
                                                <textarea class="form-control" name="commentaire_admini"
                                                    id="commentaire_admini" cols="30" rows="10"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="d-flex justify-content-end me-5 pb-5 gap-3">
                    <input class="btn_suivant_ajout btn-retour btn btn-primary mt-sm-4 position-relative start-0" style="display:none;" type="button"
                        value="RETOUR">
                    <input id="send-form" class="btn_suivant_ajout btn-suivant btn btn-primary mt-sm-4 position-relative end-0" type="button"
                        value="SUIVANT">
                </div>
            </form>

        </div>
    </section>
</div>

<template id="new-exterieur">
    <swal-title>
      Création d'un nouvel extérieur
    </swal-title>
    <swal-icon type="warning" color="red"></swal-icon>
    <swal-html>
        <div id="create-new-ext">
            <div class="form-group">
                <p>Prénom</p>
                <input type="text" name="prenom" class="form-control">
                <p>Nom</p>
                <input type="text" name="nom" class="form-control">
            </div>
            <div class="form-group email_bloc_partenaire">
                <p>Email</p>
                <input type="email" name="email" class="form-control">
            </div>
        </div>
    </swal-html>

    <swal-button type="confirm">
      Confirmer
    </swal-button>
    <swal-button type="cancel">
      Annuler
    </swal-button>
    <swal-param name="allowEscapeKey" value="false" />
    <swal-param
      name="customClass"
      value='{ "popup": "my-popup" }' />
  </template>

  {{-- Lors du clone du template, il faut lui donner un attribut data-id = nb_ajout_encadrant --}}
  {{-- Voir verifpropproj.js --}}
  {{-- Comme ça si le input change ou si l'utilsiateur supprime le bloc_encadrant alors on efface aussi ses inputs invisible pour pas créer un user pour rien --}}
  <template id="new-user-data">
    <div class="new-exterieur-created">
        <input name="encadrants[§][prenom]" value="%prenom%" type="hidden">
        <input name="encadrants[§][nom]" value="%nom%" type="hidden">
        <input name="encadrants[§][mail]" value="%mail%" type="hidden">
    </div>
  </template>

  <script type="module">
    $('.addNewStudents').select2({
        theme: "bootstrap-5",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
            'style'
    });

    $(".input-mots-cles").select2({
        theme: "bootstrap-5",
        tags: true,
        maximumSelectionLength: 5,
        createTag: function (params) {
            var term = $.trim(params.term);
            // console.log(term.length);

            if (term === '' || term.length < 3) {
              return null;
            }

            return {
              id: term,
              text: term,
              newTag: true // add additional parameters
            }
          }
    })
    // .on("change", function () {
    //     $(this).valid();
    // });

    $("form").validate({
        messages: {
            nomProj: {
                minlength: jQuery.validator.format("Le titre du projet doit faire au moins {0} caractères.")
            },

            resume: {
                minlength: jQuery.validator.format("La description doit faire au moins {0} caractères.")
            },

            'mots_cles[][mot_cle]': {
                tags: jQuery.validator.format("Veuillez assigner au minimum {0} mots-clés.")
            }
        }
    });

    /////////////////////////////////////////
    // Ajouter des fichiers (documents, diapos...)
    /////////////////////////////////////////

    // Dropzone.autoDiscover = false;
    var uploadedDocumentMap = {}

    let documentsDropzone = new Dropzone("#document-upload", {
        url: "{{ route('store_tmp_file') }}",
        acceptedFiles: ".pdf, .png, .jpg, .jpeg",
        addRemoveLinks: true,
        uploadMultiple: true,
        parallelUploads: 1,
        maxFilesize: 256,
        maxFiles: 10,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        paramName: "files",
        // autoProcessQueue:false,

        success: function (file, response) {
            $('form').append('<input type="hidden" name="documents[]" value="' + response.name + '">');
            uploadedDocumentMap[file.name] = response.name;
        },

        error: function(file, response){
            $(file.previewElement).addClass("dz-error").find('.dz-error-message').text("Une erreur s'est produite avec ce fichier");
        },

        removedfile: function (file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }

            $('form').find('input[name="documents[]"][value="' + name + '"]').remove();

            $.ajax({
                type:'POST',
                url:"{{ route('remove_tmp_file') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "name": name,
                },
                success:function(data){
                    console.log("ok");
                }
            });
        },
    });

    // documentsDropzone.on("addedfile", file => {
    //     console.log(file);
    //     console.log(`File added: ${file.name}`);
    // });

  </script>

@endsection
