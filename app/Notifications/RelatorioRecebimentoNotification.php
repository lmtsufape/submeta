<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RelatorioRecebimentoNotification extends Notification
{
    use Queueable;

    public $data;
    public $url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id,$usuario,$eventoTitulo,$trabalhoTitulo,$tipoRelatorio)
    {
        $this->data =  date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $url = "/projeto/planosTrabalho/".$id;
        $this->url = url($url);
        $this->editalNome = $eventoTitulo;
        $this->trabalhoNome = $trabalhoTitulo;
        $this->user = $usuario;
        $this->tipo = $tipoRelatorio;
        $this->subject ="Sistema Submeta - Recebimento de Relatório {$this->tipo}";

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
                    ->subject($this->subject)
                    ->greeting("Saudações!")
                    ->line("O(A) proponente / coordenador(a) do projeto {$this->trabalhoNome} vinculado ao edital {$this->editalNome} do Submeta submeteu Relatório {$this->tipo} para avaliação.")
                    ->line("Solicitamos gentilmente que acesse o sistema Submeta para avaliar o documento.")
                    ->action('Acessar Relatório', $this->url )
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
