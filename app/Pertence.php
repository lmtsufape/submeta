<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertence extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'revisorId', 'areaId',
  ];

  public function user(){
      return $this->belongsTo('App\User', 'revisorId');
  }

  public function area(){
      return $this->belongsTo('App\Area', 'areaId');
  }
}
