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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $nomeUsuarioPai, String $nomeTrabalho, String $nomeFuncao, String $nomeEvento, String $senhaTemporaria)
    {
      $this->nomeUsuarioPai  = $nomeUsuarioPai;
      $this->nomeTrabalho    = $nomeTrabalho;
      $this->nomeFuncao      = $nomeFuncao;
      $this->nomeEvento      = $nomeEvento;
      $this->senhaTemporaria = $senhaTemporaria;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.usuarioNaoCadastrado');
    }
}
