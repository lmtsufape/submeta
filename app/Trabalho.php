<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabalho extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'titulo',
      'data', 
      'avaliado',
      'decisaoCONSU',      
      'pontuacaoPlanilha', 
      'linkGrupoPesquisa',
      'linkLattesEstudante',      

      'anexoDecisaoCONSU',
      'anexoAutorizacaoComiteEtica',
      'anexoLattesCoordenador',
      'anexoPlanilhaPontuacao',
      'anexoProjeto',

      'grande_area_id',
      'area_id',
      'sub_area_id',
      'evento_id', 
      'proponente_id',
      'coordenador_id',
  ];

  public function recurso(){
      return $this->hasMany('App\Recurso', 'trabalhoId');
  }

  public function arquivo(){
      return $this->hasMany('App\Arquivo', 'trabalhoId');
  }

  public function modalidade(){
      return $this->belongsTo('App\Modalidade', 'modalidadeId');
  }

  public function area(){
      return $this->belongsTo('App\Area', 'areaId');
  }

  public function autor(){
      return $this->belongsTo('App\User', 'autorId');
  }

  public function coautor(){
      return $this->hasMany('App\Coautor', 'trabalhoId');
  }

  public function parecer(){
      return $this->hasMany('App\Parecer', 'trabalhoId');
  }

  public function atribuicao(){
      return $this->hasMany('App\Atribuicao', 'trabalhoId');
  }

  public function evento(){
      return $this->belongsTo('App\Evento');
  }
  public function planoTrabalho(){
      return $this->hasMany('App\PlanoTrabalho');
  }
  public function participantes(){
      return $this->belongsToMany('App\Participante', 'trabalho_participante');
  }
  public function proponentes(){
      return $this->belongsToMany('App\Proponente', 'trabalho_proponente');
  }
  public function coordenador(){
      return $this->belongsTo('App\CoordenadorComissao');
  }
  public function avaliadors(){
      return $this->belongsToMany('App\Avaliador');
  }
}
