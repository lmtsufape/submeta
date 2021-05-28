@extends('layouts.app')

@section('content')

<div class="container">

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

@endsection
