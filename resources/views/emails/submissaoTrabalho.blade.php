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
			<h4>Seu trabalho {{ $trabalho->titulo }} foi submetido com sucesso no Edital {{ $evento->nome }}  </h4>
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