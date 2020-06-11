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

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <header>
            {{-- Navbar --}}
            <nav class="navbar navbar-light backgroud-color-default shadow">
                <div class="container">
                    <div class="links-menu">
                        <a class="navbar-brand" href="{{route('home-user')}}">
                            <img id="logo-menu" src="{{ asset('img/icons/logo_submeta_pemenor.png') }}" alt="">
                        </a>
                    </div>
                    <div class="navbar-text">
                        @guest
                            <a href="#" class="btn navbar-text negrito" style="color: rgb(0, 140, 255);">Editais</a>
                            <a href="#" class="btn dropdown-toggle negrito" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: rgb(0, 140, 255);">Login</a>
                            <div class="dropdown-menu dropdown-menu-right negrito" aria-labelledby="dropdownMenuLink" style="right: 15%; width: 300px; height: 380px;">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div style="padding: 20px;">
                                        <div style="color: rgb(0, 140, 255); position: relative; top: 5px; text-align: center; font-size: 20px;">
                                            Entrar
                                        </div>
                                        <div style="position: relative; top: 30px; left: 1px;">
                                            
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
                                        <div style="position: relative; top: 40px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Lembrar Senha') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div style="position: relative; top: 50px;">
                                            <button class="btn botao-entrar" style="color: white;">
                                                {{__('Entrar')}}
                                            </button>
                                            <a href="{{ route('password.request') }}" style="font-weight: normal; color: rgb(44, 96, 209);">{{ __('Esqueseu sua senha?')}}</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <a href="{{ route('register') }}" class="btn navbar-text btn-azul-destaque negrito" style="color:  rgb(0, 140, 255);">{{ __('Cadastre-se') }}</a>
                        @else
                            <a href="{{route('visualizarEvento')}}" class="btn navbar-text negrito " style="color: rgb(0, 140, 255);">Home</a>
                            
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

    <div class="rodape">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <a href="http://ww3.uag.ufrpe.br/" target="_blank" style="color: white;">
                        <div class="col-sm-2">
                            <img class="logo-ufape" src="{{ asset('img/logoUfape.svg') }}"/>
                        </div>
                        <div class="col-sm-4 format-text">
                            <a href="http://ww3.uag.ufrpe.br/" target="_blank" style="color: white; font-size: 15px; position: relative; top: 30%; left: 0px;">Universidade Federal <br> do Agreste de Pernambuco</a>
                        </div>
                    </a>
                    <a href="http://lmts.uag.ufrpe.br/" target="_blank" style="color: white;">
                        <div class="col-sm-2">
                            <img class="logo-lmts" src="{{ asset('img/lmts.png') }}"/>
                        </div>
                        <div class="col-sm-4 format-text">
                            <a href="http://lmts.uag.ufrpe.br/" target="_blank" style="color: white; font-size: 15px; position: relative; top: 30%; left: 0px;">Laboratório Multidisciplinar <br> de Tecnologias Sociais</a>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>