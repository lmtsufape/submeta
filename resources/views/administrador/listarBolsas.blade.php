@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center titulo-menu mb-0">
		<h4>Dados Bolsa </h4>
	</div>
	<div class="card-body" style="width: 75% !important;margin: auto;">
			<table class="table table-bordered table-hover" style="display: block; overflow-x: visible; white-space: nowrap; border-radius:10px; margin-bottom:0px">

                <thead>
                    <tr>
						<th scope="col" style="width:200px; text-align: center;">Edital</th>
						<th scope="col" style="width:200px; text-align: center;">Projeto</th>
						<th scope="col" style="width:200px; text-align: center;">Status Projeto</th>
                        <th scope="col" style="width:200px; text-align: center;">Discente</th>
                        <th scope="col" style="width:200px; text-align: center;">Tipo de Bolsa</th>
                    </tr>
				</thead>
				@foreach($trabalhos as $trabalho)
					@foreach($trabalho->participantes as $participante)
						<tbody>

							<td style="text-align: center;">{{$trabalho->evento->nome}}</td>
							<td style="text-align: center;">{{$trabalho->titulo}}</td>
							<td style="text-align: center;">{{$trabalho->status}}</td>
							<td style="text-align: center;">{{$participante->user->name}}</td>
							<td style="text-align: center;">
								<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modalConfirm{{$participante->id}}">
									@if($participante->tipoBolsa==null)
										Não Definida
									@elseif($participante->tipoBolsa == "Voluntario")
										Voluntário
                                    @else
                                        {{$participante->tipoBolsa}}
									@endif
								</button>
							</td>
						</tbody>

						<div class="modal fade" id="modalConfirm{{$participante->id}}" tabindex="-1" role="dialog"
							 aria-labelledby="modalConfirmLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title" id="modalConfirmLabel" align="center">
											Confirmar alteração do tipo de bolsa ?</h4>
									</div>
									@if($participante->tipoBolsa!=null)
										<div class="modal-body">
											<h6 class="modal-title" id="modalConfirmLabel" align="center">
												@if($participante->tipoBolsa=='Voluntario')
													O discente {{$participante->user->name}} será definido como bolsista
												@else
													O discente {{$participante->user->name}} será definido como voluntário
												@endif
											</h6>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">
												Não
											</button>
											<a type="button" href="{{ route('bolsa.alterar',['id'=>$participante->id, 'tipo'=>1])  }}"  id="btnSubmit" class="btn btn-info">
												Sim
											</a>
										</div>
									@else
										<div class="modal-body">
											<div class="row">
												<div class="col-6">
													<a  style="float: right;" type="button" href="{{ route('bolsa.alterar',['id'=>$participante->id, 'tipo'=>1])  }}"  id="btnSubmit" class="btn btn-info">
														Voluntário
													</a>
												</div>
												<div class="col-6">
													<a style="float: left;" type="button" href="{{ route('bolsa.alterar',['id'=>$participante->id, 'tipo'=>2])  }}"  id="btnSubmit" class="btn btn-info">
														Bolsista
													</a>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">
												Cancelar
											</button>
										</div>
									@endif
								</div>
							</div>
						</div>

					@endforeach
				@endforeach

			</table>
	</div>
</div>


@endsection
