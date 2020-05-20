<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nome', 'eventoId',
  ];

  public function modalidade(){
      return $this->hasMany('App\Modalidade', 'areaId');
  }

  public function trabalho(){
      return $this->hasMany('App\Trabalho', 'areaId');
  }

  public function pertence(){
      return $this->hasMany('App\Pertence', 'areaId');
  }

  public function evento(){
      return $this->belongsTo('App\Evento', 'eventoId');
  }

  public function revisor(){
      return $this->hasMany('App\User', 'eventoId');
  }
}
