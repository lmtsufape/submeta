<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Proponente;
use App\GrandeArea;
use App\Evento;

class ProponenteController extends Controller
{
    public function index(){

    	return view('proponente.index');
    }

    public function create(){
        return view('proponente.cadastro');
    }

    public function store(Request $request){
        if (Auth::user()->proponentes == null) {
            
            $validated = $request->validate([                   
                'cargo' => 'required',
                'vinculo' => 'required',
                'titulacaoMaxima' => 'required',
                'anoTitulacao' => 'required',
                'areaFormacao' => 'required',                
                'bolsistaProdutividade' => 'required',
                'linkLattes' => 'required',
            ]);

            $proponente = new Proponente();
            $proponente->SIAPE = $request->SIAPE;
            $proponente->cargo = $request->cargo;
            $proponente->vinculo = $request->vinculo;
            $proponente->titulacaoMaxima = $request->titulacaoMaxima;
            $proponente->anoTitulacao = $request->anoTitulacao;
            $proponente->areaFormacao = $request->areaFormacao;            
            $proponente->bolsistaProdutividade = $request->bolsistaProdutividade;
            $proponente->nivel = $request->nivel;
            $proponente->linkLattes = $request->linkLattes;
            $proponente->user_id = Auth::user()->id;
            $proponente->save();
            
            $user = User::find(Auth()->user()->id); 
            $user->tipo = "proponente";
            $user->save();
    
        }

        $eventos = Evento::all();
        return redirect( route('admin.editais', ['eventos'=> $eventos]))->with(['mensagem' => 'Usuário cadastrado com sucesso']);
    }
}
