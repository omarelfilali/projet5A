@extends('layouts/full-screen')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-4">
                <h1 class="m-0">Affecter les projets</h1>

                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{route('administration.projets.dashboard')}}">Projets</a>
                    </li>
                    <li class="breadcrumb-item active">Affectation</li>
                </ol>
            </div><!-- /.col -->

            <div class="col-sm-4" align="center">

                <a href="{{route('administration.projets.dashboard')}}" class="btn btn-secondary m-3">Retour</a>

                <input type="submit" value="Affecter les voeux 1" class="btn btn-warning m-3">

                <input type="submit" value="Enregistrer" class="btn btn-success m-3 ">

            </div>

            <div class="col-sm-4">

                <button class="filter_dashboard float-right m-3 btn bg-primary"><i class="fas fa-filter"></i></button>

            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" action={{route('administration.projets.affectation')}} enctype="multipart/form-data">
                        {{method_field('PATCH')}}
                        @csrf
                        <div class="d-flex flex-direction-row justify-content-center col-12">
                            <div class="card col-10 p-0 filtre-panel">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center header_filtre">
                                    <h3 class="card-title">Filtres</h3>
                                    <button class="croix_filtre btn"><i class="fas fa-xmark"></i></button>
                                </div>
                                <div class="card-body">
                                    <div class="row d-flex flex-wrap">
                                        <div class="col-sm-4 col1_filtre d-flex flex-column justify-content-center">
                                            <div class="annee_filtre row mb-2">
                                                <label class="col-5" for="annee_scolaire">Année scolaire : </label>

                                                <select name="annee_scolaire" class="col-7" id="annee_scolaire">
                                                    @for ($i=2019; $i<=date("Y"); $i++)
                                                        <option value="{{$i}}-{{$i+1}}" {{($_POST AND $_POST['annee_scolaire'] == $i."-".$i+1) ? "selected=selected" : "" }}> {{$i}}-{{$i+1}}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="row mb-2">
                                                <label class="col-5" for="cursus">Cursus : </label>
                                                <select name="cursus" class="col-7" id="cursus">
                                                    <option value="toutes">Tous</option>
                                                    <option value="0" {{($_POST AND $_POST['cursus'] == 0) ? "selected=selected" : "" }}>FISE</option>
                                                    <option value="1" {{($_POST AND $_POST['cursus'] == 1) ? "selected=selected" : "" }}>FISA</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-sm-4 col2_filtre d-flex flex-column justify-content-center">
                                            <div class="row mb-2">
                                                <label class="col-5" for="promo">Promo : </label>
                                                <select name="promo" class="col-7" id="promo">
                                                    <option value="3A" {{($_POST AND $_POST['promo'] == "3A") ? "selected=selected" : "" }}>3ème année</option>
                                                    <option value="4A" {{($_POST AND $_POST['promo'] == "4A") ? "selected=selected" : "" }}>4ème année</option>
                                                    <option value="5A" {{($_POST AND $_POST['promo'] == "5A") ? "selected=selected" : "" }}>5ème année</option>
                                                </select>
                                            </div>

                                            <div class="row mb-2">
                                                <label class="col-5" for="specialite">Spécialité : </label>
                                                <select name="specialite" class="col-7" id="specialite">
                                                    <option value="toutes">Toutes</option>
                                                    <option value="1">A&I</option>
                                                    <option value="2">Informatique</option>
                                                </select>
                                            </div>


                                        </div>
                                        <div class="col-sm-4 row">
                                            <div class="elements_filtre row mb-2">
                                                <label class="col-5" for="prioritaire">Priorité : </label>
                                                <select name="prioritaire" class="col-7" id="prioritaire">
                                                    <option value="tout">Tous les projets</option>
                                                    <option value="prioritaire">Seulement les prioritaires</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="input_onlyprojetsdispo">Seulement les projets non attribués</label>
                                                <input type="checkbox" name="input_onlyprojetsdispo" id="input_onlyprojetsdispo">

                                                <label for="input_onlyetudispo">Seulement les étudiants non affectés</label>
                                                <input type="checkbox" name="input_onlyetudispo" id="input_onlyetudispo">
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row tableauAffectation">
                        <div class="table-container">
                            {{-- semestre : class="text-secondary" + <i class="fa-solid fa-plane"></i>
                                        alternant : <i class="fa-solid fa-industry"></i>
                                        ajac : picto --}}
                            <table class="table table-bordered scroll tableauAffectation" style="width:100%">
                                <thead  align="center">
                                    <tr>
                                        <th width="18%"></th>
                                        <th width="2%" title="Nb d'étudiants ayant classé ce projet en voeu 1"><i class="fa-solid fa-2x fa-ranking-star text-secondary"></i></th>
                                        <th width="2%" title="Nb d'étudiants affectés à ce projet"><i class="fa-solid fa-2x fa-people-group text-secondary"></i></th>

                                        @foreach ($etudiants as $etudiant)
                                        <th class="rotate table-active">
                                            <img src="{{$etudiant->getLogoSpecialite()}}" width="25px">

                                            {{$etudiant->nom}} {{$etudiant->prenom}}
                                            <span class='photo'>
                                                <i class='fa-solid fa-camera'></i><span><img src='{{$etudiant->getPhotoURLAttribute()}}' /></span>
                                            </span>

                                            @if($etudiant->alternance == 1)
                                                <i class="fa-solid fa-briefcase" title="Alternant"></i>
                                            @endif
                                        </th>
                                        @endforeach



                                    </tr>
                                </thead>
                                <tbody align="center" >

                                    @foreach ($projets as $projet)




                                    <tr>
                                        <td class="align-middle border-{{$projet->getFiliereCible()}}" align="left">
                                            <div class="" width="10px" height="10px"></div>
                                            <input type="checkbox" name="groupe_complet" id="groupe_complet">
                                            {{$projet->titre}}
                                        </td>
                                        <td class="align-middle "><b>?</b></td>
                                        <td class="align-middle "><b>{{count($projet->etudiants)}}/{{$projet->nb_places}}</b></td>

                                        @foreach ($etudiants as $etudiant)

                                            @if(in_array($etudiant->id, $projet->etudiants->pluck('id')->toArray()))
                                                <td class="align-middle choix affecte">
                                                    <p title="{{$projet->titre}}"><b>X</b></p>
                                                    <input type='radio' name='choix' value='{{$projet->id}}' >
                                                </td>
                                            @elseif($etudiant->getClassementProjet($projet->id))
                                                <td class="align-middle choix voeu{{$etudiant->getClassementProjet($projet->id)->rang}}">
                                                    <p title="{{$projet->titre}}"><b>{{$etudiant->getClassementProjet($projet->id)->rang}}</b></p>
                                                    <input type='radio' name='choix' value='{{$projet->id}}' >
                                                </td>
                                            @else
                                                <td class="align-middle choix">
                                                    <p>_</p>
                                                </td>
                                            @endif

                                        @endforeach

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


<script type="module">

    $("table td.choix").click(function(){
        // $(this).addClass('affectation-encours').siblings().removeClass('voeux-selected');
        // $(this).siblings().removeClass('affectation-encours');


        // $(this).siblings().find('input').attr("checked", false);
        // $(this).find('input').attr("checked", true);

        // TEST SAMY
        alert('a');
        $index = $(this).index();
        alert('ok');
        if ($(this).hasClass("affectation-encours")){
            $(this).removeClass('affectation-encours');
        }else{

            $(`table td.choix:nth-of-type(${$index+1})`).each(function () {
                $(this).removeClass("affectation-encours");
            });

            $(this).addClass('affectation-encours');
        }

    });

</script>

@endsection
