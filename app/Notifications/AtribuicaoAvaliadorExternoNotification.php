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
    public function __construct($usuario, $trabalho, $evento, $tipoAval, $avaliacao)
    {
        $this->data = date('d/m/Y \à\s  H:i\h', strtotime(now()));
        $url = '/avaliador/editais';
        $this->url = url($url);
        $this->user = $usuario;
        $this->titulo = $trabalho->titulo;
        $this->trabalho = $trabalho;
        $this->arquivo = $evento->formAvaliacaoExterno;
        $this->tipoAval = $tipoAval;
        $this->avaliacao = $avaliacao;
        $this->tipoEvento = $evento->tipo;
        $this->naturezaEventoId = $evento->natureza_id;
        $this->dataFinalaval = date('d/m/Y', strtotime($evento->fimRevisao));
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

        //NaturezaEventoId == 3 é Extensão
        if($this->tipoEvento == 'PIBEX' && $this->naturezaEventoId == 3)
        {
            return (new MailMessage())
                ->subject('Convite para avaliar proposta de projeto - Sistema Submeta')
                ->greeting('Prezado/a avaliador/a,')
                ->line('Saudações!')
                ->line("O/A senhor/a foi convidado/a a avaliar a proposta de projeto de Extensão da UFAPE intitulada \"{$this->titulo}\".")
                ->line("Caso o/a senhor/a tenha disponibilidade de tempo para realizar a avaliação, solicitamos por gentileza que o seu parecer seja enviado até o prazo do dia {$this->dataFinalaval}, para que possamos dar continuidade com os trâmites previstos no edital PIBEX 2023.")
                ->line('Aproveitamos esse e-mail para enviar, em anexo, o formulário de avaliação que deverá ser anexado ao sistema Submeta da UFAPE com o seu parecer.')
                ->line('Novamente agradecemos a vossa disponibilidade em participar do banco de avaliadores/as dos projetos de Extensão da UFAPE.')
                ->line('')
                ->line('Por favor, acesse o sistema Submeta através do link abaixo para visualizar e baixar a Proposta de Projeto e Plano de Trabalho.')
                ->action('Link de Acesso', $this->url)
                ->line('')
                ->line('Em casos de dúvidas, por favor entrar em contato pelo e-mail editais.prec@ufape.edu.br.')
                ->line('')
                ->line('Seção de Editais e Apoio à Projetos e Programas')
                ->line('Pró-reitoria de Extensão e Cultura - PREC')
                ->attach(storage_path('app').'/'.$this->arquivo)
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
