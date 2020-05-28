@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        <div class="col-sm-12">
            <h2 style="margin-top: 100px; ">{{ __('Editar um usuário') }}</h2>
        </div>
    </div>  
    <div class="row">
        <form method="POST" action="{{ route('admin.user.update', ['id' => $user->id])}}">
            @csrf
            <div class="col-sm-12">
                

                <label for="nome" class="col-form-label">{{ __('Nome') }}</label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $user->name }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="email" class="col-form-label">{{ __('Email') }}</label>
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="nome" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="tipo" class="col-form-label">{{ __('Tipo') }}</label>
                
                <div>
                    <select name="tipo" id="">
                        <option value="{{$user->tipo}}">{{$user->tipo}}<option>
                        <option value="administrador">administrador</option>
                        <option value="administradorResponsavel">administradorResponsavel</option>
                        <option value="coordenador">coordenador</option>
                        <option value="proponente">proponente</option>
                        <option value="participante">participante</option>
                    </select> 
                </div>
                
                <label for="passworld" class="col-form-label">{{ __('Senha atual') }}</label>
                <input id="passworld" type="text" class="form-control @error('senha_atual') is-invalid @enderror" name="senha_atual" value="" required autocomplete="nome" autofocus>

                @error('senha_atual')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="new_passworld" class="col-form-label">{{ __('Nova senha') }}</label>
                <input id="new_passworld" type="text" class="form-control @error('nova_senha') is-invalid @enderror" name="nova_senha" value="" required autocomplete="nome" autofocus>

                @error('nova_senha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <label for="confirm_passworld" class="col-form-label">{{ __('Confirmar nova senha') }}</label>
                <input id="confirmar_passworld" type="text" class="form-control @error('confirmar_senha') is-invalid @enderror" name="confirmar_senha" value="" required autocomplete="nome" autofocus>

                @error('confirmar_senha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <button type="submit" class="btn btn-primary" style="position:relative;top:10px;">{{ __('Salvar') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection