@extends('layouts/default')
@section('content')
@include('partials/menu-proj')

<script type="text/javascript" charset="utf8" src="js/choix_proj.js"></script>
<div class="container_proj_etu">
    <div class="choix">
        <h2>Choix des projets</h2>
        <p>Dans cette section, vous pouvez réaliser vos vœux pour la Xème année. Pour cela vous pouvez classer les
            projets suivants dans l'ordre de
            vos préférences. Vous devez également faire un 2ème classement pour les projets prioritaires qui sont
            proposés.</p>
        <div class="classement_choix">
            <div class="tous_les_projets">
                <h2>TOUS LES PROJETS</h2>
                <ul class="select_box">
                    <li data-value="1" class="pt dropzone" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">1</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                    </li>
                    <li data-value="2" class="vac dropzone" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">2</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                        <i class="prio_proj fas fa-exclamation-triangle"></i>
                    </li>
                    <li data-value="3" class="vac dropzone" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">3</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                    </li>
                    <li data-value="4" class="pt dropzone" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">4</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                    </li>
                    <li data-value="5" class="vac dropzone" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">5</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                    </li>
                    <li data-value="6" class="pt dropzone" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">6</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                        <i class="prio_proj fas fa-exclamation-triangle"></i>
                    </li>
                </ul>
            </div>
            <div class="prioritaires">
                <h2>PRIORITAIRES</h2>
                <ul class="select_box_prio">
                    <li data-value="1" class="vac dropzone_prio" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">1</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                        <i class="prio_proj fas fa-exclamation-triangle"></i>
                    </li>
                    <li data-value="2" class="pt dropzone_prio" draggable="true">
                        <i class="fas fa-arrows-alt-v fa-2x" style="color: white"></i>
                        <p class="classement_choix">2</p>
                        <button class="informations_choix">INFORMATIONS</button>
                        <h3 class="titre_projet">Un projet cool</h3>
                        <i class="prio_proj fas fa-exclamation-triangle"></i>
                    </li>
                </ul>
            </div>
        </div>
        <button class="maj" style="transform: translateX(-50px);">Mettre à jour</button>
    </div>
    <div class="infos_choix">
        <ul class="legende_choix">
            <li>
                <i class="fas fa-exclamation-triangle" style="color: rgb(0, 0, 70)"></i>
                <p>Projets prioritaires</p>
            </li>
            <li>
                <i class="fas fa-circle" style="color: #ffde73"></i>
                <p> Projet VAC</p>
            </li>
            <li>
                <i class="fas fa-circle" style="color: rgb(72, 176, 207)"></i>
                <p> Projet transversaux</p>
            </li>
        </ul>
        <div class="bloc_infos">
            <h2 class="titre_proj">Titre du projet</h2>
            <div class="content_proj">
                <p><span>Ref. du projet : </span>rpkgvporkmlsdvpo</p>
                <p><span>Date de dépôt : </span>05/05/2022</p>
                <h3 class="encadrants">ENCADRANTS</h3>
                <div class="encadrant encadrant1">
                    <p><span>Nom : </span>DELBECQUE</p>
                    <p><span>Prénom : </span>Alice</p>
                    <p><span>Structure : </span>-</p>
                    <p><span>Mail : </span>delbecque.alice@gmail.com</p>
                    <p><span>Téléphone : </span>0687698937</p>
                    <p><span>Adresse : </span>Toulouse France</p>
                </div>
                <h3 class="description_choix">DESCRIPTION</h3>
                <P>Pas de description</P>
                <h3 class="annee_etude">Année d'étude & nombre d'étudiants</h3>
                <p>Projet de 4ème année proposé pour une équipe de : 5</p>
                <h3 class="spé_option">Spécialité & option</h3>
                <p>Projet TRANSVERSAL proposé aux spécialités A&I et/ou INFOdont le
                    thème relève essentiellement des options : C&I et/ou ASTRE et/ou IPS
                </p>
                <div class="action_choix">
                    <p>Pour en savoir plus :<button class="informations_proj">PLUS D'INFOMRATIONS</button></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection