@extends('layouts.app')

@section('content')


<div class="container">
  @if(isset($mensagem))
  <div class="col-sm-12">
      <br>
      <div class="alert alert-success">
          <p>{{ $mensagem }}</p>
      </div>
  </div>
  @endif
  @if(session('mensagem'))
  <div class="col-sm-12">
      <br>
      <div class="alert alert-success">
          <p>{{session('mensagem')}}</p>
      </div>
  </div>
  @endif
  <div class="row justify-content-center" style="margin-top: 3rem;">
    <div class="col-md-11" style="margin-bottom: -3rem">
      <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
        <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
            <div class="bottomVoltar" style="margin-top: -20px">
              <a href="{{ route('home') }}"  class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
            </div>
            <div class="form-group">
                <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Planos do edital: {{ $evento->nome }}</h5>
            </div>
            <div style="margin-top: -2rem">
              <div class="form-group">
                <div style="margin-top:30px;">
                 {{-- Pesquisar--}}
                </div>
              </div>
            </div>
          </div>
        </div>
        

        <div class="card-body" >
            <table class="table table-bordered table-hover" style="display: block; overflow-x: auto; white-space: nowrap; border-radius:10px; margin-bottom:0px">
              <thead>
                <tr>
                  <th scope="col" style="width:100%">Nome do Projeto</th>
                  <th scope="col">Data de Criação</th>
                  <th scope="col">Parecer</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($planos as $plano)
                    <tr>
                      <td>{{ $plano->titulo }}</td>
                      <td>{{ $plano->created_at->format('d/m/Y') }}</td>
                      {{-- <td>
                        <a href="{{route('download', ['file' => $trabalho->anexoProjeto])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                            <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                        </a>
                      </td>
                      <td>
                        @foreach( $trabalho->participantes as $participante)
                          @php
                            if( App\Arquivo::where('participanteId', $participante->id)->first() != null){
                              $planoTrabalho = App\Arquivo::where('participanteId', $participante->id)->first()->nome;
                            }else{
                              $planoTrabalho = null;
                            }
                          @endphp
                          @if ($planoTrabalho != null)
                            <a href="{{route('download', ['file' => $planoTrabalho])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
                              <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
                            </a>
                          @else
                            Não há planos de trabalho.
                          @endif
                        @endforeach
                      </td> --}}
                      <td>
                        <div class="row">
                          <form action="{{ route('avaliador.parecer.plano', ['evento' => $evento]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="plano_id" value="{{ $plano->id }}" >
                            <button type="submit" class="btn btn-primary mr-2 ml-2" >
                              Parecer
                            </button>

                          </form>
                        </div>
                      </td>
                    </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script>

</script>
@endsection
