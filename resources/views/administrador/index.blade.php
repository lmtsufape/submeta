@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row justify-content-center mb-4">
		<div class="col col-sm-4 col-md-4 col-lg-4 col-xl-4  text-center">
			<div class="titulo-menu">
				<h4>Área do Administrador</h4>
			</div>
		</div>
	</div>
	<div class="row justify-content-around mt-5 mb-5 row-cols-1 row-cols-sm-2 row-cols-md-3 ">
		<div class="col-sm-4 col-md-4 col-lg-4 col-xl-3 align-self-center mt-2 text-center ">
			<a href="{{ route('admin.editais') }}" style="text-decoration:none; color: inherit;">
				<i class="fas fa-folder-open  fa-5x"></i>
			</a>
			<p class="mt-2"> Editais</p>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 col-xl-3 align-self-center mt-2 text-center">
			<a href="{{ route('admin.usuarios') }}" style="text-decoration:none; color: inherit;">
				<i class="fas fa-user-circle fa-5x"></i>
			</a>
			<p class="mt-2"> Usuários</p>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 col-xl-3 align-self-center mt-2 text-center">
			<a href="{{ route('grandearea.index') }}" style="text-decoration:none; color: inherit;">
				<i class="fas fa-project-diagram fa-5x"></i>
			</a>
			<p class="mt-2"> Áreas</p>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 col-xl-3 align-self-center mt-2 text-center">
			<a href="{{ route('cursos.index') }}" style="text-decoration:none; color: inherit;">
				<i class="fas fa-graduation-cap fa-5x"></i>
			</a>
			<p class="mt-2"> Cursos</p>
		</div>
	</div>

    
	<div class="col-md-12 justify-content-around d-flex align-items-center">
		
		

		{{-- <a href="{{ route('admin.naturezas') }}" style="text-decoration:none; color: inherit;">
		</a>
		<a href="{{ route('admin.showProjetos') }}" style="text-decoration:none; color: inherit;">
		</a> --}}
			
	</div>


      

</div>

@endsection
