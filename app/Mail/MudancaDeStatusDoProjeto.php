<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MudancaDeStatusDoProjeto extends Mailable
{
    use Queueable, SerializesModels;

    public $trabalho;
    public $usuario;
    public $assunto;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario, $trabalho)
    {
        $this->usuario = $usuario;
        $this->assunto = "O projeto " . strval($trabalho->titulo) . " foi " . strval($trabalho->status);
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
                    ->subject($this->assunto)
                    ->view('emails.mudancaDeStatusDoProjeto')
                    ->with([
                        'user' => $this->usuario,
                        'comentario' => $this->trabalho->comentario,
                    ]);
    }
}
