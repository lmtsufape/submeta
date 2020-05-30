<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
}
