<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParecerInterno extends Model
{

    protected $fillable = [
        'statusLinkGrupoPesquisa',
        'statusLinkLattesProponente',
        'statusAnexoProjeto',
        'statusAnexoDecisaoCONSU',
        'statusAnexoPlanilhaPontuacao',
        'statusAnexoLattesCoordenador',
        'statusAnexoGrupoPesquisa',
        'statusAnexoAtuorizacaoComiteEtica',
        'statusJustificativaAutorizacaoEtica',
        'statusParecer',
        'statusPlanoTrabalho',
        'comentario',

        'trabalho_id',
        'avaliador_id',
    ];

    public function trabalho(){
        return $this->belongsTo(Trabalho::class, 'trab_id', 'id');
    }
    public function avaliador(){
        return $this->belongsTo(Avaliador::class, 'avali_id', 'id');
    }
}
