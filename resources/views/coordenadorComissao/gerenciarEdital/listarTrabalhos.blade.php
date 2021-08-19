

  <div class="col-sm-10">
      <h1 class="">Trabalhos</h1>
  </div>

  <table class="table table-hover table-responsive-lg table-sm">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Titulo</th>
        <th scope="col">Avaliadores</th>
        <th scope="col" style="text-align:center">Baixar</th>
        <th scope="col" style="text-align:center">Atribuição</th>
      </tr>
    </thead>
    <tbody>
      @php $i = 0; @endphp
      @foreach($trabalhos as $trabalho)
           
      <tr>
          <td>{{$trabalho->id}}</td>
          <td>{{$trabalho->titulo}}</td>
          <td>
            @foreach($trabalho->avaliadors as $atribuicao)
                {{$atribuicao->user->email}},
            @endforeach
          </td>
          <td style="text-align:center">
            @php $arquivo = ""; $i++; @endphp
            @foreach($trabalho->arquivo as $key)
            @php
            if($key->versaoFinal == true){
              $arquivo = $key->nome;
            }
            @endphp
            @endforeach
            <img onclick="document.getElementById('formDownload{{$i}}').submit();" class="" src="{{asset('img/icons/file-download-solid-black.svg')}}" style="width:20px" alt="">
            <form method="GET" action="{{ route('download') }}" target="_new" id="formDownload{{$i}}">
              <input type="hidden" name="file" value="{{$arquivo}}">
            </form>
          </td>
          <td style="text-align:center">
            <a id="listarComissao" class="exibir">
            
            <form action="{{ route('coordenador.atribuirAvaliadorTrabalho') }}" method="POST" >
              @csrf
              <input type="hidden" name="trabalho_id"  value="{{$trabalho->id}}">

              <button type="submit" class="btn btn-primary" > Atribuir Avaliadores </button>


            </form>

            {{-- <a class="botaoAjax" href="#" data-toggle="modal" onclick="" data-target="#modalTrabalho"><img src="{{asset('img/icons/eye-regular.svg')}}" style="width:20px"></a> --}}
          </td>
      </tr>
      
      @endforeach
    </tbody>
  </table>

