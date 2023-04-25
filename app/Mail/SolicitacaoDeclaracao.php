<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitacaoDeclaracao extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $trabalho;
    public $evento;
    

    public function __construct($user, $trabalho, $evento = '')
    {
        $this->user = $user;
        $this->trabalho = $trabalho;
        $this->evento = $evento;
    }

    public function build(){
        
        return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                    ->subject('Solicitação de Declaração')
                    ->view('emails.solicitacaoDeclaracao')
                    ->with([
                        'user' => $this->user,
                        'trabalho' => $this->trabalho,
                        'evento' => $this->evento,
                    ]);
    }
}
