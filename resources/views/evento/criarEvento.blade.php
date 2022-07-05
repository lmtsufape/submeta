@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row titulo">
        <h1>Novo Edital</h1>
    </div>

    <form action="{{route('evento.criar')}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Informações Gerais</p>
            </div>
        </div>
        {{-- nome | Participantes | Tipo--}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <label for="nome" class="col-form-label">{{ __('Nome:') }}<span style="color:red; font-weight:bold;">*</span></label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-5">
                <label for="tipo" class="col-form-label">{{ __('Tipo:') }}<span style="color:red; font-weight:bold;">*</span></label>
                <select id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ old('tipo') }}" required>
                  <option @if(old('tipo')=='PIBIC' ) selected @endif value="PIBIC">PIBIC</option>
                  <option @if(old('tipo')=='PIBIC-EM' ) selected @endif value="PIBIC-EM">PIBIC-EM</option>
                  <option @if(old('tipo')=='PIBITI' ) selected @endif value="PIBITI">PIBITI</option>
                  <option @if(old('tipo')=='PIBEX' ) selected @endif value="PIBEX">PIBEX</option>
                </select>

                @error('tipo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-sm-2">
                <label for="natureza" class="col-form-label">{{ __('Natureza:') }}<span style="color:red; font-weight:bold;">*</span></label>
                <select id="natureza" type="text" class="form-control @error('natureza') is-invalid @enderror" name="natureza" value="{{ old('natureza') }}" required>
                  @foreach ($naturezas as $natureza)
                    <option @if(old('natureza')==$natureza->id ) selected @endif value="{{ $natureza->id }}">{{ $natureza->nome }}</option>
                  @endforeach
                </select>

                @error('natureza')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-2">
                <label for="numParticipantes" class="col-form-label">{{ __('Nº de Discentes:') }}<span style="color:red; font-weight:bold;">*</span></label>

                <input id="numParticipantes" type="number" min="1" max="20" class="form-control @error('numParticipantes') is-invalid @enderror" name="numParticipantes" value="{{ old('numParticipantes') }}" required autocomplete="numParticipantes" autofocus>

                @error('numParticipantes')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-3">
                <label for="consu" class="col-form-label">{{ __('Decisão da Câmara ou Conselho Pertinente: obrigatório? ') }}<input type="checkbox" name="consu" id="consu"> </label>

                {{-- <input id="consu" type="checkbox" class="form-control @error('consu') is-invalid @enderror" name="consu" @if(old('consu')) checked @endif required autocomplete="consu" autofocus> --}}

                @error('consu')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <br>

                <label for="cotaDoutor" class="col-form-label">{{ __('Cota para recém doutor?') }}</label>
                <input type="checkbox" name="cotaDoutor" id="cotaDoutor">

                @error('cotaDoutor')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end nome | Participantes | Tipo--}}

        {{-- Descricao Edital --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrição:<span style="color:red; font-weight:bold;">*</span></label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" required autocomplete="descricao" autofocus id="descricao" name="descricao" rows="6">{{ old('descricao') }}</textarea>
                    @error('descricao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
            </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-sm-12">
              <div class="row">
                  <div class="col-md-11">
                      <label for="coordenador_id" class="col-form-label">{{ __('Coordenador:') }}<span style="color:red; font-weight:bold;">*</span></label>

                  </div>
                  <div class="col-md-1 text-sm-right">
                      <a type="button" value="Selecionar" data-toggle="modal" data-target="#modalCoord">
                          <img class="" src="{{asset('img/icons/add.ico')}}" style="width:30px" alt="">
                      </a>
                  </div>
              </div>

              <input id="coordenador_id" name="coordenador_id" class="form-control" value="{{old('coordenador_id')}}" hidden>
             
              <input style="margin-top: 5px" id="coordenador_name" name="coordenador_name" class="form-control @error('coordenador_id') is-invalid @enderror" value="{{old('coordenador_name')}}" placeholder="Nenhum Coordenador atribuido" required readonly>

             {{-- <select class="form-control @error('coordenador_id') is-invalid @enderror" id="coordenador_id" name="coordenador_id" style="pointer-events: none">
                  <option value="" disabled selected hidden>-- Coordenador da Comissão Avaliadora --</option>
                  @foreach($coordenadors as $coordenador)
                    <option @if(old('coordenador_id')==$coordenador->id ) selected @endif value="{{$coordenador->id}}">{{$coordenador->user->name}}</option>
                  @endforeach
              </select>--}}
              @error('coordenador_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
          </div>
        </div>
        <!-- Modal Coordenador -->
        <div class="modal fade" id="modalCoord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header" style="overflow-x:auto">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#1492E6">Coordenadores</h5>
                        <button type="button" class="close" aria-label="Close" data-dismiss="modal" style="padding-top: 8px; color:#1492E6">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered" >
                            <thead>
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Instituição</th>
                                <th scope="col">Seleção</th>
                            </tr>
                            </thead>
                            <tbody id="projetos">
                            
                            @foreach($coordenadors as $coordenador)
                                <tr>
                                    <td>{{$coordenador->user->name}}</td>
                                    <td>{{$coordenador->user->email}}</td>
                                    @if($coordenador->user->celular != null)
                                        <td>{{$coordenador->user->celular}}</td>
                                    @else
                                        <td>Não Definido</td>
                                    @endif
                                    @if($coordenador->user->instituicao != null)
                                        <td>{{$coordenador->user->instituicao}}</td>
                                    @else
                                        <td>Não Definida</td>
                                    @endif
                                    <td style="text-align-last:center"><input  type="button" class="btn-primary btn" value="Definir" onclick="defCoord({{$coordenador->id}},'{{$coordenador->user->name}}')" style="width: 100px"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Projetos</p>
            </div>
        </div>
        {{-- dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}
        <div class="row justify-content-center">

            <div class="col-sm-6">
                <label for="inicioSubmissao" class="col-form-label">{{ __('Início da Submissão:') }}<span style="color:red; font-weight:bold;">*</span></label>
                <input id="inicioSubmissao" type="date" class="form-control @error('inicioSubmissao') is-invalid @enderror" name="inicioSubmissao" value="{{ old('inicioSubmissao') }}" required autocomplete="inicioSubmissao" autofocus>

                @error('inicioSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>
                        @if ($message != null)
                            @for ($i = 0; $i < 9; $i++)
                                @if ($i < 8)
                                    {{ explode(" ", $message)[$i] }}
                                @else
                                    {{ date('d/m/Y', strtotime(explode(" ", $message)[$i])) }}
                                @endif
                            @endfor
                        @endif
                    </strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="fimSubmissao" class="col-form-label">{{ __('Fim da Submissão:') }}<span style="color:red; font-weight:bold;">*</span></label>
                <input id="fimSubmissao" type="date" class="form-control @error('fimSubmissao') is-invalid @enderror" name="fimSubmissao" value="{{ old('fimSubmissao') }}" required autocomplete="fimSubmissao" autofocus>

                @error('fimSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}

        <div class="row justify-content-center">
          <div class="col-sm-6">
              <label for="inicioRevisao" class="col-form-label">{{ __('Início da Avaliação:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="inicioRevisao" type="date" class="form-control @error('inicioRevisao') is-invalid @enderror" name="inicioRevisao" value="{{ old('inicioRevisao') }}" required autocomplete="inicioRevisao" autofocus>

              @error('inicioRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="fimRevisao" class="col-form-label">{{ __('Fim da Avaliação:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="fimRevisao" type="date" class="form-control @error('fimRevisao') is-invalid @enderror" name="fimRevisao" value="{{ old('fimRevisao') }}" required autocomplete="fimRevisao" autofocus>

              @error('fimRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>

        <div class="row justify-content-left">
          <div class="col-sm-6">
              <label for="resultado_preliminar" class="col-form-label">{{ __('Resultado Preliminar:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="resultado_preliminar" type="date" class="form-control @error('resultado_preliminar') is-invalid @enderror" name="resultado_preliminar" value="{{ old('resultado_preliminar') }}" required autocomplete="resultado_preliminar" autofocus>

              @error('resultado_preliminar')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="inicio_recurso" class="col-form-label">{{ __('Início do recurso:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="inicio_recurso" type="date" class="form-control @error('inicio_recurso') is-invalid @enderror" name="inicio_recurso" value="{{ old('inicio_recurso') }}" required autocomplete="inicio_recurso" autofocus>

              @error('inicio_recurso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>

        </div>
        <div class="row justify-content-left">
          <div class="col-sm-6">
              <label for="fim_recurso" class="col-form-label">{{ __('Fim do Recurso:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="fim_recurso" type="date" class="form-control @error('fim_recurso') is-invalid @enderror" name="fim_recurso" value="{{ old('fim_recurso') }}" required autocomplete="resultado" autofocus>

              @error('fim_recurso')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>

          <div class="col-sm-6">
              <label for="resultado_final" class="col-form-label">{{ __('Resultado Final:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="resultado_final" type="date" class="form-control @error('resultado_final') is-invalid @enderror" name="resultado_final" value="{{ old('resultado_final') }}" required autocomplete="resultado" autofocus>

              @error('resultado_final')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>

        <!-- AKI -->
        <div class="row justify-content-left">
            <div class="col-sm-6">
              <label for="inicioProjeto" class="col-form-label">{{ __('Início do Projeto:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="inicioProjeto" type="date" class="form-control @error('inicioProjeto') is-invalid @enderror" name="inicioProjeto" value="{{ old('inicioProjeto') }}" required autocomplete="inicioProjeto" autofocus>

              @error('inicioProjeto')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>

            <div class="col-sm-6">
              <label for="fimProjeto" class="col-form-label">{{ __('Fim do Projeto:') }}<span style="color:red; font-weight:bold;">*</span></label>
              <input id="fimProjeto" type="date" class="form-control @error('fimProjeto') is-invalid @enderror" name="fimProjeto" value="{{ old('fimProjeto') }}" required autocomplete="fimProjeto" autofocus>

              @error('fimProjeto')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
        </div>


        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Relatórios</p>
            </div>
        </div>
        <div class="row justify-content-left">
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Início do Relatório Parcial:'])
                    <input id="dt_inicioRelatorioParcial" type="date" class="form-control @error('dt_inicioRelatorioParcial') is-invalid @enderror" name="dt_inicioRelatorioParcial" value="{{ old('dt_inicioRelatorioParcial') }}" required autocomplete="dt_inicioRelatorioParcial" autofocus
                           title="Início para o período do envio do relatório parcial">
                    @error('dt_inicioRelatorioParcial')
                    <span class="invalid-feedback" role="alert">
                        <strong>Apenas será aceita data posterior ao dia do Resultado Final</strong>
                    </span>
                    @enderror
                @endcomponent
            </div>
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Fim do Relatório Parcial:'])
                    <input id="dt_fimRelatorioParcial" type="date" class="form-control @error('dt_fimRelatorioParcial') is-invalid @enderror" name="dt_fimRelatorioParcial" value="{{ old('dt_fimRelatorioParcial') }}" required autocomplete="dt_fimRelatorioParcial" autofocus
                           title="Final do período de envio do relatório parcial">
                    @error('dt_fimRelatorioParcial')
                    <span class="invalid-feedback" role="alert">
                        <strong>A data deve ser igual ou posterior a data de início do Relatório Parcial</strong>
                    </span>
                    @enderror
                @endcomponent
            </div>
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Início do Relatório Final:'])
                    <input id="dt_inicioRelatorioFinal" type="date" class="form-control @error('dt_inicioRelatorioFinal') is-invalid @enderror" name="dt_inicioRelatorioFinal" value="{{ old('dt_inicioRelatorioFinal') }}" required autocomplete="dt_inicioRelatorioFinal" autofocus
                           title="Início para o período de envio do relatório final">
                    @error('dt_inicioRelatorioFinal')
                    <span class="invalid-feedback" role="alert">
                        <strong>Apenas será aceita data posterior ao fim do Relatório Parcial</strong>
                    </span>
                    @enderror
                @endcomponent
            </div>
            <div class="col-sm-6">

                @component('componentes.input', ['label' => 'Fim do Relatório Final:'])
                    <input id="dt_fimRelatorioFinal" type="date" class="form-control @error('dt_fimRelatorioFinal') is-invalid @enderror" name="dt_fimRelatorioFinal" value="{{ old('dt_fimRelatorioFinal') }}" required autocomplete="dt_fimRelatorioFinal" autofocus
                           title="Final do período de envio do relatório final">
                    @error('dt_fimRelatorioFinal')
                    <span class="invalid-feedback" role="alert">
                        <strong>A data deve ser igual ou posterior a data de início do Relatório Final</strong>
                    </span>
                    @enderror
                @endcomponent
            </div>
        </div>

        <hr>
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Documentos</p>
            </div>
        </div>

        {{-- Pdf Edital --}}
        <div class="row justify-content-center" style="margin-top:10px">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pdfEdital">Anexar edital:<span style="color:red; font-weight:bold;">*</span></label>
                    @if(old('pdfEditalPreenchido') != null)
                        <a id="pdfEditalTemp" href="{{ route('baixar.evento.temp', ['nomeAnexo' => 'pdfEdital' ])}}">Arquivo atual</a>
                    @endif
                    <input type="hidden" id="pdfEditalPreenchido" name="pdfEditalPreenchido" value="{{ old('pdfEditalPreenchido') }}" >
                    <input type="file" accept=".pdf" class="form-control-file pdf @error('pdfEdital') is-invalid @enderror" name="pdfEdital" value="{{ old('pdfEdital') }}" id="pdfEdital" onchange="exibirAnexoTemp(this)">
                    <small>O arquivo selecionado deve ser no formato PDF de até 2mb.</small>
                    @error('pdfEdital')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                    <label for="modeloDocumento">Anexar arquivo com os modelos de documentos do edital:</label>
                    @if(old('modeloDocumentoPreenchido') != null)
                    <a id="modeloDocumentoTemp" href="{{ route('baixar.evento.temp', ['nomeAnexo' => 'modeloDocumento' ])}}">Arquivo atual</a>
                    @endif
                    <input type="hidden" id="modeloDocumentoPreenchido" name="modeloDocumentoPreenchido" value="{{ old('modeloDocumentoPreenchido') }}" >
                    <input type="file" class="form-control-file @error('modeloDocumento') is-invalid @enderror" name="modeloDocumento" value="{{ old('modeloDocumento') }}" id="modeloDocumento" onchange="exibirAnexoTemp(this)">
                    <small>O arquivo selecionado deve ter até 2mb.</small>
                    @error('modeloDocumento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pdfFormAvalExterno">Formulário para avaliador <i>ad hoc</i>:<span style="color:red; font-weight:bold;">*</span></label>
                    @if(old('pdfFormAvalExternoPreenchido') != null)
                        <a id="pdfFormAvalExternoTemp" href="{{ route('baixar.evento.temp', ['nomeAnexo' => 'formAvaliacaoExterno' ])}}">Arquivo atual</a>
                    @endif
                    <input type="hidden" id="pdfFormAvalExternoPreenchido" name="pdfFormAvalExternoPreenchido" value="{{ old('pdfFormAvalExternoPreenchido') }}" >
                    <input type="file" accept=".pdf,.doc,.docx,.xlsx,.xls,.csv,.zip" class="form-control-file @error('pdfFormAvalExterno') is-invalid @enderror" name="pdfFormAvalExterno" value="{{ old('pdfFormAvalExterno') }}" id="pdfFormAvalExterno" onchange="exibirAnexoTemp(this)">
                    <small>O arquivo selecionado deve ter até 2mb.</small>
                    @error('pdfFormAvalExterno')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="pdfFormAvalExterno">Formulário de avaliação do relatório:</label>
                    @if(old('pdfFormAvalRelatorioPreenchido') != null)
                        <a id="pdfFormAvalRelatorioTemp" href="{{ route('baixar.evento.temp', ['nomeAnexo' => 'formAvaliacaoPlano' ])}}">Arquivo atual</a>
                    @endif
                    <input type="hidden" id="pdfFormAvalRelatorioPreenchido" name="pdfFormAvalRelatorioPreenchido" value="{{ old('pdfFormAvalRelatorioPreenchido') }}" >
                    <input type="file" accept=".pdf" class="form-control-file pdf @error('pdfFormAvalRelatorio') is-invalid @enderror" name="pdfFormAvalRelatorio" value="{{ old('pdfFormAvalRelatorio') }}" id="pdfFormAvalRelatorio" onchange="exibirAnexoTemp(this)">
                    <small>O arquivo selecionado deve ser no formato PDF de até 2mb.</small>
                    @error('pdfFormAvalRelatorio')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="docTutorial">Documento auxiliar para Avaliador:</label>
                        @if(old('docTutorialPreenchido') != null)
                            <a id="docTutorialTemp" href="{{ route('baixar.evento.temp', ['nomeAnexo' => 'docTutorial' ])}}">Arquivo atual</a>
                        @endif
                        <input type="hidden" id="docTutorialPreenchido" name="docTutorialPreenchido" value="{{ old('docTutorialPreenchido') }}" >
                        <input type="file" accept=".pdf,.docx,.doc,.zip" class="form-control-file pdf @error('docTutorial') is-invalid @enderror" name="docTutorial" value="{{ old('docTutorial') }}" id="docTutorial" onchange="exibirAnexoTemp(this)">
                        <small>O arquivo selecionado deve ser de atÃ© 2mb.</small>
                        @error('docTutorial')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
        </div>

        <div class="row justify-content-center" style="margin: 20px 0 20px 0">

            <div class="col-md-6" style="padding-left:0">
                <a class="btn btn-secondary botao-form" href="{{ route('admin.editais') }}" style="width:100%">Cancelar</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Criar Edital') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    function exibirAnexoTemp(file){
        console.log(file.id);
        if(file.id === "pdfEdital"){
        var pdfEditalPreenchido = document.getElementById('pdfEditalPreenchido');
        pdfEditalPreenchido.value = "sim";
        }
        if(file.id === "modeloDocumento"){
        var modeloDocumentoPreenchido = document.getElementById('modeloDocumentoPreenchido');
        modeloDocumentoPreenchido.value = "sim";
        }
        if(file.id === "pdfFormAvalExterno"){
            var pdfFormAvalExternoPreenchido = document.getElementById('pdfFormAvalExternoPreenchido');
            pdfFormAvalExternoPreenchido.value = "sim";
        }
        if(file.id === "pdfFormAvalRelatorio"){
            var pdfFormAvalRelatorioPreenchido = document.getElementById('pdfFormAvalRelatorioPreenchido');
            pdfFormAvalRelatorioPreenchido.value = "sim";
        }
    }

    $("input[type='file']").on("change", function () {
        if(this.files[0].size > 2000000) {
            //  console.log($(this).parents( ".col-sm-5" ))
            alert("O tamanho do arquivo deve ser menor que 2MB!");
            $(this).val('');

        }
    });

    $("input.pdf").on("change", function () {
        if(this.files[0].type.split('/')[1] == "pdf") {
            if(this.files[0].size > 20000000){
                alert("O arquivo possui o tamanho superior a 2MB!");
                $(this).val('');
            }
        }else{
            alert("O arquivo não é de tipo PDF!");
            $(this).val('');
        }
    });

    function defCoord(data,data2){
        document.getElementById('coordenador_id').value=data;
        document.getElementById('coordenador_name').value=data2;
        $("#modalCoord").modal('hide');

    }
</script>
@endsection