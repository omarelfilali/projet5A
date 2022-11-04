<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventaireEmprunt;
use App\Models\InventaireProduit;
use App\Models\Personnel;
use App\Models\Option;
use App\Models\Etudiant;
use App\Models\InventaireEmpruntEncadrant;
use App\Models\InventaireProduitReference;
use App\Models\InventaireEmpruntProduit;
use App\Models\InventaireEmpruntHistorique;
use App\Models\InventaireType;
use Illuminate\Validation\ValidationException;
use App\Mail\StatusChanged;
use App\Mail\ActionRequired;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class RequestController extends Controller
{
    public function index(Request $request) {
        $title = trans_choice('msg.loan_request', 2);
        $small_title = __('msg.manage_requests');
        $technicien_encadrants_only = true;
        // $admin = Personnel::getGuard()->user()->isRespAdministratif();
        $admin = Auth::user()->hasRole('Responsable administratif');
        $demandes = InventaireEmprunt::where('technicien_id', '!=', NULL)->orderBy('updated_at', 'DESC');

        $timerangestart = null;
        $timerangeend = null;
        if ($request->timerangestart && $request->timerangeend) {
            $timerangestart = Carbon::parse($request->timerangestart);
            $timerangeend = Carbon::parse($request->timerangeend)->endOfDay();
        } else {
            $option = Option::findOrFail('emprunts_from')->first();
            $timerangestart = Carbon::createFromFormat('d/m/Y', $option->value);
            $timerangeend = Carbon::now()->endOfDay();
        }
        //dd($timerangeend);
        //Restriction sur la période
        $demandes->where(function($query) use ($timerangestart, $timerangeend) {
            $query->whereBetween('updated_at', [$timerangestart, $timerangeend])->orWhereBetween('created_at', [$timerangestart, $timerangeend]);
        });

        $demandesEnAttente = (clone $demandes)->whereBetween('status', [-1, 3])->get();
		$demandesEnCours = (clone $demandes)->where('status', 4)->get();
		$demandesTerminees = (clone $demandes)->where('status', '>=', 5)->orWhere('status', '-2')->get();

        return view('administration.materiel.requests.index')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('technicien_encadrants_only', $technicien_encadrants_only)
            ->with('admin', $admin)
            ->with('search_bar', true)
			->with('demandesEnAttente', $demandesEnAttente)
			->with('demandesEnCours', $demandesEnCours)
			->with('demandesTerminees', $demandesTerminees)
            ->with('timerangestart', $timerangestart)
            ->with('timerangeend', $timerangeend);

    }

    public function admin(Request $request) {
        $title = trans_choice('msg.loan_request', 2);
        $small_title = __('msg.manage_requests');
        $technicien_encadrants_only = false;
        $admin = true;
        $demandes = InventaireEmprunt::where('technicien_id', '!=', NULL)->orderBy('updated_at', 'DESC');

        $timerangestart = null;
        $timerangeend = null;
        if ($request->timerangestart && $request->timerangeend) {
            $timerangestart = Carbon::parse($request->timerangestart);
            $timerangeend = Carbon::parse($request->timerangeend);
        } else {
            $option = Option::findOrFail('emprunts_from')->first();
            $timerangestart = Carbon::createFromFormat('d/m/Y', $option->value);
            $timerangeend = Carbon::now();
        }

        //Restriction sur la période
        $demandes->where(function($query) use ($timerangestart, $timerangeend) {
            $query->whereBetween('debut_date', [$timerangestart, $timerangeend])->orWhereBetween('fin_date', [$timerangestart, $timerangeend]);
        });

        $demandesEnAttente = (clone $demandes)->whereBetween('status', [-1, 3])->get();
		$demandesEnCours = (clone $demandes)->where('status', 4)->get();
		$demandesTerminees = (clone $demandes)->where('status', '>=', 5)->orWhere('status', '-2')->get();

        return view('administration.materiel.requests.index')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('technicien_encadrants_only', $technicien_encadrants_only)
            ->with('admin', $admin)
            ->with('search_bar', true)
			->with('demandesEnAttente', $demandesEnAttente)
			->with('demandesEnCours', $demandesEnCours)
			->with('demandesTerminees', $demandesTerminees)
            ->with('timerangestart', $timerangestart)
            ->with('timerangeend', $timerangeend);
    }

    public function respm_add() {
        $title = trans_choice('msg.loan', 2);
        $small_title = __('msg.create');
        $etudiants = Etudiant::get();
        $personnels = Personnel::get();
        // Personnel::getGuard()->
        $categories = auth()->user()->categories->map(function ($c) {
    		return collect($c->categorie_id);
    	})->toArray();
    	$types = InventaireType::whereIn('category_id', $categories)->get()->map(function ($c) {
            return collect($c->id);
        })->toArray();
        #dd($types);
        $produits = InventaireProduit::whereIn('type_id', $types)->where('masked', 0)->get();

        return view('administration.materiel.requests.form')
            ->with('title', $title)
            ->with('etudiants', $etudiants)
            ->with('personnels', $personnels)
            ->with('produits', $produits)
            ->with('small_title', $small_title);
    }

	public function respm_emprunts(Request $request) {
        $title = trans_choice('msg.loan', 2);
        $small_title = __('msg.visualize');
        $technicien_encadrants_only = false;
        $admin = false;
        $demandes = InventaireEmprunt::where('technicien_id', '=', NULL)->orderBy('updated_at', 'DESC');

        $timerangestart = null;
        $timerangeend = null;
        if ($request->timerangestart && $request->timerangeend) {
            $timerangestart = Carbon::parse($request->timerangestart);
            $timerangeend = Carbon::parse($request->timerangeend);
        } else {
            $option = Option::findOrFail('emprunts_from')->first();
            $timerangestart = Carbon::createFromFormat('d/m/Y', $option->value);
            $timerangeend = Carbon::now();
        }

        //Restriction sur la période
        $demandes->where(function($query) use ($timerangestart, $timerangeend) {
            $query->whereBetween('debut_date', [$timerangestart, $timerangeend])->orWhereBetween('fin_date', [$timerangestart, $timerangeend]);
        });

		$demandesEnCours = (clone $demandes)->where('status', 4)->get();
		$demandesTerminees = (clone $demandes)->where('status', '>=', 5)->get();

        // Personnel::getGuard()->user()->
        $categories = auth()->user()->categories->map(function ($c) {
    		return $c->categorie->id;
    	})->toArray();

        return view('administration.materiel.requests.index')
        ->with('title', $title)
        ->with('small_title', $small_title)
        ->with('technicien_encadrants_only', $technicien_encadrants_only)
        ->with('admin', $admin)
        ->with('search_bar', true)
        ->with('categories', $categories)
        ->with('demandesEnCours', $demandesEnCours)
        ->with('demandesTerminees', $demandesTerminees)
        ->with('timerangestart', $timerangestart)
        ->with('timerangeend', $timerangeend);
	}

    public function respm_update_periode($id, Request $request) {
        $emprunt = InventaireEmprunt::findOrFail($id);

        //Si l'emprunt est lié à un technicien, alors ce n'est pas un emprunt de responsable matériel
        if ($emprunt->technicien != null) {
            abort(403, 'Unauthorized action.');
            return;
        }
        $categories = Personnel::getGuard()->user()->categories->map(function ($c) {
            return $c->categorie->id;
        })->toArray();
        // Si on n'est pas responsable matériel ou qu'on n'a pas accès à la catégorie, accès refusé
        if (!((Personnel::getGuard()->user()->isRespMateriel()) && (in_array($emprunt->articles->first()->reference->produit->type->category_id, $categories)))){
            abort(403, 'Unauthorized action.');
            return;
        }

        $rules = [
			'timerangeend' => [
                'bail',
				'required',
                'date_format:d/m/Y',
			],
		];

		$messages = [

		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.period.updated.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $timerangeend_date = Carbon::createFromFormat('d/m/Y', $request->timerangeend);

        //Vérification : La deuxième date n'est pas passée
        if ($this->isBeforeToday($timerangeend_date)) {
            toastr()->error(__('validation.request.period.updated.error'));
            throw ValidationException::withMessages(['timerangeend' => __('validation.request.past_date')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // Mise à jour des dates
        $debut_date_ancien = $emprunt->debut_date;
        $fin_date_ancien = $emprunt->fin_date;
        $emprunt->fin_date = $timerangeend_date;
        $emprunt->save();
        InventaireEmpruntHistorique::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => Personnel::getGuard()->user()->id,
            'role' => "Responsable Matériel",
            'titre' => "Modification de la période",
            'commentaire' => $debut_date_ancien->format("d/m/Y")." au ".$fin_date_ancien->format("d/m/Y")." → ".$emprunt->debut_date->format("d/m/Y")." au ".$emprunt->fin_date->format("d/m/Y")
        ]);

        toastr()->success(__('validation.request.period.updated.success'));
        return redirect()->route('administration.materiel.respmateriel.emprunts.show', $id);
    }

    // Création d'un emprunt par un responsable matériel
    public function respm_create(Request $request) {
        dd($request);
        $rules = [
			'produit' => [
				'required',
				'integer',
                'exists:inventaire_produits,id',
			],
			'numero_serie' => [
				'required',
				'integer',
                'exists:inventaire_produits_references,id',
			],
			'etudiant' => [
				'required',
				'string',
				'exists:inscriptions2,login',
			],
            'timerangeend' => [
                'bail',
				'required',
				'date_format:d/m/Y',
			],
		];

        $messages = [
            'produit.exists' => __('validation.not_found.product'),
            'numero_serie.exists' => __('validation.not_found.serial_nb'),
            'etudiant.exists' => __('validation.not_found.student'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.added.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $timerangeend_date = Carbon::createFromFormat('d/m/Y', $request->timerangeend);

        //Vérification : La date de retour ne doit pas être dépassée
        if ($this->isBeforeToday($timerangeend_date)) {
            toastr()->error(__('validation.request.added.error'));
            throw ValidationException::withMessages(['timerangeend' => __('validation.request.past_date')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $reference = InventaireProduitReference::findOrFail($request->numero_serie);
        $produit = $reference->produit;

        // On vérifie que la référence correspond au produit
        if ($request->produit != $produit->id) {
            toastr()->error(__('validation.request.added.error'));
            throw ValidationException::withMessages(['numero_serie' => __('validation.not_found.serial_nb')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user = Personnel::getGuard()->user();
        $categories = $user->categories->map(function ($c) {
            return $c->categorie->id;
        })->toArray();
        if (!($user->isRespMateriel() && in_array($produit->type->category_id, $categories))){
            abort(403, 'Unauthorized action.');
            return;
        }

        $emprunt = InventaireEmprunt::firstOrCreate([
            'etudiant_uid' => $request->etudiant,
            'description' => ($request->description == null ? '' : $request->description),
            'debut_date' => Carbon::now(),
            'fin_date' => $timerangeend_date,
            'status' => 4
        ]);

        InventaireEmpruntProduit::firstOrCreate([
            'emprunt_id' => $emprunt->id,
            'reference_id' => $reference->id
        ]);

        toastr()->success(__('validation.request.added.success'));
        return redirect()->route('administration.materiel.respmateriel.emprunts');
    }


    public function respm_rendu($id, Request $request) {

        $emprunt = InventaireEmprunt::findOrFail($id);

        // Si l'emprunt ne concerne pas un responsable matériel
        if ($emprunt->technicien != null) {
            abort(403, 'Unauthorized action.');
            return;
        }

        // On vérifie que le personnel gère la catégorie
        $categories = auth()->user()->categories->map(function ($c) {
            return $c->categorie->id;
        })->toArray();
        if (!((auth()->user()->can('materiel.acces.respmateriel')) && (in_array($emprunt->articles->first()->reference->produit->type->category_id, $categories)))){
            abort(403, 'Unauthorized action.');
            return;
        }

        $emprunt->rendu_date = Carbon::now();
        $emprunt->status = 5;
        $emprunt->save();
        InventaireEmpruntHistorique::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => auth()->user()->id,
            'role' => "Responsable Matériel",
            'titre' => "Matériel retourné",
            'commentaire' => ""
        ]);

        toastr()->success(__('validation.request.returned.success'));
        return redirect()->route('administration.materiel.respmateriel.emprunts.show', $id);
    }

    public function respm_show($id) {
        return $this->show($id, "RESPM");
    }

    public function classic_show($id) {
        return $this->show($id, "");
    }

    private function show($id, $type) {
        
        $demande = InventaireEmprunt::findOrFail($id);
        #dd($demande->assurance());
        if ($type == "RESPM" && $demande->technicien != NULL){
            abort(403, 'Unauthorized action.');
            return;
        }
        if ($type != "RESPM" && $demande->technicien == NULL){
            abort(403, 'Unauthorized action.');
            return;
        }
        
        $title = ($type == "RESPM" ? trans_choice('msg.loan', 2) : trans_choice('msg.request', 2)).' '.__('msg.from').' '.$demande->etudiant->nomprenom;
        $small_title = ($type == "RESPM" ? __('msg.created_the_masc') :  __('msg.created_the_fem')).' '.$demande->created_at->format('d/m/Y à H:i');
        $techniciens = $type == "RESPM" ? NULL : Personnel::getTechniciens()->where('id', '!=', $demande->technicien->id);
        $personnels = Personnel::whereNotIn('id', $demande->encadrants_id())->get();
        $categories = Personnel::getGuard()->user()->categories->map(function ($c) {
            return $c->categorie->id;
        })->toArray();

        $isEncadrant = in_array(Personnel::getGuard()->user()->id, $demande->encadrants_id());
        if (!Personnel::getGuard()->user()->admin() && !Personnel::getGuard()->user()->isRespAdministratif() && !in_array(Personnel::getGuard()->user()->id, $demande->encadrants_id()) && $demande->technicien->id != Personnel::getGuard()->user()->id && !(Personnel::getGuard()->user()->isRespMateriel() && in_array($demande->articles->first()->reference->produit->type->category_id, $categories))){
            abort(403, 'Unauthorized action.');
            return;
        }

        $personnel = Personnel::getGuard()->user();
        $action = NULL;
        if ($type != "RESPM") {
            if ($personnel->isRespAdministratif()){
                $type = "RESPA";
            }
            switch ($demande->status){
                case -1:
                    if ($personnel->isRespAdministratif()){
                        $action = __('msg.question.accept_insurance');
                    }
                    break;
                case 0:
                    if (in_array($personnel->id, $demande->encadrants_id())){
                        $action = __('msg.question.allow_loan');
                    }
                    break;
                case 1:
                    if ($personnel->id == $demande->technicien->id){
                        $action = __('msg.question.allow_loan');
                    }
                    break;
                case 2:
                    if ($personnel->isRespAdministratif()){
                        $action = __('msg.question.allow_loan');
                    }
                    break;
                case 3:
                    if ($personnel->id == $demande->technicien->id){
                        $action = __('msg.question.mark_as_picked_up');
                    }
                    break;
                case 4:
                    if ($personnel->id == $demande->technicien->id){
                        $action = __('msg.question.mark_as_returned');
                    }
                    break;
            }
        }

        $assurance = $demande->etudiant->assurances()->orderBy('date_fin', 'DESC')->first();

        return view('administration.materiel.requests.show')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('demande', $demande)
            ->with('isEncadrant', $isEncadrant)
            ->with('techniciens', $techniciens)
            ->with('type', $type)
            ->with('assurance', $assurance)
            ->with('action', $action)
            ->with('personnels', $personnels);
    }

    public function action($id, Request $request){

        $rules = [
			'action' => [
                'required',
				'string',
                'in:accept,refuse',
			],
		];

		$messages = [
            'action.in' => __('validation.not_found.action')
		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.action.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $demande = InventaireEmprunt::findOrFail($id);
        if ($demande->technicien_id == null){
            abort(403, 'Unauthorized action.');
            return;
        }

        if ($demande->status >= 5){
            abort(403, 'Action impossible.');
            return;
        }

        $categories = Personnel::getGuard()->user()->categories->map(function ($c) {
            return $c->categorie->id;
        })->toArray();

        $isEncadrant = in_array(Personnel::getGuard()->user()->id, $demande->encadrants_id());
        if (!Personnel::getGuard()->user()->admin() && !Personnel::getGuard()->user()->isRespAdministratif() && !in_array(Personnel::getGuard()->user()->id, $demande->encadrants_id()) && $demande->technicien->id != Personnel::getGuard()->user()->id && !(Personnel::getGuard()->user()->isRespMateriel() && in_array($demande->articles->first()->reference->produit->type->category_id, $categories))){
            abort(403, 'Unauthorized action.');
            return;
        }

        switch ($request['action']) {
            case "accept":
                return $this->accept($demande, $request);
            case "refuse":
                return $this->refuse($demande, $request);
        }
        return redirect()->back();
    }

    public function accept($demande, Request $request) {
        $personnel = Personnel::getGuard()->user();
        $action_title = NULL;
        $action_role = NULL;
        $personnelsToMail = [];
        $mailStudent = True;

        switch ($demande->status){
            case -1:
                if ($personnel->isRespAdministratif()){
                    $mailStudent = False;
                    $action_title = "Validation de l'assurance";
                    $action_role = "Responsable administratif";
                    // Changement du statut de l'assurance en valide
                    $assurance = $demande->assurance();
                    $assurance->valide = 1;
                    $assurance->save();
                    // Mise à jour de toutes les demandes en attente
                    foreach($assurance->etudiant->demandes as $d) {
                        if ($d->status == -1) {
                            $deb_emprunt = $d->dateDebutCarbon();
                            $fin_emprunt = $d->dateFinCarbon();
                            if ($deb_emprunt->gte($assurance->date_debut) && $fin_emprunt->lte($assurance->date_fin)) {
                                // Mise à jour du statut de la demande
                                $d->status = 0;
                                $d->save();
                                // Envoi d'un mail pour avertir l'étudiant d'un changement de statut
                                $mail = new StatusChanged(route('requests.index'), $d->id, $action_title);
                                $student = $d->etudiant;
                                Mail::to($student->email, $student->nomprenom)->send($mail);
                                // Envoi d'un mail pour prévenir les encadrants qu'ils ont une action a réaliser
                                $encadrantsToMail = [];
                                foreach ($d->encadrants as $encadrant) {
                                    array_push($encadrantsToMail, $encadrant->personnel);
                                }
                                $mail = new ActionRequired(route('administration.materiel.requests.show', ['id' => $d->id]), $d->id);
                                foreach ($encadrantsToMail as $personnel) {
                                    Mail::to($personnel->email, $personnel->nomprenom)->send($mail);
                                }
                            }
                        }
                    }
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.accepted.admin_resp'));
                break;
            case 0:
                if (in_array($personnel->id, $demande->encadrants_id())){
                    $demande->status = 1;
                    $demande->save();
                    $action_title = "Validation par l'encadrant";
                    $action_role = "Encadrant";
                    array_push($personnelsToMail, $demande->technicien);
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.accepted.supervisor'));
            break;
            case 1:
                if ($personnel->id == $demande->technicien->id){
                    $demande->status = 2;
                    $demande->save();
                    $action_title = "Validation par le technicien";
                    $action_role = "Technicien";
                    foreach (Personnel::getRespAdministratifs() as $resp) {
                        array_push($personnelsToMail, $resp);
                    }
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.accepted.technician'));
                break;
            case 2:
                if ($personnel->isRespAdministratif()){
                    $demande->status = 3;
                    $demande->save();
                    $action_title = "Validation par le responsable administratif";
                    $action_role = "Responsable administratif";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.accepted.admin_resp'));
                break;
            case 3:
                if ($personnel->id == $demande->technicien->id){
                    $demande->status = 4;
                    $demande->save();
                    $action_title = "Début du prêt";
                    $action_role = "Technicien";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.picked_up'));
                break;
            case 4:
                if ($personnel->id == $demande->technicien->id){
                    $demande->status = 5;
                    $demande->rendu_date = Carbon::now();
                    $demande->save();
                    $action_title = "Articles retournés";
                    $action_role = "Technicien";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.returned.error.bad_technician'));
                break;
        }

        if ($action_title != null){
            InventaireEmpruntHistorique::firstOrCreate([
                'emprunt_id' => $demande->id,
                'personnel_id' => Personnel::getGuard()->user()->id,
                'role' => $action_role,
                'titre' => $action_title,
                'commentaire' => $request->commentaire ?? ""
            ]);

            // Envoi d'un mail pour avertir l'étudiant d'un changement de statut
            if ($mailStudent) {
                $mail = new StatusChanged(route('requests.index'), $demande->id, $action_title);
                $student = $demande->etudiant;
                Mail::to($student->email, $student->nomprenom)->send($mail);
            }

            //Envoi d'un mail pour avertir un personnel qu'il a une action a effectuer
            if (count($personnelsToMail) > 0) {
                $mail = new ActionRequired(route('administration.materiel.requests.show', ['id' => $demande->id]), $demande->id);
                foreach ($personnelsToMail as $personnel) {
                    Mail::to($personnel->email, $personnel->nomprenom)->send($mail);
                }
            }
        }

        return redirect()->route('administration.materiel.requests.show', $demande->id);
    }

    public function refuse($demande, Request $request) {
        $personnel = Personnel::getGuard()->user();
        $action_title = NULL;
        $action_role = NULL;
        $mailStudent = True;

        switch ($demande->status){
            case -1:
                if ($personnel->isRespAdministratif()){
                    $mailStudent = False;
                    $action_title = "Refus de l'assurance";
                    $action_role = "Responsable administratif";
                    // Changement du statut de l'assurance en refusé
                    $assurance = $demande->assurance;
                    $assurance->valide = -1;
                    $assurance->save();
                    // Mise à jour de toutes les demandes en attente
                    foreach($assurance->etudiant->demandes as $d) {
                        if ($d->status == -1) {
                            $deb_emprunt = $d->dateDebutCarbon();
                            $fin_emprunt = $d->dateFinCarbon();
                            if ($deb_emprunt->gte($assurance->date_debut) && $fin_emprunt->lte($assurance->date_fin)) {
                                // Mise à jour du statut de la demande
                                $d->status = -2;
                                $d->save();
                                // Envoi d'un mail pour avertir l'étudiant d'un changement de statut
                                $mail = new StatusChanged(route('requests.index'), $d->id, "Refus de l'assurance");
                                $student = $d->etudiant;
                                Mail::to($student->email, $student->nomprenom)->send($mail);
                            }
                        }
                    }
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.accepted.admin_resp'));
                break;
            case 0:
                if (in_array($personnel->id, $demande->encadrants_id())){
                    $demande->status = 6;
                    $demande->save();
                    $action_title = "Refus de l'encadrant";
                    $action_role = "Encadrant";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                else if ($personnel->id == $demande->technicien->id){
                    $demande->status = 7;
                    $demande->save();
                    $action_title = "Annulation de la demande";
                    $action_role = "Technicien";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.refused.supervisor'));
            break;
            case 1:
                if ($personnel->id == $demande->technicien->id){
                    $demande->status = 8;
                    $demande->save();
                    $action_title = "Refus du technicien";
                    $action_role = "Technicien";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.refused.technician'));
                break;
            case 2:
                if ($personnel->isRespAdministratif()){
                    $demande->status = 10;
                    $demande->save();
                    $action_title = "Refus du responsable administratif";
                    $action_role = "Responsable administratif";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                else if ($personnel->id == $demande->technicien->id){
                    $demande->status = 11;
                    $demande->save();
                    $action_title = "Annulation de la demande";
                    $action_role = "Technicien";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.refused.admin_resp'));
                break;
            case 3:
                if ($personnel->id == $demande->technicien->id){
                    $demande->status = 12;
                    $demande->save();
                    $action_title = "Annulation de la demande";
                    $action_role = "Technicien";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.refused.technician'));
                break;
            case 4:
                if ($personnel->id == $demande->technicien->id){
                    $demande->status = 13;
                    $demande->rendu_date = Carbon::now();
                    $demande->save();
                    $action_title = "Annulation de la demande";
                    $action_role = "Technicien";
                    toastr()->success(__('validation.request.action.success'));
                    break;
                }
                toastr()->error(__('validation.request.refused.cancelled'));
                break;
        }

        if ($action_title != null){
            InventaireEmpruntHistorique::firstOrCreate([
                'emprunt_id' => $demande->id,
                'personnel_id' => Personnel::getGuard()->user()->id,
                'role' => $action_role,
                'titre' => $action_title,
                'commentaire' => $request->commentaire ?? ""
            ]);

            // Envoi d'un mail pour avertir l'étudiant d'un changement de statut
            if ($mailStudent) {
                $mail = new StatusChanged(route('requests.index'), $demande->id, $action_title);
                $student = $demande->etudiant;
                Mail::to($student->email, $student->nomprenom)->send($mail);
            }
        }

        return redirect()->route('administration.materiel.requests.show', $demande->id);
    }

    public function edit_product($id, $article) {
        $demande = InventaireEmprunt::findOrFail($id);
        if ($demande->technicien->id != Personnel::getGuard()->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }

        if ($demande->status >= 5){
            abort(403, 'Action impossible.');
            return;
        }

        $title = trans_choice('msg.loan_request', 2);
        $small_title = __('msg.manage_requests');
        $techniciens = Personnel::getTechniciens()->where('id', '!=', $demande->technicien->id);
        $personnels = Personnel::whereNotIn('id', $demande->encadrants_id())->get();
        $isEncadrant = in_array(Personnel::getGuard()->user()->id, $demande->encadrants_id());

        $personnel = Personnel::getGuard()->user();

        if ($personnel->isRespAdministratif()){
            $type = "RESPA";
        }

        $assurance = $demande->etudiant->assurances()->orderBy('date_fin', 'DESC')->first();

        return view('administration.materiel.requests.show')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('demande', $demande)
            ->with('article_edit', $article)
            ->with('type', "")
            ->with('assurance', $assurance)
            ->with('techniciens', $techniciens)
            ->with('isEncadrant', $isEncadrant)
            ->with('personnels', $personnels);
    }

    public function update_product($id, $article, Request $request) {

        $demande = InventaireEmprunt::findOrFail($id);
        if ($demande->technicien == null){
            abort(403, 'Unauthorized action.');
            return;
        }
        if ($demande->technicien->id != Personnel::getGuard()->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }
        if ($demande->status >= 5){
            abort(403, 'Action impossible.');
            return;
        }

        $rules = [
			'update_product' => [
                'required',
				'integer',
                'exists:inventaire_produits_references,id',
			],
		];

		$messages = [
            'update_product.exists' => __('validation.not_found.serial_nb'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.product_replacement.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $reference = InventaireProduitReference::findOrFail($request->update_product);
        $ancienne_reference = InventaireProduitReference::findOrFail($article);

         // On vérifie que la référence correspond toujours au même produit
         if ($reference->produit_id != $ancienne_reference->produit_id) {
            toastr()->error(__('validation.request.product_replacement.error'));
            throw ValidationException::withMessages(['update_product' => __('validation.not_found.serial_nb')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $emprunt = InventaireEmpruntProduit::where('emprunt_id', $id)->where('reference_id', $article)->firstOrFail();
        $emprunt->reference_id=$reference->id;
        $emprunt->save();
        InventaireEmpruntHistorique::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => Personnel::getGuard()->user()->id,
            'role' => "Technicien",
            'titre' => "Mise à jour d'un article",
            'commentaire' => "Remplacement de l'article (".$ancienne_reference->numero_serie.") par l'article (".$reference->numero_serie.")"
        ]);

        toastr()->success(__('validation.request.product_replacement.success'));
        return redirect()->route('administration.materiel.requests.show', $id);
    }


    public function add_encadrant($id, Request $request) {

        $demande = InventaireEmprunt::findOrFail($id);
        if ($demande->technicien == null){
            abort(403, 'Unauthorized action.');
            return;
        }
        if ($demande->technicien->id != Personnel::getGuard()->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }

        if ($demande->status >= 5){
            abort(403, 'Action impossible.');
            return;
        }

        $rules = [
			'add_encadrant' => [
                'required',
				'string',
                'exists:personnels,uid',
			],
		];

		$messages = [
            'add_encadrant.exists' => __('validation.not_found.staff'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.supervisor.add.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $personnel = Personnel::findOrFail($request->add_encadrant);
        InventaireEmpruntEncadrant::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => $personnel->id
        ]);
        InventaireEmpruntHistorique::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => Personnel::getGuard()->user()->id,
            'role' => "Technicien",
            'titre' => "Ajout d'un encadrant",
            'commentaire' => "Ajout de ".$personnel->nomprenom
        ]);

        toastr()->success(__('validation.request.supervisor.add.success'));
        return redirect()->route('administration.materiel.requests.show', $id);
    }

    public function delete_encadrant($id, Request $request) {
        $demande = InventaireEmprunt::findOrFail($id);
        if ($demande->technicien == null){
            abort(403, 'Unauthorized action.');
            return;
        }

        if ($demande->technicien->id != Personnel::getGuard()->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }

        if ($demande->status >= 5){
            abort(403, 'Action impossible.');
            return;
        }

        $rules = [
			'delete_encadrant' => [
                'required',
				'string',
                'exists:personnels,uid',
			],
		];

		$messages = [
            'delete_encadrant.exists' => __('validation.not_found.staff'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.supervisor.remove.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        // On vérifie qu'on ne supprime pas le dernier encadrant
        if ($demande->encadrants->count() == 1){
            toastr()->error(__('validation.request.supervisor.remove.error.generic'));
            throw ValidationException::withMessages(['delete_encadrant' => __('validation.request.supervisor.remove.error.last_one')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $personnel = Personnel::findOrFail($request->delete_encadrant);
        $toRemove = InventaireEmpruntEncadrant::where('emprunt_id', $id)->where('personnel_id', $personnel->id)->delete();
        InventaireEmpruntHistorique::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => Personnel::getGuard()->user()->id,
            'role' => "Technicien",
            'titre' => "Retrait d'un encadrant",
            'commentaire' => "Retrait de ".$personnel->nomprenom
        ]);

        toastr()->success(__('validation.request.supervisor.remove.success'));
        return redirect()->route('administration.materiel.requests.show', $id);
    }

    public function update_technicien($id, Request $request) {
        $demande = InventaireEmprunt::findOrFail($id);
        if ($demande->technicien == null){
            abort(403, 'Unauthorized action.');
            return;
        }
        if ($demande->technicien->id != Personnel::getGuard()->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }

        if ($demande->status >= 5){
            abort(403, 'Action impossible.');
            return;
        }

        $rules = [
			'edit_technicien' => [
                'required',
				'string',
                'exists:personnels,uid',
			],
		];

		$messages = [
            'edit_technicien.exists' => __('validation.not_found.technician'),
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.technician_change.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $personnel = Personnel::findOrFail($request->edit_technicien);

        // On vérifie que le personnel sélectionné est bien technicien
        if (!$personnel->isTechnicien()){
            toastr()->error(__('validation.request.technician_change.error'));
            throw ValidationException::withMessages(['edit_technicien' => __('validation.not_found.technician')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $emprunt = InventaireEmprunt::findOrFail($id);
        $emprunt->technicien_id = $personnel->id;
        $emprunt->save();
        InventaireEmpruntHistorique::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => Personnel::getGuard()->user()->id,
            'role' => "Technicien",
            'titre' => "Changement de technicien",
            'commentaire' => "Modification par ".$personnel->nomprenom
        ]);

        toastr()->success(__('validation.request.technician_change.success'));
        return redirect()->route('administration.materiel.requests.show', $id);
    }

    public function update_periode($id, Request $request) {
        $emprunt = InventaireEmprunt::findOrFail($id);
        $demande = InventaireEmprunt::findOrFail($id);
        if ($demande->technicien == null){
            abort(403, 'Unauthorized action.');
            return;
        }
        if ($demande->technicien->id != Personnel::getGuard()->user()->id){
            abort(403, 'Unauthorized action.');
            return;
        }

        if ($demande->status >= 5){
            abort(403, 'Action impossible.');
            return;
        }

        $rules = [
			'timerangestart' => [
                'bail',
				'required',
				'date',
			],
			'timerangeend' => [
                'bail',
				'required',
				'date',
			],
		];

		$messages = [

		];

        $validator = \Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
            toastr()->error(__('validation.request.period.updated.error'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $old_start = Carbon::parse($emprunt->debut_date);
        $new_start = Carbon::parse($request->timerangestart);
        // Si la date de début a changé
        if ($old_start->ne($new_start)) {
            //Vérification : Si la date de début est passée, on ne peut plus la modifier
            if ($this->isBeforeToday($old_start)) {
                toastr()->error(__('validation.request.period.updated.error'));
                throw ValidationException::withMessages(['timerangestart' => __('validation.request.period.request_started')]);
                return redirect()->back()->withInput()->withErrors($validator);
            //Vérification : La date de début ne doit pas être dépassée
            } else if ($this->isBeforeToday($new_start)) {
                toastr()->error(__('validation.request.period.updated.error'));
                throw ValidationException::withMessages(['timerangestart' => __('validation.request.period.past_date')]);
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        //Vérification : La deuxième date est après la première
        if (Carbon::parse($request->timerangestart)->isAfter(Carbon::parse($request->timerangeend))) {
            toastr()->error(__('validation.request.period.updated.error'));
            throw ValidationException::withMessages(['timerangeend' => __('validation.request.period.second_date_before')]);
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $debut_date_ancien = $emprunt->debut_date;
        $fin_date_ancien = $emprunt->fin_date;
        $emprunt->debut_date = $request->timerangestart;
        $emprunt->fin_date = $request->timerangeend;
        $emprunt->save();
        InventaireEmpruntHistorique::firstOrCreate([
            'emprunt_id' => $id,
            'personnel_id' => Personnel::getGuard()->user()->id,
            'role' => "Technicien",
            'titre' => "Modification de la période",
            'commentaire' => $debut_date_ancien->format("d/m/Y")." au ".$fin_date_ancien->format("d/m/Y")." → ".$emprunt->debut_date->format("d/m/Y")." au ".$emprunt->fin_date->format("d/m/Y")
        ]);

        toastr()->success(__('validation.request.period.updated.success'));
        return redirect()->route('administration.materiel.requests.show', $id);
    }

    function isBeforeToday($date){
        return Carbon::now()->startOfDay()->gt($date);
     }
}
