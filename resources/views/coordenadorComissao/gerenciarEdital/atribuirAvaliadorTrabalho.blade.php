@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

			<h2>{{$trabalho->titulo}}</h2>

	    <form action="{{ route('coordenador.atribuir') }}" method="post" enctype="multipart/form-data">
        @csrf
				<input type="hidden" name="trabalho_id" value="{{$trabalho->id}}" >
        <div class="form-group">
			      <label>Avaliadores</label>
			      <select name="avaliadores[]" id="" class="form-control" multiple>
			          @foreach($avaliadores as $avaliador)
			              <option value="{{$avaliador->id}}">{{$avaliador->user->name}}</option>
			          @endforeach
			      </select>
			  </div>

        <div>
        		<a href="{{ route('coordenador.detalhesEdital', ['evento_id' => $evento->id]) }}" class="btn btn-danger">Cancelar</a>
            <button type="submit" class="btn btn-primary">Atribuir</button>

        </div>
    </form>
 </div>
    

@endsection

@section('javascript')
<script>
  
</script>
@endsection
