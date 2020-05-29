@extends('layouts.app')

@section('content')

<div class="container" style="margin-top: 100px;">

  <div class="container" >
    <div class="row" >
      <div class="col-sm-10">
        <h3>Usuarios</h3> 
      </div>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>   
        <th scope="col">Nome do Usuário</th>
        <th scope="col">E-mail</th>
        <th scope="col">Opção</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($usuarios as $usuario)
        <tr>
          <td>{{ $usuario->user->name }}</td>
          <td>{{ $usuario->user->email }}</td>
          <td>
            <form id="form{{ $usuario->user->id }}">
              @csrf
              <button type="button" class="btn btn-primary" data-toggle="modal" id="button{{ $usuario->user->id }}" onclick="permissao({{ $usuario->user->id }});" data-target="#exampleModal{{ $usuario->user->id }}">
                Atribuir Permissões
              </button>
              <!-- Modal -->
              <div class="modal fade" id="exampleModal{{ $usuario->user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Mudar Permissão{{ $usuario->user->id }}</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>

                    <div class="modal-body">
                        <div class="custom-control custom-switch">
                          <input type="checkbox" name="avaliador" value="{{ $usuario->user->id }}" checked="" onclick="myFunction({{ $usuario->user->id }})" class="custom-control-input switch" id="{{ $usuario->user->id }}" >
                          <input type="hidden" name="user_id" value="{{ $usuario->user->id }}" id="usuario{{ $usuario->user->id }}">
                          <label class="custom-control-label" for="{{ $usuario->user->id }}">Avaliador</label>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" id="atribuir_id" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>


              
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>




@endsection

@section('javascript')
<script>
  
  function myFunction(id) {
      var checkBox = document.getElementById(id);

      let dados = $('#form'+id).serialize()
      // let dados = document.getElementById("usuario"+id).value;
      console.log(dados)

      //ajax
      $.ajax({
        type: 'post',
        url: 'http://submeta.test/adminResp/atribuir',
        data: dados, //x-www-form-urlencoded
        dataType: 'json',
        success: dados => {
          
          console.log(dados)
          
        },
        error: erro => { console.log(erro) }
      })

  }

  
  function permissao(id) {
        var checkBox = document.getElementById(id);

        // console.log('#atribuir_id'+id);
        // console.log($('#'+id).attr('checked'))
        let dados = $('#form'+id).serialize()
        //let dados = $('form').serialize()

        $.ajax({
        type: 'post',
        url: 'http://submeta.test/adminResp/verPermissao',
        data: dados, //x-www-form-urlencoded
        dataType: 'json',
        success: dados => {

          checkBox.checked = dados[0];
          console.log(checkBox.checked)

        },
        error: erro => { console.log(erro) }
      })

      
  }

  $(document).ready(() => {
    
    
    
  })
</script>
@endsection


