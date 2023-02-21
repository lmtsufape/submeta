<!-- Participantes -->
<div class="col-md-12" style="margin-top: 20px">
        <div class="card" style="border-radius: 5px">
            <div class="card-body" style="padding-top: 0.2rem;">
                <div class="container">
                    <div class="form-row mt-3">
                        <div class="col-sm-8"><h5 style="color: #234B8B; font-weight: bold">Integrantes</h5></div>
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
                            </div>
                            
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--X Participantes X-->
