<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WifiNouvelleDemande extends Mailable
{
    use Queueable, SerializesModels;

    public $codeWifi;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($lien,$demandeur)
    {
        $this->lien = $lien;
        $this->demandeur = $demandeur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[MYENSIM] Nouvelle demande de code Wifi')
                    ->view('emails.informatique.wifi_demande_code')
                    ->with('lien', $this->lien)
                    ->with('demandeur', $this->demandeur);
    }
}
