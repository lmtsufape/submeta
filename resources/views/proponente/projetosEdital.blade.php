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
  <div class="row justify-content-center" style="margin-top: 2rem;">
    <div class="col-md-11">
      <div class="card" style="border-radius: 12px; padding:14px">
          
        <div class="card-body" style="margin-bottom: -2rem">
          <div class="d-flex justify-content-between align-items-center">
            <div class="bottomVoltar">
              <a href="{{ route('proponente.editais') }}"  class="btn btn-secondary" style="position:relative; float: right;"><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
            </div>
            <div>
              <h5 style="color: #1492E6; margin-top:0.5rem">Projetos submetidos - {{ $edital->nome }}</h5>
              <h6 class="titulo-table" style="color: red">Submissão irá até o dia <span style="color: red">{{ date('d/m/Y', strtotime($edital->fimSubmissao)) }}</span></h6>
            </div>
            <div>
              <a @if($edital->inicioSubmissao <= $hoje && $hoje <= $edital->fimSubmissao) href="{{ route('trabalho.index', ['id' => $edital->id] )}}" class="btn btn-info" @else href="#" data-toggle="tooltip" data-placement="top" title="O periodo de submissão foi encerrado." @endif style="position:relative; float: right;">Criar projeto</a>
          </div>
          </div>
          <div  style="margin-top:-10px"><hr style="border-top: 1px solid#1492E6"></div>
        </div>

        <div class="card-body" >
          @if(count($projetos)>0)
            <table class="table table-bordered table-hover" style="display: block; 
            overflow-x: auto;
            white-space: nowrap; border-radius:10px">
              <thead>
                <tr>
                  <th scope="col" style="width:100%">Nome do projeto</th>
                  <th scope="col" style="text-align:center">Status</th>
                  <th scope="col">Data de Criação</th>
                  <th scope="col">Opção</th>
                </tr>
              </thead>
              <tbody id="projetos">
                @foreach ($projetos as $projeto)
                  @if ($projeto->proponente_id === Auth()->user()->proponentes->id)
                    <tr>
                      <td>
                        {{ $projeto->titulo }}
                      </td>
                      @if($projeto->status == 'Avaliado')
                        <td style="color: rgb(6, 85, 6); text-align: center">Avaliado</td>
                      @elseif($projeto->status == 'Submetido')
                        <td style="color: rgb(0, 0, 0); text-align: center">Submetido</td>
                      @elseif($projeto->status == 'Rascunho')
                        <td style="color: rgb(0, 0, 0); text-align: center">Rascunho</td>
                      @endif
                      <td style="text-align: center">{{ date('d-m-Y', strtotime($projeto->updated_at)) }}</td>
                      <td>
                        <div class="dropright dropdown-options" style="width: 100%; text-align:center; float:none">
                            <a id="options" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                            </a>
                            <div class="dropdown-menu">
                                @if($edital->inicioSubmissao <= $hoje && $hoje <= $edital->fimSubmissao)
                                  <a href="{{ route('trabalho.editar', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center;">
                                    Editar
                                  </a>
                                  <hr class="dropdown-hr">
                                @else
                                @endif
                                <a href="{{ route('trabalho.show', ['id' => $projeto->id]) }}" class="dropdown-item" style="text-align: center">
                                  Visualizar
                                </a>
                                <hr class="dropdown-hr">
                                {{-- <a href="" class="dropdown-item" style="text-align: center">
                                  Recorrer
                                </a>
                                <a href="" class="dropdown-item" style="text-align: center">
                                  Resultado
                                </a> --}}
                                <!-- Button trigger modal -->
                                <button type="button" class="dropdown-item dropdown-item-delete" data-toggle="modal" data-target="#modal{{$projeto->id}}" style="text-align: center">
                                  <img src="{{asset('img/icons/logo_lixeira.png')}}" alt=""> Deletar
                                </button>
                            </div>
                        </div>
                      </td>
                    </tr>
                  @endif
                  <!-- Modal -->
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
              <a href="{{ route('trabalho.index', ['id' => $edital->id] )}}">Cliquei aqui para submeter um projeto.</a>
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
