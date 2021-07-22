<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailParaUsuarioNaoCadastrado extends Mailable
{
    use Queueable, SerializesModels;
    public $nomeUsuarioPai;
    public $nomeTrabalho;
    public $nomeFuncao;
    public $nomeEvento;
    public $senhaTemporaria;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $nomeUsuarioPai, String $nomeTrabalho, String $nomeFuncao, String $nomeEvento, String $senhaTemporaria,  String $subject, String $tipo)
    {
      $this->nomeUsuarioPai  = $nomeUsuarioPai;
      $this->nomeTrabalho    = $nomeTrabalho;
      $this->nomeFuncao      = $nomeFuncao;
      $this->nomeEvento      = $nomeEvento;
      $this->senhaTemporaria = $senhaTemporaria;
      $this->subject         = $subject;
      $this->tipoEvento      = $tipo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->nomeFuncao != 'Participante'){
            if($this->tipoEvento == 'PIBITI'){
                $file1 = public_path().'/ParecerProjetoPIBITI2021-2021.xlsx';
                $file2 = public_path().'/TermoDeConfidencialidade-AvaliadorExterno.doc';
                return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                        ->subject($this->subject)
                        ->view('emails.usuarioNaoCadastrado')
                        ->with([
                            'nomeUsuarioPai' => $this->nomeUsuarioPai,
                            'nomeTrabalho' => $this->nomeTrabalho,    
                            'nomeFuncao' => $this->nomeFuncao,      
                            'nomeEvento' => $this->nomeEvento,      
                            'senhaTemporaria' => $this->senhaTemporaria,
                            'tipoEvento' => $this->tipoEvento 
                            
                        ])->attach($file1, [
                            'as' => 'ParecerProjetoPIBITI2021-2021.xlsx',
                            'mime' => 'application/xlsx',
                        ])->attach($file2, [
                            'as' => 'TermoDeConfidencialidade-AvaliadorExterno.doc',
                            'mime' => 'application/doc',
                        ]);
            }else{
                $file = public_path().'/ModeloFormularioAvaliadorExternoPIBIC.docx';
                return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                        ->subject($this->subject)
                        ->view('emails.usuarioNaoCadastrado')
                        ->with([
                            'nomeUsuarioPai' => $this->nomeUsuarioPai,
                            'nomeTrabalho' => $this->nomeTrabalho,    
                            'nomeFuncao' => $this->nomeFuncao,      
                            'nomeEvento' => $this->nomeEvento,      
                            'senhaTemporaria' => $this->senhaTemporaria,
                            'tipoEvento' => $this->tipoEvento 
                            
                        ])->attach($file, [
                            'as' => 'ModeloFormularioAvaliadorExternoPIBIC.docx',
                            'mime' => 'application/docx',
                        ]);
            }
        }else{
            return $this->from('lmtsteste@gmail.com', 'Submeta - LMTS')
                        ->subject($this->subject)
                        ->view('emails.usuarioNaoCadastrado')
                        ->with([
                            'nomeUsuarioPai' => $this->nomeUsuarioPai,
                            'nomeTrabalho' => $this->nomeTrabalho,    
                            'nomeFuncao' => $this->nomeFuncao,      
                            'nomeEvento' => $this->nomeEvento,      
                            'senhaTemporaria' => $this->senhaTemporaria,
                            'tipoEvento' => $this->tipoEvento 
                            
                        ]);
        }
    
    }
}
