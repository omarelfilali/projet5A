<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductAvailable extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $product;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $product)
    {
        $this->link = $link;
        $this->product = $product;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[ENSIM Inventaire Matériel] '.$this->product.' est à nouveau disponible !')
                    ->view('emails.productavailable')
                    ->with('product', $this->product)
                    ->with('link', $this->link);
    }
}
