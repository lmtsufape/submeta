<div id="accordion1">
    <div class="card">
        <div class="row">
            <div class="col-11  ">
                <h2 class="m-2">Grande Áreas</h2>
            </div>
            <div class="col-1 text-center">
                <a href="{{route('grandearea.criar')}}" >
                    <i class="fas fa-plus-circle fa-2x m-2" style="color: green"></i>
                </a>
            </div>
            
        </div>
    </div>
    @foreach ($grandesAreas as $grandeArea)
    {{-- @dd($grandeArea->areas) --}}
        <div class="card">
            <h5 class="mb-0">
                <div class="row">
                    <div class="col-11">
                        <button class="btn btn-link font-size-naturezas" data-toggle="collapse" data-target="#collapse{{ $grandeArea->id }}" aria-expanded="true" aria-controls="collapseOne" >
                            <i class="fas fa-sort-down fa-1x"></i> {{ $grandeArea->nome }}
                        </button>
                    </div>
                    <div class="col-1 text-center">
                        <div class=" dropright mt-2 text-center">
                            <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <i class="fas fa-cogs"></i> --}}
                                <i class="fas fa-cog fa-1x"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('grandearea.show', ['id' => $grandeArea->id ]) }}" class="dropdown-item text-center">
                                  Detalhes
                                </a>
                                <hr class="dropdown-hr">
                                <a href="{{ route('grandearea.editar', ['id' => $grandeArea->id]) }}" class="dropdown-item text-center">
                                    Editar
                                </a>
                                <hr class="dropdown-hr">
                                <button data-toggle="modal" data-target="#removerGrandeArea{{ $grandeArea->id }}" class="dropdown-item dropdown-item-delete text-center">
                                    <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">
                                    Deletar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </h5>
        
            <div id="collapse{{ $grandeArea->id }}" class="collapse ml-3" aria-labelledby="headingOne" data-parent="#accordion1">
                @include('naturezas.grandeArea.collapse-area')
            </div>
        </div>

        <!-- Modal Remover -->
        <div class="modal fade" id="removerGrandeArea{{ $grandeArea->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Remover Grande Área</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja remover a Grande Área: {{ $grandeArea->nome }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="{{ route('grandearea.deletar', ['id' => $grandeArea->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Remover</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endforeach

</div>
<div id="accordion2">
    <div class="card">
        <div class="row">
            <div class="col-11  ">
                <h2 class="m-2">Áreas Temáticas</h2>
            </div>
            <div class="col-1 text-center">
                <a href="{{route('areaTematica.criar')}}" >
                    <i class="fas fa-plus-circle fa-2x m-2" style="color: green"></i>
                </a>
            </div>

        </div>
    </div>
    @foreach ($areasTematicas as $areasTematica)
        <div class="card">
            <h5 class="mb-0">
                <div class="row">
                    <div class="col-11">
                        <button class="btn btn-link font-size-naturezas" aria-expanded="true" >
                            {{ $areasTematica->nome }}
                        </button>
                    </div>
                    <div class="col-1 text-center">
                        <div class=" dropright mt-2 text-center">
                            <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{-- <i class="fas fa-cogs"></i> --}}
                                <i class="fas fa-cog fa-1x"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="{{ route('areaTematica.edit', ['id' => $areasTematica->id]) }}" class="dropdown-item text-center">
                                    Editar
                                </a>
                                <hr class="dropdown-hr">
                                <button data-toggle="modal" data-target="#removerAreaTematica{{ $areasTematica->id }}" class="dropdown-item dropdown-item-delete text-center">
                                    <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">
                                    Deletar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </h5>
        </div>

        <!-- Modal Remover -->
        <div class="modal fade" id="removerAreaTematica{{ $areasTematica->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Remover Área Temática</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja remover a Área Temática: {{ $areasTematica->nome }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form method="POST" action="{{ route('areaTematica.deletar', ['id' => $areasTematica->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Remover</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>