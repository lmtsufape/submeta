@php $arquivo = \App\Arquivo::find($aval->arquivo_id); @endphp
<div class="container-fluid">
    <div class="row">
        @if ($arquivo->trabalho->evento->numParticipantes != 0)
        <h5><b>Discente:</b>
            @if(\App\Participante::find($arquivo->participanteId))
                {{\App\Participante::find($arquivo->participanteId)->user->name}}
            @else
                {{\App\Participante::withTrashed()->find($arquivo->participanteId)->user->name}}
            @endif
        </h5>
        @else
        <h5><b>Proponente:</b>
            {{$arquivo->trabalho->proponente->user->name}}</h5>
        @endif
    </div>

    <div class="row">
        <h5><b>Plano:</b> {{$arquivo->titulo}}</h5>
    </div>

    <form action="{{route('coordenador.atualizar.avaliacao', ['id' => $aval->id])}}" method="POST">
        <div class="row">
            @csrf
            <div class="col-sm-1 padEsquerda">
                <label for="lattes" class="col-form-label font-tam"
                    style="font-weight: bold">{{ __('Nota: ') }}</label>
            </div>
            <div class="col-sm-5 text-center padEsquerda">
                <input class="form-control" name="nota" type="number" step="0.01"
                    style="width: 60px" @if(isset($aval)) value="{{$aval->nota}}" @endif>
            </div>

            <div class="col-sm-2 padEsquerda">
                <label for="lattes" class="col-form-label font-tam"
                    style="font-weight: bold">{{ __('Apresentação: ') }}</label>
            </div>
            <div class="col-sm-4 text-center padEsquerda">
                <input class="form-control" name="nota_apresentacao" type="number"  step="0.01"
                    style="width: 60px" @if(isset($aval)) value="{{$aval->nota_apresentacao}}" @endif>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 padEsquerda">
                <label for="lattes" class="col-form-label font-tam"
                    style="font-weight: bold">{{ __('Comentário: ') }}</label>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12 padEsquerda">
                <textarea class="col-md-12" minlength="20" id="comentario"
                        name="comentario"
                        style="border-radius:5px 5px 0 0;height: 71px;"
                        disabled>@if(isset($aval)){{$aval->comentario}}</textarea>@else
                </textarea>@endif
            </div>
        </div>
        <div class="row">
            <div class="col-10">

                <label for="lattes" class="col-form-label font-tam"
                style="font-weight: bold;margin-right: 5px;">{{ __('Arquivo: ') }}</label>
                @if(isset($aval))
                @if($aval->arquivoAvaliacao != null)
                <a href="{{route('download', ['file' => $aval->arquivoAvaliacao])}}" target="_new"  >
                    <img class="" src="{{asset('img/icons/pdf.ico')}}" style="width:40px">
                </a>
                @endif
                @endif
            </div>


            @if(Auth::user()->tipo == 'coordenador')
            <div class='col-2' style='margin-top:1%; padding-left:8%;'>
                <button type='submit' class='btn btn-info btn-sm'>Editar</button>
            </div>
            @endif
        </form>
    </div>
    

</div>
<style>
    .padEsquerda {
        padding-left: 0px
    }
</style>