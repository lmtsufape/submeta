@extends('layouts.app')

@section('content')


<div class="container" style="margin-top: 2rem">
  <div class="row justify-content-center">
      <div class="container" style="margin-bottom: 1rem;">
        @if(!Auth::check())
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> A submissão de um projeto é possível apenas quando cadastrado no sistema. </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
      </div>
      <div class="col-md-7" style="margin-bottom:10px">

        <div class="form-row">
          <div class="col-md-12" style="margin-bottom:20px">
            <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
              @if(isset($evento->fotoEvento))
                <img src="{{asset('storage/eventos/'.$evento->id.'/logo.png')}}" class="card-img-top" alt="...">
              @else
                <img src="{{asset('img/img_fundo_2.png')}}" class="card-img-top" alt="..." style="border-radius:12px">
              @endif
                <div class="card-body">
                    <div class="form-row">
                      
                      <div class="col-md-12" style="margin-bottom: 1.5rem">
                        <h5 class="card-title mb-0" style="font-size:35px; font-family:Arial, Helvetica, sans-serif; color:#0842A0; font-weight:bold">{{$evento->nome}}</h5>
                      </div>

                      <div class="col-md-12" style="margin-top: 5px">
                        <div><h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6;">Descrição</h5></div>
                        <div style="margin-top: 10px"><h5 style="font-weight:normal; text-align:justify; font-family:Arial, Helvetica, sans-serif">{{$evento->descricao}}</h5></div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          {{-- @if($hasFile == true)
          @if($hasTrabalho)
          <div class="col-md-12" style="margin-top:8px; margin-bottom:20px">
            <div class="card shadow bg-white" style="border-radius:12px; border-width:0px;">
              <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                  <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Minhas propostas</h5>
                </div>
              </div>
                <div class="card-body">
                    <div class="form-row">
                      
                     
                        <div class="col-md-12">
                          <div style=" margin-bottom:-12px">
                                
                            <table class="table table-bordered table-hover" style="display: block; 
                            overflow-x: auto;
                            white-space: nowrap; border-radius:10px">
                                  <thead>
                                    <tr>
                                      <th scope="col" style="width:100%; font-weight:normal; color:#909090">Título</th>
                                      <th scope="col" style="font-weight:normal; color:#909090; text-align:center">Baixar</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($trabalhos as $trabalho)
                                      <tr>
                                        <td style="font-size:18px">{{ $trabalho->titulo }}</td>
                                        <td style="text-align:center">
                                          @php $arquivo = ""; @endphp
                                          @foreach($trabalho->arquivo as $key)
                                            @php
                                              if($key->versaoFinal == true){
                                                $arquivo = $key->nome;
                                              }
                                            @endphp
                                          @endforeach
                                          <a class="btn btn-light" href="{{route('baixar.anexo.projeto', ['id' => $trabalho->id])}}" target="_new" style="" >
                                              <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:15px"> Baixar
                                          </a>
                                        </td>
                                      </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                            
                          </div>
                        </div>
                       
                    </div>
                </div>
            </div>
          </div>
          @endif
          @endif --}}
        </div>
      </div>
      <div class="col-md-4">
          <div class="form-row">
              <div class="col-md-12" style="margin-bottom:30px">
                  <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                      <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                              <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Ações</h5>
                            </div>
                      </div>
                      <div class="card-body">
                        <div class="form-row">
                          
                          @if($evento->inicioSubmissao <= $mytime)
                            @if($mytime < $evento->fimSubmissao)
                            <div class="col-md-12" style="margin-bottom:18px">
                              <a class="btn btn-success " href="{{route('trabalho.index',['id'=>$evento->id])}}" style="width:100%; height:50px; padding-top:7px; font-size:20px"><img src="{{asset('img/icons/icon_enviar_proposta.png')}}" class="card-img-top" alt="..." style="width:30px; margin-right:5px"> Submeter proposta</a>
                            </div>
                            @endif
                          @endif
                          <div class="col-md-12">
                            <a class="btn btn-primary" href="{{ route('proponente.projetosEdital', ['id' => $evento->id]) }}" style="width:100%; height:50px; padding-top:5px; font-size:20px"><img src="{{asset('img/icons/icon_minhas_propostas.png')}}" class="card-img-top" alt="..." style="width:20px; margin-right:10px; margin-top:-5px"> Minhas propostas</a>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-12" style="margin-bottom:30px">
                  <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                      <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                            <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Datas importantes</h5>
                          </div>
                      </div>
                      <div class="card-body">
                        <div class="form-row">

                          <div class="col-md-12">
                            <div class="d-flex justify-content-left align-items-center">
                              <div style="margin-right:10px; margin-top:-20px">
                                <img class="" src="{{asset('img/icons/icon_submissao.png')}}" alt="" width="40px">
                              </div>
                                <div class="form-group">
                                  <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Submissão</h5></div>
                                  <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($evento->inicioSubmissao))}} - {{date('d/m/Y',strtotime($evento->fimSubmissao))}}</h5></div>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="d-flex justify-content-left align-items-center">
                              <div style="margin-right:10px; margin-top:-20px">
                                <img class="" src="{{asset('img/icons/icon_revisao.png')}}" alt="" width="40px">
                              </div>
                                <div class="form-group">
                                  <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Revisão</h5></div>
                                  <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($evento->inicioRevisao))}} - {{date('d/m/Y',strtotime($evento->fimRevisao))}}</h5></div>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="d-flex justify-content-left align-items-center">
                              <div style="margin-right:10px; margin-top:-20px">
                                <img class="" src="{{asset('img/icons/icon_resultado_preliminar.png')}}" alt="" width="40px">
                              </div>
                                <div class="form-group">
                                  <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Resultado preliminar</h5></div>
                                  <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($evento->resultado_preliminar))}}</h5></div>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <div class="d-flex justify-content-left align-items-center">
                              <div style="margin-right:10px; margin-top:-20px">
                                <img class="" src="{{asset('img/icons/icon_recurso.png')}}" alt="" width="40px">
                              </div>
                                <div class="form-group">
                                  <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Recurso</h5></div>
                                  <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($evento->inicio_recurso))}} - {{date('d/m/Y',strtotime($evento->fim_recurso))}}</h5></div>
                                </div>
                            </div>
                          </div>

                          <div class="col-md-12" style="margin-bottom: -15px">
                            <div class="d-flex justify-content-left align-items-center">
                              <div style="margin-right:10px; margin-top:-20px">
                                <img class="" src="{{asset('img/icons/icon_resultado_final.png')}}" alt="" width="40px">
                              </div>
                                <div class="form-group">
                                  <div style="margin-bottom: -8px;"><h5 style=" font-size:19px">Resultado final</h5></div>
                                  <div><h5 style="font-weight: normal; color:#909090">{{date('d/m/Y',strtotime($evento->resultado_final))}}</h5></div>
                                </div>
                            </div>
                          </div>

                        </div>
                      </div>
                  </div>
              </div>
              <div class="col-md-12" style="margin-bottom:30px">
                <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                    <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                        <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                          <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Documentos</h5>
                        </div>
                    </div>
                    <div class="card-body">
                      <div class="form-row">

                        <div class="col-md-12">
                          <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                            <div style="margin-right:10px; margin-top:-15px">
                              <img class="" src="{{asset('img/icons/icon_edital.png')}}" alt="" width="40px">
                            </div>
                            <div class="form-group" style="width: 100%">
                              <div class="d-flex justify-content-between" style="width: 100%">
                                <div><h5 style=" font-size:19px; margin-top:18px">Edital</h5></div>
                                <div style="float: right"><a class="btn btn-light" href="{{route('baixar.edital', ['id' => $evento->id])}}" target="_new" style="" >
                                  <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px"><br>
                                  Baixar</a></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12"><hr></div>

                        <div class="col-md-12">
                          @if($evento->modeloDocumento != null)
                          <div class="d-flex justify-content-left align-items-center" style="margin-bottom: -15px">
                            <div style="margin-right:10px; margin-top:-15px">
                              <img class="" src="{{asset('img/icons/icon_modelo.png')}}" alt="" width="40px">
                            </div>
                            <div class="form-group" style="width: 100%">
                              <div class="d-flex justify-content-between" style="width: 100%">
                                <div><h5 style=" font-size:19px; margin-top:9px">Outros<br>documentos</h5></div>
                                <div>
                                    <a class="btn btn-light" href="{{route('baixar.modelos', ['id' => $evento->id])}}" target="_new" style="" >
                                    <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px"><br>
                                    Baixar</a>
                                </div>
                              </div>
                            </div>
                          </div>
                          @else
                          <h6 style="color: #909090">O criador do edital não disponibilizou modelos</h6>
                        @endif
                        </div>

                      </div>
                    </div>
                </div>
            </div>
  </div>
