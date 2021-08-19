<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabalho extends Model
{

  use SoftDeletes;
  //   'rascunho','submetido', 'avaliado', 'corrigido','aprovado','reprovado', 'arquivado'
  protected $fillable = [
      'titulo',
      'data', 
      'aprovado',
      'status',
      'decisaoCONSU',      
      'pontuacaoPlanilha', 
      'linkGrupoPesquisa',
      'linkLattesEstudante',      

      'anexoDecisaoCONSU',
      'anexoAutorizacaoComiteEtica',
      'JustificativaAutorizacaoEtica',
      'anexoLattesCoordenador',
      'anexoGrupoPesquisa',
      'anexoPlanilhaPontuacao',
      'anexoProjeto',

      'grande_area_id',
      'area_id',
      'sub_area_id',
      'evento_id', 
      'proponente_id',
      'coordenador_id',
      'proponente_id',
      'pivot',
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
      return $this->belongsTo('App\Area');
  }
  public function grandeArea(){
      return $this->belongsTo('App\GrandeArea');
  }
  public function subArea(){
      return $this->belongsTo('App\SubArea');
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
    // return $this->belongsToMany('App\Trabalho', 'trabalho_participante');
      return $this->hasMany('App\Participante', 'trabalho_id');
  }
  public function proponente(){
      return $this->belongsTo('App\Proponente');
  }
  public function coordenador(){
      return $this->belongsTo('App\CoordenadorComissao');
  }
  public function avaliadors(){
      return $this->belongsToMany('App\Avaliador')->withPivot('status', 'AnexoParecer', 'parecer', 'recomendacao', 'created_at');
  }
}
