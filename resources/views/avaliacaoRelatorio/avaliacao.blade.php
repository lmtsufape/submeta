@php $arquivo = \App\Arquivo::find($aval->arquivo_id); @endphp
<div class="container-fluid">
    <div class="row">
        <h5><b>Discente:</b>
            {{\App\Participante::find($arquivo->participanteId)->user->name}}</h5>
    </div>

    <div class="row">
        <h5><b>Plano:</b> {{$arquivo->titulo}}</h5>
    </div>

    <div class="row">

        <div class="col-sm-1 padEsquerda">
            <label for="lattes" class="col-form-label font-tam"
                   style="font-weight: bold">{{ __('Nota: ') }}</label>
        </div>
        <div class="col-sm-6 text-center padEsquerda">
            <input class="form-control" name="nota" type="number"
                   style="width: 60px" @if(isset($aval)) value="{{$aval->nota}}" @endif disabled>
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
</div>
<style>
    .padEsquerda {
        padding-left: 0px
    }
</style>