<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atribuicao extends Model
{
  use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'confirmacao', 'parecer','revisorId', 'trabalhoId',
  ];

  public function revisor(){
      return $this->belongsTo('App\Revisor', 'revisorId');
  }

  public function trabalho(){
      return $this->belongsTo('App\Trabalho', 'trabalhoId');
  }
}
