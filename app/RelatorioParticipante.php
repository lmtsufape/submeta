<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioParticipante extends Model
{
    protected $table = 'relatorio_participantes';

    protected $fillable = [
        'nome',
        'cpf',
        'carga_horaria',
        'relatorio_id',
    ];
}
