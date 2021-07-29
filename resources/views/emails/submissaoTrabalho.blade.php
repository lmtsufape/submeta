<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
	@if(isset($user->proponentes))
		@if($user->proponentes->id == $trabalho->proponente_id)
			{{-- Usuario proponente--}}
			<h2>Olá, {{ $user->name }} </h2>
			<br>
			<h4>O sistema de recepção de formulários eletrônicos do Submeta registra que em {{ date('d/m/Y \à\s  H:i\h', strtotime(now()))  }} horas, o formulário identificado acima foi recebido e reconhecido no Submeta. Seu projeto intitulado {{ $trabalho->titulo }} foi submetido com sucesso ao Edital {{ $evento->nome }}  </h4>
			<br>
			<h4>
				Atenciosamente,
				<br>
				Equipe submeta.
			</h4>	
		@endif
	@else
			{{-- Usuario participante--}}
			<h2>Olá, {{ $user->name }} </h2>
			<h4>Você é participante no Projeto {{ $trabalho->titulo }} que foi submetido no Edital {{ $evento->nome }}.  </h4>	
	@endif
	
	
</body>
</html>