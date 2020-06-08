@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
        <h3>Trabalhos do Edital: {{ $evento->nome }}</h3> 
      </div>
    </div>
  </div>
  <hr>
      <div class="accordion" id="accordionExample">
        @foreach( $trabalhos as $trabalho )
        <div class="card ">
          <div class="card-header " id="headingOne">
            <h2 class="mb-0">

              <a class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne{{ $trabalho->id }}" aria-expanded="true" aria-controls="collapseOne">
                <h5>Titulo: {{ $trabalho->titulo }}</h5> 
                
              </a>
            </h2>
          </div>

          <div id="collapseOne{{ $trabalho->id }}" class="collapse @if($trabalhos->first() == $trabalho) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Avaliador</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Parecer</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($trabalho->avaliadors as $avaliador)
                    <tr>
                      <td>{{ $avaliador->user->name }}</td>
                      <td>{{ $avaliador->user->email }}</td>
                      <td>
                        <form action="{{ route('admin.visualizarParecer') }}" method="post">
                          @csrf
                          <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">
                          <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}">
                          <button class="btn btn-primary" @if($avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot->parecer == null) disabled="disabled" @endif >
                            Visualizar
                          </button>
                        </form>
                        
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        @endforeach
      </div>
</div>

@endsection

@section('javascript')
<script>
  
</script>
@endsection
