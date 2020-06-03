@extends('layouts.app')

@section('content')
<div class="container content">

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card" style="margin-top:50px">
                <div class="card-body">
                  <h5 class="card-title">Meu Parecer</h5>
                  <h6 class="card-title">Trabalho: {{ $trabalho->titulo }}</h6>
                  <p class="card-text">
                    <form method="POST" action="{{route('avaliador.enviarParecer')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" >
												<div class="form-group">
											    <label for="exampleFormControlTextarea1">Parecer:</label>
											    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="textParecer">{{ $trabalho->pivot->parecer }}</textarea>
											  </div>
											  <div class="form-group">
											  	@if($trabalho->pivot->AnexoParecer == null)
														<label for="exampleFormControlFile1">Anexo do Parecer:</label>
											    	<input type="file" class="form-control-file" id="exampleFormControlFile1" name="anexoParecer">

											  	@else
														<label for="exampleFormControlFile1">Atualizar arquivo do Parecer?</label> <br>
														<label for="exampleFormControlFile1">Arquivo:{{ $trabalho->pivot->AnexoParecer }}</label>
											    	<input type="file" class="form-control-file" id="exampleFormControlFile1" name="anexoParecer">
											  	@endif
											    
											  </div>
												<button type="submit" class="btn btn-primary">Enviar</button>
												<a href="{{url()->previous()}}"  class="btn btn-danger" >Cancelar</a>
                    </form>

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
