<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitacaoDesligamento extends Mailable
{
    use Queueable, SerializesModels;
    public $edital;
    public $projeto;
    public $tipo;

    public function __construct($edital, $projeto, $tipo = '')
    {
        $this->edital = $edital;
        $this->projeto = $projeto;
        $this->tipo = $tipo;
    }

    public function build(){
        
        return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                    ->subject('Solicitação de Desligamento')
                    ->view('emails.solicitacaoDesligamento')
                    ->with([
                        'edital' => $this->edital,
                        'projeto' => $this->projeto,
                        'tipo' => $this->tipo
                    ]);
    }
}
