@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 30px;">

  <div class="container" >
    <div class="row">
      @if(session('mensagem'))
        <div class="col-md-12" style="margin-top: 30px;">
            <div class="alert alert-success">
                <p>{{session('mensagem')}}</p>
            </div>
        </div>
      @endif
    </div>
    <div class="row" >
      <div class="col-sm-1">
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">
          Voltar
        </a>
      </div>
      <div class="col-sm-9" style="text-align: center;">
        <h3 class="titulo-table">Usuários</h3> 
      </div>
      <div class="col-sm-2">
        <a href="{{route('admin.user.create')}}" class="btn btn-info" style="float: right;">{{ __('Criar usuário') }}</a>
      </div>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome</th>
        <th scope="col">Tipo</th>
        <th scope="col">Data de Criação</th>
        <th scope="col">Opções</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        @if (auth()->user()->id != $user->id)
          @if(auth()->user()->id != "administrador")
            <tr>
              <td>
                {{ $user->name }}
              </td>
              @if($user->tipo != "avaliador")
                <td>{{ $user->tipo }}</td>
              @else
                <td>{{ $user->tipo }} - @if(isset($user->avaliadors->tipo)){{ $user->avaliadors->tipo }} @else Indefinido @endif </td>
              @endif

              <td>{{ $user->creaet_at }}</td>
              <td>
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{route('admin.user.edit', $user->id)}}" class="dropdown-item text-center">
                            Editar
                        </a>
                        <hr class="dropdown-hr">
                        <form method="POST" action="{{route('admin.user.destroy', $user->id)}}">
                            {{ csrf_field() }}
                            <button type="submit" class="dropdown-item dropdown-item-delete text-center">
                              <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">
                                Deletar
                            </button>

                        </form>
                    </div>
                </div>
              </td>
            </tr>
          @else
            @if ($user->tipo != "administrador" && $user->tipo != "administradorResponsavel") 
            <tr>
              <td>
                {{ $user->name }}
              </td>
              <td>{{ $user->tipo }}</td>
              <td>{{ $user->creaet_at }}</td>
              <td>
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{route('admin.user.edit', $user->id)}}" class="dropdown-item text-center">
                            Editar
                        </a>
                        <hr class="dropdown-hr">
                        <form method="POST" action="{{route('admin.user.destroy', $user->id)}}">
                            {{ csrf_field() }}
                            <button type="submit" class="dropdown-item dropdown-item-delete text-center">
                                <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">
                                Deletar
                            </button>
    
                        </form>
                    </div>
                </div>
              </td>
            </tr>
            @endif
          @endif
        @endif
      @endforeach
    </tbody>
  </table>
</div>

@endsection

@section('javascript')
<script>
  
</script>
@endsection
