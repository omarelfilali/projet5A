@extends('layouts.default')

@section('content')

@include('partials.menu-proj')

<div class="container_relindus">

    <div class="infos_proj">
        <div class="container_info">
            <div class="infos_title">
                <div class="infos_4a info_title">Informations PROJETS 4A</div>
                <a href="#5a">
                    <div class="infos_5a info_title">5A</div>
                </a>
            </div>
            <div class="content_infos">
                <div class="container_4a container_annee">
                    <h2>Projet de 4ème ANNEE</h2>
                    <h3>Contenu et objectif</h3>
                    <p> Un projet technique et/ou scientifique. Un apprentissage de la conduite de projet. Les projets
                        4A permettent aux étudiants de mener à bien une étude à caractères techniques et scientifiques.
                        Dans la mesure du possible et des offres disponibles à l'École, ce projet s'effectue avec un
                        partenaire industriel. Il peut aussi s'effectuer dans un laboratoire de recherche. Dans ce
                        dernier cas, il est demandé au laboratoire de présenter des sujets requérant une réalisation
                        technique (par exemple : montage d'un banc d'essai, développement d'une application
                        informatique). Les projets sont réalisés par des équipes de 4 à 6 étudiants. La taille de
                        l'équipe permet de mettre en jeu les problèmes liés à l'organisation et au management de projet.
                    </p>
                    <h3>Organisation</h3>
                    <p><span>Mai à septembre :</span> Collecte des sujets.</p>
                    <p><span>Septembre - octobre :</span> Choix des projets par les étudiants</p>
                    <p><span>Octobre à juin :</span> Travaux lors de séances programmées dans lemploi du temps</p>
                    <br>
                    <p>Les projets bénéficient de 100 heures dans l'emploi du temps.</p>
                    <p>Projet de fin d'études en 5ème année (5A)</p>
                </div>
                <div class="container_5a container_annee" id="5a">
                    <h2>Projet de 5ème ANNEE</h2>
                    <h3>Contenu et objectif</h3>
                    <p>Les projets 5A permettent aux étudiants de mener à bien une étude à caractère scientifique ou à
                        caractère technique avec une partie scientifique importante. Ce projet s'effectue, dans la
                        mesure du possible, avec un partenaire industriel ou dans un laboratoire de recherche. Les
                        projets sont réalisés par des équipes de 2 à 3 étudiants.</p>
                    <h3>Organisation</h3>
                    <p><span>Mai à septembre :</span> Collecte des sujets</p>
                    <p><span>Septembre :</span> Choix des projets par les étudiants</p>
                    <p><span>Fin septembre à février :</span> Travaux lors de séances programmées dans lemploi du temps
                    </p>
                    <p>Les projets bénéficient de 150 heures dans l'emploi du temps.</p>
                </div>
            </div>
        </div>
        <a href="#">
            <div class="guide"><i class="far fa-file-pdf"></i> Guide des projets 4A/5A</div>
        </a>
    </div>
    <div class="video_infos">
        <iframe class="video" src="https://www.youtube.com/embed/mgBN_hxk9zI" title="YouTube video player"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen height="500px" width="100%"></iframe>
        <div class="content_vid">
            <p>Sur <span>3</span> ans, <span>300</span> heures sont consacrées à la réalisation de projets.</p>
            <p>En <span>1ère année</span>, les étudiants s'investissent dans un projet de vulgarisation scientifique, de
                communication ou lié au monde associatif.</p>
            <p>En <span>2ème et 3ème année</span>, ils concrétisent des études sur projets afin de répondre aux besoins
                industriels ou des laboratoires de recherche.</p>
            <p>Pour en savoir plus sur les projets de <span>4ème et 5èmes années</span>, vous pouvez consulter les
                informations à gauche.</p>
        </div>
    </div>
</div>

