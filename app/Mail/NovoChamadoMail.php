<?php

namespace App\Mail;

use App\Models\Chamado;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovoChamadoMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $chamado;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Chamado $chamado)
    {
        $this->chamado = $chamado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $usuario = $this->chamado->usuario ?? null;

        if (! $usuario) {
            return;
        }

        $name = $usuario->name;

        return $this->view('emails.novo_chamado', [
            'name' => $name,
            'chamado' => $this->chamado,
        ]);
    }
}
