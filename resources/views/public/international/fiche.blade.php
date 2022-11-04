@extends('layouts.default')

@section('content')

@if (hasPermission("SAMY"))
<p>coucou</p>
@endif

<div class="modal fade" id="nouveauProjet" tabindex="-1" aria-labelledby="nouveauProjetLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nouveauProjetLabel">Nouvelle fiche internationale</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <div class="row">
        <div class="mb-3 col-6">
            <label for="type">Type d'expérience :</label>
            <select class="form-select" name="type" id="type" required>
                <option value="semestre">Semestre d'études</option>
                <option value="stage">Stage</option>
                <option value="job">Autre emploi</option>
                <option value="dispense">Demande de dispense</option>
            </select>
        </div>
            <div class="col-6 mb-3">
                <label for="org_nom">Période :</label>
                <input class="date-picker form-control" name="periode" id="periode" required>
            </div>
        </div>

        <!-- DECLARATION NOUVEAU SEMESTRE -->
        <form style="display:none;" action="{{ route('public.international.create_fiche') }}" class="form form-semestre" method="post">
        @csrf
            <div class="row">
                <input type="hidden" name="type" value="semestre"/>
                <div class="col-12 mb-3">
                    <label for="entreprise">Sélectionnez une Université :</label>
                    <select class="form-select entreprise" name="entreprise" data-placeholder="Sélectionnez une entreprise" required>
                    <option></option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="remarque_etudiant">Remarque :</label>
                    <textarea name="remarque_etudiant" id="remarque_etudiant" class="form-control"></textarea>
                </div>

            </div>
        </form>

        <!-- DECLARATION NOUVEAU STAGE -->
        <form style="display:none;" action="{{ route('public.international.create_fiche') }}" class="form form-stage" method="post">
        @csrf
            <div class="row">
                <input type="hidden" name="type" value="stage"/>

                <div class="col-12 mb-3">
                    <label for="entreprise">Sélectionnez une entreprise :</label>
                    <select class="form-select entreprise" name="entreprise" data-placeholder="Sélectionnez une entreprise" required>
                    <option></option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="remarque_etudiant">Remarque :</label>
                    <textarea name="remarque_etudiant" id="remarque_etudiant" class="form-control"></textarea>
                </div>

            </div>
        </form>

        <!-- DECLARATION NOUVEAU JOB -->
        <form style="display:none;" action="{{ route('public.international.create_fiche') }}" class="form form-job" method="post">
        @csrf
            <div class="row">
                <input type="hidden" name="type" value="job"/>

                <div class="col-12 mb-3">
                    <label for="entreprise">Sélectionnez une entreprise :</label>
                    <select class="form-select entreprise" name="entreprise" data-placeholder="Sélectionnez une entreprise" required>
                    <option></option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="remarque_etudiant">Remarque :</label>
                    <textarea name="remarque_etudiant" id="remarque_etudiant" class="form-control"></textarea>
                </div>

            </div>
        </form>

        <!-- DECLARATION NOUVELLE DISPENSE -->
        <form style="display:none;" action="{{ route('public.international.create_fiche') }}" class="form form-dispense" method="post">
        @csrf
            <div class="row">
                <input type="hidden" name="type" value="dispense"/>

                <div class="col-12 mb-3">
                    <label for="remarque_etudiant">Remarque :</label>
                    <textarea name="remarque_etudiant" id="remarque_etudiant" class="form-control"></textarea>
                </div>
            </div>
        </form>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="creer_fiche" >Créer la fiche</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-3 col-lg-4 me-0 me-lg-4 mb-5">
            <div id="international-profil" class="tile">
                <div class="photo-profil mt-2"><img src="{{$etudiant->getPhotoURLAttribute()}}" alt=""></div>
                <h5>{{$etudiant->prenom}} {{$etudiant->nom}}</h5>
                <p class="mb-0">4A VAC</p>

                <div id="international-progressbar"><div id="progression"></div></div>
                {{-- Ne pas oublier de remplacer par des vraies valeurs --}}
                <p class="mb-1">Expérience internationale : <strong> <span id="nbJours_exp">{{$etudiant->getExperienceInternationale()}}</span> jours</strong> </p>
                <button type="button" class="btn btn-ensim" data-bs-toggle="modal" data-bs-target="#nouveauProjet">Nouvelle fiche</button>
            </div>
        </div>

        <div class="col-12 col-xxl-5 col-lg-7">

            <div class="row mx-0 mb-5">
                <div class="tile col-12 col-xxl me-5 mb-xxl-0 mb-5">
                    <p>salit</p>
                </div>
                <div class="tile col-12 col-xxl">
                    <p>salut</p>
                </div>
            </div>

            <div class="international-projet-liste tile mb-5">
                <div class="tile-header">
                    <h5 class="fw-bolder">Mes projets internationaux</h5>
                    <p class="mb-3 opacity-50" style="font-size: 16px;">{{$etudiant->projetsInternationaux()->count()}} en cours</p>
                    <div class="toggles">
                        <p></p>
                        <p></p>
                        <p></p>
                    </div>
                </div>
                @forelse ($etudiant->projetsInternationaux()->get() as $projet)
                    <div class="projet-international">

                        @switch($projet->getLastStatutRealisation())
                            @case("valide")
                                <div class="icone termine"></div>
                                @break

                            @case("en_cours")
                                <div class="icone enCours"></div>
                                @break

                            @case("non_valide")
                                <div class="icone nonValide"></div>
                                @break

                            @default

                        @endswitch
                        <div class="infos ms-4">
                            <a style="font-size: 16px;">{{ ucfirst(trans($projet->type))}} ({{$projet->getPeriode()}} jours)</a>
                            <p class="opacity-50 mb-0" style="font-size: 14px;">Du {{$projet->getDateDebut()}} au {{$projet->getDateFin()}}</p>
                        </div>
                    </div>

                @empty
                <h6 class="mx-auto opacity-50">Aucun projet n'a été effectué</h6>

                @endforelse
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $( document ).ready(function() {
        $progression = parseInt($("#nbJours_exp").html()*(100/57));
        if ($progression>100){
            $progression = 100;
        }
        $("#international-progressbar>#progression").css({"width": `${$progression}%`});

        $(".date-picker").flatpickr({
            mode: "range",
            locale: "fr",
            allowInput: true,
            dateFormat: "d-m-Y",
        });

        $("#type").change(function (e){
            $(".form").hide();
            $(`.form-${$("#type option:selected").val()}`).show();
        });

        $("#type").change();

        var entreprises = [];
        $.each({!! $entreprises !!}, function(key,value) {
            item = {};
            item["id"] = value.id;
            item["text"] = `${value.nom} (${value.ville})`;
            entreprises.push(item);
        });

        $('.entreprise').select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            dropdownParent: $("#nouveauProjet"),
            data: entreprises
        });

        $("#creer_fiche").click(function(){
            Swal.fire({
            title: 'Confirmez-vous la création ?',
            text: "Une fois envoyée, vous ne pourrez modifier les informations !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Envoyer',
            cancelButtonText: "Annuler"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Fiche envoyée !',
                'En attente de validation.',
                'success'
                );
                $('.form:visible').append($("#periode"));
                $('.form:visible').submit();
            }
            });
        });
        console.log($("#periode"));

    });
</script>

@endsection
