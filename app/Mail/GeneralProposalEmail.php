<?php

namespace App\Mail;

use App\Models\Chamado;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneralProposalEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $email_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $email_data)
    {
        $email_collect_data = collect($email_data);
        if(!$email_collect_data->has([
            'email_subject',
            'email_content',
        ]))
        {
            throw new \Exception("Os dados passados são inválidos", 1);
        }

        $this->email_data = $email_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.general-proposal', $this->email_data)
                    ->subject($this->email_data['email_subject'] ?? 'E-mail do suporte');
    }
}
