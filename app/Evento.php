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
      'nome', 'descricao', 'tipo',
      'inicioSubmissao', 'fimSubmissao', 'inicioRevisao', 'fimRevisao',
      'resultado', 'coordenadorId',
      'numMaxTrabalhos', 'numMaxCoautores', 'hasResumo', 'criador_id'
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

  public function coordenadorComissao(){
      return $this->belongsTo('App\CoordenadorComissao', 'coordenadorId');
  }
  public function trabalhos(){
      return $this->hasMany('App\Trabalho');
  }
  public function avaliadors(){
      return $this->belongsToMany('App\Avaliador')->withPivot('convite', 'created_at');
  }


}
