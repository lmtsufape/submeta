<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coautor extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'ordem','autorId', 'trabalhoId',
  ];

  public function user(){
      return $this->belongsTo('App\User', 'autorId');
  }

  public function trabalho(){
      return $this->belongsTo('App\Trabalho', 'trabalhoId');
  }
}
