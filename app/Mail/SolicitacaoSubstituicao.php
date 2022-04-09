<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitacaoSubstituicao extends Mailable{

    use Queueable, SerializesModels;
    public $edital;
    public $projeto;
    public $tipo;

    public function __construct($edital, $projeto, $tipo = '',$sub, $status = '')
    {
        $this->edital = $edital;
        $this->projeto = $projeto;
        $this->tipo = $tipo;
        $this->sub = $sub;
        $this->status = $status;
    }

    public function build(){

        if($this->tipo==null){
            return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                ->subject('Sistema Submeta - Solicitação de substituição')
                ->view('emails.solicitacaoSubstituicao')
                ->with([
                    'edital' => $this->edital,
                    'projeto' => $this->projeto,
                    'tipo' => $this->tipo,
                    'sub' => $this->sub,
                    'status' => $this->status
                ]);
        }else{
            return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                ->subject('Sistema Submeta - Resultado da avaliação de pedido de substituição de estudante')
                ->view('emails.solicitacaoSubstituicao')
                ->with([
                    'edital' => $this->edital,
                    'projeto' => $this->projeto,
                    'tipo' => $this->tipo,
                    'sub' => $this->sub,
                    'status' => $this->status
                ]);
        }

    }
}