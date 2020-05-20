<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nome', 'descricao', 'tipo', 'dataInicio', 'dataFim',
      'inicioSubmissao', 'fimSubmissao', 'inicioRevisao', 'fimRevisao',
      'inicioResultado', 'fimResultado', 'possuiTaxa', 'valorTaxa', 'fotoEvento',
      'enderecoId', 'coordenadorId',
      'numMaxTrabalhos', 'numMaxCoautores', 'hasResumo',
  ];

  public function endereco(){
      return $this->belongsTo('App\Endereco', 'enderecoId');
  }

  public function atividade(){
      return $this->hasOne('App\Atividade', 'eventoId');
  }

  public function area(){
      return $this->hasOne('App\Area', 'eventoId');
  }

  public function coordenador(){
      return $this->belongsTo('App\User', 'coordenadorId');
  }


}
