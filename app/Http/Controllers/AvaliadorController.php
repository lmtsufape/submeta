<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Trabalho;
use App\Evento;
use App\Recomendacao;
use App\User;
use App\Avaliador;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AvaliadorController extends Controller
{
	public function index(){

    	return view('avaliador.index');
    }

    public function editais(Request $request){

        $user = User::find(Auth::user()->id);
        $eventos = $user->avaliadors->where('user_id',$user->id)->first()->eventos;

        return view('avaliador.editais', ["eventos"=>$eventos]);
    }


    public function visualizarTrabalhos(Request $request){

        $user = User::find(Auth::user()->id);
        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhos = $user->avaliadors->where('user_id',$user->id)->first()->trabalhos->where('evento_id', $request->evento_id);

    	//dd();

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos, 'evento'=>$evento]);

    }

    public function parecer(Request $request){

      $user = User::find(Auth::user()->id);
      $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      $trabalho = $avaliador->trabalhos->find($request->trabalho_id);
      $evento = Evento::find($request->evento);
      $recomendacaos = Recomendacao::all();
      
    	return view('avaliador.parecer', ['trabalho'=>$trabalho, 'evento'=>$evento, 'recomendacaos'=>$recomendacaos]);
    }

    public function parecerPlano(Request $request){

      $user = User::find(Auth::user()->id);
      $avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      $plano = $avaliador->planoTrabalhos->where('id', $request->plano_id)->first();
      $evento = Evento::find($request->evento);
      $recomendacaos = Recomendacao::all();
      // dd($plano);
    	return view('avaliador.parecerPlano', ['plano'=>$plano, 'evento'=>$evento, 'recomendacaos'=>$recomendacaos]);
    }
    public function enviarParecer(Request $request){

        $user = User::find(Auth::user()->id);
        

        $evento = Evento::find($request->evento_id);
        $trabalhos = $user->avaliadors->where('user_id',$user->id)->first()->trabalhos->where('evento_id', $request->evento_id);
      	$avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      	$trabalho = $avaliador->trabalhos->find($request->trabalho_id);
        $trabalho->status = 'avaliado';
        $trabalho->save();
        $data = Carbon::now('America/Recife');
    	if($request->anexoParecer == ''){  

                $avaliador->trabalhos()
                ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
    	}else{
          $anexoParecer = $request->anexoParecer;
          $path = 'anexoParecer/' . $avaliador->id . $trabalho->id . '/';
          $nome = "parecer.pdf";
          Storage::putFileAs($path, $anexoParecer, $nome);  
          $anexoParecer = $path . $nome;   

			$avaliador->trabalhos()
                ->updateExistingPivot($trabalho->id,['status'=> 1,'parecer'=>$request->textParecer,'AnexoParecer'=> $anexoParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
    	}
    	
  
    	//	dd($trabalho);

    	return view('avaliador.listarTrabalhos', ['trabalhos'=>$trabalhos, 'evento'=>$evento ]);
    }
    public function conviteResposta(Request $request){
        //dd($request->all());
        $user = User::find(Auth::user()->id);
        $evento = Evento::find($request->evento_id);
        $user->avaliadors->eventos()->updateExistingPivot($evento->id, ['convite'=> $request->resposta]);
        //dd( $user->avaliadors->eventos->where('id', $evento->id)->first()->pivot);
        return redirect()->back();
    }

    public function listarPlanos(Request $request){

        $user = User::find(Auth::user()->id);
        $evento = Evento::where('id', $request->evento_id)->first();
        $planos = $user->avaliadors->where('user_id',$user->id)->first()->planoTrabalhos;

    	//dd();

    	return view('avaliador.listarPlanos', ['planos'=>$planos, 'evento'=>$evento]);

    }

    public function enviarParecerPlano(Request $request){

        $user = User::find(Auth::user()->id);
        

        $evento = Evento::find($request->evento_id);
        $planos = $user->avaliadors->where('user_id',$user->id)->first()->planoTrabalhos;
      	$avaliador = $user->avaliadors->where('user_id',$user->id)->first();
      	$plano = $avaliador->planoTrabalhos->find($request->plano_id);
        $plano->versao = 1;
        $plano->save();
        $data = Carbon::now('America/Recife');
    	if($request->anexoParecer == ''){  

                $avaliador->planoTrabalhos()
                ->updateExistingPivot($plano->id,['status'=> 1,'parecer'=>$request->textParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
    	}else{
          $anexoParecer = $request->anexoParecer;
          $path = 'anexoParecerPlano/' . $avaliador->id . $plano->id . '/';
          $nome = "parecerPlano.pdf";
          Storage::putFileAs($path, $anexoParecer, $nome);  
          $anexoParecer = $path . $nome;   

			$avaliador->planoTrabalhos()
                ->updateExistingPivot($plano->id,['status'=> 1,'parecer'=>$request->textParecer,'AnexoParecer'=> $anexoParecer, 'recomendacao'=>$request->recomendacao, 'created_at' => $data]);
    	}
    	
  
    	//	dd($trabalho);

    	return view('avaliador.listarPlanos', ['planos'=>$planos, 'evento'=>$evento ]);
    }
}
