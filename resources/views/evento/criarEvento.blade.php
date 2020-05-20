@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row titulo">
        <h1>Novo Evento</h1>
    </div>

    <form action="{{route('evento.criar')}}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Informações Gerais</p>
            </div>
        </div>
        {{-- nome | Participantes | Tipo--}}
        <div class="row justify-content-center">
            <div class="col-sm-9">
                <label for="nome" class="col-form-label">{{ __('Nome') }}</label>
                <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" required autocomplete="nome" autofocus>

                @error('nome')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            {{-- <div class="col-sm-3">
                <label for="numeroParticipantes" class="col-form-label">{{ __('N° de Participantes') }}</label>
                <input id="numeroParticipantes" type="number" class="form-control @error('numeroParticipantes') is-invalid @enderror" name="numeroParticipantes" value="{{ old('numeroParticipantes') }}" required autocomplete="numeroParticipantes" autofocus>

                @error('numeroParticipantes')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div> --}}

            <div class="col-sm-3">
                <label for="tipo" class="col-form-label">{{ __('Tipo') }}</label>
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
            </div>
        </div>{{-- end nome | Participantes | Tipo--}}

        {{-- Descricao Evento --}}
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrição</label>
                    <textarea class="form-control @error('descricao') is-invalid @enderror" value="{{ old('descricao') }}" required autocomplete="descricao" autofocus id="descricao" name="descricao" rows="3"></textarea>
                    @error('descricao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
            </div>
        </div>
        <!-- Inicio e fim do evento -->
        <div class="row justify-content-center">
          <div class="col-sm-6">
              <label for="dataInicio" class="col-form-label">{{ __('Início') }}</label>
              <input id="dataInicio" type="date" class="form-control @error('dataInicio') is-invalid @enderror" name="dataInicio" value="{{ old('dataInicio') }}" required autocomplete="dataInicio" autofocus>

              @error('dataInicio')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="dataFim" class="col-form-label">{{ __('Fim') }}</label>
              <input id="dataFim" type="date" class="form-control @error('dataFim') is-invalid @enderror" name="dataFim" value="{{ old('dataFim') }}" required autocomplete="dataFim" autofocus>

              @error('dataFim')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
        </div><!-- end Inicio e fim do evento -->

        {{-- Foto Evento --}}
        <div class="row justify-content-center" style="margin-top:10px">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="fotoEvento">Logo</label>
                    <input type="file" class="form-control-file @error('fotoEvento') is-invalid @enderror" name="fotoEvento" value="{{ old('fotoEvento') }}" id="fotoEvento">
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

            <div class="col-sm-6">
                <label for="inicioSubmissao" class="col-form-label">{{ __('Início da Submissão') }}</label>
                <input id="inicioSubmissao" type="date" class="form-control @error('inicioSubmissao') is-invalid @enderror" name="inicioSubmissao" value="{{ old('inicioSubmissao') }}" required autocomplete="inicioSubmissao" autofocus>

                @error('inicioSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="fimSubmissao" class="col-form-label">{{ __('Fim da Submissão') }}</label>
                <input id="fimSubmissao" type="date" class="form-control @error('fimSubmissao') is-invalid @enderror" name="fimSubmissao" value="{{ old('fimSubmissao') }}" required autocomplete="fimSubmissao" autofocus>

                @error('fimSubmissao')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>{{-- end dataInicio | dataFim | inicioSubmissao | fimSubmissao --}}

        <div class="row justify-content-center">
          <div class="col-sm-6">
              <label for="inicioRevisao" class="col-form-label">{{ __('Início da Revisão') }}</label>
              <input id="inicioRevisao" type="date" class="form-control @error('inicioRevisao') is-invalid @enderror" name="inicioRevisao" value="{{ old('inicioRevisao') }}" required autocomplete="inicioRevisao" autofocus>

              @error('inicioRevisao')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
          <div class="col-sm-6">
              <label for="fimRevisao" class="col-form-label">{{ __('Fim da Revisão') }}</label>
              <input id="fimRevisao" type="date" class="form-control @error('fimRevisao') is-invalid @enderror" name="fimRevisao" value="{{ old('fimRevisao') }}" required autocomplete="fimRevisao" autofocus>

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
                <input id="inicioResultado" type="date" class="form-control @error('inicioResultado') is-invalid @enderror" name="inicioResultado" value="{{ old('inicioResultado') }}" required autocomplete="inicioResultado" autofocus>

                @error('inicioResultado')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="fimResultado" class="col-form-label">{{ __('Fim do Resultado') }}</label>
                <input id="fimResultado" type="date" class="form-control @error('fimResultado') is-invalid @enderror" name="fimResultado" value="{{ old('fimResultado') }}" required autocomplete="fimResultado" autofocus>

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
                <input id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep') }}" required autocomplete="cep" autofocus>

                @error('cep')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-6">
                <label for="rua" class="col-form-label">{{ __('Rua') }}</label>
                <input id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua" value="{{ old('rua') }}" required autocomplete="rua" autofocus>

                @error('rua')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-2">
                <label for="numero" class="col-form-label">{{ __('Número') }}</label>
                <input id="numero" type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" required autocomplete="numero" autofocus>

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
                <input id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" value="{{ old('bairro') }}" required autocomplete="bairro" autofocus>

                @error('bairro')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>
                <input id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" value="{{ old('cidade') }}" required autocomplete="cidade" autofocus>

                @error('cidade')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-sm-4">
                <label for="uf" class="col-form-label">{{ __('UF') }}</label>
                {{-- <input id="uf" type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" value="{{ old('uf') }}" required autocomplete="uf" autofocus> --}}
                <select class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf">
                    <option value="" disabled selected hidden>-- UF --</option>
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
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
                <a class="btn btn-secondary botao-form" href="{{route('coord.home')}}" style="width:100%">Cancelar</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Criar Evento') }}
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
