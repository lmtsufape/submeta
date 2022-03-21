<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoCertificado extends Model
{

    protected $table = "solicitacoes_certificados";

    protected $fillable = [
        'trabalho_id'
    ];

    public function solicitacoesParticipantes()
    {
        return $this->hasMany('App\SolicitacaoParticipante', 'solicitacao_certificado_id');
    }
}
