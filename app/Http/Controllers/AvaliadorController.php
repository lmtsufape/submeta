<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Trabalho;

class AvaliadorController extends Controller
{
	public function index(){

    	return view('avaliador.index');
    }


    public function visualizarTrabalhos(Request $request){

    	$trabalhos = Auth::user()->avaliadors->first()->trabalhos;
    	//dd($trabalhos);

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos]);

    }

    public function parecer(Request $request){

    	//$trabalho = Trabalho::find($request->trabalho_id);
    	$avaliador = Auth::user()->avaliadors->first();
    	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
			

    	return view('avaliador.parecer', ['trabalho'=>$trabalho]);
    }
    public function enviarParecer(Request $request){

    	$trabalhos = Auth::user()->avaliadors->first()->trabalhos;
    	$avaliador = Auth::user()->avaliadors->first();
    	$trabalho = $avaliador->trabalhos->find(1);
    	$avaliador->trabalhos()->updateExistingPivot($trabalho->id, 
    															['status'=> 1,
    															 'parecer'=>$request->textParecer,
    															 'AnexoParecer'=> $request->anexoParecer]);
  
    	//	dd($trabalho);

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos]);
    }
}
