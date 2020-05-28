@extends('layouts.app')
@section('sidebar')
<div class="wrapper">
    <div class="sidebar">
        <h2>{{{$evento->nome}}}</h2>
        <ul>
            <a id="informacoes">
                <li>
                    <img src="{{asset('img/icons/info-circle-solid.svg')}}" alt=""> <h5> Informações</h5>
                </li>
            </a>

            <a id="trabalhos">
                <li data-toggle="collapse" data-target="#ajuda" class="collapsed">
                    <img src="{{asset('img/icons/file-alt-regular.svg')}}" alt=""><h5>Trabalhos</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <ul class="sub-menu collapse" id="ajuda" style="background-color: gray">
                    <a id="submissoes" class="exibir">
                        <li>
                            <img src="{{asset('img/icons/plus-square-solid.svg')}}" alt=""><h5>Definir Submissões</h5>
                        </li>
                    </a>
                    <a id="listarTrabalhos" class="exibir" >
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5>Listar Trabalhos</h5>
                        </li>
                    </a>
                </ul>
            </a>
            <a id="areas">
                <li data-toggle="collapse" data-target="#menuAreas" class="collapsed">
                    <img src="{{asset('img/icons/area.svg')}}" alt=""><h5> Áreas</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <ul class="sub-menu collapse" id="menuAreas" style="background-color: gray">
                    <a >
                        <li>
                            <img src="{{asset('img/icons/plus-square-solid.svg')}}" alt=""><h5> Cadastrar Áreas</h5>
                        </li>
                    </a>
                    <a>
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5> Listar Áreas</h5>
                        </li>
                    </a>
                </ul>
            </a>
            <a id="avaliador">
                <li data-toggle="collapse" data-target="#menuAvaliador" class="collapsed">
                    <img src="{{asset('img/icons/glasses-solid.svg')}}" alt=""><h5>Avaliadores</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <ul class="sub-menu collapse" id="menuAvaliador" style="background-color: gray">
                    <a >
                        <li>
                            <img src="{{asset('img/icons/user-plus-solid.svg')}}" alt=""><h5> Cadastrar Revisores</h5>
                        </li>
                    </a>
                    <a>
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5> Listar Revisores</h5>
                        </li>
                    </a>
                </ul>
                
            </a>
            <a id="comissao" >
                <li data-toggle="collapse" data-target="#menuComissao" class="collapsed">
                    <img src="{{asset('img/icons/user-tie-solid.svg')}}" alt=""><h5>Comissão</h5><img class="arrow" src="{{asset('img/icons/arrow.svg')}}">
                </li>
                <ul class="sub-menu collapse" id="menuComissao" style="background-color: gray">
                    <a>
                        <li>
                            <img src="{{asset('img/icons/crown-solid.svg')}}" alt=""><h5> Definir Coordenador</h5>
                        </li>
                    </a>
                    <a >
                        <li>
                            <img src="{{asset('img/icons/list.svg')}}" alt=""><h5> Listar Comissão</h5>
                        </li>
                    </a>
                </ul>
                
            </a>
            
        </ul>
    </div>
    
</div>

<!-- paginas -->
        <div class="main"  style="margin-left: 200px; margin-top: 100px;">
            <div class="container">
                <div class="row" id="pagina">
                    
                </div>
            </div>
        </div>


@endsection
@section('javascript')
  <script type="text/javascript" >
    
        
            
            
        



   $(document).ready(()=>{
        $('.exibir').on('click',(event) => {
                event.preventDefault();
                console.log(event.currentTarget.id);

                var itemMenu = event.currentTarget.id;
                

                $.ajax({
                    type: 'POST',
                    url: '{{ route('coordenador.retornoDetalhes') }}',
                    data: 'item='+itemMenu+'&evento_id='+'{{ $evento->id }}' ,
                    headers: 
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        $('#pagina').html(data);
                        //console.log(data);
                    },
                    error: (data) => {
                        console.log(data);
                    }

                })


            });
   })



  </script>

@endsection

