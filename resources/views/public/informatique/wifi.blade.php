@extends('layouts.default')

@section('content')

<div class="pre-banniere">
    <div class="banniere">
        <i class="fas fa-angle-double-left" onclick="window.location.href = '{{route('public.informatique.show_demandes') }}'"></i>
        <p class="nomCategorieActuelle">Informatique</p>
    </div>
</div>


<div class="container-fluid container-page mt-5">

    
    <div class="row justify-content-center">
        <div class="col-md-5 me-0 me-lg-4 mb-3">

            <div class="row justify-content-around mb-3">
                <div class="col-md-5 small-box bg-gradient-blue">
                    <div class="inner">
                        <h3>SAMIE</h3>
                        <p>Un problème technique ? un incident ? <br/>
                            Merci de renseigner un ticket</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <a href="https://samie.univ-lemans.fr" class="small-box-footer">
                        Gérer mes tickets <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>

                
                <div class="col-md-5 small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>Logiciels disponibles</h3>
                        <p>Salles informatiques</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-grip-horizontal"></i>
                    </div>
                    <a href="{{route('public.informatique.logiciels') }}" class="small-box-footer">
                        Consulter la liste <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="row justify-content-around  mt-4">
                <div class="col-11 tile-secondaire">
                    <h5 class="fw-bolder mb-4">Applications en ligne</h5>
                    <div class="services_numeriques row justify-content-start">
                        <div class="col-2 text-center unOutilExterne" data-id="caldav" data-url="https://agenda.univ-lemans.fr/index.php/apps/calendar/dayGridMonth/now" data-color="#e5442d" data-desc="Votre Agenda en ligne.">
                            <i class="far fa-calendar fa-2x"></i>
                            <p>AGENDA</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="ent" data-url="http://ent.univ-lemans.fr/fr/index.html" data-color="#6185ef" data-desc="L’espace numérique de travail vous permet d’accéder à différents services utiles à votre vie étudiante.">
                            <i class="fas fa-laptop fa-2x"></i>
                            <p>ENT</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="evento" data-url="https://evento.renater.fr/" data-color="#fdc201" data-desc="Evento vous permet d’organiser facilement vos événements directement en ligne en tenant compte des disponibilités et des souhaits des participants.">
                            <i class="fas fa-users fa-2x"></i>
                            <p>EVENTO</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="filesender" data-url="https://www.renater.fr/fr/filesender" data-color="#a3cad9" data-desc="FileSender est un outil sécurisé pour l’envoi de tous vos fichiers volumineux.">
                            <i class="fas fa-file-export fa-2x"></i>
                            <p>FILESENDER</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="gitlab" data-url="https://e-gitlab.univ-lemans.fr/" data-color="#e24329" data-desc="Logiciel libre de forge basé sur git proposant les fonctionnalités de wiki, un système de suivi des bugs, l’intégration continue et la livraison continue.">
                            <i class="fab fa-gitlab fa-2x"></i>
                            <p>Gitlab</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="listes" data-url="http://listes.univ-lemans.fr" data-color="#F0A624" data-desc="Consultation et gestion des listes de diffusion.">
                            <i class="fas fa-list fa-2x"></i>
                            <p>LISTES</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="office365" data-url="https://www.office.com/" data-color="#b73656" data-desc="Ensemble de services microsoft : Applications Windows, OneDrive, Outlook, Skype, OneNote, Microsoft Teams.">
                            <i class="fas fa-mail-bulk fa-2x"></i>
                            <p>Office 365</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="umtice" data-url="https://umtice.univ-lemans.fr/" data-color="#ff9800" data-desc="L’espace pédagogique de l'université vos cours en ligne.">
                            <i class="fas fa-database fa-2x"></i>
                            <p>Phpmyadmin</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="piwigo" data-url="http://e-www3-t1-gallery.univ-lemans.fr/" data-color="#566778" data-desc="Application contenant la gallerie photo de l'ENSIM.">
                            <i class="fas fa-image fa-2x"></i>
                            <p>Piwigo</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="umtice" data-url="https://umtice.univ-lemans.fr/" data-color="#30628a" data-desc="L’espace pédagogique de l'université vos cours en ligne.">
                            <i class="fas fa-database fa-2x"></i>
                            <p>PostgreSQL</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="ppn" data-url="https://e-ppn.univ-lemans.fr" data-color="#1caae4" data-desc="Votre outil pour les demandes d'achat dans le cadre des projets de 4A et 5A.">
                            <i class="fas fa-shopping-basket fa-2x"></i>
                            <p>PPN</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="supportinfo" data-url="https://ensim-projets.univ-lemans.fr/" data-color="#d94a85" data-desc="Outil de gestion de projets">
                            <i class="fas fa-tasks fa-2x"></i>
                            <p>Redmine</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="rendezvous" data-url="https://rendez-vous.renater.fr/home/" data-color="#6c79b8" data-desc="Evento vous permet d’organiser facilement vos événements directement en ligne en tenant compte des disponibilités et des souhaits des participants.">
                            <i class="fas fa-users fa-2x"></i>
                            <p>Rendez-Vous</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="rocketchat" data-url="https://e-rocketchat.univ-lemans.fr/" data-color="#991818" data-desc="Votre outil de discussion instantannée.">
                            <i class="fab fa-rocketchat fa-2x"></i>
                            <p>RocketChat</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="umbox" data-url="https://umbox.univ-lemans.fr/index.php" data-color="#fb612b" data-desc="L’espace de stockage et de partage de l'université.">
                            <i class="fas fa-box-open fa-2x"></i>
                            <p>UMBOX</p>
                        </div>
                        <div class="col-2 text-center unOutilExterne" data-id="umtice" data-url="https://umtice.univ-lemans.fr/" data-color="#4c301b" data-desc="L’espace pédagogique de l'université vos cours en ligne.">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                            <p>UMTICE</p>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            
        </div>

        <div class="col-md-5 me-0 me-lg-4 mb-3">

            <div class="tile mb-4">
                @if(Auth::user()->role == 3)
                    <h5 class="fw-bolder">Accès WIFI</h5>

                    @if($demandes->count()>0)
                        <p class="mb-3 opacity-50">{{$demandes->count()}} demandes</p>
                    @else
                        <p class="mb-3 opacity-50">Vous n'avez pas de demande de code Wifi</p>
                    @endif


                    @foreach($demandes as $demande)
                        <div class="projet-international">

                            @if($demande->validation==1)
                                <div class="icone termine"></div>
                            @elseif($demande->validation==-1)
                                <div class="icone nonValide"></div>
                            @else
                                <div class="icone enCours"></div>
                            @endif

                            <div class="infos ms-4">
                                <p>Pour : {{$demande->usager}} - Raison : {{$demande->raison}} - Durée : {{$demande->duree}} 
                                    <br/>
                                    <span class="opacity-50 mb-0" style="font-size: 12px;">Le {{$demande->getDateDemande()}}</span></p>
                            </div>
                        </div>

                    @endforeach

                    <div class="text-center">
                        <button type="button" class="btn btn-ensim text-center" data-bs-toggle="modal" data-bs-target="#nouveauProjet">Nouvelle demande</button>
                    </div>           
                    
                @elseif(Auth::user()->role == 4)
                    <h5 class="fw-bolder">Vos quotas disponibles</h5>

                        
                        

                        <div class="row mt-4">
                            <div class="col-6 text-center">
                                <p><span class="fw-bold">Quota d'impression </span>
                                    {{-- <small>({{$infos_ldap->umquotaimpcour[0]}} / {{$infos_ldap->umquotaimpmax[0]}} pages)</small> --}}
                                </p>
                                <canvas id="quotaImpression"></canvas>
                            </div>
                            <div class="col-6 text-center">
                                    <p class="fw-bold">Quota disque DATA université</p>
                                    <div class="text-center mt-4 text-secondary">
                                        <i class="fas fa-hdd fa-5x"></i>
                                        <p class="fw-bold">{{$infos_ldap->umquotadisquecour[0]}} Mo utilisé</p>
                                    </div>
                            </div>
                        </div>


                @endif
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="nouveauProjet" tabindex="-1" aria-labelledby="nouveauProjetLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{route('public.informatique.create_demande') }}" id="form_demande" method="post">
        @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="nouveauProjetLabel">Nouvelle demande de code WIFI</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p>L'accès à la WIFI est restreint et surveillé. Merci de ne pas communiquer le code.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="">Qui utilisera le code :</label>
                        <textarea class="form-control" name="usager" cols="5" required></textarea>
                        
                    </div>
                    <div class="col-6 mb-3">
                        <label for="">Raison :</label>
                        <textarea class="form-control" name="raison" cols="5" required></textarea>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="duree">Durée approximative d'utilisation :</label>
                        <textarea class="form-control" name="duree" cols="5" required></textarea>
                    </div>
                </div>
      
            </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" >Demander le code</button>
          </div>
        </form>
      </div>
    </div>
</div>

@vite(['resources/js/services_numeriques.js'])

@if(Auth::user()->role == 4)
    <script type="module">

        const data = {
            labels: [
                'Pages imprimées',
                'Pages restantes'
            ],
            datasets: [{
                label: 'Quota d\'impression',
                data: [{{$infos_ldap->umquotaimpcour[0]}}, {{$infos_ldap->umquotaimpmax[0]}}],
                backgroundColor: [
                'rgb(47, 176, 212)',
                'rgb(210, 210, 210)'
                ],
                hoverOffset: 4
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        };
        
        const myChart = new Chart(
            document.getElementById('quotaImpression'),
            config
        );

    </script>
@endif  
  
  

@endsection