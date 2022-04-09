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
									    <label for="exampleFormControlTextarea1">Parecer</label>
									    <textarea class="form-control" id="exampleFormControlTextarea1" disabled="disabled" rows="3"> {{ $parecer->parecer }} </textarea>
									  </div>
                                        @if($trabalho->evento->tipo == "PIBEX")
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Pontuação: <strong>{{ $parecer->pontuacao }}</strong> </label>
                                        </div>
                                        @endif
									  <div class="form-group">
									    <label for="exampleFormControlSelect1">Recomendação: <strong>{{ $parecer->recomendacao }}</strong> </label>
									  </div>
									  <div class="form-group">
									    <label for="exampleFormControlSelect1">Anexo:  </label>
                      <a href="{{route('download', ['file' => $parecer->AnexoParecer])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                        <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                    </a>
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
