<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'titulo', 'autores', 'data', 'modalidadeId', 'areaId', 'autorId', 'eventoId', 'resumo', 'avaliado'
  ];

  public function recurso(){
      return $this->hasMany('App\Recurso', 'trabalhoId');
  }

  public function arquivo(){
      return $this->hasMany('App\Arquivo', 'trabalhoId');
  }

  public function modalidade(){
      return $this->belongsTo('App\Modalidade', 'modalidadeId');
  }

  public function area(){
      return $this->belongsTo('App\Area', 'areaId');
  }

  public function autor(){
      return $this->belongsTo('App\User', 'autorId');
  }

  public function coautor(){
      return $this->hasMany('App\Coautor', 'trabalhoId');
  }

  public function parecer(){
      return $this->hasMany('App\Parecer', 'trabalhoId');
  }

  public function atribuicao(){
      return $this->hasMany('App\Atribuicao', 'trabalhoId');
  }

  public function evento(){
      return $this->belongsTo('App\Evento', 'eventoId');
  }
}
