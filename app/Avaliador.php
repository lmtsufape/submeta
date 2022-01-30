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
      'tipo',
  ];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trabalhos(){
        return $this->belongsToMany('App\Trabalho')->withPivot('status', 'AnexoParecer', 'parecer', 'recomendacao', 'created_at');
    }
    public function planoTrabalhos(){
        return $this->belongsToMany('App\Arquivo', 'avaliadors_plano_trabalho')->withPivot('status', 'AnexoParecer', 'parecer', 'recomendacao', 'created_at');
    }
    public function eventos(){
        return $this->belongsToMany('App\Evento')->withPivot('convite', 'created_at');
    }
    public function area(){
        return $this->belongsTo('App\Area');
    }

}
