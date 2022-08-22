@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
	<!--Proponente Dados-->
	<div class="col-md-10" style="margin-top:4rem;padding: 0px">
		@component('projeto.formularioVisualizar.proponente2', ['edital' => $trabalho->evento, 'projeto' => $trabalho])
		@endcomponent
	</div>

	<!--Anexos do Projeto-->
	<div class="col-md-10"  style="margin-top:20px">
		<div class="card" style="border-radius: 5px">
			<div class="card-body" style="padding-top: 0.2rem;">
				<div class="container">
					<div class="form-row mt-3">
						<div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Anexos</h5></div>
					</div>
					<hr style="border-top: 1px solid#1492E6">

					{{-- Anexo do Projeto --}}
					<div class="row justify-content-left">
						{{-- Arquivo  --}}
						<div class="col-sm-12">
							<label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold">{{ __('Projeto: ') }}</label>
							<a href="{{ route('baixar.anexo.projeto', ['id' => $trabalho->id])}}"><img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>

						</div>
						<br>
						{{-- Autorização Especial --}}
						@if($trabalho->evento->natureza_id != 3)
							<div class="col-sm-12">
								<label for="nomeTrabalho" class="col-form-label font-tam" style="font-weight: bold">{{ __('Autorização Especial: ') }}</label>
								@if($trabalho->anexoAutorizacaoComiteEtica != null)
									<a href="{{ route('baixar.anexo.comite', ['id' => $trabalho->id]) }}"> <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
								@else
									-
								@endif
							</div>
							<br>
						@endif
						{{-- Anexo(s) do Plano(s) de Trabalho  --}}
						@foreach( $trabalho->participantes as $participante)
							@php
								if( App\Arquivo::where('participanteId', $participante->id)->first() != null){
                                  $planoTrabalhoTemp = App\Arquivo::where('participanteId', $participante->id)->first()->nome;
                                }else{
                                  $planoTrabalhoTemp = null;
                                }
							@endphp
							<div class="col-sm-12">
								<label for="anexoProjeto" class="col-form-label font-tam" style="font-weight: bold"
								title="{{$participante->planoTrabalho->titulo}}">{{ __('Projeto: ') }}{{$participante->planoTrabalho->titulo}}</label>

								@if($planoTrabalhoTemp != null)
									<a href="{{route('download', ['file' => $planoTrabalhoTemp])}}"><img src="{{asset('img/icons/pdf.ico')}}" style="width:40px" alt=""></a>
								@endif
							</div>
						@endforeach

						{{--Documento Extra--}}
						@if($trabalho->evento->nome_docExtra != null)
							<div class="col-sm-12">
								<label for="anexo_docExtra" class="col-form-label font-tam" style="font-weight: bold">{{ $trabalho->evento->nome_docExtra }}:@if($trabalho->evento->obrigatoriedade_docExtra == true) <span style="color: red; font-weight:bold">*</span> @endif</label>
								@if($trabalho->anexo_docExtra != null)
									<a href="{{ route('baixar.anexo.docExtra', ['id' => $trabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
								@else
									<i class="fas fa-times-circle fa-2x" style="color:red; font-size:25px"></i>
								@endif
							</div>
							<br>
						@endif
					</div>

					<!-- TO AKI -->
					<hr style="border-top: 1px solid#1492E6">
					<div class="form-row mt-3">
						<div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Meu parecer</h5></div>
						<div class="col-md-12"><h6 style="color: #234B8B; font-weight: bold">Trabalho: {{$trabalho->titulo}}</h6></div>
					</div>
					

				<form method="POST" action="{{route('avaliador.enviarParecer')}}" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="trabalho_id" value="{{ $trabalho->id }}" >
					<input type="hidden" name="evento_id" value="{{ $evento->id }}" >
					<div class="form-group">
						<label style="font-weight: bold">Parecer</label>
							<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="textParecer" placeholder="Digite aqui o seu parecer" >{{ $trabalho->pivot->parecer }}</textarea>
					</div>
					
					@if($evento->tipo == "PIBEX")
					<div class="form-group">
						<div class="row justify-content-start">
							<div class="col-sm-3">
								@component('componentes.input', ['label' => 'Pontuação calculada'])
								<input type="number" min="0" step="1" name="pontuacao" style="width: 70px"
									@if($trabalho->pivot!=null && $trabalho->pivot->pontuacao !=null )
									value="{{$trabalho->pivot->pontuacao}}"
									@else value="0"
									@endif required>
								@endcomponent
							</div>
						</div>
					</div>
					@endif


					<select class="custom-select" name="recomendacao" >
							<option  @if($trabalho->pivot->recomendacao =='RECOMENDADO' ) selected @endif value="RECOMENDADO">RECOMENDADO</option>	
							<option @if($trabalho->pivot->recomendacao =='NAO-RECOMENDADO' ) selected @endif value="NAO-RECOMENDADO">NAO-RECOMENDADO</option>												  
					</select>
					<div class="form-group  mt-3 md-3">
						<label >Formulário do Parecer : </label>
						<a href="{{route('download', ['file' => $trabalho->evento->formAvaliacaoExterno])}}" target="_new" style="font-size: 20px; color: #114048ff;" >
							<img class="" src="{{asset('img/icons/file-download-solid.svg')}}" style="width:20px">
						</a>
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
					<hr style="border-top: 1px solid#1492E6">
					<div class="d-flex justify-content-end">
						<div style="margin-right: 15px"><a href="{{ route('avaliador.visualizarTrabalho', ['evento_id' => $evento->id])}}"  class="btn btn-light" style="color: red;">Cancelar</a></div>
						<div><button type="submit" class="btn btn-success" @if($evento->inicioRevisao > $hoje || $evento->fimRevisao < $hoje) disabled @endif>Enviar meu parecer</button></div>
						
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

<style>
	label {
		font-weight: bold;
	}
</style>
