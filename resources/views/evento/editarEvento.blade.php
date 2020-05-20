@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row titulo">
        <h1>{{$evento->nome}}</h1>
    </div>

    <form action="{{route('evento.update',$evento->id)}}" method="POST">
    @csrf
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Informações Gerais</p>
            </div>
        </div>
        {{-- nome | Tipo--}}
        <div class="row justify-content-center">
            <div class="col-sm-9">{{--Nome do evento--}}
                <label for="nome" class="col-form-label">{{ __('Nome') }}</label>
                <input value="{{$evento->nome}}" id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{--End Nome do evento--}}
            {{--Número de Participantes--}}
            {{-- <div class="col-sm-3">
                <label for="numeroParticipantes" class="col-form-label">{{ __('N° de Participantes') }}</label>
                <input value="{{$evento->numeroParticipantes}}" id="numeroParticipantes" type="number" class="form-control @error('numeroParticipantes') is-invalid @enderror" name="numeroParticipantes" value="{{ old('numeroParticipantes') }}" required autocomplete="numeroParticipantes" autofocus>

                @error('numeroParticipantes')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div> --}}
            {{-- Tipo do evento --}}
            <div class="col-sm-3">
                <label for="tipo" class="col-form-label">{{ __('Tipo') }}</label>
                <!-- <input value="{{$evento->tipo}}" id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ old('tipo') }}" required autocomplete="tipo" autofocus> -->
                <select id="tipo" type="text" class="form-control @error('tipo') is-invalid @enderror" name="tipo" value="{{ old('tipo') }}" required>
                  <option value="Congresso">Congresso</option>
                  <option value="Encontro">Encontro</option>
                  <option value="Seminário">Seminário</option>
                  <option value="Mesa-redonda">Mesa-redonda</option>
                  <option value="Simpósio">Simpósio</option>
                  <option value="Painel">Painel</option>
                  <option value="Fórum">Fórum</option>
                  <option value="Conferência">Conferência</option>
                  <option value="Jornada">Jornada</option>
                  <option value="Cursos">Cursos</option>
                  <option value="Colóquio">Colóquio</option>
                  <option value="Semana">Semana</option>
                  <option value="Workshop">Workshop</option>
                </select>
                @error('tipo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{-- Tipo do evento --}}
        </div>{{-- end nome | Participantes | Tipo--}}

        {{-- Descricao Evento --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrição</label>
                    <textarea value="{{$evento->descricao}}" class="form-control @error('descricao') is-invalid @enderror" value="{{ old('descricao') }}" id="descricao" name="descricao" rows="3"></textarea>
                    @error('descricao')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
            </div>
        </div>

        <div class="row justify-content-center">
          {{-- Início do Evento --}}
          <div class="col-sm-6">
              <label for="dataInicio" class="col-form-label">{{ __('Início') }}</label>
              <input value="{{$evento->dataInicio}}" id="dataInicio" type="date" class="form-control @error('dataInicio') is-invalid @enderror" name="dataInicio" value="{{ old('dataInicio') }}" required autocomplete="dataInicio" autofocus>

              @error('dataInicio')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>{{--End Início do Evento --}}
          {{-- Fim do Evento --}}
          <div class="col-sm-6">
              <label for="dataFim" class="col-form-label">{{ __('Fim') }}</label>
              <input value="{{$evento->dataFim}}" id="dataFim" type="date" class="form-control @error('dataFim') is-invalid @enderror" name="dataFim" value="{{ old('dataFim') }}" required autocomplete="dataFim" autofocus>

              @error('dataFim')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>{{-- end Fim do Evento --}}
        </div>

        {{-- Foto Evento --}}
        <div class="row justify-content-center" style="margin-top:10px">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="fotoEvento">Logo</label>
                    <input type="file" class="form-control-file @error('isCoordenador') is-invalid @enderror" name="isCoordenador" value="{{ old('isCoordenador') }}" id="fotoEvento">
                    @error('fotoEvento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
            </div>
        </div>

        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Trabalhos</p>
            </div>
        </div>
        {{-- dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}
        <div class="row justify-content-center">

            {{-- Início da Submissão --}}
            <div class="col-sm-6">
                <label for="inicioSubmissao" class="col-form-label">{{ __('Início da Submissão') }}</label>
                <input value="{{$evento->inicioSubmissao}}" id="inicioSubmissao" type="date" class="form-control @error('inicioSubmissao') is-invalid @enderror" name="inicioSubmissao" value="{{ old('inicioSubmissao') }}" required autocomplete="inicioSubmissao" autofocus>

                @error('inicioSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{-- end Início da Submissão --}}
            {{-- Fim da submissão --}}
            <div class="col-sm-6">
                <label for="fimSubmissao" class="col-form-label">{{ __('Fim da Submissão') }}</label>
                <input value="{{$evento->fimSubmissao}}" id="fimSubmissao" type="date" class="form-control @error('fimSubmissao') is-invalid @enderror" name="fimSubmissao" value="{{ old('fimSubmissao') }}" required autocomplete="fimSubmissao" autofocus>

                @error('fimSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>{{-- end Fim da submissão --}}
        </div>{{-- end dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}
        <div class="row justify-content-center">
          <div class="col-sm-6">
              <label for="inicioRevisao" class="col-form-label">{{ __('Início da Revisão') }}</label>
              <input value="{{$evento->inicioRevisao}}" id="inicioRevisao" type="date" class="form-control @error('inicioRevisao') is-invalid @enderror" name="inicioRevisao" value="{{ old('inicioRevisao') }}" required autocomplete="inicioRevisao" autofocus>

              @error('inicioRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="fimRevisao" class="col-form-label">{{ __('Fim da Revisão') }}</label>
              <input value="{{$evento->fimRevisao}}" id="fimRevisao" type="date" class="form-control @error('fimRevisao') is-invalid @enderror" name="fimRevisao" value="{{ old('fimRevisao') }}" required autocomplete="fimRevisao" autofocus>

              @error('fimRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div>
        {{-- inicioRevisao | fimRevisao | inicioResultado | fimResultado--}}
        <div class="row justify-content-center">

            <div class="col-sm-6">
                <label for="inicioResultado" class="col-form-label">{{ __('Início do Resultado') }}</label>
                <input value="{{$evento->inicioResultado}}" id="inicioResultado" type="date" class="form-control @error('inicioResultado') is-invalid @enderror" name="inicioResultado" value="{{ old('inicioResultado') }}" required autocomplete="inicioResultado" autofocus>

                @error('inicioResultado')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="fimResultado" class="col-form-label">{{ __('Fim do Resultado') }}</label>
                <input value="{{$evento->fimResultado}}" id="fimResultado" type="date" class="form-control @error('fimResultado') is-invalid @enderror" name="fimResultado" value="{{ old('fimResultado') }}" required autocomplete="fimResultado" autofocus>

                @error('fimResultado')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end inicioRevisao | fimRevisao | inicioResultado | fimResultado--}}


        <div class="row subtitulo" style="margin-top:20px">
            <div class="col-sm-12">
                <p>Endereço</p>
            </div>
        </div>

        {{-- Rua | Número | Bairro --}}
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <label for="cep" class="col-form-label">{{ __('CEP') }}</label>
                <input value="{{$endereco->cep}}" id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep') }}" required autocomplete="cep" autofocus>

                @error('cep')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="rua" class="col-form-label">{{ __('Rua') }}</label>
                <input value="{{$endereco->rua}}" id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua" value="{{ old('rua') }}" required autocomplete="rua" autofocus>

                @error('rua')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-2">
                <label for="numero" class="col-form-label">{{ __('Número') }}</label>
                <input value="{{$endereco->numero}}" id="numero" type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" required autocomplete="numero" autofocus>

                @error('numero')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


        </div>{{--end Rua | Número | Bairro --}}

        <div class="row justify-content-center">
            <div class="col-sm-4">
                <label for="bairro" class="col-form-label">{{ __('Bairro') }}</label>
                <input value="{{$endereco->bairro}}" id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" value="{{ old('bairro') }}" required autocomplete="bairro" autofocus>

                @error('bairro')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>
                <input value="{{$endereco->cidade}}" id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" value="{{ old('cidade') }}" required autocomplete="cidade" autofocus>

                @error('cidade')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="uf" class="col-form-label">{{ __('UF') }}</label>
                {{-- <input id="uf" type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" value="{{ old('uf') }}" required autocomplete="uf" autofocus> --}}
                <select value="{{$endereco->uf}}" class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf">
                    <option value="" disabled selected hidden>-- UF --</option>
                    <option @if($endereco->uf == 'AC') selected @endif value="AC">Acre</option>
                    <option @if($endereco->uf == 'AL') selected @endif value="AL">Alagoas</option>
                    <option @if($endereco->uf == 'AP') selected @endif value="AP">Amapá</option>
                    <option @if($endereco->uf == 'AM') selected @endif value="AM">Amazonas</option>
                    <option @if($endereco->uf == 'BA') selected @endif value="BA">Bahia</option>
                    <option @if($endereco->uf == 'CE') selected @endif value="CE">Ceará</option>
                    <option @if($endereco->uf == 'DF') selected @endif value="DF">Distrito Federal</option>
                    <option @if($endereco->uf == 'ES') selected @endif value="ES">Espírito Santo</option>
                    <option @if($endereco->uf == 'GO') selected @endif value="GO">Goiás</option>
                    <option @if($endereco->uf == 'MA') selected @endif value="MA">Maranhão</option>
                    <option @if($endereco->uf == 'MT') selected @endif value="MT">Mato Grosso</option>
                    <option @if($endereco->uf == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                    <option @if($endereco->uf == 'MG') selected @endif value="MG">Minas Gerais</option>
                    <option @if($endereco->uf == 'PA') selected @endif value="PA">Pará</option>
                    <option @if($endereco->uf == 'PB') selected @endif value="PB">Paraíba</option>
                    <option @if($endereco->uf == 'PR') selected @endif value="PR">Paraná</option>
                    <option @if($endereco->uf == 'PE') selected @endif value="PE">Pernambuco</option>
                    <option @if($endereco->uf == 'PI') selected @endif value="PI">Piauí</option>
                    <option @if($endereco->uf == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                    <option @if($endereco->uf == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                    <option @if($endereco->uf == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                    <option @if($endereco->uf == 'RO') selected @endif value="RO">Rondônia</option>
                    <option @if($endereco->uf == 'RR') selected @endif value="RR">Roraima</option>
                    <option @if($endereco->uf == 'SC') selected @endif value="SC">Santa Catarina</option>
                    <option @if($endereco->uf == 'SP') selected @endif value="SP">São Paulo</option>
                    <option @if($endereco->uf == 'SE') selected @endif value="SE">Sergipe</option>
                    <option @if($endereco->uf == 'TO') selected @endif value="TO">Tocantins</option>
                </select>

                @error('uf')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>

        <div class="row justify-content-center" style="margin: 20px 0 20px 0">
            <div class="col-md-6" style="padding-left:0">
                <a class="btn btn-secondary botao-form" href="{{route('coord.home')}}">Voltar</a>
            </div>
            <div class="col-md-6" style="padding-ridht:0">
                <button type="submit" class="btn btn-primary botao-form">
                    {{ __('Salvar Evento') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
