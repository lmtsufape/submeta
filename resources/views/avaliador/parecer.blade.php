@extends('layouts.app')

@section('content')


<div class="row justify-content-center">
	<!--Proponente Dados-->
	<div class="col-md-10" style="margin-top:4rem">
		<div class="card" style="border-radius: 12px">
			<div class="card-body">
				<div class="container">
					<div class="form-row mt-3">
						<div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Informações do proponente</h5></div>
						<div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>

						<div class="form-group col-md-12" style="margin-top: 15px">
							<label for="nomeCompletoProponente1">Proponente</label>
							<input class="form-control" type="text" id="nomeCompletoProponente1" name="nomeCoordenador" disabled="disabled" value="{{ $trabalho->proponente->user->name }}">

						</div>

						<div class="form-group col-md-6">
							<label for="linkLattesEstudante">Link do currículo Lattes</label>
							<input class="form-control @error('linkLattesEstudante') is-invalid @enderror" type="text" name="linkLattesEstudante" value="{{$trabalho->linkLattesEstudante}}" disabled >
							@error('linkLattesEstudante')
							<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
							  <strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>

						<div class="form-group col-md-6">
							<label for="linkGrupo">Link do grupo de pesquisa</label>
							<input class="form-control @error('linkGrupo') is-invalid @enderror" type="url" name="linkGrupo"
								   value="{{ $trabalho->linkGrupoPesquisa }}" disabled>

							@error('linkGrupo')
							<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
							  <strong>{{ $message }}</strong>
							</span>
							@enderror
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--Anecos do Projeto-->
	<div class="col-md-10"  style="margin-top:4rem">
		<div class="card" style="border-radius: 12px">
			<div class="card-body">
				<div class="container">
					<div class="form-row mt-3">
						<div class="col-md-12"><h5 style="color: #1492E6; margin-bottom:-0.4rem">Anexos</h5></div>
						<div class="col-md-12" style="margin-bottom: -0.8rem;"><hr style="border-top: 1px solid#1492E6"></div>
						{{-- Anexo do Projeto --}}
						<div class="form-group col-md-6" style="margin-top: 10px">
							<div class="row justify-content-start">
								<div class="col-9">
									@component('componentes.input', ['label' => 'Projeto (.pdf)'])
									@endcomponent
								</div>
								@if($trabalho->anexoProjeto)
									<div class="col-3 ">
										<a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}"><i class="fas fa-file-pdf fa-2x"></i></a>
									</div>
								@else
									<div class="col-3 text-danger">
										<p><i class="fas fa-times-circle fa-2x"></i></p>
									</div>
								@endif
							</div>
						</div>

						<!--Planos de Trabalho -->
						@foreach( $trabalho->participantes as $participante)
							@php
								if( App\Arquivo::where('participanteId', $participante->id)->first() != null){
                                  $planoTrabalhoTemp = App\Arquivo::where('participanteId', $participante->id)->first()->nome;
                                }else{
                                  $planoTrabalhoTemp = null;
                                }
							@endphp
							<div class="form-group col-md-6" style="margin-top: 10px">
								<div class="row justify-content-start">
									<div class="col-9">
										<label for="nomePlano" class="col-form-label">Plano: {{$participante->planoTrabalho->titulo}}   </label>
									</div>
									@if($planoTrabalhoTemp != null)
										<div class="col-3 ">
											<a href="{{route('download', ['file' => $planoTrabalhoTemp])}}"><i class="fas fa-file-pdf fa-2x"></i></a>
										</div>
									@else
										<div class="col-3 text-danger">
											<p><i class="fas fa-times-circle fa-2x"></i></p>
										</div>
									@endif
								</div>
							</div>
						@endforeach

						<!-- Anexo da autorizações especiais  -->
						<div class="form-group col-md-6">
							<div class="row justify-content-start">
								<div class="col-10 ">
									<div class="row">
										<div class="col-12">
											<label for="botao" class="col-form-label @error('botao') is-invalid @enderror" data-toggle="tooltip" data-placement="bottom" title="Se possuir, coloque todas em único arquivo pdf." style="margin-right: 15px;">{{ __('Possui autorizações especiais?') }} <span style="color: red; font-weight:bold">*</span></label>
										</div>
										<div class="col-12">
											<input type="radio" @if($trabalho->anexoAutorizacaoComiteEtica) checked @endif  id="radioSim"  onchange="displayAutorizacoesEspeciais('sim')" disabled>
											<label for="radioSim" style="margin-right: 5px">Sim</label>
											<input type="radio" id="radioNao" @if($trabalho->justificativaAutorizacaoEtica) checked @endif onchange="displayAutorizacoesEspeciais('nao')" disabled>
											<label for="radioNao" style="margin-right: 5px">Não</label><br>
										</div>
									</div>
									<span id="idAvisoAutorizacaoEspecial" class="invalid-feedback" role="alert" style="overflow: visible; display:none">
									  <strong>Selecione a autorização e envie o arquivo!</strong>
									</span>

									<div class="form-group" id="displaySim" style="display: block; margin-top:-1rem">
										@component('componentes.input', ['label' => 'Sim, declaro que necessito de autorizações especiais (.pdf)'])

											<div class="row justify-content-center">
												@if($trabalho->anexoAutorizacaoComiteEtica )
													<div class="col-3 mt-2">
														<a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
													</div>
												@else
													<div class="col-3 text-danger">
														<p><i class="fas fa-times-circle fa-2x"></i></p>
													</div>
												@endif

											</div>
											@error('anexoAutorizacaoComiteEtica')
											<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
											<strong>{{ $message }}</strong>
										  </span>
											@enderror
										@endcomponent
									</div>

									<div class="form-group" id="displayNao" style="display: none; margin-top:-1rem">
										@component('componentes.input', ['label' => 'Declaração de que não necessito de autorização especiais (.pdf)'])

											@if($trabalho->justificativaAutorizacaoEtica  )
												<div class="row justify-content-center">
													<div class="col-3 mt-2">
														<a href="{{ route('baixar.anexo.justificativa', ['id' => $trabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
													</div>
												</div>
											@else
												<div class="row justify-content-center">
													<div class="col-3 text-danger">
														<p><i class="fas fa-times-circle fa-2x"></i></p>
													</div>
												</div>
											@endif

											@error('justificativaAutorizacaoEtica')
											<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
											  <strong>{{ $message }}</strong>
											</span>
											@enderror
										@endcomponent
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div class="container">
	
	<div class="row justify-content-center" style="margin-top: 3rem;">
	  <div class="col-md-12" style="margin-bottom: -3rem">
		<div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px; overflow:auto">
		  <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
			<div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
			  <div class="bottomVoltar" style="margin-top: -20px">
				<a href="javascript:history.back()" class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
			  </div>
			  <div class="form-group">
				  <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Meu parecer</h5>
				  <h5 class="card-title mb-0" style="font-size:19px; font-family:Arial, Helvetica, sans-serif; color:#909090">Trabalho: {{ $trabalho->titulo }}</h5>
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
			<form method="POST" action="{{route('avaliador.enviarParecer')}}" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" >
				<input type="hidden" name="evento_id" value="{{ $evento->id }}" >
				<div class="form-group">
					@component('componentes.input', ['label' => 'Parecer'])
						<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="textParecer" placeholder="Digite aqui o seu parecer" required>{{ $trabalho->pivot->parecer }}</textarea>
					@endcomponent
				</div>
				<select class="custom-select" name="recomendacao" >
						<option  @if($trabalho->pivot->recomendacao =='RECOMENDADO' ) selected @endif value="RECOMENDADO">RECOMENDADO</option>	
						<option @if($trabalho->pivot->recomendacao =='NAO-RECOMENDADO' ) selected @endif value="NAO-RECOMENDADO">NAO-RECOMENDADO</option>												  
				</select>
				<div class="form-group  mt-3 md-3">
					@if($trabalho->pivot->AnexoParecer == null)
						@component('componentes.input', ['label' => 'Anexo do Parecer'])
							<input type="file" class="form-control-file" id="exampleFormControlFile1" name="anexoParecer" required>
						@endcomponent

					@else
					<div class="form-row">
						<div class="col-md-12">
							<h6>Arquivo atual</h6>
						</div>
						<div class="col-md-12 form-group">
							<div>
								<a href="{{route('download', ['file' => $trabalho->pivot->AnexoParecer])}}" target="_new" style="font-size: 18px;;" class="btn btn-light">
									<img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px; margin:5px">
									Baixar arquivo atual
								</a>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-12">
							<h6>Alterar arquivo atual</h6>
						</div>
						<div class="col-md-12 form-group">
							<div>
								<input type="file" class="form-control-file" id="exampleFormControlFile1" name="anexoParecer">
							</div>
						</div>
					</div>
					@endif
				
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
