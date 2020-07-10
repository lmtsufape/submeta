@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    @if ($errors->any())
      <div class="row">
        <div class="col-md-12">
          <ul style="list-style-type: none;">
              @foreach ($errors->all() as $error)
                  <li class="alert alert-danger" role="alert">{{ $error }}</li>
              @endforeach
          </ul>
        </div>
      </div>
    @endif
    <div class="row" >
      <div class="col-sm-10">
        <h3>Usuários</h3> 
      </div>
      <div class="col-sm-2">
        <a href="{{route('admin.user.create')}}" class="btn btn-primary" style="float: right;">{{ __('Criar usuário') }}</a>
      </div>
    </div>
    <div class="row">
      @if(session('mensagem'))
        <div class="col-md-12" style="margin-top: 100px;">
            <div class="alert alert-success">
                <p>{{session('mensagem')}}</p>
            </div>
        </div>
      @endif
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
              <td>{{ $user->tipo }}</td>
              <td>{{ $user->creaet_at }}</td>
              <td>
                <div class="btn-group dropright dropdown-options">
                    <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{route('admin.user.edit', $user->id)}}" class="dropdown-item">
                            <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                            Editar
                        </a>
                        <form method="POST" action="{{route('admin.user.destroy', $user->id)}}">
                            {{ csrf_field() }}
                            <button type="submit" class="dropdown-item">
                                <img src="{{asset('img/icons/trash-alt-regular.svg')}}" class="icon-card" alt="">
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
                        <a href="{{route('admin.user.edit', $user->id)}}" class="dropdown-item">
                            <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                            Editar
                        </a>
                        <form method="POST" action="{{route('admin.user.destroy', $user->id)}}">
                            {{ csrf_field() }}
                            <button type="submit" class="dropdown-item">
                                <img src="{{asset('img/icons/trash-alt-regular.svg')}}" class="icon-card" alt="">
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
