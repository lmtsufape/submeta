@extends('layouts.app')

@section('content')
<div class="container content">
    <div class="row titulo">
        <h1>Cadastro</h1>
    </div>

    <div class="row subtitulo">
        <div class="col-sm-12">
            <p>Informações Pessoais</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        {{-- Nome | CPF --}}
        <div class="form-group row">

            <div class="col-md-8">
                <label for="name" class="col-form-label">{{ __('Nome Completo') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="cpf" class="col-form-label">{{ __('CPF') }}</label>
                <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required autocomplete="cpf" autofocus>

                @error('cpf')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        {{-- Instituição de Ensino e Celular --}}
        <div class="form-group row">
            <div class="col-md-8">
                <label for="instituicao" class="col-form-label">{{ __('Instituição de Vínculo') }}</label>
                <input id="instituicao" type="text" class="form-control @error('instituicao') is-invalid @enderror" name="instituicao" value="{{ old('instituicao') }}" required autocomplete="instituicao" autofocus>

                @error('instituicao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-4">
                <label for="celular" class="col-form-label">{{ __('Celular') }}</label>
                <input id="celular" type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" value="{{ old('celular') }}" required autocomplete="celular" autofocus>

                @error('celular')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Email | Senha | Confirmar Senha --}}
        <div class="form-group row">

            <div class="col-md-4">
                <label for="email" class="col-form-label">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="password" class="col-form-label">{{ __('Senha') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="password-confirm" class="col-form-label">{{ __('Confirme a Senha') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>


        <div class="row subtitulo">
            <div class="col-sm-12">
                <p>Endereço</p>
            </div>
        </div>

        {{-- Rua | Número | Bairro --}}
        <div class="form-group row">
          <div class="col-md-2">
              <label for="cep" class="col-form-label">{{ __('CEP') }}</label>
              <input value="{{old('cep')}}" onblur="pesquisacep(this.value);" id="cep" type="text" required autocomplete="cep" name="cep" autofocus class="form-control field__input a-field__input" placeholder="CEP" size="10" maxlength="9" >
              @error('cep')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
        </div>
        <div class="form-group row">


            <div class="col-md-6">
                <label for="rua" class="col-form-label">{{ __('Rua') }}</label>
                <input value="{{old('rua')}}" id="rua" type="text" class="form-control @error('rua') is-invalid @enderror" name="rua" required autocomplete="new-password">

                @error('rua')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-2">
                <label for="numero" class="col-form-label">{{ __('Número') }}</label>
                <input value="{{old('numero')}}" id="numero" type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" autocomplete="numero">

                @error('numero')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="bairro" class="col-form-label">{{ __('Bairro') }}</label>
                <input value="{{old('bairro')}}" id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" required autocomplete="bairro">

                @error('bairro')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


          </div>

          <div class="form-group row">

            <div class="col-md-6">
                <label for="cidade" class="col-form-label">{{ __('Cidade') }}</label>
                <input value="{{old('cidade')}}" id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" required autocomplete="cidade">

                @error('cidade')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="col-sm-6">
                <label for="uf" class="col-form-label">{{ __('UF') }}</label>
                {{-- <input id="uf" type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" value="{{ old('uf') }}" required autocomplete="uf" autofocus> --}}
                <select class="form-control @error('uf') is-invalid @enderror" id="uf" name="uf">
                    <option value="" disabled selected hidden>-- UF --</option>
                    <option @if(old('uf') == 'AC') selected @endif value="AC">Acre</option>
                    <option @if(old('uf') == 'AL') selected @endif value="AL">Alagoas</option>
                    <option @if(old('uf') == 'AP') selected @endif value="AP">Amapá</option>
                    <option @if(old('uf') == 'AM') selected @endif value="AM">Amazonas</option>
                    <option @if(old('uf') == 'BA') selected @endif value="BA">Bahia</option>
                    <option @if(old('uf') == 'CE') selected @endif value="CE">Ceará</option>
                    <option @if(old('uf') == 'DF') selected @endif value="DF">Distrito Federal</option>
                    <option @if(old('uf') == 'ES') selected @endif value="ES">Espírito Santo</option>
                    <option @if(old('uf') == 'GO') selected @endif value="GO">Goiás</option>
                    <option @if(old('uf') == 'MA') selected @endif value="MA">Maranhão</option>
                    <option @if(old('uf') == 'MT') selected @endif value="MT">Mato Grosso</option>
                    <option @if(old('uf') == 'MS') selected @endif value="MS">Mato Grosso do Sul</option>
                    <option @if(old('uf') == 'MG') selected @endif value="MG">Minas Gerais</option>
                    <option @if(old('uf') == 'PA') selected @endif value="PA">Pará</option>
                    <option @if(old('uf') == 'PB') selected @endif value="PB">Paraíba</option>
                    <option @if(old('uf') == 'PR') selected @endif value="PR">Paraná</option>
                    <option @if(old('uf') == 'PE') selected @endif value="PE">Pernambuco</option>
                    <option @if(old('uf') == 'PI') selected @endif value="PI">Piauí</option>
                    <option @if(old('uf') == 'RJ') selected @endif value="RJ">Rio de Janeiro</option>
                    <option @if(old('uf') == 'RN') selected @endif value="RN">Rio Grande do Norte</option>
                    <option @if(old('uf') == 'RS') selected @endif value="RS">Rio Grande do Sul</option>
                    <option @if(old('uf') == 'RO') selected @endif value="RO">Rondônia</option>
                    <option @if(old('uf') == 'RR') selected @endif value="RR">Roraima</option>
                    <option @if(old('uf') == 'SC') selected @endif value="SC">Santa Catarina</option>
                    <option @if(old('uf') == 'SP') selected @endif value="SP">São Paulo</option>
                    <option @if(old('uf') == 'SE') selected @endif value="SE">Sergipe</option>
                    <option @if(old('uf') == 'TO') selected @endif value="TO">Tocantins</option>
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
                <a class="btn btn-secondary botao-form" href="{{route('cancelarCadastro')}}" style="width:100%">Cancelar Cadastro</a>
            </div>
            <div class="col-md-6" style="padding-right:0">
                <button type="submit" class="btn btn-primary botao-form" style="width:100%">
                    {{ __('Finalizar Cadastro') }}
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

@section('javascript')
  <script type="text/javascript" >
    $(document).ready(function($){
      $('#cep').mask('00000-000');
      $('#cpf').mask('000.000.000-00');
      var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      spOptions = {
        onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
      };
      $('#celular').mask(SPMaskBehavior, spOptions);

    });
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
