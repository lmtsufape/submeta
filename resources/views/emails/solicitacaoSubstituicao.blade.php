<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
	@if($tipo == 'resultado')
        <h4>Saudações</h4>
        <p>O pedido de substituição de estudante no projeto {{$projeto->titulo}} foi analisado e obteve o seguinte resultado: {{$status}}</p>
        <p>O resultado também pode conferir-se <a href="{{route('trabalho.trocaParticipante', ['evento_id' => $projeto->evento->id, 'projeto_id' => $projeto->id])}}">aqui.</a></p>

        <p>
			Atenciosamente,
			<br>
            Universidade Federal do Agreste de Pernambuco.
        </p>	
    @else
        <h4>Saudações</h4>

        <p>O(A) proponente / coordenador(a) solicitou a substituição de
            @if($sub=="TrocarPlano")plano de trabalho @elseif(
            $sub=="ManterPLano")participante @else
                participante e plano de trabalho @endif
            no projeto {{$projeto->titulo}} do edital {{$edital->nome}}.</p>
        <p>Solicitamos gentilmente que acesse o sistema Submeta através do <a href="{{route('trabalho.telaAnaliseSubstituicoes', ['trabalho_id' => $projeto->id])}}">LINK</a> para avaliar a solicitação.</p>
        <p>
            Atenciosamente,
            <br>
            Universidade Federal do Agreste de Pernambuco.
        </p>
    @endif
</body>
</html>