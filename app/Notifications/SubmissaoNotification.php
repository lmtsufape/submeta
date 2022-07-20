<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubmissaoNotification extends Notification
{
    use Queueable;

    public $data;
    public $url;
    public $natureza_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trabalho)
    {
        $this->data =  date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $url = "/projeto/visualizar/".$trabalho->id;
        $this->url = url($url);
        $this->titulo = $trabalho->titulo;
        $this->natureza_id = $trabalho->evento->natureza_id;
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
        $user = Auth::user();
        return (new MailMessage)
                    ->subject('Sistema Submeta - Submissão de proposta / projeto')
                    ->greeting("Saudações!")
                    ->line("O sistema Submeta recebeu o envio de sua proposta / projeto intitulada(o) {$this->titulo}\n\n.")
                    ->line("{$this->data}")
                    ->action('Acessar Proposta', $this->url )
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
