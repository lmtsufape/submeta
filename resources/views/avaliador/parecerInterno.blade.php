@extends('layouts.app')

@section('content')

	<div class="row justify-content-center">

		@component('projeto.formularioVisualizar.projeto',
                  ['grandeAreas' => $grandeAreas, 'projeto' => $trabalho,
                   'areas' => $areas, 'subareas' => $subAreas])
		@endcomponent

		@component('projeto.formularioVisualizar.proponente', ['projeto' => $trabalho])
		@endcomponent

		@component('projeto.formularioVisualizar.anexos', ['projeto' => $trabalho])
		@endcomponent

		@component('projeto.formularioVisualizar.participantes', ['estados' => $estados, 'enum_turno' => $enum_turno, 'projeto' => $trabalho, 'participantes' => $participantes, 'arquivos' =>$arquivos])
		@endcomponent

		{{-- @component('projeto.formularioVisualizar.finalizar', ['projeto' => $projeto])
        @endcomponent --}}

	</div>
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

					<div class="col-sm-10">
						<label for="nomeTrabalho" class="col-form-label">Link Lattes do Proponente:    </label>

						<label for="aceito">{{ __(' Aceito') }}</label>
						<input type="radio" name="anexoLinkLattes" value="aceito" @if($parecer!=null && $parecer->statusLinkLattesProponente =='aceito') checked @endif required>

						<label for="recusado" >{{ __(' Recusado') }}</label>
						<input type="radio" name="anexoLinkLattes" value="recusado" @if($parecer!=null && $parecer->statusLinkLattesProponente =='recusado') checked @endif>

					</div>

					<div class="col-sm-10" >
						<label for="nomeTrabalho" class="col-form-label">{{ __('Link do grupo de pesquisa: ') }}</label>

						<label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
						<input type="radio" name="anexoGrupoPesquisa" value="aceito" @if($parecer!=null && $parecer->statusLinkGrupoPesquisa =='aceito' ) checked @endif required>

						<label for="recusado">{{ __(' Recusado') }}</label>
						<input type="radio" name="anexoGrupoPesquisa" value="recusado" @if($parecer!=null && $parecer->statusLinkGrupoPesquisa =='recusado' ) checked @endif>
					</div>

				</div>

				<h3>Anexos</h3>

				{{-- Anexo do Projeto --}}
				<div class="row">
					{{-- Arquivo  --}}
					<div class="col-sm-6">
						<label for="anexoProjeto" class="col-form-label">{{ __('Projeto: ') }}</label>

                        <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                        <input type="radio" name="anexoProjeto" value="aceito" @if($parecer!=null && $parecer->statusAnexoProjeto =='aceito' ) checked @endif required>

                        <label for="recusado">{{ __(' Recusado') }}</label>
                        <input type="radio" name="anexoProjeto" value="recusado" @if($parecer!=null && $parecer->statusAnexoProjeto =='recusado' ) checked @endif>
                    </div>

					<div class="col-sm-6">
						<label for="anexoLatterCoordenador" class="col-form-label">{{ __('Lattes do Coordenador: ') }}</label>

                        <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                        <input type="radio" name="anexoLattesCoordenador" value="aceito" @if($parecer!=null && $parecer->statusAnexoLattesCoordenador =='aceito' ) checked @endif required>

                        <label for="recusado">{{ __(' Recusado') }}</label>
                        <input type="radio" name="anexoLattesCoordenador" value="recusado" @if($parecer!=null && $parecer->statusAnexoLattesCoordenador =='recusado' ) checked @endif>
                    </div>

					<div class="col-sm-6">
						<label for="anexoPlanilha" class="col-form-label">{{ __('Planilha de Pontuação: ') }}</label>

                        <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                        <input type="radio" name="anexoPlanilha" value="aceito" @if($parecer!=null && $parecer->statusAnexoPlanilhaPontuacao =='aceito' ) checked @endif required>

                        <label for="recusado">{{ __(' Recusado') }}</label>
                        <input type="radio" name="anexoPlanilha" value="recusado" @if($parecer!=null && $parecer->statusAnexoPlanilhaPontuacao =='recusado' ) checked @endif>
                    </div>

					@if($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM')
						{{-- Decisão do CONSU --}}
						<div class="col-sm-6">
							<label for="anexoCONSU" class="col-form-label">{{ __('Decisão do CONSU: ') }}</label>

                            <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                            <input type="radio" name="anexoConsu" value="aceito" @if($parecer!=null && $parecer->statusAnexoDecisaoCONSU =='aceito' ) checked @endif required>

                            <label for="recusado">{{ __(' Recusado') }}</label>
                            <input type="radio" name="anexoConsu" value="recusado" @if($parecer!=null && $parecer->statusAnexoDecisaoCONSU =='recusado' ) checked @endif>
                        </div>
					@endif

					<div class="col-sm-6">
						<label for="nomeTrabalho" class="col-form-label">{{ __('Autorização do Comitê de Ética: ') }}</label>

                        <label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
                        <input type="radio" name="anexoComiteEtica" value="aceito" @if($parecer!=null && $parecer->statusAnexoAtuorizacaoComiteEtica =='aceito' ) checked @endif required>

                        <label for="recusado">{{ __(' Recusado') }}</label>
                        <input type="radio" name="anexoComiteEtica" value="recusado" @if($parecer!=null && $parecer->statusAnexoAtuorizacaoComiteEtica =='recusado' ) checked @endif>
                    </div>

					<div class="col-sm-6">
						<label for="nomeTrabalho" class="col-form-label">{{ __('Justificativa: ') }}</label>

						<label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
						<input type="radio" name="anexoJustificativa" value="aceito" @if($parecer!=null && $parecer->statusJustificativaAutorizacaoEtica =='aceito' ) checked @endif required>

						<label for="recusado">{{ __(' Recusado') }}</label>
						<input type="radio" name="anexoJustificativa" value="recusado" @if($parecer!=null && $parecer->statusJustificativaAutorizacaoEtica =='recusado' ) checked @endif>
					</div>

					{{--Planos de trabalho--}}
					<div class="col-sm-6">
						<label for="nomeTrabalho" class="col-form-label">{{ __('Plano de Trabalho: ') }}</label>

						<label for="aceito" style="left: auto">{{ __(' Aceito') }}</label>
						<input type="radio" name="anexoPlano" value="aceito" @if($parecer!=null && $parecer->statusPlanoTrabalho =='aceito' ) checked @endif required>

						<label for="recusado">{{ __(' Recusado') }}</label>
						<input type="radio" name="anexoPlano" value="recusado" @if($parecer!=null && $parecer->statusPlanoTrabalho =='recusado' ) checked @endif>
					</div>

				</div>
				<div><hr></div>
				<div class="d-flex justify-content-end">
					<div style="margin-right: 15px"><a href="{{ route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id])}}"  class="btn btn-light" style="color: red;">Cancelar</a></div>
					<div><button type="submit" class="btn btn-success">Enviar meu parecer</button></div>
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
