<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Trabalho;
use App\Participante;

class ParticipanteController extends Controller
{
    public function index(){

    	return view('participante.index');
    }
    public function editais(){

        $eventos = Evento::all();
        return view('participante.editais', ['eventos'=> $eventos] );
    }

    public function edital($id){
        $edital = Evento::find($id);
        $trabalhosId = Trabalho::where('evento_id', '=', $id)->select('id')->get();
        $meusTrabalhosId = Participante::where('user_id', '=', Auth()->user()->id)
            ->whereIn('trabalho_id', $trabalhosId)->select('trabalho_id')->get();
        $projetos = Trabalho::whereIn('id', $meusTrabalhosId)->get();

        //dd($projetos);

        return view('participante.projetos')->with(['edital' => $edital, 'projetos' => $projetos]);
    }
}
