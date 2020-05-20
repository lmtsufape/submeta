<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'tituloRecurso', 'corpoRecurso', 'statusAvaliacao', 'trabalhoId', 'comissaoId',
  ];

  public function trabalho(){
      return $this->belongsTo('App\Trabalho', 'trabalhoId');
  }

  public function user(){
      return $this->belongsTo('App\User', 'comissaoId');
  }
}
