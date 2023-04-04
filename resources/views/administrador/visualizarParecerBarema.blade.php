@extends('layouts.app')

@php $i=0; $numCampos=0; @endphp

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
                      <table class="table table-bordered col-sm-12" id="dynamicAddRemove">
                        <tr>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Nota Máxima</th>
                            <th>Prioridade</th>
                            <th><strong>Nota da avaliação</strong></th>
                        </tr>
                        @foreach ($camposAvaliacao as $campoAvaliacao)
                        <tr>
                          <td><input type="text" name="inputField[{{$i}}][nome]" class="form-control nome" value="{{ $campoAvaliacao->nome }}" disabled/></td>
                          <td><input type="text" name="inputField[{{$i}}][descricao]" class="form-control descricao" value="{{ $campoAvaliacao->descricao }}" disabled/>
                          </td>
                          <td><input type="number" name="inputField[{{$i}}][nota_maxima]" class="form-control nota_maxima" value="{{ $campoAvaliacao->nota_maxima }}" disabled/></td>
                          <td><input type="number" name="inputField[{{$i}}][nota_prioridade]" class="form-control nota_maxima" value="{{ $campoAvaliacao->prioridade }}" disabled/></td>
                          <td> <input type="number" min="0" max="{{ $campoAvaliacao->nota_maxima }}" step="1" name="inputField[{{$i}}][nota]" class="form-control nota" value="{{$avalTrabalho->values()->get($i)->nota}}" style="font-weight: bold;" disabled /> </td>
                          </tr>
                          
                          @php ++$i; ++$numCampos; @endphp
                        @endforeach
                      </table>
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
