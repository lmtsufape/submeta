<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{ asset('js/jquery-mask-plugin.js')}}"></script>

    <!-- Scripts -->
    <script type="text/javascript" src="{{URL::asset('js/valida_cpf_cnpj.js')}}" defer></script>
    <script type="text/javascript" src="{{URL::asset('js/pesquisar_cep.js')}}" defer></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">

    <style>
      .styleRodape {
        background-color: rgb(0, 140, 255);;
        text-align: center;
      }

      .styleRodape_Imagem_ufape {
        padding-top: 1.5rem;
        padding-bottom: 1rem;
        text-align: center;
      }

      .styleRodape_Imagem_lmts {
        padding-top: 3rem;
        padding-bottom: 2rem;
        text-align: center;
      }

      .styleRodape_Texto {
        font-size: 13px;
        color: white;
        text-align: center;
      }

      .styleRodape_Texto_Titulo {
        padding-top: 1rem;
        padding-bottom: 1rem;
        color: white;
      }

      .styleRodape_Texto_Conteudo_MapaDoSite {
        color: white;
        font-size: 13px;
        padding-top: 0.4rem;
      }

      .styleRodape_container {
        padding-bottom: 0.1rem;
        text-align: left;
      }

      .styleRodape_Texto_Contato {
        font-size: 14px;
      }

      .styleRodape_linha_left {
        border-left: solid;
        color: white;
        margin-top: 0.5rem;
        padding-bottom: 1rem;
        margin-left: 0.5rem;
        height: 100%;
      }

      .styleRodape_linha_top {
        border-top: solid;
        color: white;
        margin: 0.5rem;
      }
    </style>
</head>

