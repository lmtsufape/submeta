@extends('layouts.app')

@section('content')
<div class="container content">

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card" style="margin-top:50px">
                <div class="card-body">
                <a href="{{url()->previous()}}" class="btn btn-primary mb-2"> Voltar</a>
                  <h5 class="card-title">Parecer do avaliador: {{ $avaliador->user->name }}</h5>
                  <h6 class="card-title">Trabalho: {{ $trabalho->titulo }}</h6>
                  <p class="card-text">
                    <div class="form-group">
                      <label>Link para parecer: </label>
                      <input type="text" class="form-control" id="exampleFormControlTextarea1" name="textParecer" value="{{ $evento->formAvaliacaoExterno }}" disabled />
                    </div>    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Pontuação: <strong>{{ $parecer->pontuacao }}</strong> </label>
                    </div>
									  <div class="form-group">
									    <label for="exampleFormControlSelect1">Recomendação: <strong>{{ $parecer->recomendacao }}</strong> </label>
									  </div>
                </div>
              </div>
        </div>
    </div>

</div>
@endsection

@section('javascript')
<script type="text/javascript">


</script>
@endsection
