@extends('layouts.app')

@section('content')

    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-md-11">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card-body" style="padding-top: 0.2rem;">
                        <div class="container">
                            <div class="form-row mt-3">
                                <div class="col-md-12"><h5 style="color: #1492E6; font-size: 20px;">Edital - {{$evento->nome}}</h5></div>
                                <div class="col-md-12"><h6 style="color: #234B8B; margin-bottom:-0.4rem; font-weight: bold; font-size: 14px;">Propostas Submetidas</h6><br></div>
                                <div class="col-md-12">
                                    <select id="" class="form-control select-submeta" onchange="teste(this)" style="width: 200px;">
                                        <option value="todos" selected>Todos</option>
                                        <option value="aprovado">Recomendados</option>
                                        <option value="reprovado">Não Recomendados</option>
                                        <option value="submetido">Submetidos</option>
                                        <option value="avaliado">Avaliados</option>
                                        
                                    
                                        
                                        @foreach($grandesAreas as $grandeArea)
                                            
                                            <option value="{{$grandeArea->nome}}">
                                                Grande Área: {{ $grandeArea->nome }}  
                                            </option>
                                            @foreach($areas as $area)
                                                @if($grandeArea->id == $area->grande_area_id)
                                                    <option value="{{$area->nome}}">
                                                        &nbsp;&nbsp; - Área: {{ $area->nome }}
                                                    </option>
                                                @endif
                                            @endforeach 
                                        @endforeach
                                        
                                                           
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3" style="display:flex; align-items: end;">
                    <input type="text" class="form-control form-control-edit" placeholder="Título do projeto ou nome do Proponente" onkeyup="buscar(this)"> <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
                </div>

                <div class="col-sm-5" style="display:flex; align-items: center;">
                    <h6 style="color: #234B8B; font-weight: bold; margin-left: 30px;">
                        <img src="{{asset('img/icons/pendente.png')}}" style="width: 22px"/>
                        Proposta Pendente
                        <img src="{{asset('img/icons/aprovado.png')}}" style="width: 22px"/>
                        Proposta Recomendada
                        <img src="{{asset('img/icons/negado.png')}}" style="width: 22px"/>
                        Proposta Negada
                        <br>
                        
                    </h6>
                </div>
            </div>
        </div>
    </div>
                        <div id="projetos">
                            @foreach( $trabalhos as $trabalho )
                            
                            <!--Informações Proponente-->
                                    <div class="row justify-content-center allTrab apareceu {{$trabalho->status}} {{$trabalho->grandeArea->nome}} {{$trabalho->area->nome}}" style="margin-top: 20px;" >
                                        <br>
                                        <div class="col-md-11" onclick="myFunc({{$trabalho->id}})">
                                            <a href="{{route('admin.analisarProposta',['id'=>$trabalho->id])}}" id="vizuProposta{{$trabalho->id}}" hidden></a>

                                            <div class="card" style="border-radius: 5px;margin-left: 25px;margin-right: 25 px">
                                                <div class="card-body" style="padding-top: 0.2rem; padding-left: 25px;padding-right: 25px;">

                                                        <div class="form-row mt-3">
                                                            <div class="col-md-10 tituloProj"><h5 style="color: #234B8B; font-weight: bold; margin-top: 15px;">Título: {{ $trabalho->titulo }}</h5></div>
                                                            <div class="col-md-2">
                                                                @if($trabalho->status == "aprovado")
                                                                    <img src="{{asset('img/icons/aprovado.png')}}" style="width: 23%;margin: auto;display: flex;margin-top: 0px;justify-content: center;align-items: center;" alt="">
                                                                @elseif($trabalho->status == "reprovado")
                                                                    <img src="{{asset('img/icons/negado.png')}}" style="width: 23%;margin: auto;display: flex;margin-top: 0px;justify-content: center;align-items: center;" alt="">
                                                                
                                                                @else
                                                                    <img src="{{asset('img/icons/pendente.png')}}" style="width: 20%;margin: auto;display: flex;justify-content: center;align-items: center;" alt="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr style="border-top: 1px solid#1492E6">
                                                        <div class="form-row mt-3">
                                                            <div class="col-md-12">
                                                                <p class="proponenteProj" style="color: #4D4D4D; padding: 0px"><b>Proponente:</b> {{ App\Proponente::find($trabalho->proponente_id)->user->name }}</p>
                                                            </div>

                                                            <div class="col-md-12"> <p style="color: #4D4D4D; padding: 0px"><b>Discentes:</b>
                                                                @foreach($trabalho->participantes as $participante)
                                                                    {{$participante->user->name}};
                                                                @endforeach
                                                            </div>
                                                            @if($trabalho->grande_area_id != null && $trabalho->area_id != null && $trabalho->sub_area_id != null)
                                                                <div class="col-md-12">
                                                                    <h6 style="color: #234B8B; font-weight: bold;font-size: 13px;">{{$trabalho->grandeArea->nome}} > {{$trabalho->area->nome}} > {{$trabalho->subArea->nome}}</h6>
                                                                </div>
                                                            @endif


                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>


    <div class="row justify-content-center" >
        <div class="col-md-11">
            <br>
            {{ $trabalhos->appends(['evento_id' => $evento->id])->links() }}
           
                </div>

        </div>



@endsection

@section('javascript')
<script type="application/javascript">
    function myFunc(i){
        document.getElementById("vizuProposta"+i).click();
    }

    
    function buscar(input) {
        let trabalhos = document.getElementById("projetos").children;
        //console.log(trabalhos)
        if(input.value.length > 2) {
            for(let i = 0; i < trabalhos.length; i++){
                if(trabalhos[i].classList.contains("apareceu")){
                    let tituloProjeto = trabalhos[i].getElementsByClassName("tituloProj")[0].textContent
                    let nomeProponente = trabalhos[i].getElementsByClassName("proponenteProj")[0].textContent
    
                    if(tituloProjeto.toLowerCase().substr(0).indexOf(input.value.toLowerCase()) >= 0 || nomeProponente.toLowerCase().substr(0).indexOf(input.value.toLowerCase()) >= 0) {
                        trabalhos[i].style.display = "";
                    }else {
                        trabalhos[i].style.display = "none";
                    }
                }

            }
        }else {
            for(let i = 0; i < trabalhos.length; i++) {
                if(trabalhos[i].classList.contains("apareceu")){
                    trabalhos[i].style.display = "";
                }
            }
            
        }
    }
    


    function teste(select) {
        let todos = document.getElementsByClassName("allTrab");
        let selecionados = document.getElementsByClassName(select.value);

        if(select.value == "todos"){
            for(let i = 0; i < todos.length; i++){
                todos[i].style.display = ""
                if(!todos[i].classList.contains("apareceu")){
                    todos[i].classList.add("apareceu");
                }
            }
        }else {
            for(let j = 0; j < todos.length; j++){
                todos[j].style.display = "none";
                todos[j].classList.remove("apareceu");
            }

            for(let k = 0; k < selecionados.length; k++){
                selecionados[k].style.display = "";
                selecionados[k].classList.add("apareceu");
                
            }
        }
    }
</script>
@endsection
<style>
    html{
        overflow-x:hidden;
    }
</style>
