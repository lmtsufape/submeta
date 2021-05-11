@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 50px;">
    <div class="row" >
        <div class="col-sm-12">
            <h2 style="color: rgb(0, 140, 255);">{{ __('Criar uma nova grande área') }}</h2>
        </div>
    </div>  
    <div class="row">
        <form method="POST" action="{{ route('grandearea.salvar')}}">
            @csrf
            <div class="col-sm-12">
                <label for="nome" class="col-form-label" style="color: rgb(0, 140, 255);">{{ __('Nome') }}<span style="color: red;"> *</span></label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus >

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <button type="submit" class="btn btn-info" style="position:relative;top:10px;">{{ __('Salvar') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection