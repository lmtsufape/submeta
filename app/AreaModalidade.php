<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaModalidade extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'areaId', 'modalidadeId',
  ];

  public function area(){
      return $this->belongsTo('App\Area', 'areaId');
  }

  public function modalidade(){
      return $this->belongsTo('App\Modalidade', 'modalidadeId');
  }
}
