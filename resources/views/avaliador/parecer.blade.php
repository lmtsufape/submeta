@extends('layouts.app')

@section('content')


<div class="container">
	
	<div class="row justify-content-center" style="margin-top: 3rem;">
	  <div class="col-md-11" style="margin-bottom: -3rem">
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
				<label for="exampleFormControlTextarea1">Parecer:</label>
				<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="textParecer" placeholder="Digite aqui o seu parecer">{{ $trabalho->pivot->parecer }}</textarea>
				</div>
				<select class="custom-select" name="recomendacao" >
						<option  @if($trabalho->pivot->recomendacao =='RECOMENDADO' ) selected @endif value="RECOMENDADO">RECOMENDADO</option>	
						<option @if($trabalho->pivot->recomendacao =='NAO-RECOMENDADO' ) selected @endif value="NAO-RECOMENDADO">NAO-RECOMENDADO</option>												  
				</select>
				<div class="form-group  mt-3 md-3">
					@if($trabalho->pivot->AnexoParecer == null)
						<label for="exampleFormControlFile1">Anexo do Parecer:</label>
					<input type="file" class="form-control-file" id="exampleFormControlFile1" name="anexoParecer">

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
