<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioIntegranteExterno extends Model
{
    protected $table = 'relatorio_integrantes_externos';

    protected $fillable = [
        'nome',
        'cpf',
        'instituicao_vinculo',
        'ch_total_atuacao',
        'ingresso_proposta',
        'conclusao_proposta',
        'relatorio_id',
    ];
}
