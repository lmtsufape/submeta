<!-- Participantes -->
<div class="col-md-12" style="margin-top: 20px">
        <div class="card" style="border-radius: 5px">
            <div class="card-body" style="padding-top: 0.2rem;">
                <div class="container">
                    <div class="form-row mt-3">
                        <div class="col-sm-5"><h5 style="color: #234B8B; font-weight: bold">Integrantes</h5></div>
                        <div class="col-sm-4 text-sm" >
                            <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $projeto->evento->id, 'projeto_id' => $projeto->id])}}"
                               class="button">Solicitar Substituições/Desligamentos</a>
                        </div>
                        @if((($projeto->evento->tipo == "PIBEX" || $projeto->evento->tipo == "PIBAC") && $hoje > $projeto->evento->resultado_final) || $projeto->evento->tipo == "CONTINUO")
                            <div class="col-sm-3 text-sm-right" >
                                <a href="" data-toggle="modal" data-target="#modalAdicionarParticipante" class="button">Adicionar Participante</a>
                            </div>
                        @endif
                    </div>
                    <hr style="border-top: 1px solid#1492E6">

                    <div class="row justify-content-start" style="alignment: center">
                        @foreach($projeto->participantes as $participante)
                            <div class="col-sm-1 mt-4">
                                    <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                            </div>
                            <div class="col-sm-5 mt-4">
                                <h5 class="mb-0">Nome: {{$participante->user->name}}</h5>
                                <h5 class="mb-0">Plano: @if(isset($participante->planoTrabalho)) {{$participante->planoTrabalho->titulo}} @else Não há @endif </h5>
                                <h6>
                                    <a href="" data-toggle="modal" data-target="#modalVizuParticipante{{$participante->id}}" class="button">Informações</a>
                                </h6>
                            </div>
                            
                            <!-- Modal visualizar informações participante -->
                            <div class="modal fade" id="modalVizuParticipante{{$participante->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">

                                        <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                            <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Participante</h5>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">

                                            <div class="row">
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Nome completo'])
                                                    <input type="text" class="form-control " value="{{$participante->user->name}}" name="name" placeholder="Nome Completo" maxlength="150" id="nome{{$participante->id}}" disabled />
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'E-mail'])
                                                    <input type="email" class="form-control" value="{{$participante->user->email}}" name="email" placeholder="E-mail" maxlength="150" id="email{{$participante->id}}" disabled />
                                                    @endcomponent
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Data de nascimento'])
                                                    <input type="date" class="form-control" value="{{$participante->data_de_nascimento}}" name="data_de_nascimento" placeholder="Data de nascimento" disabled />
                                                    @endcomponent
                                                </div>

                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'CPF'])
                                                    <input type="text" class="form-control cpf" value="{{$participante->user->cpf}}" name="cpf" placeholder="CPF" disabled />
                                                    @endcomponent
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'RG'])
                                                    <input type="text" class="form-control" min="1" maxlength="12" value="{{$participante->rg}}" name="rg" placeholder="RG" disabled />
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Celular'])
                                                    <input type="tel" class="form-control celular" value="{{$participante->user->celular}}" name="celular" placeholder="Celular" id="inputCelular" disabled />
                                                    @endcomponent
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 style="font-weight: bold;">Endereço</h5>
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        @component('componentes.input', ['label' => 'CEP'])
                                                        <input type="text" class="form-control cep" value="@if(isset($participante->user->endereco)){{$participante->user->endereco->cep}} @endif" name="cep" placeholder="CEP" disabled />
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-6">
                                                        @component('componentes.select', ['label' => 'Estado'])
                                                        <select name="uf" id="estado" class="form-control" style="visibility: visible" disabled>
                                                            <option value="@if(isset($participante->user->endereco)) {{$participante->user->endereco->uf}} @endif" selected>@if(isset($participante->user->endereco)) {{$participante->user->endereco->uf}} @endif</option>
                                                        </select>
                                                        @endcomponent
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        @component('componentes.input', ['label' => 'Cidade'])
                                                        <input type="text" class="form-control" value=" @if(isset($participante->user->endereco)){{$participante->user->endereco->cidade}} @endif" name="cidade" placeholder="Cidade" maxlength="50" id="cidade{{$participante->id}}" disabled />
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-6">
                                                        @component('componentes.input', ['label' => 'Bairro'])
                                                        <input type="text" class="form-control" value="@if(isset($participante->user->endereco)){{$participante->user->endereco->bairro}} @endif" name="bairro" placeholder="Bairro" maxlength="50" id="bairro{{$participante->id}}" disabled />
                                                        @endcomponent
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        @component('componentes.input', ['label' => 'Rua'])
                                                        <input type="text" class="form-control" value="@if(isset($participante->user->endereco)) {{ $participante->user->endereco->rua}} @endif" name="rua" placeholder="Rua" maxlength="100" id="rua{{$participante->id}}" disabled />
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-6">
                                                        @component('componentes.input', ['label' => 'Número'])
                                                        <input type="text" class="form-control" value="@if(isset($participante->user->endereco)){{$participante->user->endereco->numero}} @endif" name="numero" placeholder="Número" disabled />
                                                        @endcomponent
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label class=" control-label" for="firstname">Complemento</label>
                                                            <input type="text" class="form-control" value="@if(isset($participante->user->endereco)){{ $participante->user->endereco->complemento}} @endif" name="complemento" placeholder="Complemento" maxlength="75" id="complemento{{$participante->id}}" disabled />
                                                        </div>
                                                    </div>
                                                </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 style="font-weight: bold;">Dados do curso</h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Instituição de Ensino'])
                                                    <select style="display: inline" onchange="showInstituicao(this)" class="form-control" name="instituicao" id="instituicao[{{$participante->id}}]" disabled>
                                                        <option value="{{$participante->user->instituicao}}" disabled selected hidden>{{$participante->user->instituicao}}</option>
                                                    </select>
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.input', ['label' => 'Curso'])
                                                    <select style="display: inline" class="form-control" name="curso" onchange="showCurso(this)" id="curso[{{$participante->id}}]" disabled>
                                                        <option value="{{$participante->curso}}" disabled selected hidden>{{$participante->curso}}</option>
                                                    </select>
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    @component('componentes.select', ['label' => 'Turno'])
                                                    <select name="turno" class="form-control" disabled>
                                                        <option value="{{$participante->turno}}" selected>{{$participante->turno}}</option>
                                                    </select>
                                                    @endcomponent
                                                </div>
                                                <div class="col-6">
                                                    @component('componentes.select', ['label' => 'Total de períodos/anos do curso'])
                                                    <select name="total_periodos" class="form-control" onchange="gerarPeriodo(this)" disabled>
                                                        <option value="{{$participante->total_periodos}}" selected>{{$participante->total_periodos}}</option>
                                                    </select>
                                                    @endcomponent
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    @component('componentes.select', ['label' => 'Período/Ano atual'])
                                                    <select name="periodo_atual" class="form-control" disabled>
                                                        <option value="{{$participante->periodo_atual}}" selected>{{$participante->periodo_atual}}</option>
                                                    </select>
                                                    @endcomponent
                                                </div>

                                                <div class="col-6">
                                                    @component('componentes.select', ['label' => 'Ordem de prioridade'])
                                                    <select name="ordem_prioridade" class="form-control" disabled>
                                                        <option value="{{$participante->ordem_prioridade}}" selected>{{$participante->ordem_prioridade}}</option>
                                                    </select>
                                                    @endcomponent
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5 style="font-weight: bold;">Plano de trabalho</h5>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                @if($participante->planoTrabalho)
                                                <div class="col-6">
                                                    <h6>{{$participante->planoTrabalho->titulo}}</h6>
                                                </div>
                                                <div class="col-6">
                                                    <a href="{{ route('baixar.plano', ['id' => $participante->planoTrabalho->id]) }}"><i class="fas fa-file-pdf fa-2x"></i></a>
                                                </div>
                                                @else
                                                <div class="col-3 text-danger">
                                                    <p><i class="fas fa-times-circle fa-2x"></i></p>
                                                </div>
                                                @endif
                                            </div>

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

<!--X Participantes X-->
