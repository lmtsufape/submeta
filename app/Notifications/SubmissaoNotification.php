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
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->data =  date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $url = "/projeto/visualizar/".$id;
        $this->url = url($url);
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
                    ->subject('Submissão de Proposta')
                    ->greeting("Olá, {$user->name}!")
                    ->action('Acessar Formulário', $this->url )
                    ->line("O sistema de recepção de formulários eletrônicos do Submeta registra que em {$this->data}, o formulário identificado acima foi recebido e reconhecido no Submeta")
                    ->line('Obrigado por usar o nosso sistema.')
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
