<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class MailFormulariContacte extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuari)
    {
        $this->usuari = $usuari;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from($this->usuari->email, 'TecnoLord')
            ->subject('Contacte de:'.$this->usuari->email)
            ->markdown('mails.mail_contacte')
            ->with([
                'name' => $this->usuari->nom,
                'telefon' => $this->usuari->telefon,
                'missatge' => $this->usuari->missatge,
                'link' => '',
                'usuari' => $this->usuari,
            ]);
    }
}
