<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $emprunt_id;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $emprunt_id, $status)
    {
        $this->link = $link;
        $this->emprunt_id = $emprunt_id;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[ENSIM Inventaire Matériel] Mise à jour du statut votre demande')
                    ->view('emails.statuschanged')
                    ->with('status', $this->status)
                    ->with('emprunt_id', $this->emprunt_id)
                    ->with('link', $this->link);
    }
}
