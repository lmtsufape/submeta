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
        return $this->belongsToMany('App\Trabalho')->withPivot('status', 'AnexoParecer', 'parecer', 'recomendacao', 'created_at','pontuacao','acesso');
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
    public function parecer_internos(){
        return $this->hasMany(ParecerInterno::class, 'avali_id', 'id');
    }

    public function naturezas(){
        return $this->belongsToMany('App\Natureza', 'naturezas_avaliadors', 'avaliador_id');
    }

    public function areaTematicas() {
        return $this->belongsToMany('App\AreaTematica', 'area_tematica_avaliadors', 'avaliador_id');
    }

    public function avaliacaoTrabalho(){
        return $this->hasMany('App\AvaliacaoTrabalho');
    }
}
