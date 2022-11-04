@extends('layouts/default-admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0">Toutes les demandes WIFI</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">Demandes en attente <span class="badge badge-warning right">{{ count($demandesEnAttente) }}</span></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:20%">Demandeur</th>
                        <th style="width:20%">Usager</th>
                        <th style="width:10%">Duree</th>
                        <th style="width:20%">Motif</th>
                        <th style="width:10%">Date de la demande</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demandesEnAttente as $demandeEnAttente)

                    <tr class="elem-row">
                        <td>{{$demandeEnAttente->getDemandeur()}}</td>
                        <td>{{$demandeEnAttente->usager}}</td>
                        <td>{{$demandeEnAttente->duree}}</td>
                        <td>{{$demandeEnAttente->raison}}</td>
                        <td>le {{$demandeEnAttente->getDateDemande()}}</td>
                        <td>
                            <form method="POST" action={{ route('administration.informatique.wifi_action',['id' => $demandeEnAttente->id]) }} id="form_accept_demande">
                                {{ method_field('PATCH') }}
                                @csrf
                                <input style="display:none" name="action_wifi" value="accepte"></input>
                                <button type="button" onclick="accept_box()" class="btn btn-success btn-sm">Accepter</button>
                            </form>
                            <form method="POST" action={{ route('administration.informatique.wifi_action',['id' => $demandeEnAttente->id]) }} id="form_refuse_demande">
                                {{ method_field('PATCH') }}
                                @csrf
                                <input style="display:none" name="action_wifi" value="refuse"></input>
                                <button type="button" onclick="refuse_box()" class="btn btn-danger btn-sm">Refuser</button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-success card-outline collapsed-card">

        <div class="card-header">
            <h3 class="card-title">Demandes acceptées <span class="badge badge-success right">{{ count($demandesAccepte) }}</span></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:20%">Demandeur</th>
                        <th style="width:20%">Usager</th>
                        <th style="width:10%">Durée</th>
                        <th style="width:20%">Motif</th>
                        <th style="width:10%">Date de la demande</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demandesAccepte as $demandeAccepte)

                    <tr class="elem-row">
                        <td>{{$demandeAccepte->getDemandeur()}}</td>
                        <td>{{$demandeAccepte->usager}}</td>
                        <td>{{$demandeAccepte->duree}}</td>
                        <td>{{$demandeAccepte->raison}}</td>
                        <td>le {{$demandeAccepte->getDateDemande()}}</td>
                        <td>
                            <form method="POST" action={{ route('administration.informatique.wifi_action',['id' => $demandeAccepte->id]) }} id="form_annuler_demande">
                                {{ method_field('PATCH') }}
                                @csrf
                                <input style="display:none" name="action_wifi" value="annule"></input>
                                <button type="button" onclick="annul_box()" class="btn btn-secondary btn-sm">Annuler la décision</button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="card card-danger card-outline collapsed-card">

        <div class="card-header">
            <h3 class="card-title">Demandes refusées <span class="badge badge-danger right">{{ count($demandesRefuse) }}</span></h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body table-responsive no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width:20%">Demandeur</th>
                        <th style="width:20%">Usager</th>
                        <th style="width:10%">Duree</th>
                        <th style="width:20%">Motif</th>
                        <th style="width:10%">Date de la demande</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demandesRefuse as $demandeRefuse)

                    <tr class="elem-row">
                        <td>{{$demandeRefuse->getDemandeur()}}</td>
                        <td>{{$demandeRefuse->usager}}</td>
                        <td>{{$demandeRefuse->duree}}</td>
                        <td>{{$demandeRefuse->raison}}</td>
                        <td>le {{$demandeRefuse->getDateDemande()}}</td>
                        <td>
                            <form method="POST" action={{ route('administration.informatique.wifi_action',['id' => $demandeRefuse->id]) }} id="form_annuler_demande">
                                {{ method_field('PATCH') }}
                                @csrf
                                <input style="display:none" name="action_wifi" value="annule"></input>
                                <button type="button" onclick="annul_box()" class="btn btn-secondary btn-sm">Annuler le refus</button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</section>

<script>

    function accept_box(){
        Swal.fire({
            title: 'Confirmer l\'envoi du code ?',
            text: "Vous êtes sur le point d'envoyer le code wifi",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui',
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Code envoyé !'
                );
                $('#form_accept_demande').submit();
            }
        })
    };

    function refuse_box(){
        Swal.fire({
            title: 'Refuser la demande de code ?',
            text: "Vous êtes sur le point de refuser l'envoi du code wifi",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Refuser',
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Demande refusée !'
                );
                $('#form_refuse_demande').submit();
            }
        })
    };

    function annul_box(){
        Swal.fire({
            title: 'Annuler la décision de refus ?',
            text: "Vous êtes sur le point de réinitialiser la demande du code wifi",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok',
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                'Décision annulée !'
                );
                $('#form_annuler_demande').submit();
            }
        })
    };

</script>

@endsection
