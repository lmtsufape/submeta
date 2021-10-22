<div id="accordion2">
    @foreach ($grandeArea->areas as $area)
    <h5 class="mb-0 ml-2">
        <button class="btn btn-link mb-0" data-toggle="collapse" data-target="#collapse{{ $area->id }}" aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-sort-down fa-1x"></i>{{ $area->nome }}
        </button>
    </h5>

    <div id="collapse{{ $area->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
        @include('naturezas.grandeArea.collapse-sub-area')
    </div>
    @endforeach
</div>