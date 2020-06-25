<!DOCTYPE html>
<html>
<head>

</head>
<body>
	@if($nomeFuncao == "Avaliador")
	
		<h3>Prezado(a) Pesquisador(a)</h3>
		<p>
			A Universidade Federal do Agreste de Pernambuco (UFAPE) convida Vossa Senhoria para participar como Avaliador de projetos do Edital {{ $nomeEvento }}.
			Caso concorde em participar, segue a senha para se cadastrar no Sistema de Submissão de Projetos (Submeta). senha: {{$senhaTemporaria}} e o link: <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">Submeta</a> 
			<br>Desde já, a UFAPE agradece toda a atenção dispensada por Vossa Senhoria.
		</p>
	@endif
	@if($nomeFuncao == "Participante")
	
		<h3>Prezado(a)</h3>
		<p>
			{{ $nomeUsuarioPai }} convida Vossa Senhoria para integrar como Participante do projeto {{ $nomeTrabalho }} do Edital {{ $nomeEvento }}.
			Caso concorde em participar, segue a senha para se cadastrar no Sistema de Submissão de Projetos (Submeta). senha: {{$senhaTemporaria}} e o link: <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">Submeta</a>.
			<br>Desde já, a UFAPE agradece toda a atenção dispensada por Vossa Senhoria.
		</p>
	@endif
	@if($nomeFuncao == "Avaliador-Cadastrado")
	
		<h3>Prezado(a)</h3>
		<p>
			{{ $nomeUsuarioPai }} convida Vossa Senhoria para participar como Avaliador de projetos do Edital {{ $nomeEvento }}.
			Caso concorde em participar, segue o link: <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">Submeta</a> para confirmar o convite.
			<br>Desde já, a UFAPE agradece toda a atenção dispensada por Vossa Senhoria.
		</p>
	@endif
	

</body>
</html>

