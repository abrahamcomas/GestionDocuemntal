<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * 
     * @return void
     */
    public $Titulo,$Nombres,$Contenido,$Email;

    public function __construct($Titulo,$Nombres,$Contenido,$Email)
    {
        $this->Titulo = $Titulo;

        $this->Nombres = $Nombres;
        
        $this->Contenido = $Contenido;

        $this->Email = $Email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Email.Avisos.EnviarLink');
    }
}