</div>



<!--
    <div class="row justify-content-center" style="margin: 20px 0 20px 0">

        <div class="col-md-6 botao-form-left" style="">
            @if (Auth::check()) 
              @if (Auth()->user()->administradors != null)
                <a class="btn btn-secondary botao-form" href="{{ route('admin.editais') }}" style="width:100%">Voltar</a>
              @elseif (Auth()->user()->proponentes != null)
                <a class="btn btn-secondary botao-form" href="{{ route('proponente.editais') }}" style="width:100%">Voltar</a>
              @else
                <a class="btn btn-secondary botao-form" href="{{ route('participante.editais') }}" style="width:100%">Voltar</a>
              
              @endif
            @else 
              <a class="btn btn-secondary botao-form" href="{{ route('inicial') }}" style="width:100%">Voltar</a>
            @endif
        </div>

        @if($evento->inicioSubmissao <= $mytime)
          @if($mytime < $evento->fimSubmissao)
            <div class="col-md-6 botao-form-right" style="">
              <a class="btn btn-primary botao-form" href="{{route('trabalho.index',['id'=>$evento->id])}}" style="width:100%">Submeter Proposta</a>
            </div>
          @endif
        @endif

    </div>

  -->

@endsection

@section('javascript')
<script>
  function changeTrabalho(x){
    document.getElementById('trabalhoNovaVersaoId').value = x;
  }
</script>
@endsection
