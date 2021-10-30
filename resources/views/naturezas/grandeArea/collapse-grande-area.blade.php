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
                                <form method="POST" action="{{ route('grandearea.deletar', ['id' => $grandeArea->id]) }}">
                                    {{ csrf_field() }}
                                    <button type="submit" class="dropdown-item dropdown-item-delete text-center">
                                      <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">
                                        Deletar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </h5>
        
            <div id="collapse{{ $grandeArea->id }}" class="collapse ml-3" aria-labelledby="headingOne" data-parent="#accordion1">
                @include('naturezas.grandeArea.collapse-area')
            </div>
        </div>
    @endforeach
</div>