@extends('layouts.app')

@section('content')

@if(Auth()->user()->usuarioTemp == null)
<div class="container content">
    <div class="row titulo">
        <h1>Perfil</h1>
    </div>

    <div class="row subtitulo">
        <div class="col-sm-12">
            <p>Informações Pessoais</p>
        </div>
    </div>

    <form method="POST" action="{{ route('perfil') }}">
        @csrf
        <div class="row justify-content-center">
            <input hidden name="id" value="{{$user->id}}">
            <div class="col-md-8">
                <label for="name" class="col-form-label">{{ __('Nome Completo') }}</label>
                <input value="{{$user->name}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="cpf" class="col-form-label">{{ __('CPF') }}</label>
                <input value="{{$user->cpf}}" id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>

                @error('cpf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="row justify-content-center">

            <div class="col-md-8">
              <label for="instituicao" class="col-form-label">{{ __('Instituição de Ensino') }}</label>
              <input value="{{$user->instituicao}}" id="instituicao" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="instituicao" value="{{ old('instituicao') }}" required autocomplete="instituicao" autofocus>

              @error('instituicao')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>

            <div class="col-md-4">
                <label for="celular" class="col-form-label">{{ __('Celular') }}</label>
                <input value="{{$user->celular}}" id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="celular" autofocus>

                @error('celular')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>

        <div class="row subtitulo" style="margin-top:20px">
            <div class="col-sm-12">
                <p>Endereço</p>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="form-group row justify-content-center">
            <div class="col-md-2">
                <label for="cep" class="col-form-label">{{ __('CEP') }}</label>
                <input onblur="pesquisacep(this.value);" value="{{$end->cep}}" id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" required autocomplete="cep">

                @error('cep')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="rua" class="col-form-label">{{ __('Rua') }}</label>
                <input value="{{$end->rua}}" id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua" required autocomplete="new-password">

                @error('rua')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
              <label for="numero" class="col-form-label">{{ __('Número') }}</label>
              <input value="{{$end->numero}}" id="numero" type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" required autocomplete="numero">

              @error('numero')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          </div>


          <div class="form-group row justify-content-center">
            <div class="col-md-4">
                <label for="bairro" class="col-form-label">{{ __('Bairro') }}</label>
                <input value="{{$end->bairro}}" id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" required autocomplete="bairro">

                @error('bairro')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                  <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>
                  <input value="{{$end->cidade}}" id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" required autocomplete="cidade">

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
                    <option @if($end->uf == 'AC') selected @endif value="AC">Acre</option>
                    <option @if($end->uf == 'AL') selected @endif value="AL">Alagoas</option>
                    <option @if($end->uf == 'AP') selected @endif value="AP">Amapá</option>
                    <option @if($end->uf == 'AM') selected @endif value="AM">Amazonas</option>
                    <option @if($end->uf == 'BA') selected @endif value="BA">Bahia</option>
                    <option @if($end->uf == 'CE') selected @endif value="CE">Ceará</option>
                    <option @if($end->uf == 'DF') selected @endif value="DF">Distrito Federal</option>
                    <option @if($end->uf == 'ES') selected @endif value="ES">Espírito Santo</option>
                    <option @if($end->uf == 'GO') selected @endif value="GO">Goiás</option>
                    <option @if($end->uf == 'MA') selected @endif value="MA">Maranhão</option>
                    <option @if($end->uf == 'MT') selected @endif value="MT">Mato Grosso</option>
                    <option @if($end->uf == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                    <option @if($end->uf == 'MG') selected @endif value="MG">Minas Gerais</option>
                    <option @if($end->uf == 'PA') selected @endif value="PA">Pará</option>
                    <option @if($end->uf == 'PB') selected @endif value="PB">Paraíba</option>
                    <option @if($end->uf == 'PR') selected @endif value="PR">Paraná</option>
                    <option @if($end->uf == 'PE') selected @endif value="PE">Pernambuco</option>
                    <option @if($end->uf == 'PI') selected @endif value="PI">Piauí</option>
                    <option @if($end->uf == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                    <option @if($end->uf == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                    <option @if($end->uf == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                    <option @if($end->uf == 'RO') selected @endif value="RO">Rondônia</option>
                    <option @if($end->uf == 'RR') selected @endif value="RR">Roraima</option>
                    <option @if($end->uf == 'SC') selected @endif value="SC">Santa Catarina</option>
                    <option @if($end->uf == 'SP') selected @endif value="SP">São Paulo</option>
                    <option @if($end->uf == 'SE') selected @endif value="SE">Sergipe</option>
                    <option @if($end->uf == 'TO') selected @endif value="TO">Tocantins</option>
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
                <a class="btn btn-secondary botao-form" href="{{route('home')}}" style="width:100%">Voltar</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Concluir') }}
                </button>
            </div>
        </div>

        </form>
    </div>
</div>
@else

<div class="container content">
    <div class="row titulo">
        <h1>Perfil</h1>
    </div>

    <div class="row subtitulo">
        <div class="col-sm-12">
            <p>Informações Pessoais</p>
        </div>
    </div>

    <form method="POST" action="{{ route('perfil') }}">
        @csrf
        <div class="row justify-content-center">
            <input hidden name="id" value="{{$user->id}}">
            <div class="col-md-8">
                <label for="name" class="col-form-label">{{ __('Name') }}</label>
                <input value="{{$user->name}}" id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="cpf" class="col-form-label">{{ __('CPF') }}</label>
                <input value="{{$user->cpf}}" id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>

                @error('cpf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="row justify-content-center">

            <div class="col-md-8">
              <label for="instituicao" class="col-form-label">{{ __('Instituição de Ensino') }}</label>
              <input value="{{$user->instituicao}}" id="instituicao" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="instituicao" value="{{ old('instituicao') }}" required autocomplete="instituicao" autofocus>

              @error('instituicao')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>

            <div class="col-md-4">
                <label for="celular" class="col-form-label">{{ __('Celular') }}</label>
                <input value="{{$user->celular}}" id="celular" type="number" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="celular" autofocus>

                @error('celular')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>

        <div class="row subtitulo" style="margin-top:20px">
            <div class="col-sm-12">
                <p>Endereço</p>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="form-group row justify-content-center">
            <div class="col-md-2">
                <label for="cep" class="col-form-label">{{ __('CEP') }}</label>
                <input onblur="pesquisacep(this.value);" value="{{old('cep')}}" id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" required autocomplete="cep">

                @error('cep')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="rua" class="col-form-label">{{ __('Rua') }}</label>
                <input value="{{old('rua')}}" id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua" required autocomplete="new-password">

                @error('rua')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
              <label for="numero" class="col-form-label">{{ __('Número') }}</label>
              <input value="{{old('numero')}}" id="numero" type="number" class="form-control @error('numero') is-invalid @enderror" name="numero" required autocomplete="numero">

              @error('numero')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          </div>


          <div class="form-group row justify-content-center">
            <div class="col-md-4">
                <label for="bairro" class="col-form-label">{{ __('Bairro') }}</label>
                <input value="{{old('bairro')}}" id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" required autocomplete="bairro">

                @error('bairro')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                  <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>
                  <input value="{{old('cidade')}}" id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" required autocomplete="cidade">

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
                <a class="btn btn-secondary botao-form" href="{{route('home')}}" style="width:100%">Voltar</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Concluir') }}
                </button>
            </div>
        </div>

        </form>
    </div>
</div>

@endif
@endsection
@section('javascript')
  <script type="text/javascript" >
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }
    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
    function pesquisacep(valor) {
        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');
        //Verifica se campo cep possui valor informado.
        if (cep != "") {
            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;
            //Valida o formato do CEP.
            if(validacep.test(cep)) {
                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";
                //Cria um elemento javascript.
                var script = document.createElement('script');
                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };
  </script>
@endsection
