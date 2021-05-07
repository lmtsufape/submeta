@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center titulo-menu">
		<h4>Edital Selecionado: {{ $evento->nome }} </h4>
	</div>

       <div class="row justify-content-center d-flex align-items-center">
	      <div class="col-sm-3 d-flex justify-content-center ">
	         <a href="{{route('admin.selecionar', ['evento_id' => $evento->id])}}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center card-menu">
					<div class="card-body d-flex justify-content-center">
						<div class="container">
							<div class="row titulo-card-menu">
								<div class="col-md-12">
									<h2 style="padding-top:15px">Selecionar avaliadores</h2>
								</div>
							</div>
							@php
								$avaliadores = \App\Avaliador::count();
							@endphp
							<div class="row">
								<div class="col-md-12">
									<h5>Nº total de avaliadores:</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h1 class="quant-titulo-card">{{$avaliadores}}</h1>
								</div>
							</div>
						</div>
					</div>
	            </div>
	         </a>
	      </div>

	      <div class="col-sm-3 d-flex justify-content-center">
	         <a href="{{ route('admin.projetos', ['evento_id' => $evento->id]) }}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center card-menu">
					<div class="card-body d-flex justify-content-center">
						<div class="container">
							<div class="row titulo-card-menu">
								<div class="col-md-12">
									<h2 style="padding-top:15px">Selecionar projetos</h2>
								</div>
							</div>
							@php
								$projetos = \App\Trabalho::count();
							@endphp
							<div class="row">
								<div class="col-md-12">
									<h5>Nº total de projetos:</h5>
								</div>
							</div>
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
