@extends('layouts.app')

@section('content')


    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-md-10">
            <div class="card" style="border-radius: 5px">
                <div class="card-body" style="padding-top: 0.2rem;">
                    <div class="container">
                        <div class="form-row mt-3">
                            <div class="col-md-12"><h5 style="color: #1492E6; font-size: 26px;">Edital - {{$evento->nome}}</h5></div>
                            <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem; font-weight: bold; font-size: 18px;">Propostas submetidas</h6></div>
                        </div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="row">
                            @foreach( $trabalhos as $trabalho )
                                <div onclick="myFunc({{$trabalho->id}})" class="col-md-6 card" style="border: groove;border-color:#1492E6;border-radius: 10px; margin-top: 10px;">
                                    <a href="{{route('admin.analisarProposta',['id'=>$trabalho->id])}}" id="vizuProposta{{$trabalho->id}}" hidden>teste visual de proposta</a>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h6 style="color: #1492E6; font-size: 18px;">{{ $trabalho->titulo }}</h6>
                                            <h6 style="color: #234B8B; font-weight: bold;">Proponente:
                                                @foreach($trabalho->participantes as $participante)
                                                     {{$participante->user->name}};
                                                @endforeach
                                            </h6>
                                            <h6 style="color: #234B8B; font-weight: bold;">Data: {{ date('d/m/Y', strtotime($trabalho->created_at)) }}</h6>
                                        </div>

                                        <div class="col-md-2">
                                            @if($trabalho->status == "aprovado")
                                                <img src="{{asset('img/icons/aprovado.png')}}" style="width: 100%;margin: auto;display: flex;margin-top: 5px;justify-content: center;align-items: center;" alt="">
                                            @elseif($trabalho->status == "negado")
                                                <img src="{{asset('img/icons/pendente.png')}}" style="width: 100%;margin: auto;display: flex;margin-top: 5px;justify-content: center;align-items: center;" alt="">
                                            @else
                                                <img src="{{asset('img/icons/pendente.png')}}" style="width: 100%;margin: auto;display: flex;margin-top: 5px;justify-content: center;align-items: center;" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="container" >
            <div class="row" >
                <div class="col-sm-10">
                    <br>
                    <h6 style="color: #234B8B; font-weight: bold;">
                        <img src="{{asset('img/icons/pendente.png')}}" style="width: 30px"/>
                        Proposta Pendente</h6>
                    <h6 style="color: #234B8B; font-weight: bold;">
                        <img src="{{asset('img/icons/aprovado.png')}}" style="width: 30px"/>
                        Proposta Aprovada</h6>
                    <h6 style="color: #234B8B; font-weight: bold;">
                        <img src="{{asset('img/icons/negado.png')}}" style="width: 30px"/>
                        Proposta Negada</h6>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('javascript')
<script type="application/javascript">
    function myFunc(i){
        document.getElementById("vizuProposta"+i).click();
    }
</script>
@endsection
