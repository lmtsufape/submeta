<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nome', 'versao', 'versaoFinal', 'data', 'trabalhoId',
  ];

  public function trabalho(){
      return $this->belongsTo('App\Trabalho', 'trabalhoId');
  }
}
