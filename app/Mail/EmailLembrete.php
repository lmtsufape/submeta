<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailLembrete extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;
    public $informacoes;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subject, $propostaTitulo, $eventoTitulo, $tipo, $natureza, $arquivo, $acesso)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->propostaTitulo = $propostaTitulo;
        $this->eventoTitulo = $eventoTitulo;
        $this->tipo = $tipo;
        $this->natureza = $natureza;
        $this->arquivo = $arquivo;
        $this->acesso = $acesso;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = storage_path('app').'/'.$this->arquivo;
        if($this->acesso == '1' || $this->acesso == '3'){
            return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                ->subject($this->subject)
                ->view('emails.emailLembreteRevisor')
                ->with([
                    'user' => $this->user,
                    'propostaTitulo' => $this->propostaTitulo,
                    'eventoTitulo'  => $this->eventoTitulo,
                    'tipo' => $this->tipo,
                    'natureza' => $this->natureza,
                    'acesso' => $this->acesso

                ])->attach($file);
        }
        return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
            ->subject($this->subject)
            ->view('emails.emailLembreteRevisor')
            ->with([
                'user' => $this->user,
                'propostaTitulo' => $this->propostaTitulo,
                'eventoTitulo'  => $this->eventoTitulo,
                'tipo' => $this->tipo,
                'natureza' => $this->natureza,
                'acesso' => $this->acesso

            ]);
    }
}
