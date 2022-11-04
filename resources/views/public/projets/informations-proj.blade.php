@extends('layouts/default')
@section('content')

<div class="container-fluid mt-5">

    <div class="row justify-content-center">
        <div class="col-12 col-xxl-8 col-lg-8 mb-3 text-center">
            <h5 class="fw-bolder">{{$projet->titre}}</h5>

            <div class="icons-pdf-print">
                <button class="btn btn-sm btn-primary" onclick="window.print();">
                    <i class="fas fa-print"></i>
                </button>
            </div>

            <hr/>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-xxl-3 col-lg-4 me-0 me-lg-4 mb-3">

            <div class="logos-filieres">
                @if($projet->getFiliereCible()=="transversal")
                    <img src="/images/pictogramme_AI.svg" width="45px" ><br/>
                    <img src="/images/pictogramme_Informatique.svg" width="45px">
                @else
                    <img src="/images/pictogramme_{{$projet->getFiliereCible()}}.svg" width="45px">
                @endif
            </div>

            <div class="tile tile-principal mb-3">

                
                <p><b><span class="{{$projet->etat}}">Projet {{$projet->etat}}</span></b></p>

                <p><b>Nature du projet : </b>
                    @foreach($projet->types as $type)
                    {{$type->nom}}
                    @endforeach
                </p>

                <p><b>Équipe :</b> 
                    {{$projet->annee_inge}}
                    
                    -

                    @foreach ($projet->specialites as $specialite)
                        {{$specialite->acronyme}}
                        @if (!$loop->last) , @endif
                    @endforeach
                    
                </p>

                <div class="text-right">
                @if($projet->est_prioritaire == 1)
                    <i class='fa-solid fa-star' title='Projet prioritaire'></i>
                @endif

                @if($projet->est_confidentiel == 1)
                    <i class="fa-solid fa-eye-slash" title="Projet confidentiel"></i>
                @endif
                </div>


            </div>
            
            <div class="tile mb-3">
                
                @if ($projet->entreprise)
                    <p><b>Proposé par {{$projet->entreprise->nom}}</b><br/>
                        <small class="text-muted">Adresse : {{$projet->entreprise->adresse}}, {{$projet->entreprise->CP}}, {{$projet->entreprise->ville}} ({{$projet->entreprise->pays}}) </Adresse></small>
                    </p>
                @endif
               

                <p><b>Encadrants</b></p>
                @foreach ($projet->encadrants as $encadrant)


                    <p>
                        {{$encadrant->prenomNom}}
                        
                        <small class="text-muted">

                            @if($encadrant->emploi_principal)
                                <span style="font-size: 0.5rem;"><i class="fas fa-xs fa-circle"></i></span> 
                                {{$encadrant->emploi_principal}}
                                <span style="font-size: 0.5rem;"><i class="fas fa-xs fa-circle"></i></span>
                                <br/>
                            @endif
                            
                            @if($encadrant->pivot->role)
                            {{$encadrant->pivot->role}}<br/>
                            @endif

                            @if($encadrant->courriel_pro)
                            
                            <a href="mailto:{{$encadrant->courriel_pro}}" title="{{$encadrant->courriel_pro}}">
                                <i class="fa-solid fa-envelope"></i></a> {{$encadrant->courriel_pro}} 
                            @endif

                            @if($encadrant->tel_pro1)
                            <i class="fa-solid fa-phone"></i> {{$encadrant->tel_pro1}}<br/>
                            @endif

                            @if($encadrant->pivot->nb_heures_enseignement)
                            {{$encadrant->pivot->nb_heures_enseignement}}h d'encadrement
                            @endif
                        </small>
                    </p>

                    <hr/>
                        

                @endforeach

            </div>
            
            
            
            <div class="tile-secondaire">
                <p><b>Etudiants : </b></p>

                <div class="row justify-content-md-left">
                    
                    @foreach ($projet->etudiants as $etudiant)
                    <div class="col-md-auto text-center">
                        {{-- {{$etudiant->nomPrenom}}  --}}
                        <div class="photo-etudiant mt-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="{{$etudiant->nomPrenom}}">
                            <img class="" src='{{$etudiant->getPhotoURLAttribute()}}' />
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
            
        </div>

        <div class="col-12 col-xxl-5 col-lg-7">

            <div class="tile mb-4">

                <p><strong>Description scientifique et technique</strong></p>
                <div class="content-desc container_info">
                    {!!nl2br($projet->resume)!!}
                </div>

                @if($projet->mots_cles->isNotEmpty())
                <div>
                    <p>Mots clés :
                    
                        @foreach($projet->mots_cles as $mot_cle)
                        {{$mot_cle->mot_cle}} 
                        @if (!$loop->last) , @endif
                        @endforeach
                    </p>
                </div>
                @endif

                <div class="projet-images">
                    @foreach ($projet->documents as $document)
                        <div class="projetimg" id="block-{{ $document->id }}" >
                            <a class="mini-product-img" onclick="showFancy()">
                                <img src="{{ asset($document->lien) }}"/>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>

            @if ($projet->infos_complementaires)
                <div class="tile text-secondary mb-4">
                    
                        <p><b><small>Précisions : </small></b></p>
                        <p class="fst-italic"><small>"{{$projet->infos_complementaires}}"</small></p>
                    
                </div>
            @endif

            <div class="logo-documents">
                <i class="fa-regular fa-3x fa-folder-open"></i>
            </div>

            <div class="tile tile-secondaire text-center mb-4">
                
                <p><b>DOCUMENTS : </b></p>
                <ul>
                    <li>Cahier des charges</li>
                    <li>Soutenance intermédiaire</li>
                    <li>Slides</li>
                    <li>Poster</li>
                    <li>Rapport final</li>
                </ul>
            
            </div>

            <p class="text-right"><small class="text-muted">Projet déposé le {{$projet->getDateCreation()}}</small></p>

        </div>

    </div>
</div>

{{-- <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
    />

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script> --}}

<script>
    

function showFancy(){
    
    Fancybox.show([
        @foreach ($projet->documents as $image)
        {
          src: "{{ asset($image->lien) }}",
          type: "image",
        },
        @endforeach
    ],
    {
      animated: false,
      showClass: false,
      hideClass: false,
      click: false,
      dragToClose: false,
      Image: {
        zoom: false,
      },
      Toolbar: {
        display: [{ id: "counter", position: "center" }, "close"],
      },
    });
}

</script>

@endsection
