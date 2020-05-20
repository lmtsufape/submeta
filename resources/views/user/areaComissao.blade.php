@extends('layouts.app')

@section('content')

<div class="container">

    {{-- titulo da página --}}
    <div class="row justify-content-center titulo">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10">
                    <h1>Trabalhos</h1>
                </div>
                <div class="col-sm-2">
                    <a href="{{route('comissoes')}}" class="btn btn-primary">Comissões</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabela Trabalhos --}}
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-hover table-responsive-lg table-sm">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Área</th>
                <th scope="col" style="text-align:center">Revisores</th>
                <th scope="col" style="text-align:center">Baixar</th>
                <th scope="col" style="text-align:center">Nota</th>
                <th scope="col" style="text-align:center">Avaliar</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 0; @endphp
                @foreach($trabalhos as $trabalho)
    
                <tr>
                <td>{{$trabalho->id}}</td>
                <td>{{$trabalho->area->nome}}</td>
                <td>
                    @foreach($trabalho->atribuicao as $atribuicao)
                    {{$atribuicao->revisor->user->email}},
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
                <td>
                </td>
                <td style="text-align:center">
                    <a class="botaoAjax" href="#" data-toggle="modal" onclick="trabalhoId({{$trabalho->id}})" data-target="#modalTrabalho"><img src="{{asset('img/icons/eye-regular.svg')}}" style="width:20px"></a>
                </td>
    
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    
    </div>

</div>

@endsection