<body>
    <div id="app">
        <header>
            {{-- Navbar --}}
            <nav class="navbar navbar-light backgroud-color-default shadow">
                <div class="container">
                    <div class="links-menu">
                        <a class="navbar-brand" href="{{route('inicial')}}">
                            <img id="logo-menu" src="{{ asset('img/icons/logo_submeta_pemenor.png') }}" alt="">
                        </a>
                    </div>
                    <div class="navbar-text">
                        @guest
                            <a href="{{ route('coord.home') }}" class="btn navbar-text negrito" style="color: rgb(0, 140, 255);">Editais</a>
                            <a href="#" class="btn dropdown-toggle negrito" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgb(0, 140, 255);">Login</a>
                            <div id="dropdown-login" class="dropdown-menu dropdown-menu-right negrito" aria-labelledby="dropdownMenuLink" style="right: 15%; width: 300px; height: auto;">
                                
                                <div class="">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div style="padding: 20px;">
                                            <div style="color: rgb(0, 140, 255); margin: 5px; text-align: center; font-size: 20px;">
                                                Entrar
                                            </div>
                                            <div style="margin-top: 30px;">
                                                
                                                <label for="email" class="col-form-label negrito"  style="color: rgb(0, 140, 255);">{{ __('Endereço de E-mail') }}</label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
        
                                                <label for="password" class="col-form-label negrito" style="color: rgb(0, 140, 255);">{{ __('Senha') }}</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Lembrar Senha') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div style="margin-top: 10px; margin-bottom: 10px;">
                                                <button class="btn btn-login">
                                                    {{__('Entrar')}}
                                                </button>
                                                <br>
                                                <a href="{{ route('password.request') }}" style="font-weight: normal; color: rgb(44, 96, 209);">{{ __('Esqueceu sua senha?')}}</a>
                                            </div>
                                            <div style="margin-top: 10px; margin-bottom: 10px;">
                                                <label for="password" class="col-form-label negrito" style="color: rgb(0, 140, 255);">{{ __('Crie sua conta!') }}</label>
                                                <br>
                                                <a href="{{ route('register') }}">
                                                    <button type="button" class="btn btn-cadastro">
                                                        {{__('Cadastre-se')}}
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                            <a href="{{ route('register') }}" class="btn navbar-text btn-azul-destaque negrito" style="color:  rgb(0, 140, 255);">{{ __('Cadastre-se') }}</a>
                        @else
                            @if(Auth::user()->administradors != null)
                                <a href="{{route('admin.editais')}}" class="btn navbar-text negrito " style="color: rgb(0, 140, 255);">Home</a>
                            @else 
                                <a href="{{route('coord.home')}}" class="btn navbar-text negrito " style="color: rgb(0, 140, 255);">Home</a>
                            @endif
                            <a id="navbarDropdown" class="btn navbar-text negrito dropdown-toggle" style="color: rgb(0, 140, 255);" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
    
                            <div class="dropdown-menu dropdown-menu-right" style="right: 5%;" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('user.perfil') }}">
                                    <img src="{{asset('img/icons/perfil.svg')}}" alt="">
                                    {{ __('Minha Conta') }}
                                </a>                                        
                                @if(Auth::user()->administradors != null)
                                    <a class="dropdown-item" href="{{ route('admin.index') }}">
                                        <img src="{{asset('img/icons/file-alt-regular-black.svg')}}" alt="">
                                        {{ __('Perfil Administrador') }}
                                    </a>

                                @endif
                                @if(Auth::user()->AdministradorResponsavel != null)
                                    <a class="dropdown-item" href="{{ route('adminResp.index') }}">
                                        <img src="{{asset('img/icons/file-alt-regular-black.svg')}}" alt="">
                                        {{ __('Perfil Pro-reitor') }}
                                    </a>
                                @endif
                                @if(Auth::user()->coordenadorComissao != null)
                                    <a class="dropdown-item" href="{{ route('coordenador.index') }}">
                                        <img src="{{asset('img/icons/file-alt-regular-black.svg')}}" alt="">
                                        {{ __('Perfil Coordenador') }}
                                    </a>
                                @endif
                                
                                    @if(Auth::user()->avaliadors != null)
                                        <a class="dropdown-item" href="{{ route('avaliador.index') }}">
                                            <img src="{{asset('img/icons/file-alt-regular-black.svg')}}" alt="">
                                            {{ __('Perfil Avaliador') }}
                                        </a>
                                    @endif
                                    @if(Auth::user()->proponentes != null)
                                        <a class="dropdown-item" href="{{ route('proponente.index') }}">
                                            <img src="{{asset('img/icons/file-alt-regular-black.svg')}}" alt="">
                                            {{ __('Perfil Proponente') }}
                                        </a>
                                    @endif
                                    @if(Auth::user()->participantes->where('user_id', Auth::user()->id)->count() != 0)
                                        <a class="dropdown-item" href="{{ route('participante.index') }}">
                                            <img src="{{asset('img/icons/file-alt-regular-black.svg')}}" alt="">
                                            {{ __('Perfil Participante') }}
                                        </a>
                                    @endif                             
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <img src="{{asset('img/icons/sign-out-alt-solid.svg')}}" alt="">
                                    {{ __('Sair') }}
                                </a>
    
    
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        @endguest
                    </div>                 
                </div>
            </nav>
        </header>
    <section>
        @hasSection ('sidebar')
            @yield('sidebar')
        @endif

        {{-- <main class="container-fluid"> --}}
        @yield('content')
        {{-- </main> --}}
    </section>
    </div>
    @hasSection ('javascript')
    @yield('javascript')
    @else
    @endif

    <script  src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <div class="styleRodape">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-sm-2">
                  <div class="row justify-content-center">
                      <div class="col-sm-12 styleRodape_Imagem_ufape">
                          <a href="http://www.ufape.edu.br" target="_blank"><img src="{{ asset('img/logoUfape.svg') }}" alt="Logo" width="40px;"></a>
                      </div>
                      <div class="col-sm-12 styleRodape_Texto">
                          <a href="http://www.ufape.edu.br" target="_blank" style="color: white; font-weight: normal;">Universidade Federal do Agreste de Pernambuco</a>
                      </div>
                  </div>
              </div>
              <div class="col-sm-3">
                  <div class="row justify-content-center">
                      <div class="col-sm-12 styleRodape_Imagem_lmts">
                          <a target="_blank" href="http://lmts.uag.ufrpe.br/"><img src="{{ asset('img/lmts.png') }}" alt="Logo" width="125px;"></a>
                      </div>
                      <div class="col-sm-12 styleRodape_Texto">
                          <a target="_blank" href="http://lmts.uag.ufrpe.br/" style="color: white; font-weight: normal;">Laboratório Multidisciplinar de Tecnologias Sociais</a>
                      </div>
                  </div>
              </div>
              <!--<div class="col-sm-2" align="center">
                  <div class="row justify-content-center" >
                      <div class="styleRodape_linha_left">
                          <div class="col-sm-12 styleRodape_Texto_Titulo">Mapa do site</div>
                          <div class="col-sm-12 styleRodape_Texto_Conteudo_MapaDoSite">Quem Somos</div>
                          <div class="col-sm-12 styleRodape_Texto_Conteudo_MapaDoSite">Equipe</div>
                          <div class="col-sm-12 styleRodape_Texto_Conteudo_MapaDoSite">Notícia</div>
                          <div class="col-sm-12 styleRodape_Texto_Conteudo_MapaDoSite">Projetos</div>
                      </div>
                  </div>
              </div>-->
              <div class="col-sm-2">
                  <div class="row justify-content-center" style="height: 170px;">
                      <div class="styleRodape_linha_left">
                          <div class="col-sm-12 styleRodape_Texto_Titulo">Contato
                          </div>
                          <div class="col-sm-12 styleRodape_container">
                              <div class="row">
                                  <div class="col">
                                      <img src="{{ asset('img/icons/instagram-brands.svg') }}" alt="Logo" width="20px;">
                                      <a href="https://www.instagram.com/lmts_ufape/" target="_blank" class="styleRodape_Texto_Contato" style="color: white; font-weight: normal;">@lmts_ufape</a>
                                  </div>
                              </div>
                          </div>
                           <div class="col-sm-12 styleRodape_container">
                              <div class="row justify-content-center">

                                  <div class="col">
                                      <img src="{{ asset('img/icons/facebook-square-brands.svg') }}" alt="Logo" width="20px;">
                                      <a href="https://www.facebook.com/LMTSUFAPE/" target="_blank" class="styleRodape_Texto_Contato" style="color: white; font-weight: normal;">@LMTSUFAPE</a>
                                  </div>
                              </div>
                          </div>
                          <div class="col-sm-12 styleRodape_container">
                              <div class="row">
                                  <div class="col">
                                      <span>lmts@ufrpe.br</span>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
                  
          </div>
          <div class="row justify-content-center styleRodape_container styleRodape_linha_top">
              <div class="btg-group">
                  <img src="{{ asset('img/icons/local_logo.svg') }}" alt="Logo" width="10px;">
                  <a class="styleRodape_Texto" style="padding: 0.5rem; color: white; font-weight: normal;">Avenida Bom Pastor. s/nº Bairro Boa Vista - CEP 55292-270 - Garanhuns - PE</a>
              </div>
          </div>
      </div>
  </div>
</body>
<script>
    $(document).ready(function() {
        $("#dropdown-login").on('click', function(event){
            event.stopPropagation();
        });
    });
    @if(old('email') != null)
        $(document).ready(function() {
            $('#dropdownMenuLink').click();
        });
    @endif
</script>
</html>