<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AtribuicaoAvaliadorExternoNotification extends Notification
{
    use Queueable;

    public $data;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($usuario, $trabalho, $arquivo, $tipoAval, $avaliacao)
    {
        $this->data = date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $url = '/avaliador/editais';
        $this->url = url($url);
        $this->user = $usuario;
        $this->titulo = $trabalho->titulo;
        $this->trabalho = $trabalho;
        $this->arquivo = $arquivo;
        $this->tipoAval = $tipoAval;
        $this->avaliacao = $avaliacao;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {   
        if ($this->tipoAval == 2 || $this->avaliacao != "form") {
            return (new MailMessage())
                    ->subject('Convite para avaliar proposta de projeto - Sistema Submeta')
                    ->greeting('Saudações!')
                    ->line("Prezado/a avaliador/a, você foi convidado/a a avaliar a proposta de projeto intitulada {$this->titulo}.")
                    // ->line("Seção de Editais e Apoios a Projetos  - PREC/UFAPE")
                    ->action('Acessar', $this->url)
                    ->markdown('vendor.notifications.email');
        }

        return (new MailMessage())
                    ->subject('Convite para avaliar proposta de projeto - Sistema Submeta')
                    ->greeting('Saudações!')
                    ->line("Prezado/a avaliador/a, você foi convidado/a a avaliar a proposta de projeto intitulada {$this->titulo}.")
                    ->line('Aproveitamos para enviar, em anexo, o formulário de avaliação que deverá ser anexado ao sistema Submeta com o seu parecer.')
                    // ->line('Seção de Editais e Apoios a Projetos  - PREC/UFAPE')
                    ->action('Acessar', $this->url)
                    ->attach(storage_path('app').'/'.$this->arquivo)
                    ->markdown('vendor.notifications.email');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
