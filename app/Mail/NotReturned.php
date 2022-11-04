<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotReturned extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $emprunt_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $emprunt_id)
    {
        $this->link = $link;
        $this->emprunt_id = $emprunt_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[ENSIM Inventaire Matériel] Matériel non rendu')
                    ->view('emails.notreturned')
                    ->with('link', $this->link)
                    ->with('emprunt_id', $this->emprunt_id);
    }
}
