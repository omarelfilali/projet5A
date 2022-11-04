<?php

namespace App\Http\Controllers\Administration\Materiel;

use App\Http\Controllers\Controller;
use App\Models\EtudiantAssurance;
use App\Mail\ActionRequired;
use App\Mail\StatusChanged;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class InsuranceController extends Controller
{
    public function index() {
        $title = __('msg.insurance');
        $small_title = __('msg.visualize');

        $demandesEnAttente = EtudiantAssurance::where('valide', '=', 0)->orderBy('updated_at', 'DESC')->get();
        $demandesValides = EtudiantAssurance::where('valide', '=', 1)->where('date_fin', '>=', \Carbon::now())->orderBy('updated_at', 'DESC')->get();
        $demandesExpirees = EtudiantAssurance::where('valide', '=', 1)->where('date_fin', '<', \Carbon::now())->orderBy('updated_at', 'DESC')->get();

        return view('administration.materiel.insurances.index')
            ->with('title', $title)
            ->with('small_title', $small_title)
            ->with('demandesEnAttente', $demandesEnAttente)
            ->with('demandesValides', $demandesValides)
            ->with('demandesExpirees', $demandesExpirees);
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

        $assurance = EtudiantAssurance::findOrFail($id);
        $deb_assurance = $assurance->dateDebutCarbon();
        $fin_assurance = $assurance->dateFinCarbon();

        switch ($request['action']) {
            case "accept":
                // Changement du statut de l'assurance en valide
                $assurance->valide = 1;
                $assurance->save();
                // Mise à jour de toutes les demandes en attente
                foreach($assurance->etudiant->demandes as $demande) {
                    if ($demande->status == -1) {
                        $deb_emprunt = $demande->dateDebutCarbon();
                        $fin_emprunt = $demande->dateFinCarbon();
                        if ($deb_emprunt->gte($deb_assurance) && $fin_emprunt->lte($fin_assurance)) {
                            // Mise à jour du statut de la demande
                            $demande->status = 0;
                            $demande->save();
                            // Envoi d'un mail pour avertir l'étudiant d'un changement de statut
                            $mail = new StatusChanged(route('requests.index'), $demande->id, "Validation de l'assurance");
                            $student = $demande->etudiant;
                            Mail::to($student->email, $student->nomprenom)->send($mail);
                            // Envoi d'un mail pour prévenir les encadrants qu'ils ont une action a réaliser
                            $personnelsToMail = [];
                            foreach ($demande->encadrants as $encadrant) {
                                array_push($personnelsToMail, $encadrant->personnel);
                            }
                            $mail = new ActionRequired(route('administration.materiel.requests.show', ['id' => $demande->id]), $demande->id);
                            foreach ($personnelsToMail as $personnel) {
                                Mail::to($personnel->email, $personnel->nomprenom)->send($mail);
                            }
                        }
                    }
                }
                break;
            case "refuse":
                // Changement du statut de l'assurance en refusé
                $assurance->valide = -1;
                $assurance->save();
                // Mise à jour de toutes les demandes en attente
                foreach($assurance->etudiant->demandes as $demande) {
                    if ($demande->status == -1) {
                        $deb_emprunt = $demande->dateDebutCarbon();
                        $fin_emprunt = $demande->dateFinCarbon();
                        if ($deb_emprunt->gte($deb_assurance) && $fin_emprunt->lte($fin_assurance)) {
                            // Mise à jour du statut de la demande
                            $demande->status = -2;
                            $demande->save();
                            // Envoi d'un mail pour avertir l'étudiant d'un changement de statut
                            $mail = new StatusChanged(route('requests.index'), $demande->id, "Refus de l'assurance");
                            $student = $demande->etudiant;
                            Mail::to($student->email, $student->nomprenom)->send($mail);
                        }
                    }
                }
        }
        toastr()->success(__('validation.request.action.success'));
        return redirect()->back();
    }

}
