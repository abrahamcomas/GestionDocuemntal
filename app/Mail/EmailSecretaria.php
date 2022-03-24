<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSecretaria extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $DatosEmisor,$DatosReceptor;

    public function __construct($DatosEmisor,$DatosReceptor)
    {
        $this->DatosEmisor = $DatosEmisor;

        $this->DatosReceptor = $DatosReceptor;
    }

    /** 
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Email.Avisos.PortafolioRecibidoODP');
    }
}
