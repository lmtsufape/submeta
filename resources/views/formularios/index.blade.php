@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row titulo">
        <h1>Formulários</h1>
    </div>
    <div class="col-sm-3">
        <a href="{{route('evento.formularios.create', $edital->id)}}" class="btn btn-info" style="float: right;">Criar Formulário</a>
    </div>
</div>

@endsection
@section('javascript')
@endsection