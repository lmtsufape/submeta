@extends('layouts.app')

@section('content')

<div class="container">

	<div class="container" style="margin-bottom:8rem">
		<div class="row justify-content-center" style="margin-top: 2rem;">
			<div class="col-md-12 form-group" style="text-align: center">
				<h5 style="color: #1492E6; margin-top:0.5rem; font-size:25px">Página inicial</h5>
				<h5 style="color: #909090; margin-top:0.7rem; font-size:22px; font-weight:normal">Avaliador</h5>
			</div>
		  <div class="" style="text-align: center">
			<div class="form-group imagem_shadow" style="border-radius: 12px; padding:14px; height:200px; width:190px; margin:15px">
				<a href="{{ route('avaliador.editais') }}" style="text-decoration:none; color: inherit;">
					<img src="{{asset('img/icons/icon_meus_editais.png')}}" alt="" width="120px">
					<h5 style="color: #073763; margin-top:0.5rem; font-size:25px;">Meus editais</h5>
				</a>
			</div>
		  </div>
		  
		</div>
	</div>
{{--
    <div class="row justify-content-center titulo-menu">
		<h4>Página Principal - Avaliador</h4>
	</div>

       <div class="row justify-content-center d-flex align-items-center">
	      <div class="col-sm-4 d-flex justify-content-center ">
	         <a href="{{ route('avaliador.editais') }}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center card-menu">
					<div class="card-body d-flex justify-content-center">
						<div class="container">
							<div class="row titulo-card-menu">
								<div class="col-md-12">
									<h2 style="padding-top:15px">Editais</h2>
								</div>
							</div>
							@php
								$eventos = auth()->user()->avaliadors->eventos;
								$quantAberta = 0;
								$quantEncerrada = 0;
								$hoje = today();

								foreach ($eventos as $evento) {
									if ($evento->pivot->convite === null || $evento->pivot->convite) {
										if ($evento->fimSubmissao >= $hoje) {
											$quantAberta++;
										} else {
											$quantEncerrada++;
										}
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
	   </div>

--}}
      

</div>

@endsection
