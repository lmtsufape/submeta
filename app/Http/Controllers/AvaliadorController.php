<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Trabalho;
use App\Evento;
use App\Recomendacao;
use App\User;
use App\Avaliador;

class AvaliadorController extends Controller
{
	public function index(){

    	return view('avaliador.index');
    }

    public function editais(){

        $user = User::find(Auth::user()->id);
        $eventos = $user->avaliadors->where('user_id',$user->id)->first()->eventos;

        return view('avaliador.editais', ["eventos"=>$eventos]);
    }


    public function visualizarTrabalhos(Request $request){

        $user = User::find(Auth::user()->id);
        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhos = $user->avaliadors->where('user_id',$user->id)->first()->trabalhos;

    	//dd();

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos, 'evento'=>$evento]);

    }

    public function parecer(Request $request){

    	//$trabalho = Trabalho::find($request->trabalho_id);
        $user = User::find(Auth::user()->id);
    	$avaliador = $user->avaliadors->where('user_id',$user->id)->first();
    	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
		$evento = Evento::find($request->evento);
        $recomendacaos = Recomendacao::all();
        //dd($request->all());
    	return view('avaliador.parecer', ['trabalho'=>$trabalho, 'evento'=>$evento, 'recomendacaos'=>$recomendacaos]);
    }
    public function enviarParecer(Request $request){

        $user = User::find(Auth::user()->id);
        

        $evento = Evento::find($request->evento_id);
    	$trabalhos = $user->avaliadors->where('user_id',$user->id)->first()->trabalhos;
    	$avaliador = $user->avaliadors->where('user_id',$user->id)->first();
    	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
    	if($request->anexoParecer == ''){
					$avaliador
                ->trabalhos()
                ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer, 'recomendacao'=>$request->recomendacao]);
    	}else{
					$avaliador
                  ->trabalhos()
                  ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer,'AnexoParecer'=> $request->anexoParecer, 'recomendacao'=>$request->recomendacao]);
    	}
    	
  
    	//	dd($trabalho);

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos, 'evento'=>$evento ]);
    }
}
