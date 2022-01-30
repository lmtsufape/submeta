<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participante extends Model
{
    use SoftDeletes;
    public const ENUM_TURNO = ['Matutino',  'Vespertino', 'Noturno', 'Integral'];

	protected $fillable = ['rg', 'data_de_nascimento', 'curso', 'participante_id', 'turno',
        'ordem_prioridade', 'periodo_atual', 'total_periodos', 'media_do_curso', 'linkLattes',
        'tipoBolsa', 'data_entrada', 'data_saida'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function participanteSubstituido(){
        return $this->hasMany('App\Substituicao');
    }

    public function participanteSubstituto(){
        return $this->hasMany('App\Substituicao');
    }

    public function trabalhos(){
      return $this->belongsToMany('App\Trabalho', 'trabalho_participante');
  	}

    public function planoTrabalho() {
        return $this->hasOne('App\Arquivo', 'participanteId');
    }
}
