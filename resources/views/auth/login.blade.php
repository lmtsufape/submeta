@extends('layouts.app')

@section('content')
<div class="container content" style="margin-top: 40px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card card-login-cadastro">
                {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                <div class="card-body" style="font-weight: bolder;">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row justify-content-center">
                            <div class="titulo-login-cadastro" style="margin-top: 20px; margin-bottom: 20px; font-size: 20px; color: rgb(0, 140, 255);">{{ __('Login') }}</div>
                        </div>

                        <div class="form-group row">
                            
                            <div class="col-md-12">
                                <label for="email" class="col-form-label text-md-right" style="color: rgb(0, 140, 255);">{{ __('Endereço de E-mail') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            
                            <div class="col-md-12">
                                <label for="password" class="col-form-label text-md-right" style="color: rgb(0, 140, 255);">{{ __('Senha') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Lembrar Senha') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" style="width:100%; font-weight: 700;">
                                    {{ __('Login') }}
                                </button>
                                <div class="row justify-content-center">
                                
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu sua senha?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
