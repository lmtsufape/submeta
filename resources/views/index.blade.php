@extends('layouts.app')

@section('content')

<div class="content">

  {{-- Apresentação do sistema --}}
   <div class="row justify-content-center curved" style="margin-bottom:-5px">
    <div class=" col-sm-8 text">
      <h1>Logo do Sistema</h1>
      <p>
        O "sistema de gestão de eventos científicos" é uma plataforma web desenvolvida como software livre pela
        Universidade Federal do Agreste de Pernambuco que busca contribuir com instituições acadêmicas públicas
        ou privadas que necessitem de uma ferramenta para viabilizar a gestão de todo o conjunto de atividades
        ligadas a um evento científico, sejam elas inscrições para participação ou de trabalhos,
        avaliação de trabalhos, certificação, entre outros.
      </p>
    </div>
    <div class="col-sm-4">
      <img src="{{asset('img/pc.png')}}" alt="">
    </div>

  </div>


  <div class="row justify-content-center" style="margin-bottom:5%">
    <div class="col-sm-12" style="padding:0">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#114048ff"
        fill-opacity="1" d="M0,288L80,261.3C160,235,320,181,480,176C640,171,800,213,960,
        218.7C1120,224,1280,192,1360,176L1440,160L1440,0L1360,0C1280,0,1120,0,960,0C800,
        0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
      </svg>
    </div>
  </div>


  <div class="row justify-content-center modulos" style="padding:0 5% 0 5%">
    <div class="col-sm-4">
      <div class="info-modulo">
        <div class="info-modulo-head">
          <img src="{{asset('img/icons/inscricao.svg')}}" alt="">
          <h1>Inscrições</h1>

        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ccc" fill-opacity="1" d="M0,224L120,213.3C240,203,480,181,720,160C960,139,1200,117,1320,106.7L1440,96L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>
        <div class="info-modulo-body">

          <p>Permite a inscrição de pessoas físicas,
            jurídicas, grupos e outras modalidades nos eventos criados de
            modo gratuito, pago ou ainda com cupons de desconto ou de gratuidade.
            Viabiliza o pagamento por meio de boleto bancário, cartão de débito
            ou de crédito por meio de parcerias com outras ferramentas e também
            possui uma interface administrativa para a gestão destas inscrições
            e valores recebidos destas inscrições.</p>
          </div>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="info-modulo">
        <div class="info-modulo-head">
          <img src="{{asset('img/icons/documento.svg')}}" alt="">
          <h1>Trabalhos</h1>

        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ccc" fill-opacity="1" d="M0,224L120,213.3C240,203,480,181,720,160C960,139,1200,117,1320,106.7L1440,96L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>
        <div class="info-modulo-body">

          <p>Propicia a gestão do fluxo dos
            trabalhos acadêmicos de diversas naturezas (resumo,
            trabalho completo, etc) dentro de um evento, isto é,
             a inscrição, distribuição, avaliação, classificação,
              organização para apresentação, entre outras.</p>
          </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="info-modulo">
        <div class="info-modulo-head">
          <img src="{{asset('img/icons/certificado.svg')}}" alt="">
          <h1>Certificados</h1>

        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#ccc" fill-opacity="1" d="M0,224L120,213.3C240,203,480,181,720,160C960,139,1200,117,1320,106.7L1440,96L1440,320L1320,320C1200,320,960,320,720,320C480,320,240,320,120,320L0,320Z"></path></svg>
        <div class="info-modulo-body">

          <p>Viabiliza a emissão de
            todo os certificados necessários de modo rápido e
             em tempo real. Contempla a emissão de certificados
             para participantes, comissão organizadora, científica,
             palestrantes, e outras naturezas de envolvimento no evento.
              Também permite a customização inteligente de modelos de
              certificados, logos, assinaturas, etc.</p>
          </div>
        </div>
      </div>
    </div>


    {{-- Container Eventos Recentes --}}
    <div class="container-fluid" style="width:95%; margin-bottom:50px">

      <div class="col-sm-12">
        <div class="row titulo" style="margin-top:0">
          <h1>Eventos em curso</h1>
        </div>
      </div>

      <div class="row">
        @foreach ($eventos as $evento)
            <div class="card" style="width: 18rem;">
                @if(isset($evento->fotoEvento))
                  <img src="{{asset('storage/eventos/'.$evento->id.'/logo.png')}}" class="card-img-top" alt="...">
                @else
                  <img src="{{asset('img/colorscheme.png')}}" class="card-img-top" alt="...">
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="card-title">
                                <div class="row justify-content-center">
                                    <div class="col-sm-12">
                                        {{$evento->nome}}
                                        @can('isCoordenador', $evento)
                                            <div class="btn-group dropright dropdown-options">
                                                <a id="options" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{-- <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px"> --}}
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a href="{{ route('coord.detalhesEvento', ['eventoId' => $evento->id]) }}" class="dropdown-item">
                                                        <img src="{{asset('img/icons/eye-regular.svg')}}" class="icon-card" alt="">
                                                        Detalhes
                                                    </a>
                                                    <a href="{{route('evento.editar',$evento->id)}}" class="dropdown-item">
                                                        <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                                                        Editar
                                                    </a>
                                                    <form method="POST" action="{{route('evento.deletar',$evento->id)}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="dropdown-item">
                                                            <img src="{{asset('img/icons/trash-alt-regular.svg')}}" class="icon-card" alt="">
                                                            Deletar
                                                        </button>

                                                    </form>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>

                                </div>

                            </h4>

                        </div>
                    </div>
                    <p class="card-text">
                        <strong>Realização:</strong> {{date('d/m/Y',strtotime($evento->dataInicio))}} - {{date('d/m/Y',strtotime($evento->dataFim))}}<br>
                        <strong>Submissão:</strong> {{date('d/m/Y',strtotime($evento->inicioSubmissao))}} - {{date('d/m/Y',strtotime($evento->fimSubmissao))}}<br>
                        <strong>Revisão:</strong> {{date('d/m/Y',strtotime($evento->inicioRevisao))}} - {{date('d/m/Y',strtotime($evento->fimRevisao))}}<br>
                    </p>
                    <p>

                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <img src="{{asset('img/icons/map-marker-alt-solid.svg')}}" alt="" style="width:15px">
                                {{$evento->endereco->rua}}, {{$evento->endereco->numero}} - {{$evento->endereco->cidade}} / {{$evento->endereco->uf}}.
                            </div>
                        </div>
                    </p>
                    <p>
                        <a href="{{  route('evento.visualizarNaoLogado',['id'=>$evento->id])  }}" class="visualizarEvento">Visualizar Evento</a>
                    </p>
                </div>

            </div>
        @endforeach
      </div>

      <div class="row justify-content-center">
        <a class="btn btn-outline-secondary btn-lg" href="{{route('home')}}"
          style="margin-bottom:10px;" role="button">Mais Eventos</a>

      </div>

    </div>{{-- end Container Eventos Recentes --}}

    {{-- Footer --}}
    <div class="footer">

      <div class="row justify-content-center">
        <div class="col-sm-3 coluna">
          <div class="row justify-content-center">
            <small>Desenvolvidor por:</small>
          </div>
          <div class="row justify-content-center">
            <a href="http://www.lmts.uag.ufrpe.br/br" name="lmts">
              <img src="{{asset('img/lmts.png')}}" style="margin:20px 0 20px 0">
            </a>
          </div>
          <div class="row justify-content-center" style="text-align:center">
            Laboratório Multidisciplinar de<br>
            Tecnologias Sociais
          </div>
          <div class="row justify-content-center" style="margin-top:20px; text-align:center">
            <small>
              Avenida Bom Pastor, s/n.º<br>
              Bairro Boa Vista - CEP:<br>
              55292-270 - Garanhuns - PE
            </small>
          </div>

        </div>
        <div class="col-sm-3 coluna">
          <div class="row justify-content-center">
            <h3>LMTS</h3>
          </div>
          <div class="row sobre justify-content-center">
            <a href="http://www.lmts.uag.ufrpe.br/br/content/apresenta%C3%A7%C3%A3o">Quem Somos</a>
          </div>
          <div class="row sobre justify-content-center">
            <a href="http://www.lmts.uag.ufrpe.br/br/content/equipe">Equipe</a>
          </div>
          <div class="row sobre justify-content-center">
            <a href="http://www.lmts.uag.ufrpe.br/br/noticias">Notícias</a>
          </div>
          <div class="row sobre justify-content-center">
            <a href="http://www.lmts.uag.ufrpe.br/br/content/projetos">Projetos</a>
          </div>
          <div class="row social-network justify-content-center">
            <h6>Siga-nos nas Redes Sociais</h6>
          </div>
          <div class="row justify-content-center">
            <div class="social">
              <a href="https://www.facebook.com/LMTSUFAPE/">
                <img src="{{asset('img/icons/facebook-square-brands.svg')}}" alt="">
              </a>
            </div>
            <div class="social">
              <a href="https://www.instagram.com/lmts_ufape/">
                <img src="{{asset('img/icons/instagram-brands.svg')}}" alt="">
              </a>
            </div>
            <div class="social">
              <a href="https://twitter.com/lmtsufape">
                <img src="{{asset('img/icons/twitter-brands.svg')}}" alt="">
              </a>
            </div>
            <div class="social">
              <a href="https://br.linkedin.com/in/lmts-ufrpe-0b25b9196?trk=people-guest_people_search-card">
                <img src="{{asset('img/icons/linkedin-brands.svg')}}" alt="">
              </a>
            </div>
          </div>
        </div>
        <div class="col-sm-3 coluna">
          <div class="row justify-content-center">
            <h3>CONTATO</h3>
          </div>
          <div class="row justify-content-center">
            <a href="mailto:lmts@ufrpe.br">lmts@ufrpe.br</a>
          </div>
        </div>
        <div class="col-sm-3 coluna ">
          <div class="row justify-content-center">
            <h3>APOIO</h3>

          </div>
          <div class="row justify-content-center">

            <a href="http://ww3.uag.ufrpe.br/">
              <img style="width:77px" src="{{asset('img/logoUfape.svg')}}" alt="">
            </a>
          </div>
          <div class="row justify-content-center">
            Universidade Federal Rural<br>
            do Agreste de Pernambuco
          </div>
        </div>
      </div>
  </div>
  </div>



  <!-- Modal Login-->
  <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLogin" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row justify-content-center">
                <div class="titulo-login-cadastro">Login</div>
            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary" style="width:100%">
                        {{ __('Login') }}
                    </button>
                    <div class="row justify-content-center">

                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection

@section('javascript')


@endsection
