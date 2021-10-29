<div id="accordion3">
    @forelse ($area->subAreas as $subArea)
        <div class="mt-0 ml-5">
            {{ $subArea->nome }}
        </div>        
    @empty
    <div class="mt-0 ml-5">
        Não há sub-áreas
    </div>    
    @endforelse
</div>