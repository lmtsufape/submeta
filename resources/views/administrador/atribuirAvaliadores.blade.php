@extends('layouts.app')

@section('content')

<div class="container">

    <h2 style="margin-top: 100px; ">{{ Auth()->user()->name }}</h2>
    <div class="container" >
		<div class="row justify-content-center d-flex align-items-center" >
		  
		    <h3>Edital Selecionado: {{ $evento->nome }} </h3> 

		</div>
	</div>

       <div class="row justify-content-center d-flex align-items-center">
	      <div class="col-sm-3 d-flex justify-content-center ">
	         <a href="{{route('admin.selecionar', ['evento_id' => $evento->id])}}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 13rem;height: 15rem;">
	                  <div class="card-body d-flex justify-content-center">
	                      <h2 style="padding-top:15px">Selecionar Avaliadores</h2>
	                  </div>
	                 
	            </div>
	         </a>
	      </div>

	      <div class="col-sm-3 d-flex justify-content-center">
	         <a href="{{ route('admin.projetos', ['evento_id' => $evento->id]) }}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 13rem;height: 15rem;">
	             <div class="card-body d-flex justify-content-center">
	                  <h2 style="padding-top:15px">Selecionar Projetos</h2>
	               </div>
	            </div>
	         </a>
	      </div>
	      <div class="col-sm-3 d-flex justify-content-center">
	         <a href="#" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 13rem;height: 15rem;">
	             <div class="card-body d-flex justify-content-center">
	                  <h2 style="padding-top:15px">Mensagens</h2>
	               </div>
	            </div>
	         </a>
	      </div>
	   </div>


      

</div>

@endsection
