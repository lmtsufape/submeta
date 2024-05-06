<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioIntegranteInterno extends Model
{
    protected $table = 'relatorio_integrantes_internos';

    protected $fillable = [
        'tipo',
        'tipo_vinculo',
        'nome',
        'cpf',
        'curso_setor',
        'curso_graduacao',
        'ingresso_proposta',
        'conclusao_proposta',
        'ch_total_atuacao',
    ];
}
