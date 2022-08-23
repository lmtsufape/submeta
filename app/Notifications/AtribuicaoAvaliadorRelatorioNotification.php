<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AtribuicaoAvaliadorRelatorioNotification extends Notification
{
    use Queueable;
    public $data;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tipoAval, $plano, $trabalho, $usuario)
    {
        $this->data =  date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $url = "/trabalho/planos/avaliacoes/index";
        $this->url = url($url);
        $this->user = $usuario;
        $this->titulo = $trabalho->titulo;
        $this->trabalho = $trabalho;
        $this->plano = $plano;
        $this->tipoAval = $tipoAval;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("Convite para avaliar Relatório {$this->tipoAval} - Sistema Submeta")
                    ->greeting("Saudações!")
                    ->line("Prezado/a avaliador/a, você foi convidado/a a avaliar o relatório {$this->tipoAval} do plano de trabalho {$this->plano->titulo}, pertencente ao projeto intitulado {$this->titulo}.")
                    ->action('Acessar', $this->url )
                    ->markdown('vendor.notifications.email');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
