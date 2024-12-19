@extends('layouts.app')

@section('content')

<div class="container">

	@if (session('sucesso'))
		<div class="alert alert-success" role="alert">
			{{ session('sucesso') }}
		</div>
	@elseif(session('erro'))
		<div class="alert alert-danger" role="alert">
			{{ session('erro') }}
		</div>
	@endif

    <div class="row justify-content-center titulo-menu mb-0">
		<h4>Planos de Trabalho </h4>
	</div>
	<div style=" !important;margin: auto;">
			<table class="table table-bordered table-hover" style="display: block; overflow-x: visible; white-space: nowrap; border-radius:10px; margin-bottom:0px">

                <thead>
                    <tr>
						<th scope="col" style="width:400px; text-align: center;">Projeto</th>
						<th scope="col" style="width:400px; text-align: center;">Proponente</th>
						@if ($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC")
						<th scope="col" style="width:400px; text-align: center;">Título do Plano</th>
						@endif
						@if ($evento->numParticipantes != 0)
						<th scope="col" style="width:200px; text-align: center;">Discente</th>
						@endif
						@if ($evento->tipo != 'PIBEX' && $evento->tipo != 'PIBAC' && $evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PICP")
						<th scope="col" style="width:200px; text-align: center;">Relatório Parcial</th>
						@endif
						<th scope="col" style="width:250px; text-align: center;">Relatório Final</th>
                    </tr>
				</thead>
					@foreach($arquivos as $arquivo)
					@if(isset($arquivo))
                        <tbody>
						<td style="text-align: center;" title="{{$arquivo->trabalho->titulo}}">{{$arquivo->trabalho->titulo}}</td>
						<td style="text-align: center;" title="{{$arquivo->trabalho->proponente->user->name}}">{{$arquivo->trabalho->proponente->user->name}}</td>
						@if ($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC")
						<td style="text-align: center;" title="{{$arquivo->titulo}}">{{$arquivo->titulo}}</td>
						@endif
						@if ($evento->numParticipantes != 0)
						<td style="text-align: center;" title="{{$arquivo->participante->user->name}}" id="td-nomeAluno">{{$arquivo->participante->user->name}}</td>
						@endif
						@if ($evento->tipo != 'PIBEX' && $evento->tipo != 'PIBAC' && $evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PICP")
						<td style="text-align: center;">
							@if((Auth::user()->proponentes != null) && ($arquivo->relatorioParcial == null) &&
 								($arquivo->trabalho->evento->dt_inicioRelatorioParcial <= $hoje) && ($hoje <= $arquivo->trabalho->evento->dt_fimRelatorioParcial))
								<!-- Button trigger modal -->
								@if($arquivo->arquivado)
									<button type="button"  class="btn btn-secondary" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}">Arquivado</button>

								@elseif($trabalho->status == "reprovado")
									<button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}">Reprovado</button>
								@else
									<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}">Enviar</button>
								@endif
							@else
								<!-- Button trigger modal -->
								@if($arquivo->relatorioParcial != null)
									<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}"> Visualizar </button>
								@elseif($arquivo->arquivado)
									<button type="button"  class="btn btn-secondary" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}"> Arquivado </button>
								@elseif($trabalho->status == "reprovado")
									<button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}">Reprovado</button>
								@else
									<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioParcial{{ $arquivo->id }}"> Pendente </button>
								@endif
							@endif
						</td>
						@endif
						<td style="text-align: center;">
							@if(($evento->tipo == 'PIBEX' || $evento->tipo == 'PIBAC') && \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $evento->created_at)->year > 2022)
								@if($trabalho->relatorio)
									@if($trabalho->relatorio->progresso == 'finalizado')
										<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">{{ $trabalho->relatorio->status }}</button>
									@else
										<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">envio em progresso</button>
									@endif
									
								@else
									<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">Não enviado</button>
								@endif
								
							@elseif((Auth::user()->proponentes != null) && ($arquivo->relatorioFinal == null) &&
								 ($arquivo->trabalho->evento->dt_inicioRelatorioFinal <= $hoje) && ($hoje <= $arquivo->trabalho->evento->dt_fimRelatorioFinal))
								<!-- Button trigger modal -->
								@if($arquivo->arquivado)
									<button type="button"  class="btn btn-secondary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">Arquivado</button>
								@elseif($trabalho->status == "reprovado")
									<button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">Reprovado</button>
								@else
									<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">Enviar</button>
								@endif
							@else
								<!-- Button trigger modal -->
								@if($arquivo->relatorioFinal != null)
									<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}"> Visualizar </button>
								@elseif($arquivo->arquivado)
									<button type="button"  class="btn btn-secondary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}"> Arquivado </button>
								@elseif($trabalho->status == "reprovado")
									<button type="button"  class="btn btn-danger" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}">Reprovado</button>
								@else
									<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalRelatorioFinal{{ $arquivo->id }}"> Pendente </button>
								@endif
							@endif
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
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="dt_inicioRelatorioParcial" class="col-form-label">{{ __('Início do Relatório Parcial:') }}</label>
                                                <input id="dt_inicioRelatorioParcial" type="date" class="form-control" name="dt_inicioRelatorioParcial" value="{{$arquivo->trabalho->evento->dt_inicioRelatorioParcial}}" required autocomplete="dt_inicioRelatorioParcial" disabled autofocus>

                                            </div>
                                            <div class="col-6">
                                                <label for="dt_fimRelatorioParcial" class="col-form-label">{{ __('Fim do Relatório Parcial:') }}</label>
                                                <input id="dt_fimRelatorioParcial" type="date" class="form-control" name="dt_fimRelatorioParcial" value="{{$arquivo->trabalho->evento->dt_fimRelatorioParcial}}" required autocomplete="dt_fimRelatorioParcial" disabled autofocus>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
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

                                            @if((Auth::user()->proponentes != null) &&
                                                ($arquivo->trabalho->evento->dt_inicioRelatorioParcial <= $hoje) && ($hoje <= $arquivo->trabalho->evento->dt_fimRelatorioParcial))
												<input type="file" class="input-group-text" value="" name="relatorioParcial" accept=".pdf" placeholder="Relatorio Parcial" id="relatorioParcial{{$arquivo->id}}" required @if($arquivo->arquivado) disabled @endif/>
												@error('relatorioParcial')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											@endif
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            @if((Auth::user()->proponentes != null) &&
                                                ($arquivo->trabalho->evento->dt_inicioRelatorioParcial <= $hoje) && ($hoje <= $arquivo->trabalho->evento->dt_fimRelatorioParcial))
												<button type="submit" class="btn btn-success" @if($arquivo->arquivado || $trabalho->status == "reprovado") disabled @endif >Salvar</button>
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
										@if($evento->tipo == "PIBEX" || $evento->tipo == "PIBAC")
											<h5 class="modal-title" id="exampleModalLabel">Relatório Final</h5>
										@else
											<h5 class="modal-title" id="exampleModalLabel">Relatório Final (.pdf)</h5>
										@endif

										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="dt_inicioRelatorioFinal" class="col-form-label">{{ __('Início do Relatório Final:') }}</label>
                                                <input id="dt_inicioRelatorioFinal" type="date" class="form-control" name="dt_inicioRelatorioFinal" value="{{$arquivo->trabalho->evento->dt_inicioRelatorioFinal}}" required autocomplete="dt_inicioRelatorioFinal" disabled autofocus>

                                            </div>
                                            <div class="col-6">
                                                <label for="dt_fimRelatorioFinal" class="col-form-label">{{ __('Fim do Relatório Final:') }}</label>
                                                <input id="dt_fimRelatorioFinal" type="date" class="form-control" name="dt_fimRelatorioFinal" value="{{$arquivo->trabalho->evento->dt_fimRelatorioFinal}}" required autocomplete="dt_fimRelatorioFinal" disabled autofocus>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
									<form id="formRelatFinal" method="post" action="{{route('planos.anexar.relatorio')}}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" value="{{ $arquivo->id }}" name="arqId">
										<input type="hidden" value="{{ $arquivo->trabalhoId }}" name="projId">
										<div class="col-12">
											<div class="row">
												@if(($evento->tipo == 'PIBEX') && \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $evento->created_at)->year > 2022)
													@if($trabalho->relatorio && $trabalho->relatorio->progresso == 'finalizado')

														@if($trabalho->relatorio->status == "devolvido para correções" || $trabalho->relatorio->status == "em análise")
															<div class="col-4">
																<label for="editar_relatorio_final" class="col-form-label">{{ __('Relatório Final') }}</label>
																<a class="form-control btn btn-primary" href="{{ route('relatorioFinalPibex.editarParte1', ['relatorio_id' => $trabalho->relatorio->id]) }}"> {{ __('Editar') }} </a>
															</div>
														@endif

														<div class="col-4">
															<label for="pdf_relatorio_final" class="col-form-label">{{ __('Relatório Final') }}</label>
															<a class="form-control btn btn-primary" href="{{ route('relatorioFinalPibex.gerarPDF', ['relatorio_id' => $trabalho->relatorio->id]) }}" target="_blank"> {{ __('Visualizar') }} </a>
														</div>

														<div class="col-4">
															<label for="anexo_relatorio_final" class="col-form-label">{{ __('Anexo') }}</label>
															<a class="form-control btn btn-primary" href="{{ route('relatorioFinalPibex.downloadAnexo', ['relatorio_id' => $trabalho->relatorio->id]) }}" target="_blank">Baixar</a>
														</div>
													@else
														<div class="col-6">
															<label for="status_relatorio_final" class="col-form-label">{{ __('Status') }}</label>
															@if($trabalho->relatorio)
																<input id="status_relatorio_final" type="text" class="form-control" name="status_relatorio_final" value="Envio em progresso" required autocomplete="dt_inicioRelatorioFinal" disabled autofocus>
															@else
															<input id="status_relatorio_final" type="text" class="form-control" name="status_relatorio_final" value="Não enviado" required autocomplete="dt_inicioRelatorioFinal" disabled autofocus>
															@endif
														</div>

														@if($trabalho->evento->dt_inicioRelatorioFinal <= $hoje && $hoje <= $trabalho->evento->dt_fimRelatorioFinal)
															<div class="col-6">
																<label for="botao_relatorio_final" class="col-form-label" style="color: white">Relatório Final</label>
																<a class="form-control btn btn-primary" href="{{ route('relatorioFinalPibex.criarParte1', ['trabalho_id' => $trabalho->id]) }}">Relatório Final</a>
															</div>
														@endif
													@endif
												@else
													@if($arquivo->relatorioFinal)
														<div class="col-sm-2">Arquivo: </div>
														<div class="col-sm-1">
															<a href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $arquivo->relatorioFinal]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
														</div>
													@else
														<label class="control-label col-6">Nenhum arquivo carregado</label>
													@endif

													@if((Auth::user()->proponentes != null) && ($arquivo->trabalho->evento->dt_inicioRelatorioFinal <= $hoje) && ($hoje <= $arquivo->trabalho->evento->dt_fimRelatorioFinal))
														<input type="file" class="input-group-text" value="" name="relatorioFinal" accept=".pdf" placeholder="Relatorio Final" id="relatorioFinal{{$arquivo->id}}" required @if($arquivo->arquivado) disabled @endif/>
														@error('relatorioFinal')
														<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													@endif
												@endif
											</div>

											<br>


										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
											@if((Auth::user()->proponentes != null) &&
                                                ($arquivo->trabalho->evento->dt_inicioRelatorioFinal <= $hoje) && ($hoje <= $arquivo->trabalho->evento->dt_fimRelatorioFinal))
												@if($evento->tipo != 'PIBEX' && $evento->tipo != 'PIBAC')
													<button type="submit" class="btn btn-success" @if($arquivo->arquivado) disabled @endif >Salvar</button>
												@elseif(($evento->tipo == 'PIBEX' || $evento->tipo == 'PIBAC') && \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $evento->created_at)->year < 2023)
													<button type="submit" class="btn btn-success" @if($arquivo->arquivado) disabled @endif >Salvar</button>
												@endif
											@endif
										</div>

									</form>
								</div>
							</div>
						</div>
                        </tbody>
					@endif
					@endforeach

			</table>

			<div id="btn-cancelar">
				<a class="btn btn-primary" href="{{ url()->previous() }}">Cancelar</a>
			</div>
	</div>

</div>

	<style>
		td {
			max-width: 25ch;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		#td-nomeAluno {
			max-width: 25ch;
		}

		#btn-cancelar {
			margin-top: 10px;
			text-align: right;
		}

	</style>


@endsection
