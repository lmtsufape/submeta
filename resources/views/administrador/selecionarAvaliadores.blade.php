@extends('layouts.app')

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
        <th scope="col">Área</th>
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
              Indefinida
            @else
              {{ $avaliador->area->nome }}
            @endif
            
          </td>
          <td style="text-align:center">
            <form action="{{ route('admin.adicionar') }}" method="POST">
              @csrf
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
        <th scope="col">Email</th>
        <th scope="col">Status</th>
        <th scope="col" style="text-align:center">Ação</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($avalSelecionados as $avaliador)
        <tr>
          <td>{{ $avaliador->user->name }}</td>
          <td>{{ $avaliador->user->email }}</td>
          @if($avaliador->eventos->where('id', $evento->id)->first()->pivot->convite == true)
            <td style="color: rgb(3, 189, 3);">Aceito</td>
          @elseif(is_null($avaliador->eventos->where('id', $evento->id)->first()->pivot->convite))
            <td>A confirmar</td>
          @else
            <td style="color: red;">Recusado</td>
          @endif
          

          <td style="text-align:center">
            <form action="{{ route('admin.remover') }}" method="POST">
              @csrf
              <input type="hidden" name="avaliador_id" value="{{ $avaliador->id }}" >
              <input type="hidden" name="evento_id" value="{{ $evento->id }}" >
              <button type="submit" class="btn btn-danger" @if($avaliador->trabalhos->where('evento_id', $evento->id)->count()  != 0) disabled="disabled" @endif >Remover</button>
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
            <input type="text" class="form-control" name="nomeAvaliador" id="exampleInputNome1">            
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email <span style="color: red;">*</span></label>
            <input type="email" class="form-control" name="emailAvaliador" id="exampleInputEmail1">            
          </div>

          <div class="form-group">
          <label for="grandeArea" class="col-form-label">{{ __('Grande Área') }} <span style="color: red; font-weight:bold">*</span></label>
              <select class="form-control" id="grandeArea" name="grande_area_id" onchange="areas()" >
                <option value="" disabled selected hidden>-- Grande Área --</option>
                @foreach($grandeAreas as $grandeArea)
                <option value="{{$grandeArea->id}}">{{$grandeArea->nome}}</option>
                @endforeach
              </select>

              <label for="area" class="col-form-label">{{ __('Área') }} <span style="color: red; font-weight:bold">*</span></label>
              <select class="form-control @error('area') is-invalid @enderror" id="area" name="area_id" >
                <option value="" disabled selected hidden>-- Área --</option>
              </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Tipo</label>
            <select class="form-control" name="tipo" id="exampleFormControlSelect1" disabled>
              <option value="avaliador" >Avaliador</option>
            </select>
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
</script>
@endsection
