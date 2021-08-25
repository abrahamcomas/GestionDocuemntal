<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarPasword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $datos,$token;

    public function __construct($datos,$token)
    {
        $this->datos = $datos;

        $this->token = $token;
    }

    /** 
     * Build the message.
     * 
     * @return $this
     */
    public function build()
    {
        return $this->view('Email.RecuperarPass');
    }
}
