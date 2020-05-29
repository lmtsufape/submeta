<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdministradorResponsavel;
use App\User;
use App\Evento;
use App\Avaliador;

class AdministradorResponsavelController extends Controller
{
	public function index(){

    	return view('administradorResponsavel.index');
    }

    public function editais(){
    	//$admResponsavel = AdministradorResponsavel::with('user')->where('user_id', Auth()->user()->id)->first();
    	$eventos = Evento::where('criador_id',Auth()->user()->id )->get();

    	return view('administradorResponsavel.editais', ['eventos'=> $eventos]);
    }
    public function usuarios(){

    	return view('administradorResponsavel.usuarios');
    }

    public function atribuirPermissao(Request $request){

        
        $user = User::where('id', $request->user_id)->first();
        $isAvaliador = Avaliador::where('user_id', $request->user_id )->count();
        $avaliador = new Avaliador();
        $avaliador->save();
        if($isAvaliador == 0){            
            
            //$user->avaliadors()->save($user);
            $avaliador->user()->associate($user); // um avaliador tem um usuario
            $avaliador->save();
            //$user->avaliadors()->save($avaliador); //um usuario pode ter muitos avaliadores
            //$user->save();
            //$avaliador->user_id = $user->id;
            $success = true;

        }else{
            $avaliador = Avaliador::where('user_id', $request->user_id )->first();
            $avaliador->user()->dissociate($user); // um avaliador tem um usuario
            $avaliador->save();
            $success = false;
        }

        return response()->json( $success );

    }
    public function verPermissao(Request $request){

        $user = User::where('id', $request->user_id)->first();
        $isAvaliador = Avaliador::where('user_id', $request->user_id)->count();

        if($isAvaliador != 0){                
           
            $success = true;

        }else{
            
            $success = false;
        }

        

        return response()->json( [$success] );
        //return response()->json( $request->user_id );

    }


}
