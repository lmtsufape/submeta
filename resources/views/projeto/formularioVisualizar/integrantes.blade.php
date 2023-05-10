<!-- Participantes -->
<div class="col-md-12" style="margin-top: 20px">
        <div class="card" style="border-radius: 5px">
            <div class="card-body" style="padding-top: 0.2rem;">
                <div class="container">
                    <div class="form-row mt-3">
                        <div class="col-sm-8"><h5 style="color: #234B8B; font-weight: bold">Integrantes</h5></div>
                        <div class="col-sm-4 text-sm-right" >
                            <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $projeto->evento->id, 'projeto_id' => $projeto->id])}}"
                               class="button">Solicitar Substituições/Desligamentos</a>
                        </div>
                    </div>
                    <hr style="border-top: 1px solid#1492E6">

                    <div class="row justify-content-start" style="alignment: center">
                        @foreach($trabalhos_user as $trabalho_user)
                            <div class="col-sm-1 mt-4">
                                    <img src="{{asset('img/icons/usuario.svg')}}" style="width:60px" alt="">
                            </div>
                            <div class="col-sm-5 mt-4">
                                <h5 class="mb-0">Nome: {{ $trabalho_user->user->name }}</h5>
                                <h5 class="mb-0">Função: {{ $trabalho_user->funcao->nome }}</h5>
                                <h6>
                                    <a href="" data-toggle="modal" data-target="#modalVizuIntegrante{{$trabalho_user->id}}" class="button">Informações</a>
                                </h6>
                            </div>

                            <div class="modal fade" id="modalVizuIntegrante{{$trabalho_user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">

                                        <div class="modal-header" style="overflow-x:auto; padding-left: 31px">
                                            <h5 class="modal-title" id="exampleModalLabel" style= "color:#1492E6">Informações Integrante</h5>

                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-top: 8px; color:#1492E6">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body" style="padding-right: 32px;padding-left: 32px;padding-top: 20px;padding-bottom: 32px;">
                                            <div class="container-fluid">
                                                <div class="col-sm-5 mt-4">
                                                    <h5 class="mb-0">Nome: {{ $trabalho_user->user->name }}</h5>
                                                    <h5 class="mb-0">E-mail: {{ $trabalho_user->user->email }}</h5>
                                                    <h5 class="mb-0">Instituição: {{ $trabalho_user->user->instituicao }}</h5>
                                                    <h5 class="mb-0">Cargo no projeto: {{ $trabalho_user->funcao->nome }}</h5>
                                                    
                                                </div>
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
