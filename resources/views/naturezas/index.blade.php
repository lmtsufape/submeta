@extends('layouts.app')

@section('content')

<div class="container" >
      {{-- Modal criar nova natureza --}}
      <div class="modal fade" id="modalNewCenter" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content modal-submeta">
            <div class="modal-header modal-header-submeta">
               <h5 class="modal-title titulo-table" id="exampleModalLongTitle">{{__('Nova natureza')}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form id="formNew" method="POST" action="{{ route('natureza.salvar') }}" class="labels-blue">
                  @csrf
                  <label for="">Nome da natureza <span style="color: red;">*</span></label>
                  <input form="formNew" type="text" required class="form-control @error('nome') is-invalid @enderror" name="nome"  autocomplete="nome" autofocus placeholder="Nome da natureza">
                  @error('nome')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" onclick="submeterFormNew()" class="btn btn-info" style="width: 100%;">{{__('Salvar')}}</button>
            </div>
         </div>
         </div>
      </div>

      <div class="modal fade" id="modalNewFuncao" tabindex="-1" role="dialog" aria-labelledby="modalNewFuncaoTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content modal-submeta">
            <div class="modal-header modal-header-submeta">
               <h5 class="modal-title titulo-table" id="modalNewFuncaoTitle">{{__('Nova função de participante')}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form id="formNewFuncao" method="POST" action="{{ route('funcao_participante.store') }}" class="labels-blue">
                  @csrf
                  <label for="">Nome da função do participante <span style="color: red;">*</span></label>
                  <input name="nome_da_função" type="text" required class="form-control @error('nome_da_função') is-invalid @enderror" placeholder="Nome da função do participante">
                  <input type="hidden" name="newFuncao" value="0">
                  @error('nome_da_função')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </form>
            </div>
            <div class="modal-footer">
               <button type="submit" form="formNewFuncao" class="btn btn-info" style="width: 100%;">{{__('Salvar')}}</button>
            </div>
         </div>
         </div>
      </div>
    <div class="row" >
      @if(session('mensagem'))
      <div class="col-md-12" style="margin-top: 30px;">
         <div class="alert alert-success">
               <p>{{session('mensagem')}}</p>
         </div>
      </div>
      @endif
      @if(session('error'))
      <div class="col-md-12" style="margin-top: 30px;">
         <div class="alert alert-danger">
               <p>{{session('mensagem')}}</p>
         </div>
      </div>
      @endif
    </div>
    <div class="row" style="margin-top: 30px;">
      <div class="col-md-1">
         <a href="{{ route('admin.index') }}" class="btn btn-secondary">
           Voltar
         </a>
      </div>
      <div class="col-md-9" style="text-align: center;">
         <h3 class="titulo-table">{{ __('Naturezas') }}</h3>
      </div>
      <div class="col-md-2">
         <!-- Button trigger modal -->
         <a href="" class="btn btn-info" style="float: right;" data-toggle="modal" data-target="#modalNewCenter">{{ __('Criar natureza') }}</a>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12">
         <table class="table table-bordered">
            <thead>
              <tr>   
                <th scope="col">Nome</th>
                <th scope="col">Data de Criação</th>
                <th scope="col">Opção</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($naturezas as $natureza)
                 <!-- Modal Editar -->
                 <div class="modal fade" id="modalEditCenter{{$natureza->id}}" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-submeta">
                       <div class="modal-header modal-header-submeta">
                          <h5 class="modal-title titulo-table" id="exampleModalLongTitle">{{__('Editar natureza')}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                       <div class="modal-body labels-blue">
                          <form id="formEdit{{ $natureza->id }}" action="{{ route('natureza.atualizar', ['id' => $natureza->id]) }}">
                             @csrf
                             <label for="">Nome da natureza <span style="color: red;">*</span></label>
                             <input form="formEdit{{ $natureza->id }}" type="text" value="{{ $natureza->nome }}" class="form-control @error('nomeEditavel') is-invalid @enderror" name="nomeEditavel" required autocomplete="nome" autofocus>
                             @error('nomeEditavel')
                             <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                             </span>
                             @enderror
                          </form>
                       </div>
                       <div class="modal-footer">
                          <button type="button" onclick="submeterFormEdit('{{ $natureza->id }}')" class="btn btn-info" style="width: 100%">{{__('Salvar')}}</button>
                       </div>
                    </div>
                    </div>
                 </div>
                 <!-- Modal Excluir -->
                 <div class="modal fade" id="modalDelCenter{{$natureza->id}}" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                       <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">{{__('Deletar natureza')}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                       <div class="modal-body">
                          {{__('Tem certeza que deseja deletar essa natureza?')}}
                       </div>
                       <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Não')}}</button>
                          <a href="{{ route('natureza.deletar', ['id' => $natureza->id]) }}" type="button" onclick="submeterFormDel('{{ $natureza->id }}')" class="btn btn-danger">{{__('Sim')}}</a>
                       </div>
                    </div>
                    </div>
                 </div>
                <tr>
                  <td>
                    {{ $natureza->nome }}
                  </td>
                  <td>
                    {{ $natureza->creat_at }}
                  </td>
                  <td >
                    @if (is_null($natureza->projetos->first()))
                       <div class="btn-group dropright dropdown-options">
                          <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                          </a>
                          <div class="dropdown-menu">
                             <a data-toggle="modal" data-target="#modalEditCenter{{$natureza->id}}" class="dropdown-item text-center" style="color: rgb(0, 140, 255);">
                                {{__('Editar')}}
                             </a>
                             <hr class="dropdown-hr">
                             <a data-toggle="modal" data-target="#modalDelCenter{{$natureza->id}}" class="dropdown-item dropdown-item-delete text-center" style="color: white;">
                                <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">{{__('Deletar')}}
                             </a>
                          </div>
                       </div>
                    @else
                       <div style="float: right;">
                          Fixada em um edital
                       </div>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
         </table>
      </div>
   </div>
   <div class="row" style="margin-top: 30px; margin-bottom: 30px; text-align: center;">
      <div class="col-md-2">
      </div>
      <div class="col-md-7">
         <h3 class="titulo-table">{{ __('Funções de participante') }}</h3>
      </div>
      <div class="col-md-3">
         <!-- Button trigger modal -->
         <a href="" class="btn btn-info" style="float: right;" data-toggle="modal" data-target="#modalNewFuncao">{{ __('Criar função de participante') }}</a>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <table class="table table-bordered">
            <thead>
              <tr>   
                <th scope="col">Nome</th>
                <th scope="col">Data de Criação</th>
                <th scope="col">Opção</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($funcoes as $funcao)
                 <!-- Modal Editar -->
                 <div class="modal fade" id="modalEditFuncao{{$funcao->id}}" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-submeta">
                       <div class="modal-header modal-header-submeta">
                          <h5 class="modal-title titulo-table" id="exampleModalLongTitle">{{__('Editar função participante')}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                       <div class="modal-body labels-blue">
                          <form method="POST" id="formEditFuncao{{$funcao->id}}" action="{{ route('funcao_participante.update', ['id' => $funcao->id]) }}">
                             @csrf
                             <label for="">Nome da função do participante <span style="color: red;">*</span></label>
                             <input type="text" value="{{$funcao->nome}}" class="form-control @error('nome_da_função'.$funcao->id) is-invalid @enderror" name="nome_da_função{{$funcao->id}}" required>
                             <input type="hidden" name="editFuncao" value="{{$funcao->id}}">
                             @error('nome_da_função'.$funcao->id)
                             <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                             </span>
                             @enderror
                          </form>
                       </div>
                       <div class="modal-footer">
                          <button type="submit" form="formEditFuncao{{$funcao->id}}" class="btn btn-info" style="width: 100%;">{{__('Salvar')}}</button>
                       </div>
                    </div>
                    </div>
                 </div>
                 <!-- Modal Excluir -->
                 <div class="modal fade" id="modalDelFuncao{{$funcao->id}}" tabindex="-1" role="dialog" aria-labelledby="modalDelFuncaoTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                       <div class="modal-header">
                          <h5 class="modal-title" id="modalDelFuncaoTitle">{{__('Deletar função de participante')}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                       <div class="modal-body">
                          Tem certeza que deseja deletar a função de {{$funcao->nome}}?
                       </div>
                       <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Não')}}</button>
                          <a href="{{ route('funcao_participante.destroy', ['id' => $funcao->id]) }}" type="button" class="btn btn-danger">{{__('Sim')}}</a>
                       </div>
                    </div>
                    </div>
                 </div>
                <tr>
                  <td>
                    {{ $funcao->nome }}
                  </td>
                  <td>
                    {{ $funcao->creat_at }}
                  </td>
                  <td>
                    @if ($funcao->participantes->count() <= 0)
                       <div class="btn-group dropright dropdown-options">
                          <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                          </a>
                          <div class="dropdown-menu">
                             <a data-toggle="modal" data-target="#modalEditFuncao{{$funcao->id}}" class="dropdown-item text-center" style="color: rgb(0, 140, 255);">
                                {{__('Editar')}}
                             </a>
                             <hr class="dropdown-hr">
                             <a data-toggle="modal" data-target="#modalDelFuncao{{$funcao->id}}" class="dropdown-item dropdown-item-delete text-center" style="color: white;">
                                <img src="{{asset('img/icons/logo_lixeira.png')}}" alt="">{{__('Deletar')}}
                             </a>
                          </div>
                       </div>
                    @else
                       <div style="float: right;">
                          Fixada em participantes
                       </div>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>

@endsection

@section('javascript')
<script>
   function submeterFormNew() {
      var form = document.getElementById('formNew');
      form.submit();
   }
   function submeterFormEdit(id) {
      var form = document.getElementById('formEdit' + id);
      form.submit();
   }
</script>
@if(old('newFuncao') != null) 
   <script>
      $(document).ready(function () {
         $('#modalNewFuncao').modal('show');
      });
   </script>
@endif
@if(old('editFuncao') != null) 
<script>
   $(document).ready(function () {
      $('#modalEditFuncao{{old('editFuncao')}}').modal('show');
   });
</script>
@endif
@endsection