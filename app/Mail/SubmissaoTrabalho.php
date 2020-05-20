<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissaoTrabalho extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject)
    {
        $this->user = $user;
        $this->subject = $subject;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from('lmtsteste@gmail.com', 'Eventos - LMTS')
                    ->subject($this->subject)
                    ->view('emails.submissaoTrabalho');
    }
}
