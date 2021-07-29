@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center titulo-menu">
		<h4>Perfil de Administrador</h4>
	</div>

       <div class="row justify-content-center d-flex align-items-center">
	      <div class="col-sm-3 d-flex justify-content-center ">
	         <a href="{{ route('admin.editais') }}" style="text-decoration:none; color: inherit;">
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
	         <a href="{{ route('admin.naturezas') }}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center card-menu">
					<div class="container">
						<div class="row titulo-card-menu">
							<div class="card-body d-flex justify-content-center">
								<h2 style="padding-top:15px">Natureza</h2>
						 	</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h6>Nº total de naturezas:</h6>
							</div>
						</div>
						@php
							$naturezas = \App\Natureza::count();
						@endphp
						<div class="row">
							<div class="col-md-12">
								<h1 class="quant-titulo-card">{{$naturezas}}</h1>
							</div>
						</div>
					</div>
	            </div>
	         </a>
		  </div>

		  <div class="col-sm-3 d-flex justify-content-center">
			<a href="{{ route('grandearea.index') }}" style="text-decoration:none; color: inherit;">
			   <div class="card text-center card-menu">
				<div class="container">
					<div class="row titulo-card-menu">
						<div class="card-body d-flex justify-content-center">
							<h2 style="padding-top:15px">Áreas</h2>
						 </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h6>Nº total de áreas:</h6>
						</div>
					</div>
					@php
						$grandeAreas = \App\GrandeArea::count();
						$areas = \App\Area::count();
						$grandeAreas = \App\SubArea::count();
					@endphp
					<div class="row">
						<div class="col-md-12">
							<h1 class="quant-titulo-card">{{$grandeAreas + $areas + $grandeAreas}}</h1>
						</div>
					</div>
				</div>
			   </div>
			</a>
		 </div>

			<div class="col-sm-3 d-flex justify-content-center">
					<a href="{{ route('admin.usuarios') }}" style="text-decoration:none; color: inherit;">
						<div class="card text-center card-menu">
				<div class="container">
					<div class="row titulo-card-menu">
						<div class="card-body d-flex justify-content-center">
							<h2 style="padding-top:15px">Usuários</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h6>Nº total de usuários:</h6>
						</div>
					</div>
					@php
						$usuarios = \App\User::count();
					@endphp
					<div class="row">
						<div class="col-md-12">
							<h1 class="quant-titulo-card">{{$usuarios}}</h1>
						</div>
					</div>
				</div>
						</div>
					</a>
			</div>
			<br>
			<div class="col-sm-3 d-flex justify-content-center m-4">
					<a href="{{ route('admin.showProjetos') }}" style="text-decoration:none; color: inherit;">
						<div class="card text-center card-menu">
				<div class="container">
					<div class="row titulo-card-menu">
						<div class="card-body d-flex justify-content-center">
							<h2 style="padding-top:15px">Projetos</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<h6>Nº total de projetos:</h6>
						</div>
					</div>
					@php
						$trabalhos = \App\Trabalho::count();
					@endphp
					<div class="row">
						<div class="col-md-12">
							<h1 class="quant-titulo-card">{{$trabalhos}}</h1>
						</div>
					</div>
				</div>
						</div>
					</a>
			</div>
	      
	   </div>


      

</div>

@endsection