<div class="container_propos" style="display: none;">
    <div class="container_proj_etu">
        <div class="choix">
            <h2>Choix des projets</h2>
            <p>Dans cette section, vous pouvez réaliser vos vœux pour la Xème année. Pour cela vous pouvez classer les
                projets suivants dans l'ordre de
                vos préférences. Vous devez également faire un 2ème classement pour les projets prioritaires qui sont
                proposés.</p>
            <ul class="legende_choix">
                <li>
                    <i class="fas fa-exclamation-triangle" style="color: rgb(0, 0, 70)"></i>
                    <p>Projets prioritaires</p>
                </li>
                <li>
                    <i class="fas fa-circle ai"></i>
                    <p> Projet A&I</p>
                </li>
                <li>
                    <i class="fas fa-circle info"></i>
                    <p> Projet INFO</p>
                </li>
                <li>
                    <i class="fas fa-circle transversal"></i>
                    <p> Projet transversaux</p>
                </li>
            </ul>
            <div class="classement_choix">
                @php
                $i = 1;
                $n = 1;
                @endphp
                <div class="tous_les_projets">
                    <h2>TOUS LES PROJETS</h2>
                    <ul class="select_box">
                        @foreach ($projets as $projet)
                            
                            @php $color = "transversal"; @endphp
                        
                            @if($projet->filiere == "A&I")
                                @php $color = "ai"; @endphp
                            @elseif($projet->filiere == "INFO")
                                @php $color = "info"; @endphp
                            @endif

                        <li class="pt elementlist @php echo $color; @endphp" draggable="true" data-value="{{$i}}" data-id="{{$projet}}">
                            <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                            <p class="classement_choix">{{$i}}</p>
                            <h3 class="titre_projet">{{ $projet->titre }}</h3>
                            <div class="dropzone"></div>
                        </li>
                        @php
                        $i++;
                        @endphp
                        @endforeach
                    </ul>
                </div>
                <div class="prioritaires">
                    <h2>PRIORITAIRES</h2>
                    <ul class="select_box_prio">
                        @foreach ($projets as $projet)

                            @php $color = "transversal"; @endphp
                            
                            @if($projet->filiere == "A&I")
                                @php $color = "ai"; @endphp
                            @elseif($projet->filiere == "INFO")
                                @php $color = "info"; @endphp
                            @endif

                            @if ($projet->est_prioritaire === 1)
                            <li data-value="{{$n}}" draggable="true" class="pt elementlist @php echo $color; @endphp" draggable="true" data-id="{{$projet}}">
                                <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                                <p class="classement_choix">{{$n}}</p>
                                <h3 class="titre_projet">{{ $projet->titre }}</h3>
                                <div class="dropzone"></div>
                            </li>
                            @php
                            $n++;
                            @endphp
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <button class="maj" style="transform: translateX(-50px);">Mettre à jour</button>
        </div>
        <div class="infos_choix">
            <div class="bloc_infos" style="display: none">
                <h2 class="titre_proj" id="titre" data-keyword="titre"></h2>
                <div class="content_proj">
                    <p><span id="ref" data-keyword="reference">Ref. du projet : </span><span class="content"></span></p>
                    <p><span id="datadepot" data-keyword="date_creation">Date de dépôt : </span><span
                            class="content"></span></p>
                    <h3 class="encadrants">ENCADRANTS</h3>
                    <div class="encadrant encadrant1">
                        <p><span id="nom" data-keyword="nom">Nom : </span><span class="content"></span></p>
                        <p><span id="prenom" data-keyword="prenom">Prénom : </span><span class="content"></span></p>
                        <p><span id="structure" data-keyword="structure"">Structure : </span><span class="
                                content"></span></p>
                        <p><span id="mail" data-keyword="mail">Mail : </span><span class="content"></span></p>
                        <p><span id="tel" data-keyword="">Téléphone : </span><span class="content"></span></p>
                        <p><span id="adresse" data-keyword="adresse">Adresse : </span><span class="content"></span></p>
                    </div>
                    <h3 class="description_choix">DESCRIPTION</h3>
                    <P id="description" data-keyword="resume"></P>
                    <h3 class="annee_etude">Année d'étude & nombre d'étudiants</h3>
                    <p>Projet de <span id="annee" data-keyword="annee_inge_cible"></span>ème année
                        proposé pour une équipe de : <span id="nbequipe" data-keyword="nb_places"></span> personnes</p>
                    <h3 class="spe_option">Spécialité & option</h3>
                    <p id="speopt" data-keyword="option"></p>
                    <div class="action_choix">
                        <p>Pour en savoir plus : <button class="btninfossupp"><a class="informations_proj">PLUS D'INFORMATIONS</a></button></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
