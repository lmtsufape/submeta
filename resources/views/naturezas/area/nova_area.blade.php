@extends('layouts.app')

@section('content')

<div class="container" >
    <div class="row" >
        <div class="col-sm-12">
            <h2 style="margin-top: 100px; ">{{ __('Criar uma nova área') }}</h2>
        </div>
    </div>  
    <div class="row">
        <form method="POST" action="{{ route('area.salvar', ['id' => $grandeAreaId])}}">
            @csrf
            <div class="col-sm-12">
                <label for="nome" class="col-form-label">{{ __('Nome') }}</label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                @error('nome')
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