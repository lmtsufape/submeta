<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Trabalho;
use App\Evento;
use App\Recomendacao;

class AvaliadorController extends Controller
{
	public function index(){

    	return view('avaliador.index');
    }

    public function editais(){

        $eventos = Auth()->user()->avaliadors->eventos;

        return view('avaliador.editais', ["eventos"=>$eventos]);
    }


    public function visualizarTrabalhos(Request $request){

    	$trabalhos_id = Auth::user()->avaliadors->first()->trabalhos->pluck('id');;
        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhos = $evento->trabalhos->whereIn('id', $trabalhos_id);

    	//dd($trabalhos);

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos, 'evento'=>$evento]);

    }

    public function parecer(Request $request){

    	//$trabalho = Trabalho::find($request->trabalho_id);
    	$avaliador = Auth::user()->avaliadors->first();
    	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
		$evento = Evento::find($request->evento);
        $recomendacaos = Recomendacao::all();
        //dd($request->all());
    	return view('avaliador.parecer', ['trabalho'=>$trabalho, 'evento'=>$evento, 'recomendacaos'=>$recomendacaos]);
    }
    public function enviarParecer(Request $request){

        $evento = Evento::find($request->evento_id);
    	$trabalhos = Auth::user()->avaliadors->first()->trabalhos;
    	$avaliador = Auth::user()->avaliadors->first();
    	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
    	if($request->anexoParecer == ''){
					$avaliador
                ->trabalhos()
                ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer, 'recomendacao_id'=>$request->recomendacao_id]);
    	}else{
					$avaliador
                  ->trabalhos()
                  ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer,'AnexoParecer'=> $request->anexoParecer, 'recomendacao_id'=>$request->recomendacao_id]);
    	}
    	
  
    	//	dd($trabalho);

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos, 'evento'=>$evento ]);
    }
}
