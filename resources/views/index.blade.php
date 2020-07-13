@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-sm-6" style="position: relative; top: 50px; padding: 25px;">
          <div class="row">
              <img class="position-image" src="{{ asset('img/icons/logo_submeta_grande.png') }}" alt="">
          </div>
          <div class="row position-text">
              <p style="text-indent: 0.5cm;">
                O Submeta é um sistema de submissão de projetos acadêmicos, que pode ser adotado para os diferentes propósitos de Ensino, Pesquisa e Extensão. O sistema abrange todas as principais etapas relacionadas à submissão de projetos, permitindo o lançamento e configuração de editais, além de gerenciar a distribuição das avaliações e os pareceres técnicos dos avaliadores, como também, visualizar os projetos submetidos pelos proponentes.
              </p>
          </div>
          <div class="row position-text">
              {{-- <button class="btn btn-opcoes-edital" style="margin-bottom: 20px;">
                  Leia mais
              </button> --}}
          </div>
      </div>
      <br>
      <div class="col-sm-6" style=" position: relative; top: 50px; padding: 25px;">
          <h4 style="color:  rgb(0, 140, 255);">Editais</h4>
          <div id="editais">
                <ul class="col-sm-12 list-editais flexcroll" style="list-style-type: none;">
                @foreach ($eventos as $evento)
                    @if (\Carbon\Carbon::create($evento->fimSubmissao) >= \Carbon\Carbon::create($hoje))
                        <li class="col-sm-12 li-editais">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-1">
                                            <img class="img-arquivo" src="{{ asset('img/icons/logo_arquivo.png') }}" alt="">
                                    </div>
                                    <div class="col-sm-8">
                                            <div>{{$evento->nome}}</div>
                                            <div class="color-subtitle-edital">Submissão até o dia {{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</div>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="{{ route('evento.visualizarNaoLogado', ['id' => $evento->id]) }}">
                                            <button class="btn btn-opcoes-edital" style="float: left;">
                                                Visualizar
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>    
                    @endif
                @endforeach
          </div>
      </div>
  </div>
</div>
@endsection

@section('javascript')


@endsection
