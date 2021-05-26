@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center" style="margin-top: 2rem;">
    <div class="col-md-11">
      <div class="card" style="border-radius: 12px; padding:14px">
          
        <div class="card-body" style="margin-bottom: -2rem">
          <div class="d-flex justify-content-between align-items-center">
            <div class="bottomVoltar">
              <a href="{{ route('proponente.index') }}" class="btn btn-secondary" style="position:relative; float: right;"><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
            </div>
            <div><h5 style="color: #1492E6; margin-top:0.5rem">Editais</h5></div>
            <div>
              <div class="row justify-content-end">
              <div class="btn-group col">
                <button class="btn" onclick="buscarEdital(this.parentElement.parentElement.children[1].children[0])" style="margin-right:5px; border-radius:12px">
                  <img src="{{asset('img/icons/logo_lupa2.png')}}" alt="" width="25px">
                </button>
                <input type="text" class="form-control form-control-edit" placeholder="Digite o nome do edital" onkeyup="buscarEdital(this)" style="border-color: #d1d1d1">
              </div>
            </div>
          </div>
          </div>
          <div  style="margin-top:-10px"><hr style="border-top: 1px solid#1492E6"></div>
        </div>

        <div class="card-body" >
          <table class="table table-bordered" style="display: block; 
          overflow-x: auto;
          white-space: nowrap; border-radius:10px">
            <thead>
              <tr>
                <th scope="col" style="width: 100%; color:#909090">Edital</th>
                <th scope="col" style="text-align: center; color:#909090">Inicio da Submissão</th>
                <th scope="col" style="text-align: center; color:#909090">Fim da Submissão</th>
                <th scope="col" style="text-align: center; color:#909090">Data do Resultado</th>
                <th scope="col" style="text-align: center; color:#909090">Baixar Edital</th>
                <th scope="col" style="text-align: center; color:#909090">Opção</th>
              </tr>
            </thead>
            <tbody id="eventos">
              @foreach ($eventos as $evento)
                <tr>
                  <td style="text-align: left;">
                    <a href="{{  route('evento.visualizar',['id'=>$evento->id])  }}" class="">
                        {{ $evento->nome }}
                    </a>
                  </td>
                  <td style="text-align: center;">{{ date('d/m/Y', strtotime($evento->inicioSubmissao)) }}</td>
                  <td style="text-align: center;">{{ date('d/m/Y', strtotime($evento->fimSubmissao)) }}</td>
                  <td style="text-align: center;">{{ date('d/m/Y', strtotime($evento->created_at)) }}</td>
                  <td style="text-align: center">
                    <a class="btn btn-light" href="{{ route('baixar.edital', ['id' => $evento->id]) }}" style="width: 100%">
                      <img src="{{asset('img/icons/file-download-solid.svg')}}" width="15px">
                    </a>
                  </td>
                  <td>
                    <div class="dropright dropdown-options" style="width: 100%; text-align:center; float:none">
                      <a id="options" class="dropdown-toggle btn btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                      </a>
                      <div class="dropdown-menu">
                          <a href="{{ route('proponente.projetosEdital', ['id' => $evento->id]) }}" class="dropdown-item" style="text-align: center">
                            Projetos submetidos
                          </a>
                          @if($evento->inicioSubmissao <= $hoje && $hoje <= $evento->fimSubmissao)
                            <hr class="dropdown-hr">
                            <a href="{{ route('trabalho.index', ['id' => $evento->id] )}}" class="dropdown-item" style="text-align: center">
                              Criar projeto
                            </a>
                          @endif
                          {{-- <a href="" class="dropdown-item" style="text-align: center">
                            Visualizar resultado
                          </a> --}}
                          {{-- <a href="" class="dropdown-item" style="text-align: center">
                            Recurso ao resultado
                          </a>
                          <a href="" class="dropdown-item" style="text-align: center">
                            Resultado preeliminar
                          </a>
                          <a href="" class="dropdown-item" style="text-align: center">
                            Resultado final
                          </a> --}}
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script>
  function buscarEdital(input) {
    var editais = document.getElementById('eventos').children;
    if(input.value.length > 2) {      
      for(var i = 0; i < editais.length; i++) {
        var nomeEvento = editais[i].children[0].children[0].textContent;
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
</script>
@endsection
