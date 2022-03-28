<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoParticipante extends Model
{
    protected $table = "solicitacoes_participantes";

    protected $fillable = [
        'solicitacao_certificado_id', 'user_id'
    ];

    public function solicitacaoCertificado()
    {
        return $this->belongsTo('App\SolicitacaoCertificado', 'solicitacao_certificado_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
