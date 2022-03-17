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
    <div class="col-md-11" style="margin-bottom: -3rem">
      <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
        <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
            <div class="bottomVoltar" style="margin-top: -20px">
              <a href="{{ route('proponente.index') }}"  class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
            </div>
            <div class="form-group">
              @if($flag == 'false')
                <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Minhas propostas</h5>
              @else
              <div class="form-group" style="margin-bottom: 1px">
                <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Minhas propostas</h5>
                <h5 class="card-title mb-0" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Resultado da busca por: <span style="font-style: italic; font-weight:bold">{{$busca}}</span></h5>
              </div>
              @endif
            </div>
            <div style="margin-top: -2rem">
              <div class="form-group">
                <div style="margin-top:30px;">
                  <form action="{{route('proponente.projetos')}}" method="get">
                    @csrf
                    <div class="btn-group">
                        <input type="text" class="form-control" name="buscar" placeholder="Pesquisar propostas" value="{{$busca}}" style="margin-right: 5px;border-radius:8px; border-color:#dcdcdc;">
                        <button type="submit" class="btn btn-light shadow-sm" style="border-radius: 8px; margin-right:3px"><img src="{{asset('img/icons/logo_lupa.png')}}" alt="" width="20px"></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-body" >
          @if(count($projetos)>0)
            <table class="table table-bordered table-hover" style="display: block; overflow-x: auto; white-space: nowrap; border-radius:10px; margin-bottom:0px">
              <thead>
                <tr>
                  <th scope="col">Edital</th>
                  <th scope="col" style="width: 100%;">Projeto</th>
                  <th scope="col" style="text-align: center">Data de Criação</th>
                  <th scope="col" style="text-align: center">Status</th>
                  <th scope="col">Opção</th>
                </tr>
              </thead>
              <tbody id="projetos">
                @foreach ($projetos as $projeto)
                  @if ($projeto->proponente_id === Auth()->user()->proponentes->id)
                    <tr>
                      <td>
                        {{ $projeto->evento->nome }}
                      </td>
                      <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">
                        {{ $projeto->titulo }}
                      </td>
                      <td style="text-align: center">{{ date('d-m-Y \à\s H:i\h', strtotime($projeto->updated_at)) }}</td>
                      @if($projeto->status !=null)
                        <td style="color: rgb(6, 85, 6); text-align: center;text-transform: capitalize;">{{$projeto->status}}</td>
                      @else
                            <td style="color: rgb(0, 0, 0); text-align: center">Submetido</td>
                      @endif
                      <td>
                        <div class="dropright dropdown-options" style="width: 100%; text-align:center; float:none">
                            <a id="options" class="dropdown-toggle btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                            </a>
                            <div class="dropdown-menu">

                                @if( $projeto->status== 'aprovado')
                                    <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $projeto->evento->id, 'projeto_id' => $projeto->id])}}" class="dropdown-item" style="text-align: center;">
                                        Solicitar Substituições
                                    </a>
                                    <hr class="dropdown-hr">

                                    <a href="{{route('docComplementar.listar', ['projeto_id' => $projeto->id])}}" class="dropdown-item" style="text-align: center">
                                        Documentos Complementares
                                    </a>
                                    <hr class="dropdown-hr">

                                    <a href="" class="dropdown-item" style="text-align: center">
                                        Solicitar Certificado
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

                                <div class="container">
                                    <div class="row">
                                        <div class="col text-center" style="margin-left: 20px">
                                            <button type="button" class="dropdown-item dropdown-item-delete" data-toggle="modal" data-target="#modal{{$projeto->id}}" style="text-align: center">
                                                <img src="{{asset('img/icons/logo_lixeira.png')}}" alt=""> Deletar
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
            @if($flag == "true")
              <div class="form-row justify-content-center" style="margin-top: 5rem; margin-bottom:9rem;">
                <div class="col-md-12" style="text-align: center; margin-bottom:20px">
                  <img src="{{asset('img/icons/logo_projeto.png')}}" style="width:200px">
                </div>
                <div class="col-md-12" style="text-align: center; color:#909090">
                  <h5>Nenhuma proposta encontrada!</h5>
                </div>
                <div class="col-md-12" style="text-align: center;">
                </div>
              </div>
            @else
              <div class="form-row justify-content-center" style="margin-top: 5rem; margin-bottom:9rem;">
                <div class="col-md-12" style="text-align: center; margin-bottom:20px">
                  <img src="{{asset('img/icons/logo_projeto.png')}}" style="width:200px">
                </div>
                <div class="col-md-12" style="text-align: center; color:#909090">
                  <h5>Nenhuma proposta submetida!</h5>
                </div>
                <div class="col-md-12" style="text-align: center;">
                </div>
              </div>
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script>

</script>
@endsection