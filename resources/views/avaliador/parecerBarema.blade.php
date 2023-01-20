@extends('layouts.app')

@php $i=0; $numCampos=0; @endphp

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

				</div>
			</div>
		</div>
	</div>

	<div class="col-md-10 justify-content-center" style="margin-top:20px">
		<div class="card" style="border-radius: 5px">
			<div class="card-body" style="padding-top: 0.2rem">
				<div class="container">
					
					<div class="form-row mt-3">
						<div class="col-md-12"><h5 style="color: #234B8B; font-weight: bold">Meu parecer</h5></div>
						<div class="col-md-12"><h6 style="color: #234B8B; font-weight: bold">Trabalho: {{$trabalho->titulo}}</h6></div>
					</div>
					<hr style="border-top: 1px solid#1492E6">

					<form method="POST" action="{{route('avaliador.enviarParecerBarema')}}" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="trabalho_id" value="{{$trabalho->id}}" >
						<input type="hidden" name="evento_id" value="{{$evento->id}}" >

						<div class="col-sm-12">
							<div class="justify-content-center" id="displayCampos">
								<table class="table table-bordered col-sm-12" id="dynamicAddRemove">
									<tr>
											<th>Nome<span style="color:red; font-weight:bold;">*</span></th>
											<th>Descrição</th>
											<th>Nota Máxima<span style="color:red; font-weight:bold;">*</span></th>
											<th>Prioridade<span style="color:red; font-weight:bold;">*</span></th>
											<th>Nota da avaliação</th>
									</tr>
									@foreach ($camposAvaliacao as $campoAvaliacao)
										<tr>
											<td><input type="text" name="inputField[{{$i}}][nome]" class="form-control nome" value="{{ $campoAvaliacao->nome }}" disabled/></td>
											<td><input type="text" name="inputField[{{$i}}][descricao]" class="form-control descricao" value="{{ $campoAvaliacao->descricao }}" disabled/>
											</td>
											<td><input type="number" name="inputField[{{$i}}][nota_maxima]" class="form-control nota_maxima" value="{{ $campoAvaliacao->nota_maxima }}" disabled/></td>
											<td><input type="number" name="inputField[{{$i}}][nota_prioridade]" class="form-control nota_maxima" value="{{ $campoAvaliacao->prioridade }}" disabled/></td>
											<td><input type="number" min="1" max="{{ $campoAvaliacao->nota_maxima }}" step="1" name="inputField[{{$i}}][nota]" class="form-control nota" required />
										</tr>
										<input type="checkbox" id="checkB[{{$i}}]" checked name="campos[]" value="{{$i}}" hidden>
										@php ++$i; ++$numCampos; @endphp
									@endforeach
								</table>
							</div>
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
