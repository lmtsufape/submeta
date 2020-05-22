<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {        
        if(Auth::check()){
          if(Auth::user()->tipo == 'administrador'){            
            return view('administrador.index');
          }
          else if (Auth::user()->tipo == 'administradorResponsavel') {
            return view('administradorResponsavel.index');
          }
          else if (Auth::user()->tipo == 'proponente') {
            return view('proponente.index');
          }
          else if (Auth::user()->tipo == 'participante') {
            return view('participante.index');
          }
        }
      //
        return view('home');
    }

    public function downloadArquivo(Request $request){
      return response()->download(storage_path('app/'.$request->file));
  	}
}
