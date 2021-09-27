<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
	@if($tipo == 'resultado')
        <h4>Resultado pedido de substituição</h4>
        <p>A sua solicitação de substituição no projeto <strong>{{$projeto->titulo}}</strong> foi analisada e o resultado você pode conferir <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $projeto->evento->id, 'projeto_id' => $projeto->id])}}">aqui.</a></p>

        <p>
			Atenciosamente,
			<br>
			Equipe submeta.
        </p>	
    @else
        <h4>Um pedido de substituição foi solicitado</h4>
        <p>O proponente <strong>{{$projeto->proponente->user->name}}</strong> solicitou uma substituição no projeto <strong>{{$projeto->titulo}}</strong> do edital <strong>{{$edital->nome}}</strong> </p>

        <p><a href="{{route('trabalho.telaAnaliseSubstituicoes', ['trabalho_id' => $projeto->id])}}" class="">Clique aqui</a> para analisar.</p>
    @endif
</body>
</html>