<?php

namespace App\Notifications;

use App\Proponente;
use App\Trabalho;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class SolicitacaoCertificadoNotification extends Notification
{
    use Queueable;

    public $proponente;
    public $trabalho;
    public $destinatario;
    public $users;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Proponente $proponente, Trabalho $trabalho, User $destinatario, $users)
    {
        $this->proponente = $proponente;
        $this->trabalho = $trabalho;
        $this->destinatario = $destinatario;
        $this->users = $users;
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
        $nomes = $this->users
            ->reject(function ($value, $key) {
                return $value->name == $this->proponente->user->name;
            })->map(function($user) {
                return $user->name;
            })->implode(', ');
        $qtd = $this->users->count();
        return (new MailMessage)
            ->subject('Recebimento de solicitação de certificado/declaração')
            ->greeting("Olá, {$notifiable->name}!")
            ->line("O proponente ". $this->proponente->user->name . " registrou uma solicitação de certificado/declaração para ". Str::plural('o', $qtd) . ' ' .  Str::plural('seguinte', $qtd) . ' ' . Str::plural('discente', $qtd) . ': ' . $nomes)
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
