<nav class="navbar navbar-expand-lg navbar-dark ">
            <div class="container">
                <a class="navbar-brand" href="{{route('cancelarCadastro')}}">
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
                            <!-- Se o usuário for um aluno -->
                            @if(Auth::user()->tipo == 'administrador')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Naturezas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Editais</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Usuários</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Meus dados</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Meus dados</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-success" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Sair
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                
                            @endif

                            <!-- Se o usuário for um servidor -->
                            @if(Auth::user()->tipo == 'administradorResponsavel')
                                <!-- Carrega component contendo navbar do servidor -->
                                {{-- @component('componentes.navbarServidor')
                                @endcomponent --}}

                            @endif
                            
                            @if(Auth::user()->tipo == 'proponente')
                                <!-- Carrega component contendo navbar do administrador -->
                                {{-- @component('componentes.navbarAdministrador')
                                @endcomponent --}}
                            @endif
                            
                            
                            {{-- <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    <a class="dropdown-item" href="{{ route('perfil') }}">
                                        <img src="{{asset('img/icons/perfil.svg')}}" alt="">
                                        {{ __('Minha Conta') }}
                                    </a>

                                    {
                                    <a class="dropdown-item" href="{{ route('user.meusTrabalhos') }}">
                                        <img src="{{asset('img/icons/file-alt-regular-black.svg')}}" alt="">
                                        {{ __('Participante') }}
                                    </a>

                                </div>
                            </li> --}}
                            <nav class="navbar navbar-default" role="navigation">
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>