@extends('layouts.app')

@section('content')
<div class="container content"  style="margin-top: 3rem">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm shadow bg-white"  style="border-radius:12px; border-width:0px;">
                <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                    <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:6px">
                        <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Verifique o seu endereço de e-mail</h5>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Um novo link de verificação foi enviado para o seu e-mail.') }}
                        </div>
                    @endif

                    {{ __('Antes de prosseguir, verifique o seu e-mail e procure por um link de verificação.') }}
                    {{ __('Se você não recebeu o e-mail') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('clique aqui para solicitar outro.') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
