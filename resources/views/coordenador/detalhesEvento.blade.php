@extends('layouts.app')
@section('sidebar')
<div class="wrapper">
    <div class="sidebar">
        <h2>{{{$evento->nome}}}</h2>
        <ul>
            <a id="informacoes" onclick="habilitarPagina('informacoes')">
                <li>
                    <img src="{{asset('img/icons/info-circle-solid.svg')}}" alt=""> <h5> Informações</h5>
                </li>
            </a>

            <a id="trabalhos">
                <li>
                    <img src="{{asset('img/icons/file-alt-regular.svg')}}" alt=""><h5>Trabalhos</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <div id="dropdownTrabalhos" style="background-color: gray">
                    <a id="submissoesTrabalhos" onclick="habilitarPagina('submissoesTrabalhos')">
                        <li>
                            <img src="{{asset('img/icons/plus-square-solid.svg')}}" alt=""><h5>Definir Submissões</h5>
                        </li>
                    </a>
                    <a id="listarTrabalhos" onclick="habilitarPagina('listarTrabalhos')">
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5>Listar Trabalhos</h5>
                        </li>
                    </a>
                </div>
            </a>
            <a id="areas">
                <li>
                    <img src="{{asset('img/icons/area.svg')}}" alt=""><h5> Áreas</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <div id="dropdownAreas" style="background-color: gray">
                    <a id="cadastrarAreas" onclick="habilitarPagina('cadastrarAreas')">
                        <li>
                            <img src="{{asset('img/icons/plus-square-solid.svg')}}" alt=""><h5> Cadastrar Áreas</h5>
                        </li>
                    </a>
                    <a id="listarAreas" onclick="habilitarPagina('listarAreas')">
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5> Listar Áreas</h5>
                        </li>
                    </a>
                </div>

            </a>
            <a id="revisores">
                <li>
                    <img src="{{asset('img/icons/glasses-solid.svg')}}" alt=""><h5>Revisores</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <div id="dropdownRevisores" style="background-color: gray">
                    <a id="cadastrarRevisores" onclick="habilitarPagina('cadastrarRevisores')">
                        <li>
                            <img src="{{asset('img/icons/user-plus-solid.svg')}}" alt=""><h5> Cadastrar Revisores</h5>
                        </li>
                    </a>
                    <a id="listarRevisores" onclick="habilitarPagina('listarRevisores')">
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5> Listar Revisores</h5>
                        </li>
                    </a>
                </div>
            </a>
            <a id="comissao" onclick="habilitarPagina('comissao')">
                <li>
                    <img src="{{asset('img/icons/user-tie-solid.svg')}}" alt=""><h5>Comissão</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <div id="dropdownComissao" style="background-color: gray">
                    <a id="cadastrarComissao" onclick="habilitarPagina('cadastrarComissao')">
                        <li>
                            <img src="{{asset('img/icons/user-plus-solid.svg')}}" alt=""><h5> Cadastrar Comissão</h5>
                        </li>
                    </a>
                    <a id="definirCoordComissao" onclick="habilitarPagina('definirCoordComissao')">
                        <li>
                            <img src="{{asset('img/icons/crown-solid.svg')}}" alt=""><h5> Definir Coordenador</h5>
                        </li>
                    </a>
                    <a id="listarComissao" onclick="habilitarPagina('listarComissao')">
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5> Listar Comissão</h5>
                        </li>
                    </a>
                </div>
            </a>
            <a id="modalidades">
                <li>
                    <img src="{{asset('img/icons/sitemap-solid.svg')}}" alt=""><h5>Modalidades</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <div id="dropdownModalidades" style="background-color: gray">
                    <a id="cadastrarModalidade" onclick="habilitarPagina('cadastrarModalidade')">
                        <li>
                            <img src="{{asset('img/icons/plus-square-solid.svg')}}" alt=""><h5> Cadastrar Modalidade</h5>
                        </li>
                    </a>
                    <a id="listarModalidade" onclick="habilitarPagina('listarModalidade')">
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5> Listar Modalidades</h5>
                        </li>
                    </a>
                </div>
            </a>
            <!-- <a id="colocacao" onclick="habilitarPagina('colocacao')">
                <li>
                    <img src="{{asset('img/icons/trophy-solid.svg')}}" alt=""><h5>Classificação</h5>
                </li>
            </a>
            <a id="atividades" onclick="habilitarPagina('atividades')">
                <li>
                    <img src="{{asset('img/icons/calendar-alt-solid.svg')}}" alt=""><h5>Atividades</h5>
                </li>
            </a> -->
        </ul>
    </div>


</div>
@endsection
@section('content')

