<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $eventos = \App\Evento::all();        
        if(Auth::check()){
          if(Auth::user()->tipo == 'administrador'){            
            return view('administrador.index');
          }
          else if (Auth::user()->tipo == 'administradorResponsavel') {
            return view('administradorResponsavel.index');
          }
          else if (Auth::user()->tipo == 'coordenador') {
            return view('coordenadorComissao.index');
          }
          else if (Auth::user()->tipo == 'proponente') {
            return view('proponente.index');
          }
          else if (Auth::user()->has('avaliadors')) {
            return view('avaliador.index');
          }
          else if (Auth::user()->tipo == 'participante') {
            return view('participante.index');
          }
        }
        Log::debug('HomeController');
        return view('index', ['eventos' => $eventos]);
    }

    public function downloadArquivo(Request $request){
      return response()->download(storage_path('app/'.$request->file));
  	}
}
