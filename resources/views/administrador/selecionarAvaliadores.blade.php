@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')

<div class="container" style="margin-top: 30px;">
  

  <div class="container" >
    <div class="row justify-content-center d-flex align-items-center" style="margin-bottom: 50px;">
      <div class="col-md-1">
        <a href="{{ route('admin.atribuir', ['evento_id' => $evento->id]) }}" class="btn btn-secondary">
          Voltar
        </a>
      </div>
      <div class="col-md-9" style="text-align: center;">
         <h3 class="titulo-table">Avaliadores</h3>
      </div>
      <div class="col-md-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter">
          Enviar Convite
        </button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="col-sm-1">
            <button class="btn" onclick="buscar(this.parentElement.parentElement.children[1].children[0])">
              <img src="{{asset('img/icons/logo_lupa.png')}}" alt="">
            </button>
          </div>
          <div class="col-sm-6">
            <input type="text" class="form-control form-control-edit" placeholder="Digite o e-mail do avaliador" onkeyup="buscar(this)">
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Usuário</th>
        <th scope="col">Email</th>
        @if($evento->natureza_id == 3)
          <th scope="col">Área Temática</th>
        @else
          <th scope="col">Área</th>
        @endif
        <th scope="col">Tipo</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody id="avaliadores">
      @foreach ($avaliadores as $avaliador)
        <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->user->email }}</td>
          <td>
            @if(is_null($avaliador->area))
              @if($avaliador->areaTematicas()->get()->first() != null)
                {{ $avaliador->areaTematicas()->get()->first()->nome }}
              @else
                Indefinida
              @endif
            @else
              {{ $avaliador->area->nome }}
            @endif
            
          </td>
          <td>
            @if($avaliador->tipo == null)
              Externo
            @else
              {{$avaliador->tipo}}
            @endif
          </td>
          <td style="text-align:center">
            <form action="{{ route('admin.adicionar') }}" method="POST">
              @csrf
              <!-- Possibilidade de exclusão -->
              {{-- <input type="hidden" name="avaliador_id" value="{{ $avaliador->avaliador_id }}"> --}}
              <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}" > 
              <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
              <button type="submit" class="btn btn-primary" >Adicionar</button>
            </form>          
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  
  <div class="container" style="margin-top: 50px;">
    <div class="row justify-content-center" >
      <h4 class="titulo-table">Avaliadores Selecionados para o Edital: <span style="color: black;">{{ $evento->nome }}</span> </h4> 
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Usuário</th>
        <th scope="col">Tipo</th>
        <th scope="col">Email</th>
        <th scope="col">Status</th>
        <th scope="col">Projetos</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($avalSelecionados as $avaliador)
        <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->tipo }}</td>
          <td>{{ $avaliador->user->email }}</td>
          @if($avaliador->eventos->where('id', $evento->id)->first()->pivot->convite == true)
            <td style="color: rgb(3, 189, 3);">Aceito</td>
          @elseif(is_null($avaliador->eventos->where('id', $evento->id)->first()->pivot->convite))
            <td>A confirmar</td>
          @else
            <td style="color: red;">Recusado</td>
          @endif
          
          <!-- ANTOIM -->

          @if($avaliador->trabalhos->where('evento_id', $evento->id)->count() == 0)
            <td><button data-toggle="modal" class="btn btn-primary" style="color:white;
            " data-target="#avaliadorModalCenter1{{$avaliador->id}}">Visualizar</button></td>
          @else
            <td><button data-toggle="modal" class="btn btn-primary" style="color:white;
            " data-target="#avaliadorModalCenter{{$avaliador->id}}">Visualizar</button></td>
          @endif

          <!-- MODAL Projetos -->
          <div class="modal fade" id="avaliadorModalCenter{{$avaliador->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow-y: hidden">          
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

              <div class="modal-content modal-submeta modal-xl">
                <div class="modal-header modal-header-submeta">
                  <div class="col-md-8" style="padding-left: 0px">
                    <h5 class="modal-title titulo-table" id="avaliacaoModalLongTitle">
                        Projetos do Avaliador</h5>
                  </div>
                  <div class="col-md-4" style="text-align: right">
                    <button type="button" class="close" aria-label="Close"
                    data-dismiss="modal" style="color: rgb(182, 182, 182);padding-right: 0px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              
                <div class="modal-body" style="margin-left: 20px; margin-right: 20px;">        
                  @foreach($trabalhos as $trabalho)
                    @foreach($trabalho->avaliadors as $avaliador1)
                      @if($avaliador1->id == $avaliador->id)
                        {{-- {{ $avaliador->trabalhos->where('id', $trabalho->id)->first()->pivot }} --}}
                        <a href="{{route('admin.analisarProposta',['id'=>$trabalho->id])}}">Título: {{ $trabalho->titulo }}</a><br>
                      @endif 
                    @endforeach
                  @endforeach
                </div>
                
              </div>
            </div>
          </div>


          <div class="modal fade" id="avaliadorModalCenter1{{$avaliador->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow-y: hidden">          
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

              <div class="modal-content modal-submeta modal-xl">
                <div class="modal-header modal-header-submeta">
                  <div class="col-md-8" style="padding-left: 0px">
                    <h5 class="modal-title titulo-table" id="avaliacaoModalLongTitle">
                        Projetos do Avaliador</h5>
                  </div>
                  <div class="col-md-4" style="text-align: right">
                    <button type="button" class="close" aria-label="Close"
                    data-dismiss="modal" style="color: rgb(182, 182, 182);padding-right: 0px;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              
                <div class="modal-body" style="margin-left: 20px; margin-right: 20px;">        
                  Esse Avaliador não possui projetos. <a href="{{route('admin.analisar', ['evento_id' => $evento->id])}}">Clique aqui</a> e verifique os projetos disponíveis.
                </div>
                
              </div>
            </div>
          </div>

          <td @if($avaliador->eventos->where('id', $evento->id)->first()->pivot->convite  != null) style="text-align:center" @endif style="text-align:center; display:flex; justify-content: space-evenly">
            <form action="{{ route('admin.remover') }}" method="POST">
              @csrf
              <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}" >
              <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
              <button type="button" class="btn btn-danger" @if($avaliador->trabalhos->where('evento_id', $evento->id)->count()  != 0) disabled="disabled" @endif
              data-toggle="modal" data-target="#modal{{ $avaliador->id }}"
              >Remover</button>

              <!-- Modal Remover -->
              <div class="modal fade" id="modal{{ $avaliador->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Remover Avaliador</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Você tem certeza que deseja remover o avaliador: {{ $avaliador->user->name }}?</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-danger">Remover</button>
                    </div>
                  </div>
                </div>
              </div>

            </form> 
            <form action="{{ route('admin.reenviarConvite') }}" method="POST">
              @csrf
              <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}" >
              <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
              <button type="submit" class="btn btn-secondary" @if($avaliador->eventos->where('id', $evento->id)->first()->pivot->convite  != null) disabled hidden @endif >Reenviar convite</button>
            </form>    
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content modal-submeta">
      <div class="modal-header modal-header-submeta">
        <h5 class="modal-title titulo-table" id="exampleModalLongTitle" style="font-size: 20px;">Enviar Convite</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: rgb(182, 182, 182)">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="margin-left: 20px; margin-right: 20px;">

        <form action="{{ route('admin.enviarConvite') }}" method="POST" class="labels-blue">
          @csrf
          <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
          <div class="form-group">
            <label for="exampleInputEmail1">Nome Completo <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="nomeAvaliador" id="exampleInputNome1" required>            
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email <span style="color: red;">*</span></label>
            <input type="email" class="form-control" name="emailAvaliador" id="exampleInputEmail1" required>            
          </div>
  <!-- aki -->
        @if($evento->natureza_id != 3)
          <div class="form-group">
          <label for="grandeArea" class="col-form-label">{{ __('Grande Área') }} <span style="color: red; font-weight:bold">*</span></label>
              <select class="form-control" id="grandeArea" name="grande_area_id" onchange="areas()" required>
                <option value="" disabled selected hidden>-- Grande Área --</option>
                @foreach($grandeAreas as $grandeArea)
                <option value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                @endforeach
              </select>

              <label for="area" class="col-form-label">{{ __('Área') }} <span style="color: red; font-weight:bold">*</span></label>
              <select class="form-control @error('area') is-invalid @enderror" id="area" name="area_id" required>
                <option value="" disabled selected hidden>-- Área --</option>
              </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Tipo</label>
            <select class="form-control" name="tipo" id="exampleFormControlSelect1" disabled>
              <option value="avaliador" >Avaliador</option>
            </select>
          </div>
        @else       
          <div class="form-group">
            <label for="areasTemeticas" class="col-form-label">{{ __('Áreas Temáticas') }}<span style="color: red; font-weight:bold">*</span></label>
            <select class="form-control" id="areaTematicaConvite" style="width: 425px" name="areasTemeticas[]" multiple="multiple" required>
                @foreach($areasTematicas as $areaTematica)
                    <option value="{{$areaTematica->id}}">{{$areaTematica->nome}}</option>
                @endforeach
            </select>
          </div>                       
        @endif
  
          @if($evento->natureza_id != 3)
            <div class="form-group">
              <label for="exampleFormControlSelect1">Instituição <span style="color: red; font-weight:bold">*</span></label>
              <select class="form-control" name="instituicao" id="membro" required onchange="mostrarDiv(this)">
                <option value="" disabled>-- Selecione a instituição --</option>
                <option value="ufape" >Universidade Federal do Agreste de Pernambuco</option>
                <option value="outra" >Outra</option>
              </select>
            </div> 
          @endif

          <div class="form-group" id="div-outra" style="@if(old('instituicao') != null && old('instituicao') == "outra") display: block; @else display: none; @endif">
            <label for="outra">{{ __('Digite o nome da instituição') }}<span style="color: red; font-weight: bold;"> *</span></label>
            <input id="outra" class="form-control @error('outra') is-invalid @enderror" type="text" name="outra" value="{{old('outra')}}" autocomplete="outra" placeholder="Universidade Federal ...">
            @error('outra')
                <div id="validationServer03Feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group" style="margin-top: 40px; margin-bottom: 40px;">
            <button type="submit" class="btn btn-info" style="width: 100%">Enviar</button>
          </div> 
          <div class="form-group texto-info">
            O convite será enviador por e-mail e o preenchimento dos dados será de inteira responsabilidade do usuário convidado.
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
  $("#areaTematicaConvite").select2({
    placeholder: 'Selecione as áreas temáticas',
    allowClear: true
  });
