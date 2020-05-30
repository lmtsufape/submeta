<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{ asset('js/jquery-mask-plugin.js')}}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styleIndex.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-dark  shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{route('visualizarEvento')}}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                {{-- <a class="nav-link" data-toggle="modal" data-target="#modalLogin">{{ __('Login') }}</a> --}}
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Cadastro') }}</a>
                                    {{-- <a class="nav-link" data-toggle="modal" data-target="#modalCadastro">{{ __('Cadastro') }}</a> --}}
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                    <a class="nav-link" href="{{route('visualizarEvento')}}">Home</a>
                                    
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('grandearea.index') }}">Naturezas</a>
                                    
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.editais')}}">Editais</a>
                                    
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.usuarios') }}">Usuários</a>
                                    
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
                                        @if(Auth::user()->participantes != null)
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
                                </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @hasSection ('sidebar')
            @yield('sidebar')
        @endif

        {{-- <main class="container-fluid"> --}}
        @yield('content')
        {{-- </main> --}}

    </div>
    @hasSection ('javascript')
    @yield('javascript')
    @else
    @endif

</body>
</html>