@extends('layouts.app')

@section('content')

<div class="container">

	<div class="container" style="margin-bottom:8rem">
		<div class="row justify-content-center" style="margin-top: 2rem;">
			<div class="col-md-12 form-group" style="text-align: center">
				<h5 style="color: #1492E6; margin-top:0.5rem; font-size:25px">Página inicial</h5>
			</div>
			<div class="" style="text-align: center">
				<div class="form-group imagem_shadow" style="border-radius: 12px; padding:14px; height:200px; width:190px; margin:15px">
					<a href="{{ route('coordenador.editais') }}" style="text-decoration:none; color: inherit;">
						<img src="{{asset('img/icons/icon_meus_editais.png')}}" alt="" width="120px">
						<h5 style="color: #073763; margin-top:0.5rem; font-size:25px;">Meus editais</h5>
					</a>
				</div>
			</div>

		</div>
	</div>

		   <!--

	      <div class="col-sm-4 d-flex justify-content-center">
	         <a href="{{ route('coordenador.usuarios') }}" style="text-decoration:none; color: inherit;">
	            <div class="card text-center " style="border-radius: 30px; width: 18rem;">
	             <div class="card-body d-flex justify-content-center">
	                  <h2 style="padding-top:15px">Usuários</h2>
	               </div>
	            </div>
	         </a>
	      </div>
	   </div>
	   -->


      

</div>

@endsection
