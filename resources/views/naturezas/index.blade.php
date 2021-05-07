@extends('layouts.app')

@section('content')

<div class="container" >
      {{-- Modal criar nova natureza --}}
      <div class="modal fade" id="modalNewCenter" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">{{__('Nova natureza')}}</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form id="formNew" method="POST" action="{{ route('natureza.salvar') }}">
                  @csrf
                  <input form="formNew" type="text" value="" class="form-control @error('nome') is-invalid @enderror" name="nome" required autocomplete="nome" autofocus>
                  @error('nome')
                  <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </span>
                  @enderror
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancelar')}}</button>
               <button type="button" onclick="submeterFormNew()" class="btn btn-primary">{{__('Salvar')}}</button>
            </div>
         </div>
         </div>
      </div>
    <div class="row" >
        @if(session('mensagem'))
        <div class="col-md-12" style="margin-top: 100px;">
            <div class="alert alert-success">
                <p>{{session('mensagem')}}</p>
            </div>
        </div>
        @endif
        <div class="col-sm-9">
          <h2 style="margin-top: 100px; ">{{ __('Naturezas') }}</h2>
        </div>
        <div class="col-sm-3">
          <a href="" class="btn btn-info" style="position:relative;top:100px; float: right;" data-toggle="modal" data-target="#modalNewCenter">{{ __('Criar natureza') }}</a>
        </div>
    </div>

    <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome</th>
        <th scope="col">Data de criação</th>
        <th scope="col">Opção</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($naturezas as $natureza)
         <!-- Modal Editar -->
         <div class="modal fade" id="modalEditCenter{{$natureza->id}}" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">{{__('Editar natureza')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form id="formEdit{{ $natureza->id }}" action="{{ route('natureza.atualizar', ['id' => $natureza->id]) }}">
                     @csrf
                     <input form="formEdit{{ $natureza->id }}" type="text" value="{{ $natureza->nome }}" class="form-control @error('nomeEditavel') is-invalid @enderror" name="nomeEditavel" required autocomplete="nome" autofocus>
                     @error('nomeEditavel')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </form>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancelar')}}</button>
                  <button type="button" onclick="submeterFormEdit('{{ $natureza->id }}')" class="btn btn-primary">{{__('Salvar')}}</button>
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
                  <a href="{{ route('natureza.deletar', ['id' => $natureza->id]) }}" type="button" onclick="submeterFormDel('{{ $natureza->id }}')" class="btn btn-primary">{{__('Sim')}}</a>
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
          <td>
            @if (is_null($natureza->projetos->first()))
                  <div class="btn-group dropright dropdown-options">
                     <a id="options" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img src="{{asset('img/icons/ellipsis-v-solid.svg')}}" style="width:8px">
                     </a>
                     <div class="dropdown-menu">
                     
                        <a class="dropdown-item" data-toggle="modal" data-target="#modalEditCenter{{$natureza->id}}" class="dropdown-item">
                              <img src="{{asset('img/icons/edit-regular.svg')}}" class="icon-card" alt="">
                              {{__('Editar')}}
                        </a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#modalDelCenter{{$natureza->id}}" class="dropdown-item">
                           <img src="{{asset('img/icons/trash-alt-regular.svg')}}" class="icon-card" alt="">
                           {{__('Deletar')}}
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
@endsection