<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Substituicao extends Model
{
    //

    protected $fillable = [
        'status',
        'tipo',
        'justificativa',
        'causa',
        'observacao',
        'participanteSubstituido_id',
        'participanteSubstituto_id'
    ];

    public function participanteSubstituido(){
        return $this->belongsTo('App\Participante', 'participanteSubstituido_id');
    }

    public function participanteSubstituto(){
        return $this->belongsTo('App\Participante', 'participanteSubstituto_id');
    }

    public function planoSubstituto(){
        return $this->belongsTo('App\Arquivo', 'planoSubstituto_id');
    }

    public function trabalho(){
        return $this->belongsTo('App\Trabalho');
    }

}
