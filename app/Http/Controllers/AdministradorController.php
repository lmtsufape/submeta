<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrador;
use App\Evento;

class AdministradorController extends Controller
{
    public function index(){

    	return view('administrador.index');
    }
    public function naturezas(){

    	return view('naturezas.index');
    }
    public function usuarios(){

    	return view('administrador.usuarios');
    }

    public function editais(){
    	//$admin = Administrador::with('user')->where('user_id', Auth()->user()->id)->first();
    	//$eventos = Evento::where('coordenadorId',$admin->id )->get();
        $eventos = Evento::where('criador_id',Auth()->user()->id )->get();

    	return view('administrador.editais', ['eventos'=> $eventos]);
    }
}
