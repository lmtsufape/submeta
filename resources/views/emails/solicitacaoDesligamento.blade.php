<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
	@if($tipo == 'resultado')
        <h4>Resultado pedido de desligamento</h4>
        <p>A sua solicitação de desligamento no projeto <strong>{{$projeto->titulo}}</strong> foi analisada e o resultado você pode ser conferirido <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $projeto->evento->id, 'projeto_id' => $projeto->id])}}">aqui.</a></p>

        <p>
			Atenciosamente,
			<br>
			Equipe Submeta.
        </p>	
    @else
        <h4>Um pedido de desligamento foi solicitado</h4>
        <p>O proponente <strong>{{$projeto->proponente->user->name}}</strong> solicitou um desligamento no projeto <strong>{{$projeto->titulo}}</strong> do edital <strong>{{$edital->nome}}</strong> </p>

        <p><a href="{{route('trabalho.telaAnaliseSubstituicoes', ['trabalho_id' => $projeto->id])}}" class="">Clique aqui</a> para analisar.</p>
    @endif
</body>
</html>