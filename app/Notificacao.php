<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lido', 'tipo', 'destinatario_id', 'remetente_id', 'perfil_id', 'trabalho_id', 'solicitacao_certificado_id',
    ];

    public function destinatario(){
        return $this->belongsTo(User::class,'destinatario_id','id');
    }

    public function remetente(){
        return $this->belongsTo(User::class,'remetente_id','id');
    }

    public function trabalho(){
        return $this->belongsTo(Trabalho::class,'trabalho_id','id');
    }

    public function solicitacaoCertificado()
    {
        return $this->belongsTo('\App\SolicitacaoCertificado', 'solicitacao_certificado_id');
    }
}
