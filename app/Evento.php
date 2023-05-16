<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class Evento extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'nome', 'descricao', 'tipo',
      'inicioSubmissao', 'fimSubmissao', 'inicioRevisao', 'fimRevisao',
      'resultado_final','resultado_preliminar', 'coordenadorId',
      'numMaxTrabalhos', 'numMaxCoautores', 'hasResumo', 'criador_id', 'numParticipantes',
      'dt_inicioRelatorioParcial', 'dt_fimRelatorioParcial', 'dt_inicioRelatorioFinal', 'dt_fimRelatorioFinal',
      'formAvaliacaoExterno', 'formAvaliacaoInterno',
      'cotaDoutor', 'inicioProjeto', 'fimProjeto',
      'formAvaliacaoRelatorio', 'docTutorial'
  ];

  #validação para as datas dos editais padrão
  public static $dates_rules = [
    'inicioSubmissao'           => ['required', 'date'],
    'fimSubmissao'              => ['required', 'date'],
    'inicioRevisao'             => ['required', 'date'],
    'fimRevisao'                => ['required', 'date'],
    'inicio_recurso'            => ['required', 'date'],
    'fim_recurso'               => ['required', 'date'],
    'resultado_final'           => ['required', 'date'],
    'resultado_preliminar'      => ['required', 'date'],
    'dt_inicioRelatorioParcial' => ['exclude_if:tipo,PIBEX', 'required', 'date'],
    'dt_fimRelatorioParcial'    => ['exclude_if:tipo,PIBEX', 'required', 'date'],
    'dt_inicioRelatorioFinal'   => ['required', 'date'],
    'dt_fimRelatorioFinal'      => ['required', 'date'],
    'inicioProjeto'             => ['required', 'date'],
    'fimProjeto'                => ['required', 'date'],
    //'modeloDocumento'     => [],
  ];

  #validação para as datas dos editais de fluxo continuo
  public static $continuos_dates_rules = [
    'inicioSubmissao'           => ['required', 'date'],
    'fimSubmissao'              => ['required', 'date'],
  ];

  #validação completa dos dados de editais padrão
  public static $rules = [
    'nome'                      => ['required', 'string'],
    'descricao'                 => ['required', 'string','max:1500'],
    'tipo'                      => ['required', 'string'],
    'natureza'                  => ['required'],
    'coordenador_id'            => ['required'],
    'numParticipantes'          => ['required'],
    'nome_docExtra'             => ['required_with:check_docExtra','max:255'],
    'tipoAvaliacao'             => ['required'],
    'inicioSubmissao'           => ['required', 'date', 'after:yesterday'],
    'fimSubmissao'              => ['required', 'date', 'after_or_equal:inicioSubmissao'],
    'inicioRevisao'             => ['required', 'date', 'after:yesterday'],
    'fimRevisao'                => ['required', 'date', 'after:inicioRevisao', 'after:fimSubmissao'],
    'resultado_preliminar'      => ['required', 'date', 'after_or_equal:fimRevisao'],
    'inicio_recurso'            => ['required', 'date', 'after_or_equal:resultado_preliminar'],
    'fim_recurso'               => ['required', 'date', 'after:inicio_recurso'],
    'resultado_final'           => ['required', 'date', 'after:fim_recurso'],
    'dt_inicioRelatorioParcial' => ['exclude_if:tipo,PIBEX', 'required', 'date', 'after:resultado_final'],
    'dt_fimRelatorioParcial'    => ['exclude_if:tipo,PIBEX', 'required', 'date', 'after_or_equal:dt_inicioRelatorioParcial'],
    'dt_inicioRelatorioFinal'   => ['required', 'date', 'after:dt_fimRelatorioParcial'],
    'dt_fimRelatorioFinal'      => ['required', 'date', 'after_or_equal:dt_inicioRelatorioFinal'],
    'pdfEdital'                 => [('pdfEditalPreenchido'!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],
    'inicioProjeto'             => ['required', 'date', 'after:yesterday'],
    'fimProjeto'                => ['required', 'date', 'after_or_equal:fimSubmissao'],
  ];

  #validação completa dos dados de editais de fluxo continuo
  public static $continuos_rules = [
    'nome'                => ['required', 'string'],
    'descricao'           => ['required', 'string','max:1500'],
    'tipo'                => ['required', 'string'],
    'natureza'            => ['required'],
    'coordenador_id'      => ['required'],
    'numParticipantes'    => ['required'],
    'nome_docExtra'       => ['required_with:check_docExtra','max:255'],
    'tipoAvaliacao'       => ['required'],
    'inicioSubmissao'     => ['required', 'date', 'after:yesterday'],
    'fimSubmissao'        => ['required', 'date', 'after_or_equal:inicioSubmissao'],
    'pdfEdital'           => [('pdfEditalPreenchido'!=='sim'?'required':''), 'file', 'mimes:pdf', 'max:2048'],
  ];

  public static $edit_rules = [
    'nome'                => ['required', 'string'],
    'descricao'           => ['required', 'string', 'max:1500'],
    'tipo'                => ['required', 'string'],
    'natureza'            => ['required'],
    'numParticipantes'    => ['required'],
    'tipoAvaliacao'       => ['required'],
    'inicioSubmissao'     => ['required', 'date', 'after_or_equal:inicioSubmissao'],
    'fimSubmissao'        => ['required', 'date', 'after_or_equal:inicioSubmissao'],
    'inicioRevisao'       => ['required', 'date', 'after:fimSubmissao'],
    'fimRevisao'          => ['required', 'date', 'after:inicioRevisao'],
    'resultado_preliminar'=> ['required', 'date', 'after_or_equal:fimRevisao'],
    'inicio_recurso'      => ['required', 'date', 'after_or_equal:resultado_preliminar'],
    'fim_recurso'         => ['required', 'date', 'after:inicio_recurso'],
    'resultado_final'     => ['required', 'date', 'after:fim_recurso'],
    'dt_inicioRelatorioParcial'  => ['exclude_if:tipo,PIBEX', 'required', 'date', 'after:resultado_final'],
    'dt_fimRelatorioParcial'     => ['exclude_if:tipo,PIBEX', 'required', 'date', 'after_or_equal:dt_inicioRelatorioParcial'],
    'dt_inicioRelatorioFinal'  => ['required', 'date', 'after:dt_fimRelatorioParcial'],
    'dt_fimRelatorioFinal'     => ['required', 'date', 'after_or_equal:dt_inicioRelatorioFinal'],
    'modeloDocumento'     => ['file', 'mimes:zip,doc,docx,odt,pdf', 'max:2048'],
    'pdfFormAvalExterno'           => ['file', 'mimes:pdf,doc,docx,xlsx,xls,csv,zip', 'max:2048'],
    'inicioProjeto'       => ['required', 'date', 'after:resultado_final'],
    'fimProjeto'          => ['required', 'date', 'after:inicioProjeto'],
    'docTutorial'     => ['file', 'mimes:zip,doc,docx,pdf', 'max:2048'],
    'nome_docExtra'       => ['required_with:check_docExtra', 'max:255'],
  ];
  

  public static $continuos_edit_rules = [
    'nome'                => ['required', 'string'],
    'descricao'           => ['required', 'string','max:1500'],
    'tipo'                => ['required', 'string'],
    'natureza'            => ['required'],
    'coordenador_id'      => ['required'],
    'numParticipantes'    => ['required'],
    'nome_docExtra'       => ['required_with:check_docExtra','max:255'],
    'tipoAvaliacao'       => ['required'],
    'inicioSubmissao'     => ['required', 'date', 'after_or_equal:inicioSubmissao'],
    'fimSubmissao'        => ['required', 'date', 'after_or_equal:inicioSubmissao'],
    'pdfEdital'           => ['sometimes', 'required', 'file', 'mimes:pdf', 'max:2048'],
  ];

  public function endereco(){
      return $this->belongsTo('App\Endereco', 'enderecoId');
  }

  public function atividade(){
      return $this->hasOne('App\Atividade', 'eventoId');
  }

  public function area(){
      return $this->hasOne('App\Area', 'eventoId');
  }

  public function coordenador(){
      return $this->belongsTo('App\User', 'coordenadorId');
  }

  public function coordenadorComissao(){
      return $this->belongsTo('App\CoordenadorComissao', 'coordenadorId');
  }
  public function trabalhos(){
      return $this->hasMany('App\Trabalho');
  }
  public function avaliadors(){
      return $this->belongsToMany('App\Avaliador')->withPivot('convite', 'created_at');
  }
  public function campos_avaliacao(){
    return $this->hasMany('App\CampoAvaliacao');
}

}
