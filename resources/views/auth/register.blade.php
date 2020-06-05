@extends('layouts.app')

@section('content')
<div class="container content">
    <div class="row titulo">
        <h1>Cadastro</h1>
    </div>

    <div class="row subtitulo">
        <div class="col-sm-12">
            <p>Informações Pessoais</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        {{-- Nome | CPF --}}
        <div class="form-group row">

            <div class="col-md-8">
                <label for="name" class="col-form-label">{{ __('Nome Completo') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="cpf" class="col-form-label">{{ __('CPF') }}</label>
                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>

                @error('cpf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        {{-- Instituição de Ensino e Celular --}}
        <div class="form-group row">
            <div class="col-md-8">
                <label for="instituicao" class="col-form-label">{{ __('Instituição de Vínculo') }}</label>
                <input id="instituicao" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="instituicao" value="{{ old('instituicao') }}" required autocomplete="instituicao" autofocus>

                @error('instituicao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="celular" class="col-form-label">{{ __('Celular') }}</label>
                <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="celular" autofocus>

                @error('celular')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Email | Senha | Confirmar Senha --}}
        <div class="form-group row">

            <div class="col-md-4">
                <label for="email" class="col-form-label">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="password" class="col-form-label">{{ __('Senha') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="password-confirm" class="col-form-label">{{ __('Confirme a Senha') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

          <div class="row justify-content-center" style="margin: 20px 0 20px 0">

            <div class="col-md-6" style="padding-left:0">
                <a class="btn btn-secondary botao-form" href="/" style="width:100%">Cancelar Cadastro</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Finalizar Cadastro') }}
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

@section('javascript')
  <script type="text/javascript" >
    $(document).ready(function($){
      $('#cpf').mask('000.000.000-00');
      var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      spOptions = {
        onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
      };
      $('#celular').mask(SPMaskBehavior, spOptions);

    });
  </script>
@endsection
