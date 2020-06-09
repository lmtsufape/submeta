<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
          if(Auth::user()->administradors != null){            
            return view('administrador.index');
          }
          else if (Auth::user()->AdministradorResponsavel != null) {
            return view('administradorResponsavel.index');
          }
          else if (Auth::user()->coordenadorComissao != null) {
            return view('coordenadorComissao.index');
          }
          else if (Auth::user()->proponentes != null) {
            return view('proponente.index');
          }
          else if (Auth::user()->avaliadors != null) {
            return view('avaliador.index');
          }
          else if (Auth::user()->participantes != null) {
            return view('participante.index');
          }
        }
        Log::debug('HomeController');
        return view('index', ['eventos' => $eventos]);
    }

    public function downloadArquivo(Request $request){
      return Storage::download($request->file);
  	}
}
