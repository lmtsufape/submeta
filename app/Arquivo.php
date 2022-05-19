<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arquivo extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  use SoftDeletes;
  protected $fillable = [
      'nome','titulo', 'versao', 'versaoFinal', 'data', 'trabalhoId', 'participanteId'
  ];

  public function trabalho(){
      return $this->belongsTo('App\Trabalho', 'trabalhoId');
  }

  public function substituicaos(){
      return $this->hasMany('App\Substituicao');
  }
  
  public function participante() {
      return $this->belongsTo('App\Participante', 'participanteId');
  }
  public function avaliadors(){
    return $this->belongsToMany('App\Avaliador', 'avaliadors_plano_trabalho')->withPivot('status', 'AnexoParecer', 'parecer', 'recomendacao', 'created_at');
  }

    public function avaliacao_relatorios(){
        return $this->hasMany('App\AvaliacaoRelatorio', 'arquivo_id');
    }
}
