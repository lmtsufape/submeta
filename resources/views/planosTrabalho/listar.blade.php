@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center titulo-menu mb-0">
		<h4>Planos de Trabalho </h4>
	</div>
	<div class="card-body" >
			<table class="table table-bordered table-hover" style="display: block; overflow-x: visible; white-space: nowrap; border-radius:10px; margin-bottom:0px">

                <thead>
                    <tr>
						<th scope="col" style="width:200px;">Plano de Trabalho</th>
                        <th scope="col" style="width:200px;">Projeto</th>
						<th scope="col" style="width:200px;">Discente</th>
                        <th scope="col" style="width:200px;">Data</th>
                        <th scope="col" style="width:200px;">Relatório Parcial</th>
                        <th scope="col" style="width:200px;">Relatório Final</th>
                    </tr>
				</thead>

					@foreach($arquivos as $arquivo)
                        <tbody>
						<td>{{$arquivo->trabalho->titulo}}</td>
						<td>{{$arquivo->titulo}}</td>
						<td>{{$arquivo->participante->user->name}}</td>
						<td>{{$arquivo->data}}</td>
						<td>
							<!-- Button trigger modal -->
							<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}">
								Visualizar
							</button>
						</td>

						<td>
							<!-- Button trigger modal -->
							<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">
								Visualizar
							</button>

						</td>

						<!-- Modal Relatorio Parcial-->
						<div class="modal fade" id="modalRelatorioParcial{{ $arquivo->id }}" tabindex="-1" role="dialog" aria-labelledby="modalRelatorioParcialLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Relatório Parcial (.pdf)</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="formRelatParcial" method="post" action="{{route('planos.anexar.relatorio')}}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" value="{{ $arquivo->id }}" name="arqId">
										<input type="hidden" value="{{ $arquivo->trabalhoId }}" name="projId">
										<div class="col-12">
											<div class="row">
												@if($arquivo->relatorioParcial)
													<div class="col-sm-2">Arquivo: </div>
													<div class="col-sm-1">
														<a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $arquivo->relatorioParcial]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
													</div>
												@else
													<label class="control-label col-6">Nenhum arquivo carregado</label>
												@endif
											</div>
											<br>

											@if(Auth::user()->proponentes != null)
												<input type="file" class="input-group-text" value="" name="relatorioParcial" accept=".pdf" placeholder="Relatorio Parcial" id="relatorioParcial{{$arquivo->id}}" required/>
												@error('relatorioParcial')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											@endif
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
											@if(Auth::user()->proponentes != null)
												<button type="submit" class="btn btn-success">Salvar</button>
											@endif
										</div>

									</form>
								</div>
							</div>
						</div>

						<!-- Modal Relatorio Final-->
						<div class="modal fade" id="modalRelatorioFinal{{ $arquivo->id }}" tabindex="-1" role="dialog" aria-labelledby="modalRelatorioFinalLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Relatório Final (.pdf)</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="formRelatFinal" method="post" action="{{route('planos.anexar.relatorio')}}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" value="{{ $arquivo->id }}" name="arqId">
										<input type="hidden" value="{{ $arquivo->trabalhoId }}" name="projId">
										<div class="col-12">
											<div class="row">
												@if($arquivo->relatorioFinal)
													<div class="col-sm-2">Arquivo: </div>
													<div class="col-sm-1">
														<a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $arquivo->relatorioFinal]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
													</div>
												@else
													<label class="control-label col-6">Nenhum arquivo carregado</label>
												@endif
											</div>
											<br>
											@if(Auth::user()->proponentes != null)
												<input type="file" class="input-group-text" value="" name="relatorioFinal" accept=".pdf" placeholder="Relatorio Final" id="relatorioFinal{{$arquivo->id}}" required/>
												@error('relatorioFinal')
												<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											@endif
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
											@if(Auth::user()->proponentes != null)
												<button type="submit" class="btn btn-success">Salvar</button>
											@endif
										</div>

									</form>
								</div>
							</div>
						</div>
                        </tbody>
					@endforeach

			</table>
	</div>
</div>



@endsection
