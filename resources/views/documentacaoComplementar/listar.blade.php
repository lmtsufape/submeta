@extends('layouts.app')

@section('content')

<div class="container" style="margin-bottom: 279px">
	@if (session('sucesso'))
		<div class="alert alert-success" role="alert">
			{{ session('sucesso') }}
		</div>
	@endif

    <div class="row justify-content-center titulo-menu mb-0">
		<h4>Documentos Complementares </h4>
	</div>
	<div class="card-body" style="width: 100% !important;margin: auto;">
			<table class="table table-bordered table-hover" style="overflow-x: visible; white-space: nowrap; margin-bottom:0px">

                <thead>
                    <tr>
						<th scope="col" style="width:200px; text-align: center;">Edital</th>
						<th scope="col" style="width:200px; text-align: center;">Projeto</th>
						<th scope="col" style="width:200px; text-align: center;">Status Projeto</th>
                        <th scope="col" style="width:200px; text-align: center;">Discente</th>
                        <th scope="col" style="width:200px; text-align: center;">Documentação Complementar</th>
                    </tr>
				</thead>

					@foreach($trabalho->participantes as $participante)
						<tbody>

							<td style="text-align: center;" title="{{$trabalho->evento->nome}}">{{$trabalho->evento->nome}}</td>
							<td style="text-align: center;" title="{{$trabalho->titulo}}">{{$trabalho->titulo}}</td>
							<td style="text-align: center; text-transform: capitalize;" >{{$trabalho->status}}</td>
							<td style="text-align: center;" title="{{$participante->user->name}}">{{$participante->user->name}}</td>
							<td style="text-align: center;">
								<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalConfirm{{$participante->id}}" >
									@if($participante->anexoComprovanteMatricula==null || $participante->anexoTermoCompromisso==null
									 )

										Pendente
                                    @else
                                        Visualizar
									@endif
								</button>
							</td>
						</tbody>

						<div class="modal fade" id="modalConfirm{{$participante->id}}" tabindex="-1" role="odialg"
							 aria-labelledby="modalConfirmLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="modalConfirmLabel" align="center">
											Documentação Complementar</h4>
									</div>

									<form id="formDocComplementar" method="post" action="{{route('docComplementar.enviar')}}" enctype="multipart/form-data">
										@csrf
										<input type="hidden" value="{{ $participante->id }}" name="partcipanteId">
										<input type="hidden" value="{{ $trabalho->evento->tipo }}" name="eventoTipo">

										<div class="row col-md-12" >
											<div class="col-md-6" style="margin-top: 15px">
													<label class="control-label ">Termo de Compromisso <span style="color: red">*</span>@if($participante->anexoTermoCompromisso) 
														<a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoTermoCompromisso]) }}">Arquivo atual</a>
														@endif
													</label>

												<br>
												<input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="file" class="input-group-text" value="" name="termoCompromisso" accept=".pdf" id="termoCompromisso{{$participante->id}}" required
												/>
												@error('termoCompromisso')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
												<br>
											</div>
											<div class="col-md-6" style="margin-top: 15px">
													<label class="control-label ">Comprovante de Matrícula <span style="color: red">*</span>@if($participante->anexoComprovanteMatricula) 
														<a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoComprovanteMatricula]) }}">Arquivo atual</a>
														@endif
													</label>

													<br>
													<input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="file" class="input-group-text" value="" name="comprovanteMatricula" accept=".pdf" id="comprovanteMatricula{{$participante->id}}" required/>
													@error('comprovanteMatricula')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
													@enderror
													<br>
											</div>

											<div class="col-md-6" style="margin-top: 15px">
													<label class="control-label ">Documentos Pessoais (CPF/RG ou CNH) <span style="color: red">*</span>@if($participante->anexo_cpf_rg)
														<a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexo_cpf_rg]) }}">Arquivo atual</a>
														@endif
													</label>

												<br>
												<input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="file" class="input-group-text" value="" name="anexo_cpf_rg" accept=".pdf" id="anexo_cpf_rg{{$participante->id}}" required/>
												@error('anexo_cpf_rg')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
												<br>
											</div>

											@if($trabalho->evento->tipo != "PIBEX" && $trabalho->evento->tipo != "PIBAC")
												<div class="col-md-6" style="margin-top: 15px">
													<label class="control-label ">PDF Lattes <span style="color: red">*</span>@if($participante->anexoLattes) 
														<a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoLattes]) }}">Arquivo atual</a>
														@endif
													</label>
													<br>
													<input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="file" class="input-group-text" value="" name="pdfLattes" accept=".pdf" id="pdfLattes{{$participante->id}}"
														required/>
													@error('pdfLattes')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
													<br>
												</div>
											
												<div class="col-md-6" style="margin-top: 15px">
													<label class="control-label " content="required">Link Lattes <span style="color: red">*</span>  </label>
													<br>
													<input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="text" class="input-group-text col-md-12" name="linkLattes"  placeholder="Link Lattes" id="linkLattes{{$participante->id}}"
														required @if($participante->linkLattes) value="{{$participante->linkLattes}}" @endif maxlength="250" style="width: 322px;"/>
													@error('linkLattes')
													<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
													<br>
												</div>
											@endif
											
											<div class="col-md-6" style="margin-top: 15px">
												<label class="control-label ">Comprovante Bancário (Foto do cartão) @if($participante->anexoComprovanteBancario) 
													<a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoComprovanteBancario]) }}">Arquivo atual</a>
													@endif
												</label>
												<br>
												<input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="file" class="input-group-text" value="" name="comprovanteBancario" accept=".pdf,.jpg, .jpeg, .png" id="comprovanteBancario{{$participante->id}}"/>
												@error('comprovanteBancario')
												<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>

											<div class="col-md-6" style="margin-top: 15px">
												<label class="control-label ">Autorização dos Pais (Em caso de menor de idade) @if($participante->anexoAutorizacaoPais) 
													<a id="modeloDocumentoTemp" href="{{ route('baixar.documentosParticipante', ['pathDocumento' => $participante->anexoAutorizacaoPais]) }}">Arquivo atual</a>
													@endif
												</label>
												<br>
												<input @if($trabalho->status!="aprovado")disabled="disabled" @endif type="file" class="input-group-text" value="" name="autorizacaoPais" accept=".pdf" id="autorizacaoPais{{$participante->id}}"/>
												@error('autorizacaoPais	')
												<span class="invalid-feedback" role="alert" style="overflow: visible; display:block">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
										</div>


										<br>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">
												Cancelar
											</button>
											<button type="submit" href=""  id="btnSubmit" class="btn btn-info" @if($trabalho->status!="aprovado")disabled="disabled" @endif>
												Salvar
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>

					@endforeach

			</table>
	</div>
</div>

<style>
	td {
		max-width: 25ch;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
</style>

@endsection
