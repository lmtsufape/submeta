<!DOCTYPE html>
<html>
<head>
	
</head>
<body>
		
	
	@if(isset($info))
		<h4>Lembrete para revisor, {{$user->email}}, foi atribuido para você o trabalho: {{$info}}  </h4>
	@else 
		<h4>Lembrete para revisor, {{$user->email}}  </h4>
		
	@endif
</body>
</html>