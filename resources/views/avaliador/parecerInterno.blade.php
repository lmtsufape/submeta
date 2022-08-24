@extends('layouts.app')

@section('content')

<div class="container col-md-12" >
	<div class="row justify-content-center" style="margin-top: 4rem;">

		<div class="col-md-10" style="padding: 0px"
		@component('projeto.formularioVisualizar.projeto2',
                  ['edital' => $trabalho->evento, 'projeto' => $trabalho,])
		@endcomponent
		</div>

		<div class="col-md-10" style="padding: 0px"
		@component('projeto.formularioVisualizar.proponente2', ['edital' => $trabalho->evento, 'projeto' => $trabalho])
		@endcomponent
		</div>

		<div class="col-md-10" style="padding: 0px"
		@component('projeto.formularioVisualizar.anexos2', ['edital' => $trabalho->evento, 'projeto' => $trabalho])
		@endcomponent
		</div>
		<!-- Participantes -->
			<div class="col-sm-10" style="margin-top: 20px">
				<div class="card" style="border-radius: 5px">
					<div class="card-body" style="padding-top: 0.2rem;">
						<div class="container">
							<div class="form-row mt-3">
								<div class="col-sm-9"><h5 style="color: #234B8B; font-weight: bold">Discentes</h5></div>
							</div>
							<hr style="border-top: 1px solid#1492E6">

							<div class="row justify-content-start" style="alignment: center">
								@foreach($trabalho->participantes as $participante)
									<div class="col-sm-1">
										<img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
									</div>
									<div class="col-sm-5">
										<h5>{{$participante->user->name}}</h5>
										<h9>
											<a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$participante->id}}" class="button">Informações</a>
										</h9>
									</div>
									<!-- Modal visualizar informações participante -->
									<div class="modal fade" id="modalVizuParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered modal-lg">
											<div class="modal-content">
												<div class="modal-header" style="overflow-x:auto; padding-left: 31px">
													<h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

													<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
													@include('administrador.substituirParticipanteForm', ['visualizarOnly' => 1, 'edital' => $evento])
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
{{-- Parecer Interno --}}
<div class="container col-md-11">
	<div class="row justify-content-center" style="margin-top: 3rem;">
	  <div class="col-md-11" style="margin-bottom: -3rem">
		<div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px; overflow:auto">
		  <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
			<div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
			  <div class="bottomVoltar" style="margin-top: -20px">
				<a href="javascript:history.back()" class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
			  </div>
			  <div class="form-group">
				  <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Parecer Interno</h5>
				  <h5 class="card-title mb-0" style="font-size:19px; font-family:Arial, Helvetica, sans-serif; color:#909090">Projeto: {{ $trabalho->titulo }}</h5>
			  </div>
			  <div style="margin-top: -2rem">
				<div class="form-group">
				  <div style="margin-top:30px;">
				   {{-- Pesquisar--}}
				  </div>
				</div>
			  </div>
			</div>
		  </div>
  
		  <div class="card-body" >
			<form method="POST" action="{{route('avaliador.enviarParecerInterno')}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="trabalho_id" value="{{$trabalho->id}}" >
				<input type="hidden" name="avaliador_id" value="{{Auth::user()->avaliadors->id}}" >
				<input type="hidden" name="evento_id" value="{{$evento->id}}" >

				<h3>Informações do proponente</h3>
				{{-- Coordenador  --}}
				<div class="row">

					<div class="col-sm-3">
						<label for="nomeTrabalho" class="col-form-label">Lattes do Proponente:    </label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">

						<label for="aceito">{{ __(' Aceito') }}</label>
						<input type="radio" name="anexoLinkLattes" value="aceito" @if($parecer!=null && $parecer->statusLinkLattesProponente =='aceito') checked @endif required>

						<label for="recusado" >{{ __(' Recusado') }}</label>
						<input type="radio" name="anexoLinkLattes" value="recusado" @if($parecer!=null && $parecer->statusLinkLattesProponente =='recusado') checked @endif>

					</div>
					<div class="col-sm-6"></div>

					<div class="col-sm-3" >
						<label for="nomeTrabalho" class="col-form-label">{{ __('Grupo de pesquisa: ') }}</label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">

						<label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
						<input type="radio" name="anexoGrupoPesquisa" value="aceito" @if($parecer!=null && $parecer->statusLinkGrupoPesquisa =='aceito' ) checked @endif required>

						<label for="recusado">{{ __(' Recusado') }}</label>
						<input type="radio" name="anexoGrupoPesquisa" value="recusado" @if($parecer!=null && $parecer->statusLinkGrupoPesquisa =='recusado' ) checked @endif>
					</div>

				</div>

				<br>
				<h3>Anexos</h3>

				{{-- Anexo do Projeto --}}
				<div class="row">
					{{-- Arquivo  --}}
					<div class="col-sm-3">
						<label for="anexoProjeto" class="col-form-label">{{ __('Projeto: ') }}</label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">

                        <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                        <input type="radio" name="anexoProjeto" value="aceito" @if($parecer!=null && $parecer->statusAnexoProjeto =='aceito' ) checked @endif required>

                        <label for="recusado">{{ __(' Recusado') }}</label>
                        <input type="radio" name="anexoProjeto" value="recusado" @if($parecer!=null && $parecer->statusAnexoProjeto =='recusado' ) checked @endif>
                    </div>

					<div class="col-sm-3">
						<label for="anexoLatterCoordenador" class="col-form-label">{{ __('Lattes do Coordenador: ') }}</label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">

                        <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                        <input type="radio" name="anexoLattesCoordenador" value="aceito" @if($parecer!=null && $parecer->statusAnexoLattesCoordenador =='aceito' ) checked @endif required>

                        <label for="recusado">{{ __(' Recusado') }}</label>
                        <input type="radio" name="anexoLattesCoordenador" value="recusado" @if($parecer!=null && $parecer->statusAnexoLattesCoordenador =='recusado' ) checked @endif>
                    </div>

					<div class="col-sm-3">
						<label for="anexoPlanilha" class="col-form-label">{{ __('Pontuação calculada: ') }}</label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">
						<input type="number" min="0" step=".01" name="anexoPlanilha" style="width: 60px"
							   @if($parecer!=null && $parecer->statusAnexoPlanilhaPontuacao !=null)
							   	@if(is_numeric($parecer->statusAnexoPlanilhaPontuacao)) value="{{$parecer->statusAnexoPlanilhaPontuacao}}"
							    @else value="0"
							    @endif @endif required>
					</div>

					@if($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM')
						{{-- Decisão do CONSU --}}
						<div class="col-sm-3">
							<label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU: ') }}</label>
						</div>
						<div class="col-sm-3" style="top: 5px; text-align: right">

                            <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                            <input type="radio" name="anexoConsu" value="aceito" @if($parecer!=null && $parecer->statusAnexoDecisaoCONSU =='aceito' ) checked @endif required>

                            <label for="recusado">{{ __(' Recusado') }}</label>
                            <input type="radio" name="anexoConsu" value="recusado" @if($parecer!=null && $parecer->statusAnexoDecisaoCONSU =='recusado' ) checked @endif>
                        </div>
					@endif

					<div class="col-sm-3">
						<label for="nomeTrabalho" class="col-form-label">{{ __('Autorização do Comitê de Ética: ') }}</label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">

                        <label for="aceito" style="left: auto">{{ __(' Aceita') }}</label>
                        <input type="radio" name="anexoComiteEtica" value="aceito" @if($parecer!=null && $parecer->statusAnexoAtuorizacaoComiteEtica =='aceito' ) checked @endif required>

                        <label for="recusado">{{ __(' Recusada') }}</label>
                        <input type="radio" name="anexoComiteEtica" value="recusado" @if($parecer!=null && $parecer->statusAnexoAtuorizacaoComiteEtica =='recusado' ) checked @endif>
                    </div>

					<div class="col-sm-3">
						<label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa: ') }}</label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">

						<label for="aceito" style="left: auto">{{ __(' Aceita') }}</label>
						<input type="radio" name="anexoJustificativa" value="aceito" @if($parecer!=null && $parecer->statusJustificativaAutorizacaoEtica =='aceito' ) checked @endif required>

						<label for="recusado">{{ __(' Recusada') }}</label>
						<input type="radio" name="anexoJustificativa" value="recusado" @if($parecer!=null && $parecer->statusJustificativaAutorizacaoEtica =='recusado' ) checked @endif>
					</div>

					{{--Planos de trabalho--}}
					<div class="col-sm-3">
						<label for="nomeTrabalho" class="col-form-label">{{ __('Plano de Trabalho: ') }}</label>
					</div>
					<div class="col-sm-3" style="top: 5px; text-align: right">

						<label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
						<input type="radio" name="anexoPlano" value="aceito" @if($parecer!=null && $parecer->statusPlanoTrabalho =='aceito' ) checked @endif required>

						<label for="recusado">{{ __(' Recusado') }}</label>
						<input type="radio" name="anexoPlano" value="recusado" @if($parecer!=null && $parecer->statusPlanoTrabalho =='recusado' ) checked @endif>
					</div>

				</div>

				<br>
				<h3>Comentário</h3>
				<div class="row">
					<div class="col-md-9">
						<textarea class="col-md-12" minlength="20" id="comentario" name="comentario" style="border-radius:5px 5px 0 0;height: 71px;" required
						>@if($parecer!=null && $parecer->comentario !=null ) {{$parecer->comentario}} @endif</textarea>
					</div>
				</div>
				<div><hr></div>
				<div class="d-flex justify-content-end">
					<div style="margin-right: 15px"><a href="{{ route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id])}}"  class="btn btn-light" style="color: red;">Cancelar</a></div>
					<div>
						<button type="submit" class="btn btn-success" @if($evento->inicioRevisao > $hoje || $evento->fimRevisao < $hoje) disabled @endif>Enviar meu parecer</button></div>
				</div>
			</form>
		  </div>
		</div>
	  </div>
	</div>
  </div>
@endsection

@section('javascript')
<script type="text/javascript">


</script>
@endsection
