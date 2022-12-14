<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvaliacaoTrabalho extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nota',
        'avaliador_id',
        'campo_avaliacao_id',
        'trabalho_id',
    ];

    public function trabalho(){
        return $this->belongsTo('App\Trabalho');
    }

    public function avaliador(){
        return $this->belongsTo('App\Avaliador');
    }


    public function campoAvaliacao(){
        return $this->belongsTo('App\CampoAvaliacao');
    }
}
