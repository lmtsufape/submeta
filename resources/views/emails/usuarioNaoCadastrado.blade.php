<!DOCTYPE html>
<html>
<head>

</head>
<body>
	@if($nomeFuncao == "Avaliador")
	
		<h3>Prezado(a) Avaliador(a), cordiais saudações!</h3>
		<p>
			Agradecemos seu aceite para participar das avaliações de propostas de  {{$nomeEvento}} da Universidade Federal do Agreste de Pernambuco (UFAPE).
			<br>Solicitamos gentilmente que acesse o sistema Submeta através do <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">LINK</a>  e da senha {{$senhaTemporaria}}, para realizar o seu cadastro no sistema e dar seguimento na avaliação da proposta para aceite ou recusa da presente proposta.
			<br>Aproveitamos para enviar, em anexo, o formulário de avaliação que deverá ser anexado ao sistema com o seu parecer.
			<br>Qualquer dúvida, por favor, entre em contato pelo e-mail: editais.prec@ufape.edu.br

			@if($natureza == '3')
				<br>Desde já, agradecemos a disponibilidade de participar do banco de avaliadores Ad hoc de propostas de Extensão e Cultura da UFAPE.
				<br><br>Atenciosamente,
				<br>Seção de Editais e Apoios a Projetos  - PREC/UFAPE
			@else
				<br><br>Atenciosamente,
				<br>Universidade Federal do Agreste de Pernambuco
			@endif
		</p>

	@elseif($nomeFuncao == "Participante")
	
		<h3>Prezado(a)</h3>
		<p>
			{{ $nomeUsuarioPai }} convida Vossa Senhoria para integrar como Participante do projeto {{ $nomeTrabalho }} do Edital {{ $nomeEvento }}.
			Caso concorde em participar, segue a senha para se cadastrar no Sistema de Submissão de Projetos (Submeta). senha: {{$senhaTemporaria}} e o link: <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">Submeta</a>.
			<br>Desde já, a UFAPE agradece toda a atenção dispensada por Vossa Senhoria.
		</p>


	@elseif($nomeFuncao == "Avaliador-Cadastrado")

		<h3>Prezado(a) Avaliador(a), cordiais saudações!</h3>
		<p>
			Agradecemos seu aceite para participar das avaliações de propostas de  {{$nomeEvento}} da Universidade Federal do Agreste de Pernambuco (UFAPE).
			<br>Solicitamos gentilmente que acesse o sistema Submeta através do <a href="{{ url('http://sistemas.ufape.edu.br/submeta/') }}">LINK</a>  e da senha {{$senhaTemporaria}}, para realizar o seu cadastro no sistema e dar seguimento na avaliação da proposta para aceite ou recusa da presente proposta.
			<br>Aproveitamos para enviar, em anexo, o formulário de avaliação que deverá ser anexado ao sistema com o seu parecer.
			<br>Qualquer dúvida, por favor, entre em contato pelo e-mail: editais.prec@ufape.edu.br

		@if($natureza == '3')
			<br>Desde já, agradecemos a disponibilidade de participar do banco de avaliadores Ad hoc de propostas de Extensão e Cultura da UFAPE.
			<br><br>Atenciosamente,
			<br>Seção de Editais e Apoios a Projetos  - PREC/UFAPE
		@else
			<br><br>Atenciosamente,
			<br>Universidade Federal do Agreste de Pernambuco
		@endif
		</p>
	@endif
	

</body>
</html>

