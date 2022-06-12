<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailParaUsuarioNaoCadastrado extends Mailable
{
    use Queueable, SerializesModels;
    public $nomeUsuarioPai;
    public $nomeTrabalho;
    public $nomeFuncao;
    public $nomeEvento;
    public $senhaTemporaria;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $nomeUsuarioPai, String $nomeTrabalho, String $nomeFuncao, String $nomeEvento, String $senhaTemporaria,  String $subject, String $tipo, String $natureza, String $arquivo)
    {
      $this->nomeUsuarioPai  = $nomeUsuarioPai;
      $this->nomeTrabalho    = $nomeTrabalho;
      $this->nomeFuncao      = $nomeFuncao;
      $this->nomeEvento      = $nomeEvento;
      $this->senhaTemporaria = $senhaTemporaria;
      $this->subject         = $subject;
      $this->tipoEvento      = $tipo;
      $this->natureza      = $natureza;
      $this->arquivo     = $arquivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->nomeFuncao != 'Participante'){
                $file = storage_path('app').'/'.$this->arquivo;
                return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                        ->subject($this->subject)
                        ->view('emails.usuarioNaoCadastrado')
                        ->with([
                            'nomeUsuarioPai' => $this->nomeUsuarioPai,
                            'nomeTrabalho' => $this->nomeTrabalho,    
                            'nomeFuncao' => $this->nomeFuncao,      
                            'nomeEvento' => $this->nomeEvento,      
                            'senhaTemporaria' => $this->senhaTemporaria,
                            'tipoEvento' => $this->tipoEvento,
                            'natureza' => $this->natureza
                            
                        ])->attach($file);
        }else{
            return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                        ->subject($this->subject)
                        ->view('emails.usuarioNaoCadastrado')
                        ->with([
                            'nomeUsuarioPai' => $this->nomeUsuarioPai,
                            'nomeTrabalho' => $this->nomeTrabalho,    
                            'nomeFuncao' => $this->nomeFuncao,      
                            'nomeEvento' => $this->nomeEvento,      
                            'senhaTemporaria' => $this->senhaTemporaria,
                            'tipoEvento' => $this->tipoEvento,
                            'natureza' => $this->natureza
                            
                        ]);
        }
    
    }
}
