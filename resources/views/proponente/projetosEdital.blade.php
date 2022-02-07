@extends('layouts.app')

@section('content')

<div class="container">
  @if(isset($mensagem))
  <div class="col-sm-12">
      <br>
      <div class="alert alert-success">
          <p>{{ $mensagem }}</p>
      </div>
  </div>
  @endif
  @if(session('mensagem'))
  <div class="col-sm-12">
      <br>
      <div class="alert alert-success">
          <p>{{session('mensagem')}}</p>
      </div>
  </div>
  @endif
  <div class="row justify-content-center" style="margin-top: 3rem;">
    <div class="col-md-11">
      <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
        <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1.5rem">
            <div class="bottomVoltar">
              <a href="{{  route('evento.visualizar',['id'=> $edital->id])  }}"  class="btn btn-secondary" style="position:relative; float: right;"><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
            </div>
            <div class="form-group">
              <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Propostas submetidas - {{ $edital->nome }}</h5>
              <h6 class="titulo-table" style="color: red;">Submissão irá até o dia <span style="color: red">{{ date('d/m/Y', strtotime($edital->fimSubmissao)) }}</span></h6>
            </div>
            <div style="margin-top: -2rem">
              
              <div class="col-md-12" style="margin-bottom:18px">
                @if(false) {{-- Agendamento para o dia 01/07/2021 as 12:30:00--}}
                  <a data-toggle="modal" data-target="#exampleModal"  class="btn btn-info" style="color:#fff; margin-right:-15px">Criar proposta</a>

                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header" style="border: 0px solid rgba(0, 0, 0, 0.2);">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                       
                        <div class="modal-body" style="text-align: center">
                          <h3 style="color: #005387">Site em manutenção!</h3>
                        </div>
                        <img src="{{asset('img/img_manutencao.png')}}" class="card-img-top" alt="..." style="width:100%; margin-top:1rem; margin-bottom:1rem;">
                        <div class="modal-body from-group" style="text-align: center">
                          <h5 style="color: #005387; margin-bottom:-1px">Voltaremos na quinta-feira!</h5>
                          <h5 style="color: #909090"> 01/07/2021 às 12h30</h5>
                        </div>
                        
                        <div class="modal-footer"style="border: 0px solid rgba(0, 0, 0, 0.2);">
                          <button type="button" class="btn btn-light" data-dismiss="modal">Fechar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @else
                <a @if($edital->inicioSubmissao <= $hoje && $hoje <= $edital->fimSubmissao) href="{{ route('trabalho.index', ['id' => $edital->id] )}}" class="btn btn-info" @else href="#" data-toggle="tooltip" data-placement="top" title="O periodo de submissão foi encerrado." @endif style="position:relative; float: right;">Criar proposta</a>
                @endif
              </div>
            
            </div>
          </div>
        </div>

        <div class="card-body" >
          @if(count($projetos)>0)
            <table class="table table-bordered table-hover" style="display: block; overflow-x: visible; white-space: nowrap; border-radius:10px; margin-bottom:0px">
              <thead>
                <tr>
                  <th scope="col" style="width:100%">Nome do projeto</th>
                  <th scope="col">Data de Criação</th>
                  <th scope="col" style="text-align:center">Status</th>
                  <th scope="col">Opção</th>
                </tr>
              </thead>
              <tbody id="projetos">
                @foreach ($projetos as $projeto)
                  @if (Auth()->user()->proponentes != null && $projeto->proponente_id === Auth()->user()->proponentes->id)
                    <tr>
                      <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">
                        {{ $projeto->titulo }}
                      </td>
                      <td style="text-align: center">{{ date('d-m-Y', strtotime($projeto->updated_at)) }}</td>
                      @if($projeto->status == 'Avaliado'  || $projeto->status == 'avaliado')
                        <td style="color: rgb(6, 85, 6); text-align: center">Avaliado</td>
                      @elseif($projeto->status == 'Submetido' || $projeto->status == 'submetido')
                        <td style="color: rgb(0, 0, 0); text-align: center">Submetido</td>
                      @elseif($projeto->status == 'Rascunho' || $projeto->status == 'rascunho')
                        <td style="color: rgb(0, 0, 0); text-align: center">Rascunho</td>
                      @endif
                      <td>
                        <div class="dropright dropdown-options" style="width: 100%; text-align:center; float:none">
                            <a id="options" class="dropdown-toggle btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                            </a>
                            <div class="dropdown-menu">
                                @if($edital->inicioSubmissao <= $hoje && $hoje <= $edital->fimSubmissao)
                                  <a href="{{ route('trabalho.editar', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center;">
                                    Editar
                                  </a>
                                  <hr class="dropdown-hr">
                                @elseif($projeto->evento->resultado_final <= $hoje)
                                  <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $projeto->evento->id, 'projeto_id' => $projeto->id])}}" class="dropdown-item" style="text-align: center;">
                                    Solicitar Substituições
                                  </a>
                                  <hr class="dropdown-hr">
                                @endif
                                <a href="{{ route('trabalho.show', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center">
                                  Visualizar
                                </a>

                                <hr class="dropdown-hr">
                                <a href="{{route('planos.listar', ['id' => $projeto->id])}}" class="dropdown-item" style="text-align: center">
                                    Relatórios
                                </a>

                                <hr class="dropdown-hr">
                                {{-- <a href="" class="dropdown-item" style="text-align: center">
                                  Recorrer
                                </a> 
                                --}}

                                <!-- Button trigger modal -->
                                <button type="button" class="dropdown-item dropdown-item-delete" data-toggle="modal" data-target="#modal{{$projeto->id}}" style="text-align: center">
                                  <img src="{{asset('img/icons/logo_lixeira.png')}}" alt=""> Deletar
                                </button>
                            </div>
                        </div>
                      </td>
                    </tr>
                  @endif
                  <!-- Modal deletar -->
                  <div class="modal fade" id="modal{{$projeto->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Deletar projeto</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Você tem certeza que deseja deletar o projeto: {{ $projeto->titulo }}?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <a href="{{ route('trabalho.destroy', ['id' => $projeto->id]) }}" class="btn btn-primary" style="text-align: center">
                            Deletar
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>

                @endforeach
              </tbody>
          </table>
          @else
          <div class="form-row justify-content-center" style="margin-top: 5rem; margin-bottom:9rem;">
            <div class="col-md-12" style="text-align: center; margin-bottom:20px">
              <img src="{{asset('img/icons/logo_projeto.png')}}" style="width:200px">
            </div>
            <div class="col-md-12" style="text-align: center; color:#909090">
              <h5>Nenhum projeto submetido!</h5>
            </div>
            <div class="col-md-12" style="text-align: center;">
              @if($edital->inicioSubmissao <= $hoje && $hoje <= $edital->fimSubmissao)
                <a href="{{ route('trabalho.index', ['id' => $edital->id] )}}">Cliquei aqui para submeter um projeto.</a>
              @else
                <a href="#">O periodo de submissão foi encerrado.</a>
              @endif
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script>
function buscarEdital(input) {
    var editais = document.getElementById('projetos').children;
    if(input.value.length > 2) {      
      for(var i = 0; i < editais.length; i++) {
        var nomeEvento = editais[i].children[0].textContent;
        if(nomeEvento.substr(0).indexOf(input.value) >= 0) {
          editais[i].style.display = "";
        } else {
          editais[i].style.display = "none";
        }
      }
    } else {
      for(var i = 0; i < editais.length; i++) {
        editais[i].style.display = "";
      }
    }
  }
</script>
@endsection
