<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avaliador extends Model
{
  use SoftDeletes;
	protected $fillable = [
      'status',
      'parecer', 
      'AnexoParecer',
      'pivot',
  ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trabalhos(){
        return $this->belongsToMany('App\Trabalho')->withPivot('status', 'AnexoParecer', 'parecer', 'recomendacao', 'created_at');
    }
    public function eventos(){
        return $this->belongsToMany('App\Evento');
    }
    public function area(){
        return $this->belongsTo('App\Area');
    }

}
