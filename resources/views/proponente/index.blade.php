@extends('layouts.app')

@section('content')

<div class="container" style="margin-bottom:8rem">
	@if(session('verified'))
        <div class="alert alert-success" role="alert" style="margin-top: 2rem;">
			<h5 class="alert-heading">Bem-vindo ao Submeta!</h4>
			<hr>
            <p>Seu email foi verificado com sucesso.</p>
        </div>
    @endif
	<div class="row justify-content-center" style="margin-top: 2rem;">
		<div class="col-md-12 form-group" style="text-align: center">
			<h5 style="color: #1492E6; margin-top:0.5rem; font-size:25px">Página inicial</h5>
			<h5 style="color: #909090; margin-top:0.7rem; font-size:22px; font-weight:normal">Proponente</h5>
		</div>
	  <div class="" style="text-align: center">
		<div class="form-group imagem_shadow" style="border-radius: 12px; padding:14px; height:200px; width:190px; margin:15px">
			<a href="{{route('coord.home')}}" style="text-decoration:none; color: inherit;">
				<img src="{{asset('img/icons/icon_editais.png')}}" alt="" width="120px">
				<h5 style="color: #073763; margin-top:0.5rem; font-size:25px;">Editais</h5>
			</a>
		</div>
	  </div>
	  <div class="" style="text-align: center">
		<div class="form-group imagem_shadow" style="border-radius: 12px; padding:14px; height:200px; width:250px; margin:15px">
			<a href="{{ route('proponente.projetos')}}" style="text-decoration:none; color: inherit;">
				@if(\App\Trabalho::where('proponente_id', auth()->user()->proponentes->id)->count() > 0)
					<img src="{{asset('img/icons/icon_pasta_cheia.png')}}" alt="" width="140px" style="margin-top: 45px; -webkit-filter: drop-shadow(5px 5px 5px rgb(206, 206, 206)); filter: drop-shadow(5px 5px 5px rgb(206, 206, 206));">
				@else
					<img src="{{asset('img/icons/icon_pasta_vazia.png')}}" alt="" width="140px" style="margin-top: 45px; -webkit-filter: drop-shadow(5px 5px 5px rgb(206, 206, 206)); filter: drop-shadow(5px 5px 5px rgb(206, 206, 206));">
				@endif
				<h5 style="color: #073763; margin-top:0.5rem; font-size:25px">Minhas propostas</h5>
			</a>
		</div>
	  </div>
	</div>
</div>

<!--
   <div class="row justify-content-center titulo-menu">
		<h4>Página Principal - Proponente</h4>
	</div>

    <div class="row justify-content-center d-flex align-items-center">
        <div class="col-sm-3 d-flex justify-content-center ">
           <a href="{{route('coord.home')}}" style="text-decoration:none; color: inherit;">
            <div class="card text-center card-menu">
					<div class="card-body d-flex justify-content-center">
						<div class="container">
							<div class="row titulo-card-menu">
								<div class="col-md-12">
									<h2 style="padding-top:15px">Editais</h2>
								</div>
							</div>
							@php
								$eventos = \App\Evento::all();
								$quantAberta = 0;
								$quantEncerrada = 0;
								$hoje = today();

								foreach ($eventos as $evento) {
									if ($evento->fimSubmissao >= $hoje) {
										$quantAberta++;
									} else {
										$quantEncerrada++;
									}
								}
							@endphp
							<div class="info-card">
								<div class="row" style="text-align: left;">
									<div class="col-md-12">
										Total: {{$quantAberta + $quantEncerrada}}
									</div>
								</div>
								<div class="row" style="text-align: left;">
									<div class="col-md-12">
										Aberto: {{$quantAberta}}
									</div>
								</div>
								<div class="row" style="text-align: left;">
									<div class="col-md-12">
										Encerrado: {{$quantEncerrada}}
									</div>
								</div>
							</div>
						</div>
					</div>
	            </div>
           </a>
        </div>

        <div class="col-sm-3 d-flex justify-content-center">
         <a href="{{ route('proponente.projetos') }}" style="text-decoration:none; color: inherit;">
            <div class="card text-center card-menu">
					<div class="card-body d-flex justify-content-center">
						<div class="container">
							<div class="row titulo-card-menu">
								<div class="col-md-12">
									<h2 style="padding-top:15px">Projetos</h2>
								</div>
							</div>
                     <div class="row">
                        <div class="col-md-12">
                           <h6>Nº total de projetos:</h6>
                        </div>
                     </div>
							@php
								$projetos = \App\Trabalho::where('proponente_id', auth()->user()->proponentes->id)->count();
							@endphp
                     <div class="row">
                        <div class="col-md-12">
                           <h1 class="quant-titulo-card">{{$projetos}}</h1>
                        </div>
                     </div>
						</div>
					</div>
	            </div>
           </a>
        </div>
        {{-- <div class="col-sm-3 d-flex justify-content-center">
           <a href="#" style="text-decoration:none; color: inherit;">
              <div class="card text-center " style="border-radius: 30px; width: 13rem;height: 15rem;">
               <div class="card-body d-flex justify-content-center">
                    <h2 style="padding-top:15px">Mensagens</h2>
                 </div>
              </div>
           </a>
        </div> --}}
    </div>
</div>
-->
@endsection
