<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

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
    public function __construct($usuario,$trabalho)
    {
        $this->data =  date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $url = "/avaliador/editais";
        $this->url = url($url);
        $this->user = $usuario;
        $this->titulo = $trabalho->titulo;
        $this->trabalho = $trabalho;
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
                    ->subject('Sistema Submeta - Avaliar proposta / projeto')
                    ->greeting("Saudações!")
                    ->line("Prezado avaliador, você foi convidado a avaliar a proposta / projeto intitulada(o) {$this->titulo}.")
                    ->action('Acessar', $this->url )
                    ->attach(storage_path() . "/app/pdfFormAvalExterno/{$this->trabalho->evento_id}/formulario de avaliação externo.pdf")
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
