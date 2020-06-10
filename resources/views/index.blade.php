@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-sm-6" style="position: relative; top: 50px; padding: 25px;">
          <div class="row">
              <img class="position-image" src="{{ asset('img/icons/logo_submeta_grande.png') }}" alt="">
          </div>
          <div class="row position-text">
              <p>
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
              </p>
              <p>
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
              </p>
          </div>
          <div class="row position-text">
              <button class="btn btn-opcoes-edital" style="margin-bottom: 20px;">
                  Leia mais
              </button>
          </div>
      </div>
      <br>
      <div class="col-sm-6" style=" position: relative; top: 50px; padding: 25px;">
          <h4 style="color:  rgb(0, 140, 255);">Editais</h4>
          <div id="editais">
                <ul class="list-editais flexcroll" style="list-style-type: none;">
                @foreach ($eventos as $evento)
                    <li class="li-editais">
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
                                    <button class="btn btn-opcoes-edital" style="margin-left: 15px;">
                                        Opções
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
                @foreach ($eventos as $evento)
                    <li class="li-editais">
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
                                    <button class="btn btn-opcoes-edital" style="margin-left: 15px;">
                                        Opções
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
                @foreach ($eventos as $evento)
                    <li class="li-editais">
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
                                    <button class="btn btn-opcoes-edital" style="margin-left: 15px;">
                                        Opções
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
                @foreach ($eventos as $evento)
                    <li class="li-editais">
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
                                    <button class="btn btn-opcoes-edital" style="margin-left: 15px;">
                                        Opções
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
                </ul>
          </div>
      </div>
  </div>
</div>
@endsection

@section('javascript')


@endsection
