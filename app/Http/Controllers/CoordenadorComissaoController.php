<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\CoordenadorComissao;
use App\Avaliador;
use App\Proponente;
use App\Participante;
use Illuminate\Support\Facades\Log;

class CoordenadorComissaoController extends Controller
{
    public function index(){

    	return view('coordenadorComissao.index');
    }
    
    public function usuarios(){

    	return view('coordenadorComissao.usuarios');
    }

    public function editais(){

    	
    	$eventos = Evento::where('coordenadorId', Auth()->user()->id)->get();
        

    	return view('coordenadorComissao.editais', ['eventos'=> $eventos]);
    }
    public function coordenadorComite(){

        $usuarios = CoordenadorComissao::all();

        return view('coordenadorComissao.listarUsuarios', ['usuarios' => $usuarios]);
    }
    public function avaliador(){
        $usuarios = Avaliador::all();

        return view('coordenadorComissao.listarUsuarios', ['usuarios' => $usuarios]);
    }
    public function proponente(){
        $usuarios = Proponente::all();

        return view('coordenadorComissao.listarUsuarios', ['usuarios' => $usuarios]);
    }
    public function participante(){
        $usuarios = Participante::all();

        return view('coordenadorComissao.listarUsuarios', ['usuarios' => $usuarios]);
    }
}
