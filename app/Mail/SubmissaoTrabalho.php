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
    public $evento;
    public $trabalho;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $evento, $trabalho)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->evento = $evento;
        $this->trabalho = $trabalho;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                    ->subject($this->subject)
                    ->view('emails.submissaoTrabalho')
                    ->with([
                        'user' => $this->user,
                        'evento' => $this->evento,
                        'trabalho' => $this->trabalho,
                        
                    ]);
    }
}