</script>

<script>
  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
  });

  function buscar(input) {
    var editais = document.getElementById('avaliadores').children;
    if(input.value.length > 2) {      
      for(var i = 0; i < editais.length; i++) {
        var nomeEvento = editais[i].children[1].textContent;
        if(nomeEvento.substr(0).indexOf(input.value) >= 0) {
          editais[i].style.display = "";
        } else {
          editais[i].style.display = "none";
        }
      }
    } else {
      for(var i = 0; i < editais.length; i++) {
        editais[i].style.display = "";
      }
    }
  }

  function areas() {
      var grandeArea = $('#grandeArea').val();
      $.ajax({
          type: 'POST',
          url: '{{ route('area.consulta') }}',
          data: 'id='+grandeArea ,
          headers:
          {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: (dados) => {

          if (dados.length > 0) {
            if($('#oldArea').val() == null || $('#oldArea').val() == ""){
              var option = '<option selected disabled>-- Área --</option>';
            }
            $.each(dados, function(i, obj) {
              if($('#oldArea').val() != null && $('#oldArea').val() == obj.id){
                option += '<option selected value="' + obj.id + '">' + obj.nome + '</option>';
              }else{
                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
              }
            })
          } else {
            var option = "<option selected disabled>-- Área --</option>";
          }
          $('#area').html(option).show();
          subareas();
        },
          error: (data) => {
              console.log(data);
          }

      })
    }
    function mostrarDiv(select) {
      if(select.value == "outra") {
          document.getElementById('div-outra').style.display = "block";
          $("#outra").prop('required',true);
      }else if(select.value == "ufape"){
        document.getElementById('div-outra').style.display = "none";
        $("#outra").prop('required',false);
      }
    }
        
</script>
@endsection
