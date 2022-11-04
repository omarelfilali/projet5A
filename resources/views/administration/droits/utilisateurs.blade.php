@extends('layouts/default-admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Droits par utilisateurs</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      
    @foreach($utilisateurs as $utilisateur)

      <div class="col-3">

        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-4">
                @if($utilisateur->role == 3)
                <img src="{{ !empty($utilisateur->photo) ? 'http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/' . $utilisateur->photo : "http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/avatar_mascotte.png" }}" 
                class="img-circle elevation-2" style="object-fit: cover" width="70px" height="70px" alt="User Image">
                @elseif($utilisateur->role == 4)
                  <img src="{{ !empty($utilisateur->photo) ? 'http://e-www3-t1.univ-lemans.fr/data/etudiants/photos_badges_universite/' . $utilisateur->photo : "http://e-www3-t1.univ-lemans.fr/data/etudiants/photos_badges_universite/avatar_mascotte.png" }}" 
                  class="img-circle elevation-2" style="object-fit: cover" width="70px" height="70px" alt="User Image">
                @else
                  <img src="{{ asset('http://e-www3-t1.univ-lemans.fr/data/personnels/trombines/avatar_mascotte.png') }}" 
                  class="img-circle elevation-2" style="object-fit: cover" width="70px" height="70px" alt="User Image">
                @endif
              </div>
              <div class="col-8">
                <h5 class="card-title">{{$utilisateur->nom}} {{$utilisateur->prenom}}</h5>
                <p class="card-text">Role : {{$utilisateur->role}}</p>
                <a href="{{route('administration.droits.utilisateurs.edit', $utilisateur->id)}}" class="text-primary" ><i class="fa-solid fa-lock"></i> Gérer les permissions</a> 
                {{-- onClick="gererPermissions('{{$utilisateur->nomPrenom}}')" --}}
              </div>
            </div>
            
          </div>
        </div>

      </div>
    @endforeach
    </div>
  </div>
</section>


<div class="modal fade" id="nouveauProjet" tabindex="-1" aria-labelledby="nouveauProjetLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="#" id="form_demande" method="post">
      @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="nouveauProjetLabel">Permissions de </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-12">
                      <p>Voici les droits de l'utilisateur sélectionné.</p>
                  </div>
              </div>
          </div>
  
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary" >Modifier</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

// function gererPermissions($nomUtilisateur){
//   setModalTitle("Permissions pour " + $nomUtilisateur);
//   setModalContent("<b>Permissions : </b>");
//   showModal("gererPermissions"); 
// }

</script>

@endsection
