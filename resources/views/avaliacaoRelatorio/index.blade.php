@extends('layouts.app')

@section('content')

    <div class="container" style="margin-bottom: 295px" >
        @if(isset($mensagem))
            <div class="col-sm-12">
                <br>
                <div class="alert alert-success">
                    <p>{{ $mensagem }}</p>
                </div>
            </div>
        @endif
        @if(session('mensagem'))
            <div class="col-sm-12">
                <br>
                <div class="alert alert-success">
                    <p>{{session('mensagem')}}</p>
                </div>
            </div>
        @endif
        <div class="row justify-content-center" style="margin-top: 3rem;">
            <div class="col-md-12" style="margin-bottom: -3rem">
                <div class="card card_conteudo shadow bg-white" style="border-radius:12px; border-width:0px;">
                    <div class="card-header" style="border-top-left-radius: 12px; border-top-right-radius: 12px; background-color: #fff">
                        <div class="d-flex justify-content-between align-items-center" style="margin-top: 9px; margin-bottom:-1rem">
                            <div class="bottomVoltar" style="margin-top: -20px">
                                <a href="javascript:history.back()"  class="btn btn-secondary" style=""><img src="{{asset('img/icons/logo_esquerda.png')}}" alt="" width="15px"></a>
                            </div>
                            <div class="form-group">
                                <h5 class="card-title mb-0" style="font-size:25px; font-family:Arial, Helvetica, sans-serif; color:#1492E6">Avaliações de Planos de Trabalhos</h5>
                            </div>
                            <div style="margin-top: -2rem">
                                <div class="form-group">
                                    <div style="margin-top:30px;">
                                        {{-- Pesquisar--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-body" >
                        <table class="table table-bordered table-hover" style=" white-space: nowrap; border-radius:10px; margin-bottom:0px">
                            <thead>
                            <tr class="text-center">
                                <th scope="col">Nome do Evento</th>
                                <th scope="col">Nome do Projeto</th>
                                <th scope="col">Nome do plano</th>
                                <th scope="col">Discente</th>
                                <th scope="col">Tipo do Relatório</th>
                                <th scope="col">Avaliar</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($avaliacoes as $avaliacao)
                                <tr class="text-center">
                                    <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">{{ $avaliacao->plano->trabalho->evento->nome }}</td>
                                    <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">{{ $avaliacao->plano->trabalho->titulo }}</td>
                                    <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">{{ $avaliacao->plano->titulo }}</td>
                                    <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">{{ $avaliacao->plano->participante->user->name }}</td>
                                    <td style="max-width:100px; overflow-x:hidden; text-overflow:ellipsis">{{ $avaliacao->tipo }}</td>
                                    <td>
                                        <div class="row justify-content-center">
                                            <a type="button" class="btn btn-primary" href="{{route('planos.avaliacoesUser', ['id'=>$avaliacao->id])}}">Avaliar</a>
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

    </script>
@endsection
