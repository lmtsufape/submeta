@extends('layouts.app')

@section('content')

<div class="container">

    <h2 style="margin-top: 100px; ">Administrador</h2>

       <div class="row justify-content-center d-flex align-items-center">
	      <div class="col-sm-4 d-flex justify-content-center ">
	         <a href="{{route('evento.listar')}}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 18rem; height: 12rem;">
	                  <div class="card-body d-flex justify-content-center">
	                      <h2 style="padding-top:15px">Pró-Reitor</h2>
	                  </div>
	                 
	            </div>
	         </a>
	      </div>

	      <div class="col-sm-4 d-flex justify-content-center">
	         <a href="#" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 18rem; height: 12rem;">
	             <div class="card-body d-flex justify-content-center">
	                  <h2 style="padding-top:15px">Coordenador de Comitê de Avaliação</h2>
	               </div>
	            </div>
	         </a>
	      </div>
	      <div class="col-sm-4 d-flex justify-content-center">
	         <a href="#" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 18rem; height: 12rem;">
	             <div class="card-body d-flex justify-content-center">
	                  <h2 style="padding-top:15px">Avaliador</h2>
	               </div>
	            </div>
	         </a>
	      </div>
	      <div class="col-sm-4 d-flex justify-content-center">
	         <a href="#" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 18rem; height: 12rem;">
	             <div class="card-body d-flex justify-content-center">
	                  <h2 style="padding-top:15px">Proponente</h2>
	               </div>
	            </div>
	         </a>
	      </div>
	      <div class="col-sm-4 d-flex justify-content-center">
	         <a href="#" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 18rem; height: 12rem;">
	             <div class="card-body d-flex justify-content-center">
	                  <h2 style="padding-top:15px">Participante</h2>
	               </div>
	            </div>
	         </a>
	      </div>
	   </div>


      

</div>

@endsection
