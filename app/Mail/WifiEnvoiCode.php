<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WifiEnvoiCode extends Mailable
{
    use Queueable, SerializesModels;

    public $codeWifi;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codeWifi)
    {
        $this->codeWifi = $codeWifi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[MYENSIM] Code Wifi')
                    ->view('emails.informatique.wifi_envoi_code')
                    ->with('codeWifi', $this->codeWifi);
    }
}
