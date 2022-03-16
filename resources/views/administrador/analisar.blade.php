@extends('layouts.app')

@section('content')

    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-md-11">
            <div class="row">
                <div class="col-sm-7">
                    <div class="card-body" style="padding-top: 0.2rem;">
                        <div class="container">
                            <div class="form-row mt-3">
                                <div class="col-md-12"><h5 style="color: #1492E6; font-size: 20px;">Edital - {{$evento->nome}}</h5></div>
                                <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem; font-weight: bold; font-size: 14px;">Propostas Submetidas</h6></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5" style="top: 40px; text-align: end">
                    <h6 style="color: #234B8B; font-weight: bold;font-size: 13px; text-align: right">
                        <img src="{{asset('img/icons/pendente.png')}}" style="width: 22px"/>
                        Proposta Pendente
                        <img src="{{asset('img/icons/aprovado.png')}}" style="width: 22px"/>
                        Proposta Aprovada
                        <img src="{{asset('img/icons/negado.png')}}" style="width: 22px"/>
                        Proposta Negada
                        <br>
                        <img src="{{asset('img/icons/parcialmenteAprovado.png')}}" style="width: 22px"/>
                        Proposta Parcialmente Aprovada
                    </h6>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1 mt-5">
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filtro @isset ($column) - {{$column}} @endisset
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{route('admin.analisar', ['evento_id' => $evento->id])}}">
                                Todos
                            </a>
                            <a class="dropdown-item" href="{{route('admin.analisar', ['evento_id' => $evento->id, 'column' => 'aprovado'])}}">
                                Aprovados
                            </a>
                            <a class="dropdown-item" href="{{route('admin.analisar', ['evento_id' => $evento->id, 'column' => 'reprovado'])}}">
                                Reprovados
                            </a>
                            <a class="dropdown-item" href="{{route('admin.analisar', ['evento_id' => $evento->id, 'column' => 'submetido'])}}">
                                Submetidos
                            </a>
                            <a class="dropdown-item" href="{{route('admin.analisar', ['evento_id' => $evento->id, 'column' => 'avaliado'])}}">
                                Avaliados
                            </a>
                            <a class="dropdown-item" href="{{route('admin.analisar', ['evento_id' => $evento->id, 'column' => 'corrigido'])}}">
                                Corrigidos
                            </a>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>

                            @foreach( $trabalhos as $trabalho )

                            <!--Informações Proponente-->
                                    <div class="row justify-content-center" style="margin-top: 20px;">
                                        <br>
                                        <div class="col-md-11"  onclick="myFunc({{$trabalho->id}})">
                                            <a href="{{route('admin.analisarProposta',['id'=>$trabalho->id])}}" id="vizuProposta{{$trabalho->id}}" hidden></a>

                                            <div class="card" style="border-radius: 5px;">
                                                <div class="card-body" style="padding-top: 0.2rem;">
                                                    <div class="container">
                                                        <div class="form-row mt-3">
                                                            <div class="col-md-10"><h5 style="color: #234B8B; font-weight: bold">Titulo: {{ $trabalho->titulo }}</h5></div>
                                                            <div class="col-md-2">
                                                                @if($trabalho->status == "aprovado")
                                                                    <img src="{{asset('img/icons/aprovado.png')}}" style="width: 23%;margin: auto;display: flex;margin-top: 0px;justify-content: center;align-items: center;" alt="">
                                                                @elseif($trabalho->status == "reprovado")
                                                                    <img src="{{asset('img/icons/negado.png')}}" style="width: 23%;margin: auto;display: flex;margin-top: 5px;justify-content: center;align-items: center;" alt="">
                                                                @elseif($trabalho->status == "corrigido")
                                                                    <img src="{{asset('img/icons/parcialmenteAprovado.png')}}" style="width: 23%;margin: auto;display: flex;margin-top: 0px;justify-content: center;align-items: center;" alt="">
                                                                @else
                                                                    <img src="{{asset('img/icons/pendente.png')}}" style="width: 20%;margin: auto;display: flex;justify-content: center;align-items: center;" alt="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr style="border-top: 1px solid#1492E6">
                                                        <div class="form-row mt-3">
                                                            <div class="col-md-12">
                                                                <p style="color: #4D4D4D; padding: 0px"><b>Proponente:</b> {{ App\Proponente::find($trabalho->proponente_id)->user->name }}</p>
                                                            </div>

                                                            <div class="col-md-12"> <p style="color: #4D4D4D; padding: 0px"><b>Discentes:</b>
                                                                @foreach($trabalho->participantes as $participante)
                                                                    {{$participante->user->name}};
                                                                @endforeach
                                                            </div>

                                                            <div class="col-md-12">
                                                                <h6 style="color: #234B8B; font-weight: bold;font-size: 13px;">Data: {{ date('d/m/Y', strtotime($trabalho->created_at)) }}</h6>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach


    <div class="row justify-content-center" >
        <div class="col-md-11">
            <br>
            {{ $trabalhos->links() }}
           
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
<style>
    html{
        overflow-x:hidden;
    }
</style>
