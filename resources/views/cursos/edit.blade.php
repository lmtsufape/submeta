@extends('layouts.app')
@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="container" >
        <div class="row" >
            <div class="col-sm-5">
            <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
        <div class="col-sm-3" style="float: center;">
            <div class="titulo-table"><h4>Criar um novo curso</h4></div>
        </div>
    </div>
    <hr>
    <form action="{{route('cursos.update', ['id' => $curso->id])}}" method="POST">
    @csrf
        <div class='row justify-content-center'>
            <div class='col-sm-5'>
                <label for="curso" class="col-form-label" style="color: rgb(0, 140, 255);">Nome do curso:
                    <span style="color: red;">*</span>
                </label>
                <input class="form-control @error('curso') is-invalid @enderror" type="text" id='curso' name='curso' value="{{$curso->nome}}" required autocomplete='curso' autofocus>
            </div>
            @error('curso')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div>
                <button type='submit' class='btn btn-info' style="position:relative;top:37px;">Salvar</button>
            </div>
        </div>        
    </form>
</div>
@endsection