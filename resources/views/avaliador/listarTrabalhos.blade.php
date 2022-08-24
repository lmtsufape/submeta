@extends('layouts.app')

@section('content')

<div class="container">

  @if($errors->any())
      <div class="col-sm-12">
        <br>
        <div class="alert alert-danger">
            <p> {{$errors->first()}}</p>
        </div>
      </div>
  @endif
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
          @if($trabalhosIn != null)
          <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
          <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
            <div class="bottomVoltar" style="margin-top: -20px">
              <a href="javascript:history.back()"  class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
            </div>

            <div class="form-group">
                <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Avaliação Interna do Edital: {{ $evento->nome }}</h5>
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
          @endif


          @if($trabalhosIn != null)
        <div class="card-body" >
            <table class="table table-bordered table-hover" style="display: block; white-space: nowrap; border-radius:10px; margin-bottom:0px">
              <thead>
                <tr>
                  <th scope="col" style="width:100%">Nome do Projeto</th>
                  <th scope="col">Data de Criação</th>
                  @if(Auth::user()->avaliadors->tipo == 'Externo' || Auth::user()->avaliadors->tipo == null)
                      <th scope="col">Projeto</th>
                      <th scope="col">Plano de Trabalho</th>
                      <th scope="col" style="text-align: center">Status</th>
                  @else
                      <th scope="col" style="text-align: center">Status</th>
                      <th scope="col">Parecer Interno</th>
                  @endif

                </tr>
              </thead>
              <tbody>
                @foreach ($trabalhosIn as $trabalho)
                  <tr>
                    <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">{{ $trabalho->titulo }}</td>
                    <td style="text-align: center">{{ $trabalho->created_at->format('d/m/Y') }}</td>
                    @if(Auth::user()->avaliadors->tipo == 'Externo' || Auth::user()->avaliadors->tipo == null)
                        <td>
                          {{--  --}}
                          <a href="{{route('download', ['file' => $trabalho->anexoProjeto])}}" target="_new" style="font-size: 20px; color: #114048ff;" class="btn btn-light">
                              <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:15px">
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
                              <a href="{{route('download', ['file' => $planoTrabalho])}}" target="_new" style="font-size: 20px; color: #114048ff;" class="btn btn-light">
                                <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:15px">
                              </a>
                            @else
                              Não há planos de trabalho.
                            @endif
                          @endforeach
                        </td>
                        <td>
                          <div class="row justify-content-center">
                            <form action="{{ route('avaliador.parecer', ['evento' => $evento]) }}" method="POST">
                              @csrf
                              <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" >
                              @if($trabalho->pivot->AnexoParecer == null)
                                <button type="submit" class="btn btn-primary mr-2 ml-2" >
                                    Parecer
                                </button>
                              @else
                                <button type="submit" class="btn btn-secondary mr-2 ml-2" >
                                    Enviado
                                </button>
                              @endif

                            </form>
                          </div>
                        </td>
                    @else
                        @php
                          $parecer = App\ParecerInterno::where([['avaliador_id',Auth::user()->avaliadors->id],['trabalho_id',$trabalho->id]])->first();
                        @endphp
                          <td>
                              @if($parecer != null && $parecer->statusParecer !=null)
                                @if($parecer->statusParecer == 'RECOMENDADO')
                                  Recomendado
                                @else
                                  Não Recomendado
                                @endif
                              @else 
                                  Pendente 
                              @endif
                          </td>
                          <td>
                              <div class="row justify-content-center">
                                  <form action="{{ route('avaliador.parecerInterno', ['evento' => $evento]) }}" method="POST">
                                      @csrf
                                      <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}">

                                      <button type="submit" class="btn btn-primary mr-2 ml-2">
                                          Parecer
                                      </button>

                                  </form>
                              </div>
                          </td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
          </table>
        </div>
          @endif

       @if($trabalhosEx != null)
          <div class="form-group mb-0" style="margin-left: 20px;margin-top: 20px;">
              <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Avaliação <i>Ad Hoc</i> do Edital: {{ $evento->nome }}</h5>
          </div>
          <hr class="mb-0">
        <div class="card-body" >
              <table class="table table-bordered table-hover" style="display: block; white-space: nowrap; border-radius:10px; margin-bottom:0px">
                  <thead>
                  <tr>
                      <th scope="col" style="width:100%">Nome do Projeto</th>
                      <th scope="col">Data de Criação</th>
                      <th scope="col">Projeto</th>
                      <th scope="col">Plano de Trabalho</th>
                      <th scope="col" style="text-align: center">Status</th>
                      <th scope="col">Parecer Externo</th>

                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($trabalhosEx as $trabalho)
                
                      <tr>
                          <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">{{ $trabalho->titulo }}</td>
                          <td style="text-align: center">{{ $trabalho->created_at->format('d/m/Y') }}</td>
                              <td style="text-align: center">
                                  {{--  --}}
                                  <a href="{{route('download', ['file' => $trabalho->anexoProjeto])}}" target="_new" style="font-size: 20px; color: #114048ff;" class="btn btn-light">
                                      <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:15px">
                                  </a>
                              </td>
                              <td style="text-align: center">
                                  @foreach( $trabalho->participantes as $participante)
                                      @php
                                          if( App\Arquivo::where('participanteId', $participante->id)->first() != null){
                                            $planoTrabalho = App\Arquivo::where('participanteId', $participante->id)->first()->nome;
                                          }else{
                                            $planoTrabalho = null;
                                          }
                                      @endphp
                                      @if ($planoTrabalho != null)
                                          <a href="{{route('download', ['file' => $planoTrabalho])}}" target="_new" style="font-size: 20px; color: #114048ff;" class="btn btn-light">
                                              <img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:15px">
                                          </a>
                                      @else
                                          Não há planos de trabalho.
                                      @endif
                                  @endforeach
                              </td>
                              <td style="text-align: center">
                                @if($trabalho->pivot->recomendacao == 'RECOMENDADO')
                                    Recomendado
                                @elseif($trabalho->pivot->recomendacao == null)
                                    Pendente
                                @else
                                    Não Recomendado
                                @endif
                              </td>
                              <td>
                                  <div class="row justify-content-center">
                                      <form action="{{ route('avaliador.parecer', ['evento' => $evento]) }}" method="POST">
                                          @csrf
                                          <input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" >
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
      @endif
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script>

</script>
@endsection
