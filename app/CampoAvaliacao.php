<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampoAvaliacao extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nome',
        'nota_maxima',
        'descricao',
        'prioridade',
        'evento_id',
    ];

    public function evento(){
        return $this->belongsTo('App\Evento');
    }

    public function avaliacaoTrabalho(){
        return $this->hasMany('App\AvaliacaoTrabalho');
    }
}