<div class="main_content">
    {{-- {{ $evento->id ?? '' }} --}}
    {{-- Informações --}}
    <div id="divInformacoes" class="informacoes">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Informações</h1>
            </div>
        </div>

        <!-- Row trabalhos -->
        <div class="row justify-content-center">
          <div class="col-sm-8">


            <div class="row justify-content-center">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Trabalhos</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Informações referente aos trabalhos enviados</h6>
                    <p class="card-text">
                      <div class="row justify-content-center">
                        <div class="col-sm-12">
                          <table class="table table-responsive-lg table-hover">
                            <thead>
                              <tr>
                                <th style="text-align:center">Enviados</th>
                                <th style="text-align:center">Avaliados</th>
                                <th style="text-align:center">Pendentes</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td style="text-align:center"> {{$trabalhosEnviados}} </td>
                                <td style="text-align:center"> {{$trabalhosAvaliados}} </td>
                                <td style="text-align:center"> {{$trabalhosPendentes}} </td>
                              </tr>
                            </tbody>
                          </table>

                        </div>

                      </div>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Organização</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Informações referentes ao número de participantes na organização do evento</h6>
                    <p class="card-text">
                      <div class="row justify-content-center">
                        <div class="col-sm-12">
                          <table class="table table-responsive-lg table-hover">
                            <thead>
                              <tr>
                                <th style="text-align:center">Número de Revisores</th>
                                <th style="text-align:center">Número de Integrantes na Comissão</th>

                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td style="text-align:center"> {{$numeroRevisores}} </td>
                                <td style="text-align:center"> {{$numeroComissao}} </td>
                              </tr>
                            </tbody>
                          </table>

                        </div>

                      </div>
                    </p>
                  </div>
                </div>
              </div>

            </div>

          </div>



        </div><!-- end Row trabalhos -->

    </div>
    {{-- Comissão --}}
    <div id="divCadastrarComissao" class="comissao">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Cadastrar Comissão</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Novo Membro</h5>
                      <h6 class="card-subtitle mb-2 text-muted">Cadastre um membro para sua Comissão</h6>
                      <form action="{{route('cadastrar.comissao')}}" method="POST">
                        @csrf
                        <input type="hidden" name="eventoId" value="{{ $evento->id ?? '' }}">
                        <p class="card-text">
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="emailMembroComissao" class="control-label">E-mail do novo membro</label>
                                    <input type="email" name="emailMembroComissao" class="form-control @error('emailMembroComissao') is-invalid @enderror" name="emailMembroComissao" value="{{ old('emailMembroComissao') }}" id="emailMembroComissao" placeholder="E-mail">
                                    @error('emailMembroComissao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                        </div>
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    {{ __('Finalizar') }}
                                </button>
                            </div>
                        </div>

                        </form>
                    </div>
                  </div>{{-- end card--}}
            </div>

        </div>

    </div>{{-- End cadastrar Comissão --}}

    <div id="divDefinirCoordComissao" class="comissao">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Definir Coordenador da Comissão</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Coordenador da Comissão</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Selecione um coordenador para comissão do seu evento</h6>
                        <form id="formCoordComissao" action="{{route('cadastrar.coordComissao')}}" method="POST">
                            @csrf
                            <p class="card-text">
                                    <input type="hidden" name="eventoId" value="{{ $evento->id ?? '' }}">

                                    <div class="form-group">
                                        <label for="coodComissaoId">Coordenador Comissão</label>
                                        <select class="form-control" name="coordComissaoId" id="coodComissaoId">
                                            @foreach ($users as $user)
                                                @if($evento->coordComissaoId == $user->id)
                                                    <option value="{{$user->id}}" selected>{{$user->email}}</option>
                                                @else
                                                    <option value="{{$user->id}}">{{$user->email}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </p>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary" style="width:100%">
                                            {{ __('Definir Coordenador') }}
                                        </button>

                                    </div>
                                </div>
                            </form>

                    </div>
                  </div>
            </div>
        </div>
    </div>{{-- End Cord Comissão --}}

    <div id="divListarComissao" class="comissao">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="titulo-detalhes">Listar Comissão</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Comissão</h5>
                      <h6 class="card-subtitle mb-2 text-muted">Usuários cadastrados na comissão do seu evento.</h6>
                      <p class="card-text">
                        <table class="table table-hover table-responsive-lg table-sm">
                            <thead>
                                <th>
                                    <th>Nome</th>
                                    <th>Especialidade</th>
                                    <th>Celular</th>
                                    <th>E-mail</th>
                                    <th>Direção</th>
                                    <th>Remover</th>
                                </th>
                            </thead>
                                @foreach ($users as $user)
                                    <tbody>

                                        <th>
                                          @if (isset($user->name))
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->especProfissional}}</td>
                                            <td>{{$user->celular}}</td>
                                            <td>{{$user->email}}</td>
                                            @if ($evento->coordComissaoId == $user->id)
                                              <td>Coordenador</td>
                                            @endif
                                            <td>
                                              <form method="POST" action="{{route('delete.comissao', ['eventosId'=>$evento->id, 'userId'=>$user->id])}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="dropdown-item">
                                                  <img src="{{asset('img/icons/trash-alt-regular.svg')}}" style="width:15px">
                                                </button>
                                              </form>
                                            </td>
                                          @else
                                            <td>Usuário temporário - Sem nome</td>
                                            <td>Usuário temporário - Sem Especialidade</td>
                                            <td>Usuário temporário - Sem Celular</td>
                                            <td>{{$user->email}}</td>
                                            @if ($evento->coordComissaoId == $user->id)
                                              <td>Coordenador</td>
                                            @endif
                                            <td>
                                              <form method="POST" action="{{route('delete.comissao', ['eventosId'=>$evento->id, 'userId'=>$user->id])}}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="dropdown-item">
                                                  <img src="{{asset('img/icons/trash-alt-regular.svg')}}" style="width:15px">
                                                </button>
                                              </form>
                                            </td>
                                          @endif
                                        </th>
                                    </tbody>
                                @endforeach
                        </table>
                      </p>
                    </div>
                  </div>
            </div>
        </div>


        {{-- tabela membros comissão --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-responsive-lg table-hover">

                </table>
            </div>
        </div>
    </div>{{-- End Listar Comissão --}}

    <!-- Trabalhos -->
    <div id="divListarTrabalhos" style="display: none">

        <div class="row titulo-detalhes">
            <div class="col-sm-10">
                <h1 class="">Trabalhos</h1>
            </div>

            <form method="GET" action="{{route('distribuicao')}}">
              <input type="hidden" name="eventoId" value="{{$evento->id}}">
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <button onclick="event.preventDefault();" data-toggle="modal" data-target="#modalDistribuicaoAutomatica" class="btn btn-primary" style="width:100%">
                    {{ __('Distribuir Trabalhos') }}
                  </button>
                </div>
              </div>
            </form>

        </div>

    {{-- Tabela Trabalhos --}}
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-hover table-responsive-lg table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Área</th>
              <th scope="col">Modalidade</th>
              <th scope="col">Revisores</th>
              <th scope="col" style="text-align:center">Baixar</th>
              <th scope="col" style="text-align:center">Visualizar</th>
            </tr>
          </thead>
          <tbody>
            @php $i = 0; @endphp
            @foreach($trabalhos as $trabalho)

            <tr>
              <td>{{$trabalho->id}}</td>
              <td>{{$trabalho->area->nome}}</td>
              <td>{{$trabalho->modalidade->nome}}</td>
              <td>
                @foreach($trabalho->atribuicao as $atribuicao)
                {{$atribuicao->revisor->user->email}},
                @endforeach
              </td>
              <td style="text-align:center">
                @php $arquivo = ""; $i++; @endphp
                @foreach($trabalho->arquivo as $key)
                @php
                if($key->versaoFinal == true){
                  $arquivo = $key->nome;
                }
                @endphp
                @endforeach
                <img onclick="document.getElementById('formDownload{{$i}}').submit();" class="" src="{{asset('img/icons/file-download-solid-black.svg')}}" style="width:20px" alt="">
                <form method="GET" action="{{ route('download') }}" target="_new" id="formDownload{{$i}}">
                  <input type="hidden" name="file" value="{{$arquivo}}">
                </form>
              </td>
              <td style="text-align:center">
                <a class="botaoAjax" href="#" data-toggle="modal" onclick="trabalhoId({{$trabalho->id}})" data-target="#modalTrabalho"><img src="{{asset('img/icons/eye-regular.svg')}}" style="width:20px"></a>
              </td>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>

</div><!-- End Trabalhos -->
<!-- Definir Submissões -->
<div id="divDefinirSubmissoes" style="display: none">

    <div class="row titulo-detalhes">
        <div class="col-sm-10">
            <h1 class="">Definir Submissões</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Definir Submissões do Trabalho</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Informe o número de trabalhos que cada autor poderá enviar e o número de trabalhos em que um usuário poderá ser um coautor</h6>
                    <form method="POST" action="{{route('trabalho.numTrabalhos')}}">
                    @csrf
                    <p class="card-text">
                        <input type="hidden" name="eventoId" value="{{$evento->id}}">

                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <label for="trabalhosPorAutor" class="col-form-label">{{ __('Número de trabalhos por Autor') }}</label>
                                <input id="trabalhosPorAutor" type="text" class="form-control @error('trabalhosPorAutor') is-invalid @enderror" name="trabalhosPorAutor" value="{{ old('trabalhosPorAutor') }}" required autocomplete="trabalhosPorAutor" autofocus>

                                @error('trabalhosPorAutor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>{{-- end row--}}

                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <label for="numCoautor" class="col-form-label">{{ __('Número de trabalhos como Coautor') }}</label>
                                <input id="numCoautor" type="text" class="form-control @error('numCoautor') is-invalid @enderror" name="numCoautor" value="{{ old('numCoautor') }}" required autocomplete="numCoautor" autofocus>

                                @error('numCoautor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>{{-- end row--}}

                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                {{ __('Finalizar') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Resumo</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Informe se os trabalhos enviados possuem resumos.</h6>
                    <form method="POST" action="{{route('evento.setResumo')}}">
                    @csrf
                    <p class="card-text">
                        <input type="hidden" name="eventoId" value="{{$evento->id}}">
                        <input type="hidden" name="hasResumo" value="false" id="hasResumo">

                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <input id="hasResumoCheck" type="checkbox" onclick="document.getElementById('hasResumo').value = 'true'"  autocomplete="hasResumo" autofocus>
                                <label for="hasResumoCheck" >{{ __('Possui') }}</label>

                                @error('hasResumo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>{{-- end row--}}
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                {{ __('Finalizar') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Logo Evento</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Modifique a foto do evento aqui.</h6>
                    <form method="POST" action="{{route('evento.setFotoEvento')}}" enctype="multipart/form-data">
                    @csrf
                    <p class="card-text">
                        <input type="hidden" name="eventoId" value="{{$evento->id}}">

                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                              <label for="fotoEvento">Logo</label>
                              <input type="file" class="form-control-file @error('fotoEvento') is-invalid @enderror" name="fotoEvento" value="{{ old('fotoEvento') }}" id="fotoEvento">
                              @error('fotoEvento')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>

                        </div>{{-- end row--}}
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                {{ __('Finalizar') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
        </div>
    </div>
</div><!-- Definir Submissões -->

{{-- Modalidade --}}
<div id="divCadastrarModalidades" class="modalidades">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="titulo-detalhes">Cadastrar Modalidade</h1>
        </div>
    </div>
    {{-- row card --}}
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nova Modalidade</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Cadastre uma nova modalidade para o seu evento</h6>
                    <form method="POST" action="{{route('modalidade.store')}}">
                    @csrf
                    <p class="card-text">
                        <input type="hidden" name="eventoId" value="{{$evento->id}}">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="nomeModalidade" class="col-form-label">{{ __('Nome') }}</label>

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <input id="nomeModalidade" type="text" class="form-control @error('nomeModalidade') is-invalid @enderror" name="nomeModalidade" value="{{ old('nomeModalidade') }}" required autocomplete="nomeModalidade" autofocus>

                                @error('nomeModalidade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                        </div>{{-- end row--}}

                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                {{ __('Finalizar') }}
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Áreas por Modalidade</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Vincule as Áreas de acordo com cada modalidade</h6>
                    <form method="POST" action="{{route('areaModalidade.store')}}">
                    @csrf
                    <p class="card-text">
                        <input type="hidden" name="eventoId" value="{{$evento->id}}">
                        <div class="row justify-content-center">
                            <div class="col-sm-6">
                                <label for="modalidadeId" class="col-form-label">{{ __('Modalidade') }}</label>
                                <select class="form-control @error('modalidadeId') is-invalid @enderror" id="modalidadeId" name="modalidadeId">
                                    <option value="" disabled selected hidden> Modalidade </option>
                                    @foreach($modalidades as $modalidade)
                                    <option value="{{$modalidade->id}}">{{$modalidade->nome}}</option>
                                    @endforeach
                                </select>

                                @error('modalidadeId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="areaId" class="col-form-label">{{ __('Área') }}</label>
                                <select class="form-control @error('areaId') is-invalid @enderror" id="areaId" name="areaId">
                                    <option value="" disabled selected hidden> Área </option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->nome}}</option>
                                    @endforeach
                                </select>

                                @error('areaId')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </p>

                    <div class="row justify-content-center">

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                {{ __('Finalizar') }}
                            </button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>{{-- End card--}}
        </div>
    </div>{{-- end row card --}}
</div>
<div id="divListarModalidades" class="modalidades">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="titulo-detalhes">Listar Modalidades</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        {{-- table modalidades --}}
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Modalidades</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Modalidades cadastradas no seu evento</h6>
                  <p class="card-text">
                    <table class="table table-hover table-responsive-lg table-sm">
                        <thead>
                        <tr>
                            <th scope="col">Nome</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($modalidades as $modalidade)
                            <tr>
                                <td>{{$modalidade->nome}}</td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                  </p>
                </div>
              </div>

        </div>{{-- end table--}}

        {{-- table modalidades Área--}}
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Áreas por Modalidade</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Áreas correspondentes à cada modalidade do seu evento</h6>
                  <p class="card-text">
                    <table class="table table-hover table-responsive-lg table-sm">
                        <thead>
                          <tr>
                            <th scope="col">Modalidade</th>
                            <th scope="col">Área</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($areaModalidades as $areaModalidade)
                              <tr>
                                <td>{{$areaModalidade->modalidade->nome}}</td>
                                <td>{{$areaModalidade->area->nome}}</td>
                              </tr>
                            @endforeach


                        </tbody>
                      </table>
                  </p>
                </div>
              </div>

        </div>{{-- end table área--}}
    </div>
</div>
    <div id="divClassificacao" class="classificacao">
        <h1>Classificação</h1>
    </div>
    <div id="divAtividades" class="atividades">
        <h1>Atividades</h1>
    </div>

<!-- Área -->
<div id="divCadastrarAreas" style="display: none">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="titulo-detalhes">Cadastrar Áreas</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Nova Área</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Cadastre uma nova área para o seu evento</h6>
                  <form method="POST" action="{{route('area.store')}}">
                      @csrf
                    <p class="card-text">
                            <input type="hidden" name="eventoId" value="{{$evento->id}}">
                            <div class="row justify-content-center">
                                <div class="col-sm-12">
                                    <label for="nome" class="col-form-label">{{ __('Nome da Área') }}</label>
                                    <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                                    @error('nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    {{ __('Finalizar') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
              </div>{{-- End card--}}
        </div>
    </div>
</div>

<div id="divListarAreas" style="display: none">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="titulo-detalhes">Listar Áreas</h1>
        </div>
    </div>

    <div class="row justify-content-center">

        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Áreas</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Áreas cadastradas no seu evento</h6>
                  <p class="card-text">
                    <table class="table table-hover table-responsive-lg table-sm">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col" style="text-align:center">Remover</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($areas as $area)
                            <tr>
                              <th scope="row">{{$area->id}}</th>
                              <td>{{$area->nome}}</td>
                              <td>
                                <form method="POST" action="{{route('area.delete', $area->id)}}">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                  <button type="submit" class="dropdown-item">
                                    <img src="{{asset('img/icons/trash-alt-regular.svg')}}" style="width:15px">
                                  </button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                  </p>
                </div>
              </div>
        </div>
    </div>
</div>
<!-- Revisores -->
<div id="divCadastrarRevisores" style="display: none">

    <div class="row">
        <div class="col-sm-12">
            <h1 class="titulo-detalhes">Cadastrar Revisores</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Revisores</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Cadastre um novo revisor no seu evento</h6>
                    <form method="POST" action="{{route('revisor.store')}}">
                        @csrf
                        <p class="card-text">
                            <input type="hidden" name="eventoId" value="{{$evento->id}}">
                            <div class="row justify-content-center">
                                <div class="col-sm-4">
                                    <label for="nomeRevisor" class="col-form-label">{{ __('Nome do Revisor') }}</label>
                                    <input id="nomeRevisor" type="text" class="form-control @error('nomeRevisor') is-invalid @enderror" name="nomeRevisor" value="{{ old('nomeRevisor') }}" required autocomplete="nomeRevisor" autofocus>

                                    @error('nomeRevisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="emailRevisor" class="col-form-label">{{ __('Email do Revisor') }}</label>
                                    <input id="emailRevisor" type="text" class="form-control @error('emailRevisor') is-invalid @enderror" name="emailRevisor" value="{{ old('emailRevisor') }}" required autocomplete="emailRevisor" autofocus>

                                    @error('emailRevisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="areaRevisor" class="col-form-label">{{ __('Área') }}</label>
                                    <select class="form-control @error('areaRevisor') is-invalid @enderror" id="areaRevisor" name="areaRevisor">
                                        <option value="" disabled selected hidden>-- Área --</option>
                                        @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->nome}}</option>
                                        @endforeach
                                    </select>

                                    @error('areaRevisor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width:100%">
                                    {{ __('Finalizar') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>




</div>
<div id="divListarRevisores" style="display: none">

    <div class="row">
        <div class="col-sm-12">
            <h1 class="titulo-detalhes">Listar Revisores</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Revisores</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Revisores cadastrados no seu evento</h6>
                  <p class="card-text">
                    <table class="table table-hover table-responsive-lg table-sm">
                        <thead>
                          <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Área</th>
                            <th scope="col" style="text-align:center">Em Andamento</th>
                            <th scope="col" style="text-align:center">Finalizados</th>
                            <th scope="col" style="text-align:center">Visualizar</th>
                            <th scope="col" style="text-align:center">Lembrar</th>
                            <th scope="col" style="text-align:center">Remover</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($revisores as $revisor)
                            <tr>
                              <td>{{$revisor->user->email}}</td>
                              <td>{{$revisor->area->nome}}</td>
                              <td style="text-align:center">{{$revisor->correcoesEmAndamento}}</td>
                              <td style="text-align:center">{{$revisor->trabalhosCorrigidos}}</td>
                              <td style="text-align:center">
                                <a href="#" data-toggle="modal" data-target="#modalRevisor">
                                  <img src="{{asset('img/icons/eye-regular.svg')}}" style="width:20px">
                                </a>
                              </td>
                              <td style="text-align:center">
                                  <form action="{{route('revisor.email')}}" method="POST" >
                                    @csrf
                                      <input type="hidden" name="user" value= '@json($revisor->user)'>
                                      <button class="btn btn-primary btn-sm" type="submit">
                                          Enviar e-mail
                                      </button>
                                  </form>
                              </td>
                              <td>
                                <form method="POST" action="{{route('revisor.delete', ['eventoId' => $evento->id, 'userId' => $revisor->user->id])}}">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                                  <button type="submit" class="dropdown-item">
                                    <img src="{{asset('img/icons/trash-alt-regular.svg')}}" style="width:15px">
                                  </button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @if(count($revs) > 0 && isset($revs))
                        <form action="{{route('revisor.emailTodos')}}" method="POST" >
                            @csrf
                              <input type="hidden" name="revisores" value='@json($revs)'>
                              <button class="btn btn-primary btn-sm" type="submit">
                                  Lembrar todos
                              </button>
                          </form>
                      @endif
                      
                  </p>

                </div>
              </div>
        </div>
    </div>
</div>


<!-- Modal Revisor -->
<div class="modal fade" id="modalRevisor" tabindex="-1" role="dialog" aria-labelledby="modalRevisor" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Revisor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-sm-6">
            <label for="">Nome</label>
            <h5>Nome do Revisor</h5>
          </div>
          <div class="col-sm-6">
            <label for="">E-mail</label>
            <h5>E-mail do Revisor</h5>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-sm-6">
            <label for="">Área</label>
            <h5>Área do Revisor</h5>
          </div>
          <div class="col-sm-6">
            <label for="">Instituição</label>
            <h5>Instituição do Revisor</h5>
          </div>
        </div>

        <div class="row justify-content-center" style="margin-top:20px">
          <div class="col-sm-12">
            <h4>Trabalhos</h4>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-sm-12">
            <table class="table table-hover table-responsive-lg table-sm">
                <thead>
                  <tr>
                    <th scope="col">Título</th>
                    <th scope="col">Status</th>

                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Título do trabalho</td>
                    <td>Status do trabalho</td>

                  </tr>
                </tbody>
              </table>
          </div>
        </div>
        </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Salvar</button>
      </div> -->
    </div>
  </div>
</div>

<!-- Modal Trabalho -->
<div class="modal fade" id="modalTrabalho" tabindex="-1" role="dialog" aria-labelledby="modalTrabalho" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Trabalho</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-sm-12">
            <h5>Título</h5>
            <p id="tituloTrabalhoAjax"></p>
          </div>

        </div>
        <div class="row justify-content-center">
          <div class="col-sm-12">
            <h5>Resumo</h5>
            <p id="resumoTrabalhoAjax"></p>
          </div>
        </div>

        <div class="row justify-content-center" style="margin-top:20px">
          <div class="col-sm-12">
            <h5>Remover Revisor</h5>
          </div>
        </div>
        <form action="{{ route('atribuicao.delete') }}" method="post">
          @csrf
          <input type="hidden" name="eventoId" value="{{$evento->id}}">
          <input type="hidden" name="trabalhoId" value="" id="removerRevisorTrabalhoId">
        <div class="row justify-content-center">
          <div class="col-sm-9">
              <div id="revisoresAjax" class="revisoresTrabalho" style="padding-left:20px">
                <div id="cblist">

                </div>
              </div>
          </div>
          <div class="col-sm-3">
            <button type="submit" class="btn btn-primary" id="removerRevisorTrabalho">Remover Revisor</button>
          </div>
        </div>
      </form>
        <div class="row">
          <div class="col-sm-12">
            <h5>Adicionar Revisor</h5>
          </div>
        </div>
        <form action="{{ route('distribuicaoManual') }}" method="post">
          @csrf
          <input type="hidden" name="trabalhoId" value="" id="distribuicaoManualTrabalhoId">
          <input type="hidden" name="eventoId" value="{{$evento->id}}">
          <div class="row" >
            <div class="col-sm-9">
              <div class="form-group">
                <select name="revisorId" class="form-control" id="selectRevisorTrabalho">


                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <button type="submit" class="btn btn-primary" id="addRevisorTrabalho">Adicionar Revisor</button>
            </div>
        </form>
        </div>
        </div>
      <div class="modal-footer">


      </div>
    </div>
  </div>
</div>


<!-- Modal Trabalho -->
<div class="modal fade" id="modalDistribuicaoAutomatica" tabindex="-1" role="dialog" aria-labelledby="modalDistribuicaoAutomatica" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Trabalho</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="GET" action="{{ route('distribuicaoAutomaticaPorArea') }}" id="formDistribuicaoPorArea">
        <div class="modal-body">
          <input type="hidden" name="eventoId" value="{{$evento->id}}">
          <div class="row">
            <div class="col-sm-12">
                <label for="areaId" class="col-form-label">{{ __('Área') }}</label>
                <select class="form-control @error('areaId') is-invalid @enderror" id="areaIdformDistribuicaoPorArea" name="areaId">
                    <option value="" disabled selected hidden> Área </option>
                    @foreach($areas as $area)
                        <option value="{{$area->id}}">{{$area->nome}}</option>
                    @endforeach
                </select>

                @error('areaId')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="row">
              <div class="col-sm-12">
                  <label for="numeroDeRevisoresPorTrabalho" class="col-form-label">{{ __('Número de revisores por trabalho') }}</label>
              </div>
          </div>
          <div class="row justify-content-center">
              <div class="col-sm-12">
                  <input id="numeroDeRevisoresPorTrabalhoInput" type="number" min="1" class="form-control @error('numeroDeRevisoresPorTrabalho') is-invalid @enderror" name="numeroDeRevisoresPorTrabalho" value="{{ old('numeroDeRevisoresPorTrabalho') }}" required autocomplete="numeroDeRevisoresPorTrabalho" autofocus>

                  @error('numeroDeRevisoresPorTrabalho')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>

          </div>{{-- end row--}}
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button id="numeroDeRevisoresPorTrabalhoButton" disabled onclick="document.getElementById('formDistribuicaoPorArea').submit();" type="button" class="btn btn-primary">Distribuir</button>
      </div>
    </div>
  </div>
</div>




</div>
<input type="hidden" name="trabalhoIdAjax" value="1" id="trabalhoIdAjax">

@endsection
@section('javascript')
  <script type="text/javascript" >

  function trabalhoId(x){
    document.getElementById('trabalhoIdAjax').value = x;
  }

  $(function(){
    $('#areas').click(function(){
        $('#dropdownAreas').slideToggle(200);
    });
    $('#revisores').click(function(){
            $('#dropdownRevisores').slideToggle(200);
    });
    $('#comissao').click(function(){
            $('#dropdownComissao').slideToggle(200);
    });
    $('#modalidades').click(function(){
            $('#dropdownModalidades').slideToggle(200);
    });
    $('#trabalhos').click(function(){
            $('#dropdownTrabalhos').slideToggle(200);
    });
    $('.botaoAjax').click(function(e){
       e.preventDefault();
       $.ajaxSetup({
          headers: {
              // 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              'Content-Type': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
          }
      });
       jQuery.ajax({
          url: "{{ route('detalhesTrabalho') }}",
          method: 'get',
          data: {
             // name: jQuery('#name').val(),
             // type: jQuery('#type').val(),
             // price: jQuery('#price').val()
             trabalhoId: $('#trabalhoIdAjax').val()
          },
          success: function(result){
            // result = JSON.parse(result[0]);
            // console.log(result.titulo);
            $('#tituloTrabalhoAjax').html(result.titulo);
            $('#resumoTrabalhoAjax').html(result.resumo);
            $('#distribuicaoManualTrabalhoId').val($('#trabalhoIdAjax').val());
            $('#removerRevisorTrabalhoId').val($('#trabalhoIdAjax').val());
            // console.log(result.revisores);
            var container = $('#cblist');
            container.empty();
            result.revisores.forEach(addCheckbox);
            var container = $('#selectRevisorTrabalho');
            container.empty();
            addDisabledOptionToSelect();
            result.revisoresDisponiveis.forEach(addOptionToSelect);

          }});
       });
    $('#areaIdformDistribuicaoPorArea').change(function () {
      $.ajaxSetup({
         headers: {
             // 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             'Content-Type': 'application/json',
             'X-Requested-With': 'XMLHttpRequest'
         }
      });
      jQuery.ajax({
         url: "{{ route('numeroDeRevisoresAjax') }}",
         method: 'get',
         data: {
            // name: jQuery('#name').val(),
            // type: jQuery('#type').val(),
            // price: jQuery('#price').val()
            areaId: $('#areaIdformDistribuicaoPorArea').val()
         },
         success: function(result){
           if(result == 0){
             $('#numeroDeRevisoresPorTrabalhoButton').prop('disabled', true);
             alert("Não existem revisores nessa área.");
           }
           else{
             if($('#numeroDeRevisoresPorTrabalhoInput').val() < 1){
               $('#numeroDeRevisoresPorTrabalhoButton').prop('disabled', true);
             }
             else{
               $('#numeroDeRevisoresPorTrabalhoButton').prop('disabled', false);
             }
           }
           // $('#tituloTrabalhoAjax').html(result.titulo);
           // $('#resumoTrabalhoAjax').html(result.resumo);
           // $("h1, h2, p").toggleClass("blue");
         }});
    });
    $('#numeroDeRevisoresPorTrabalhoInput').on("input", function (){
      if($('#numeroDeRevisoresPorTrabalhoInput').val() < 1){
        $('#numeroDeRevisoresPorTrabalhoButton').prop('disabled', true);
      }
      else{
        $('#numeroDeRevisoresPorTrabalhoButton').prop('disabled', false);
      }
    });
  });




    function myFunction(item, index) {
      // document.getElementById("demo").innerHTML += index + ":" + item + "<br>";
      console.log(index);
      console.log(item.id);
    }

    function addCheckbox(item) {
       var container = $('#cblist');
       var inputs = container.find('input');
       var id = inputs.length+1;

       var linha = "<div class="+"row"+">"+
                    "<div class="+"col-sm-12"+">"+
                    "<input type="+"checkbox"+" id="+"cb"+id+" name="+"revisores[]"+" value="+item.id+">"+
                    "<label for="+"cb"+id+" style="+"margin-left:10px"+">"+item.nomeOuEmail+"</label>"+
                    "</div>"+
                    "</div>";
       $('#cblist').append(linha);
    }
    function addOptionToSelect(item) {
       var container = $('#selectRevisorTrabalho');
       var inputs = container.find('option');
       var id = inputs.length+1;

       var linha = "<option value="+item.id+">"+item.nomeOuEmail+"</option>";
       $('#selectRevisorTrabalho').append(linha);
    }
    function addDisabledOptionToSelect() {
       var container = $('#selectRevisorTrabalho');
       var inputs = container.find('option');

       var linha = "<option value='' disabled selected hidden> Novo Revisor </option>";
       $('#selectRevisorTrabalho').append(linha);
    }

    function cadastrarCoodComissao(){

            document.getElementById("formCoordComissao").submit();
    }

    // var newOptions = {
    //                   "Option 1": "value1",
    //                   "Option 2": "value2",
    //                   "Option 3": "value3"
    //                  };
    // var $el = $("#testeId");
    // // $("#areaRevisorTrabalhos").change(function(){
    // //   alert("The text has been changed.");
    // //   $el.empty(); // remove old options
    // //   $.each(newOptions, function(key,value) {
    // //     $el.append($("<option></option>")
    // //     .attr("value", value).text(key));
    // //   });
    // // });
    // $("#testeId").change(function(){
    //   alert("The text has been changed.");
    // });

    function habilitarPagina(id){
        informacoes = document.getElementById('divInformacoes');

        listarTrabalhos = document.getElementById('divListarTrabalhos');
        submissoesTrabalhos = document.getElementById('divDefinirSubmissoes');

        classificacao = document.getElementById('divClassificacao');
        atividades = document.getElementById('divAtividades');
        cadastrarAreas = document.getElementById('divCadastrarAreas');
        listarAreas = document.getElementById('divListarAreas');
        cadastrarRevisores = document.getElementById('divCadastrarRevisores');
        listarRevisores = document.getElementById('divListarRevisores');

        cadastrarComissao = document.getElementById('divCadastrarComissao');
        definirCoordComissao = document.getElementById('divDefinirCoordComissao');
        listarComissao = document.getElementById('divListarComissao');

        cadastrarModalidade = document.getElementById('divCadastrarModalidades');
        listarModalidade = document.getElementById('divListarModalidades');

        // habilita divInformacoes
        if(id == 'informacoes'){
            console.log('informacoes');
            informacoes.style.display = "block";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";
        }
        if(id == 'listarTrabalhos'){
            console.log('listarTrabalhos');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "block";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";
        }

        if(id == 'modalidades'){
            console.log('modalidades');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";

        }
        if(id == 'colocacao'){
            console.log('colocacao');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "block";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";

        }
        if(id == 'atividades'){
            console.log('atividades');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "block";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";

        }
        if(id == 'cadastrarAreas'){
            console.log('cadastrarAreas');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "block";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";

        }
        if(id == 'listarAreas'){
            console.log('listarAreas');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "block";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";

        }

        if(id == 'cadastrarRevisores'){
            console.log('cadastrarRevisores');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "block";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";


        }
        if(id == 'listarRevisores'){
            console.log('listarRevisores');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "block";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";


        }
        if(id == 'cadastrarComissao'){
            console.log('cadastrarComissao');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "block";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";


        }
        if(id == 'definirCoordComissao'){
            console.log('definirCoordComissao');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "block";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";


        }
        if(id == 'listarComissao'){
            console.log('listarComissao');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "block";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "none";
        }
        if(id == 'cadastrarModalidade'){
            console.log('cadastrarModalidade');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "block";
            listarModalidade.style.display = "none";
        }
        if(id == 'listarModalidade'){
            console.log('listarModalidade');
            informacoes.style.display = "none";
            listarTrabalhos.style.display = "none";
            submissoesTrabalhos.style.display = "none";
            classificacao.style.display = "none";
            atividades.style.display = "none";
            cadastrarAreas.style.display = "none";
            listarAreas.style.display = "none";
            cadastrarRevisores.style.display = "none";
            listarRevisores.style.display = "none";
            cadastrarComissao.style.display = "none";
            definirCoordComissao.style.display = "none";
            listarComissao.style.display = "none";
            cadastrarModalidade.style.display = "none";
            listarModalidade.style.display = "block";
        }
        if(id == 'submissoesTrabalhos'){
          informacoes.style.display = "none";
          listarTrabalhos.style.display = "none";
          submissoesTrabalhos.style.display = "block";
          classificacao.style.display = "none";
          atividades.style.display = "none";
          cadastrarAreas.style.display = "none";
          listarAreas.style.display = "none";
          cadastrarRevisores.style.display = "none";
          listarRevisores.style.display = "none";
          cadastrarComissao.style.display = "none";
          definirCoordComissao.style.display = "none";
          listarComissao.style.display = "none";
          cadastrarModalidade.style.display = "none";
          listarModalidade.style.display = "none";
        }

    }



  </script>

@endsection
