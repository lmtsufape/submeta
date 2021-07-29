<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modalidade extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nome',
  ];

  public function trabalho(){
      return $this->hasMany('App\Trabalho', 'modalidadeId');
  }
}
