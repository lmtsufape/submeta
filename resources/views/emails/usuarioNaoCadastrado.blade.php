<!DOCTYPE html>
<html>
<head>

</head>
<body>
	@if($nomeFuncao == "Avaliador")
	
		<h3>Prezado(a) Avaliador(a), saudações!</h3>
		<p>
			Agradecemos seu aceite para participar da avaliação de propostas do Edital {{$nomeEvento}} da Universidade Federal do Agreste de Pernambuco (UFAPE).
			<br>Solicitamos gentilmente que acesse o sistema Submeta através do <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">LINK</a>  e da senha {{$senhaTemporaria}} para concluir seu cadastro e receber os projetos para avaliação.
			
			@if($tipoEvento == 'PIBITI')
			<br><strong>Obs:</strong>Aproveitamos para enviar os arquivos para emissão do Parecer do Projeto, bem como Termo de Confidencialidade que deverão ser compactados e anexados ao sistema.
			<br><br>Atenciosamente,
			<br>Universidade Federal do Agreste de Pernambuco
			@else
			<br><strong>Obs:</strong>Aproveitamos para enviar o formulário de avaliação que deverá ser anexado ao sistema com o seu parecer.
			<br><br>Atenciosamente,
			<br>Universidade Federal do Agreste de Pernambuco
			@endif

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
	
		<h3>Prezado(a) Avaliador(a), saudações!</h3>
		<p>
			Agradecemos seu aceite para participar da avaliação de propostas do Edital {{$nomeEvento}} da Universidade Federal do Agreste de Pernambuco (UFAPE).
			<br>Solicitamos gentilmente que acesse o sistema Submeta através do <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">LINK</a> para dar seguimentos nas avaliações.
			@if($tipoEvento == 'PIBITI')
				<br><strong>Obs:</strong>Aproveitamos para enviar os arquivos para emissão do Parecer do Projeto, bem como Termo de Confidencialidade que deverão ser compactados e anexados ao sistema.
				<br><br>Atenciosamente,
				<br>Universidade Federal do Agreste de Pernambuco
			@else
				<br><strong>Obs:</strong>Aproveitamos para enviar o formulário de avaliação que deverá ser anexado ao sistema com o seu parecer.
				<br><br>Atenciosamente,
				<br>Universidade Federal do Agreste de Pernambuco
			@endif
		</p>
	@endif
	

</body>
</html>

