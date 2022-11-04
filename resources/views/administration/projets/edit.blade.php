@extends('layouts/default-admin')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Editer un projet</h1>
                {{ Breadcrumbs::render('administration.projets.edit', $projet) }}
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
        <div class="container-fluid">
            <form class="needs-validation" novalidate method="POST" action={{route('administration.projets.edit', ['id' => $projet->id])}} id="test" enctype="multipart/form-data">
                {{method_field('PATCH')}}
                @csrf
                <div class="partie_ajout part1_ajout row" data-key="1">
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
                                    <input name="nomProj" type="text" id="inputName" class="form-control" value="{{$projet->titre}}" minlength="4" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescription">Résumé</label>
                                    <textarea name="resume" id="inputDescription" class="form-control" rows="4"
                                        placeholder="Description d'un minimum de 30 caractères" minlength="30" required>{{$projet->resume}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputKeywords">Mots clés</label>
                                    <select class="form-control js-example-tokenizer" name="mots_cles[][mot_cle]" multiple="multiple">
                                        @foreach($projet->mots_cles as $mot_cle)
                                            <option selected="selected">{{$mot_cle->mot_cle}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-group @error('inputDiapo') has-error @enderror">
                                        <label for="inputDiapo">Diaporama </label>
                                        <input type="file" id="inputDiapo" name="diapo" />
                                        @error('inputDiapo')
                                            <span class="help-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header with-border">
                                <h3 class="card-title">Images</h3>
                            </div>
                            <div class="projet-images">
                                @foreach ($projet->documents as $document)
                                    <div class="projetimg" id="block-{{ $document->id }}" >
                                        <img src="{{ asset($document->lien) }}"  />
                                        <button id="img{{$document->id}}" onclick="hideImg({{$document->id}})"><i class="fa-solid fa-xmark"></i></button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-body">
                                <div id='deletePhotoDiv'></div>
                                <div class="form-group @error('inputPhotos') has-error @enderror">
                                    <label for="inputPhotos">{{ __('msg.file_uploading') }} ({{ __('msg.mutiple_files_allowed') }})</label>
                                    <input type="file" id="inputPhotos" name="photos[]" multiple />
                                    @error('inputPhotos')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
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
                                    rows="3">{{$projet->infos_complementaires}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">


                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Equipe</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
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
                                                    {{-- <option value=""></option>
                                                    @foreach ($allEncadrants as $encadrant)
                                                    @if ($encadrant->nomPrenom != "")
                                                    <option class="initiales">
                                                        {{$encadrant->nomPrenom}}
                                                    </option>
                                                    @endif
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>

                                        <hr>

                                        <label for="annee_scolaire">Année scolaire</label>
                                        <select name="annee_scolaire" id="annee_scolaire" class="form-control mb-2">
                                            <option value="selection" selected>Selectionnez une année</option>

                                            @for ($i=2015; $i<=date("Y"); $i++)
                                                <option value="{{$i}}-{{$i+1}}" {{($projet->annee_scolaire == $i."-".$i+1) ? "selected=selected" : ""}}> {{$i}}-{{$i+1}}</option>
                                            @endfor

                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="anneeEtudiant">Promo</label>
                                        <select name="anneeproj" id="anneeproj" class="form-control mb-2">
                                            <option value="selection" selected>Selectionnez une promotion</option>
                                            <option value="3A" {{($projet->annee_inge_cible == "3A") ? "selected=selected" : "" }}>3ème année</option>
                                            <option value="4A" {{($projet->annee_inge_cible == "4A") ? "selected=selected" : "" }}>4ème année</option>
                                            <option value="5A" {{($projet->annee_inge_cible == "5A") ? "selected=selected" : "" }}>5ème année</option>
                                        </select>
                                    </div>
                                </div>
                                <label class="mb-2" for="specialite">Spécialité :</label>

                                <div class="row d-flex flex-wrap radioElement pt-2 pb-2">
                                    <div class="col-5 form-check form-check-inline specialite d-flex justify-content-center">
                                        <input class="form-check-input inputSpecialite" type="radio" name="specialite" value="A&I" id="inputvac" {{($projet->filiere == "A&I") ? "checked" : "" }}>
                                        <label class="form-check-label color-ai" for="inputai">Acoustique & Instrumentation</label>
                                    </div>
                                    <div class="col form-check form-check-inline specialite d-flex justify-content-center">
                                        <input class="form-check-input inputSpecialite" type="radio" name="specialite" value="INFO" id="inputinfo" {{($projet->filiere == "INFO") ? "checked" : "" }}>
                                        <label class="form-check-label color-info" for="inputinfo">Informatique</label>
                                    </div>
                                    <div class="col form-check form-check-inline specialite d-flex justify-content-center">
                                        <input class="form-check-input inputSpecialite" type="radio" name="specialite" value="Transversal" id="inputtrans" {{($projet->filiere == "Transversal") ? "checked" : "" }}>
                                        <label class="form-check-label" for="inputtrans">Transversal</label>
                                    </div>
                                </div>
                                {{-- <div class="options_spe">
                                    <label class="mb-2" for="option">Options :</label>
                                    <div class="row pl-5">
                                        <div class="form-check form-check-inline d-flex justify-content-start">
                                            <input class="form-check-input option" type="checkbox" name="option" value="" id="option1">
                                            <label class="form-check-label" for="option1"></label>
                                        </div>
                                        <div class="form-check form-check-inline d-flex justify-content-start">
                                            <input class="form-check-input option" type="checkbox" name="option" value="" id="option2">
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
                                                    class="custom-range btn" min="2" max="12"
                                                    oninput="this.nextElementSibling.value = this.value"
                                                    id="customRange1" value="{{$projet->nb_places}}">
                                                <output class="badge bg-primary">{{$projet->nb_places}}</output>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group mb-0 border-top mt-4 pt-3">
                                    <input type="checkbox" name="ajouterEtudiants" id="ajouterEtudiants">
                                    <label for="ajouterEtudiants">Ajouter des étudiants au projet</label>
                                    <p class="font-weight-light">Il est possible d'ajouter des étudiants au projet
                                        directement lors de sa soumission. Il faut néanmoins éviter de trop le faire
                                        pour des raisons d'équité</p>
                                </div>

                                <div class="bloc_ajout_etu">
                                    <select class="select2 addNewStudents" name="addNewStudents" multiple="multiple"
                                        data-placeholder="Sélection des étudiants" style="width: 100%;">
                                        @foreach ($etudiants as $e)
                                        <option value={{$e->login}}>{{$e->prenom}} {{$e->nom}} ({{$e->login}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="form-group">
                                    <label>Etudiants affectés : </label>
                                    <select class="select2 gestion-etudiants" name="etudiants[]" multiple="multiple" data-placeholder="Sélection des étudiants" style="width: 100%;">
                                        @foreach ($etudiants as $etudiant)
                                            <option value={{ $etudiant->uid }} {{ (in_array($etudiant->id, $projet->etudiants->pluck('id')->toArray()) ? 'selected' : '') }} >{{$etudiant->nomprenom}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>


                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informations administratives</h3>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group d-flex flex-column mt-3 gap-1">
                                        <label for="cadrage">Statut du projet</label>
                                        <select class="form-control" name="etat" id="etatInput">
                                            <option value="attente" class="attente" {{($projet->etat == "attente") ? "selected=selected" : "" }}>En attente</option>
                                            <option value="soumis" class="soumis" {{($projet->etat == "soumis") ? "selected=selected" : "" }}>Soumis</option>
                                            <option value="pourvu" class="pourvu" {{($projet->etat == "pourvu") ? "selected=selected" : "" }}>Pourvu</option>
                                            <option value="nonpourvu" class="nonpourvu" {{($projet->etat == "nonpourvu") ? "selected=selected" : "" }}>Non pourvu</option>
                                            <option value="termine" class="termine" {{($projet->etat == "termine") ? "selected=selected" : "" }}>Terminé</option>
                                            <option value="annule" class="annule" {{($projet->etat == "annule") ? "selected=selected" : "" }}>Annulé</option>
                                        </select>
                                    </div>

                                </div>

                                <hr/>

                                <div class="row">

                                    <div class="col-4 d-flex gap-4">
                                        <p class="m-0 font-weight-bold">Prioritaire</p>
                                        <input type="checkbox" class="tgl tgl-skewed" name="prio" id="prio" @if($projet->est_prioritaire==1) @php echo "checked='checked'";@endphp @endif >
                                        <label for="prio" class="mb-0 tgl-btn" data-tg-off="NON" data-tg-on="OUI" ></label>
                                    </div>

                                    <div class="col-4 d-flex gap-4">
                                        <p class="m-0 font-weight-bold">Confidentiel</p>
                                        <input type="checkbox" class="tgl tgl-skewed" name="confid" id="confid" @if($projet->est_confidentiel==1) @php echo "checked='checked'";@endphp @endif>
                                        <label for="confid" class="mb-0 tgl-btn" data-tg-off="NON" data-tg-on="OUI"></label>
                                    </div>

                                    <div class="col-4 d-flex gap-4">
                                        <p class="m-0 font-weight-bold">Rétribution</p>
                                        <input value="non" type="checkbox" class="tgl tgl-skewed" name="retribution" id="retribution">
                                        <label for="retribution" class="mb-0 tgl-btn" data-tg-off="NON" data-tg-on="OUI"></label>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="form-group d-flex flex-column mt-3 gap-1">
                                        <label for="cadrage">Cadrage</label>
                                        <select class="form-control" name="cadrage" id="cadrageInput">
                                            <option value="pasCadrage" {{($projet->cadrage == "pasCadrage") ? "selected=selected" : "" }}>Pas de cadrage envisagé</option>
                                            <option value="conventionENSIM" {{($projet->cadrage == "conventionENSIM") ? "selected=selected" : "" }}>Convention ENSIM</option>
                                            <option value="contratIPREX" {{($projet->cadrage == "contratIPREX") ? "selected=selected" : "" }}>Contrat IPREX</option>
                                            <option value="saitBreak" {{($projet->cadrage == "saitBreak" OR $projet->cadrage == "") ? "selected=selected" : "" }}>Ne sait pas</option>
                                        </select>
                                    </div>

                                    <label for="budget">Budget</label>

                                    <div class="input-group budget "> <!--  style="display: none"   @error('budget') has-error @enderror--->
                                        <span class="input-group-text">€</span>
                                        <input type="number" name="budget" class="form-control" value="{{$projet->budget}}">
                                    </div>

                                </div>
                            </div>
                        </div>


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
                                            <option class="initiales">
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
                                            <input name="email" type="email" id="porteur_email_ext" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                 <div class="supp_content" data-encadrant=""> {{$encadrants}}
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="bouton_ajout_encadrant btn-lg btn btn-primary mt-sm-4"
                                        type="button">+</button>
                                </div>
                            </div>
                        </div>
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
                                        <label for="anneeEtudiant">Année du projet</label>
                                        <select name="anneeproj" id="anneeproj" class="form-control mb-2">
                                            <option value="selection">Selectionnez une année</option>
                                            <option value="3" @if($projet->annee_inge_cible == "3A") selected @endif>3ème année</option>
                                            <option value="4" @if($projet->annee_inge_cible == "4A") selected @endif>4ème année</option>
                                            <option value="5" @if($projet->annee_inge_cible == "5A") selected @endif>5ème année</option>
                                        </select>
                                    </div>
                                    <label class="mb-2" for="specialite">Spécialité :</label>
                                    <div class="row d-flex flex-wrap radioElement pt-2 pb-2">

                                        <div
                                            class="col-5 form-check form-check-inline specialite d-flex justify-content-center">
                                            <input class="form-check-input inputSpecialite" type="radio"
                                                name="specialite" value="A&I" id="inputvac"
                                                @if ($projet->filiere == "A&I")
                                                checked
                                                @endif>
                                            <label class="form-check-label color-ai" for="inputai">Acoustique &
                                                Instrumentation</label>
                                        </div>
                                        <div
                                            class="col form-check form-check-inline specialite d-flex justify-content-center">
                                            <input class="form-check-input inputSpecialite" type="radio"
                                                name="specialite" value="INFO" id="inputinfo" @if ($projet->filiere == "INFO")
                                                checked
                                                @endif>
                                            <label class="form-check-label color-info"
                                                for="inputinfo">Informatique</label>
                                        </div>
                                        <div
                                            class="col form-check form-check-inline specialite d-flex justify-content-center">
                                            <input class="form-check-input inputSpecialite" type="radio"
                                                name="specialite" value="Transversal" id="inputtrans" @if ($projet->filiere == "Transversal")
                                                checked
                                                @endif>
                                            <label class="form-check-label" for="inputtrans">Transversal</label>
                                        </div>
                                    </div>
                                    <div class="options_spe">
                                        <label class="mb-2" for="option">Options :</label>
                                        <div class="row pl-5">
                                            <div class="form-check form-check-inline d-flex justify-content-start">
                                                <input class="form-check-input option" type="checkbox" name="option"
                                                    value="" id="option1">
                                                <label class="form-check-label" for="option1"></label>
                                            </div>
                                            <div class="form-check form-check-inline d-flex justify-content-start">
                                                <input class="form-check-input option" type="checkbox" name="option"
                                                    value="" id="option2">
                                                <label class="form-check-label" for="option2"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nbEtudiants row mt-3 mb-2">
                                        <div class="col-6">
                                            <label for="nbEtudiants">Nombre d'étudiants : </label>
                                            <div class="row">
                                                <div class="d-flex flex-row">
                                                    <input name="nbEtudiants" type="range" id="selectNbEtudiants"
                                                        class="custom-range btn" min="2" max="8"
                                                        oninput="this.nextElementSibling.value = this.value"
                                                        id="customRange1" value="{{$projet->nb_places}}">
                                                    <output class="badge bg-primary">{{$projet->nb_places}}</output>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="autreNbEtudiants ">AUTRE</label>
                                            <input type="number" name="autreNbEtudiants" class="form-control autreNbEtudiants">
                                        </div>
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
                                        <div class="form-group mt-2">
                                            <input type="text" class="form-control" placeholder="Entrez un nom">
                                        </div>
                                        <ul class="list-group list-group-numbered">
                                            <li class="list-group-item d-flex">
                                                <p>coucou</p><span class="badge bg-primary rounded-pill"><i
                                                        class="fas fa-xmark align-middle"></i></span>
                                            </li>
                                            <li class="list-group-item d-flex">
                                                <p>coucou</p><span class="badge bg-primary rounded-pill"><i
                                                        class="fas fa-xmark align-middle"></i></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    {{-- <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Ressources</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body ressources" style="display: block;">
                                <div class="ajoutImage">
                                    <label class="form-lavel" for="imageRessource">Ajouter une image :</label>
                                    <input type="file" name="imageRessource" id="imageRessource" class="form-control"
                                        multiple>
                                </div>
                                <div class="ajoutDiapo">
                                    <label class="form-lavel mt-2" for="diapoRessource">Ajouter un diaporama :</label>
                                    <input type="file" name="diapoRessource" id="diapoRessource" class="form-control"
                                        multiple>
                                </div>
                                <p class="font-weight-light">Vous pouvez ajouter des ressources complémentaire sur le
                                    projet tel que des images ou un diaporama</p>
                            </div>
                        </div>
                    </div> --}}
                </div>


                <div style="text-align: center;">

                    <button type="submit" class="btn btn-primary">{{ __('msg.save_modif') }}</button>
                    <a style="margin-left: 5px" class="btn btn-danger" href={{ route('administration.projets.dashboard') }}>{{ __('msg.cancel') }}</a>

                </div>

            </form>


        </div>
    </section>


<script type="module">

    $('.gestion-etudiants').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style'
    });


    $(".js-example-tokenizer").select2({
        theme: "bootstrap-5",
        tags: true,
        tokenSeparators: [','],
        maximumSelectionLength: 5
    });

    function hideImg(id) {
		img = document.getElementById("block-"+id);
		img.style.display = "none";
		let div = document.getElementById('deletePhotoDiv');
		let input = document.createElement("input");
		input.type = "hidden";
		input.name = "deletePhotoIds[]";
		input.value = id;
		div.appendChild(input);
	}

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
            });
        }, false);
    })();
</script>

@endsection
