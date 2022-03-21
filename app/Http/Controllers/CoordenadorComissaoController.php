<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Evento;
use App\CoordenadorComissao;
use App\Avaliador;
use App\Desligamento;
use App\Mail\SolicitacaoDesligamento;
use App\Notificacao;
use App\Proponente;
use App\Participante;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CoordenadorComissaoController extends Controller
{
    public function index(){

    	return view('coordenadorComissao.index');
    }
    
    public function usuarios(){

    	return view('coordenadorComissao.usuarios');
    }

    public function editais(){

    	$coordenador = CoordenadorComissao::with('user')->where('user_id', Auth()->user()->id)->first();
    	$eventos = Evento::where('coordenadorId',$coordenador->id )->get();
        
        //dd($eventos);
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
    public function listarTrabalhos(Request $request){
        
        $evento = Evento::where('id',$request->evento_id )->first();
        $trabalhos = $evento->trabalhos;
        dd($trabalhos);
        return view('coordenadorComissao.listarTrabalhos', ['trabalhos' => $trabalhos]);
    }
    public function detalhesEdital(Request $request){
        
        $evento = Evento::where('id',$request->evento_id )->first();
        $trabalhos = $evento->trabalhos;

        return view('coordenadorComissao.detalhesEdital', ['evento' => $evento]);
    }
    public function retornoDetalhes(Request $request){

        // array:2 [▼
        //   "item" => "listarTrabalhos"
        //   "evento_id" => "1"
        // ]

        //dd($request->all());
        if($request->item == "definirSubmissoes" ){

        }else if($request->item == "listarTrabalhos" ){
            $evento = Evento::where('id',$request->evento_id )->first();
            $trabalhos = $evento->trabalhos;
            //dd($trabalhos);
            //return redirect()->route('coordenador.listarTrabalhos', ['trabalhos' => $trabalhos]);
            return view('coordenadorComissao.gerenciarEdital.listarTrabalhos', ['trabalhos' => $trabalhos]);

        }else if($request->item == "cadastrarAreas" ){

            return view('coordenadorComissao.gerenciarEdital.cadastrarAreas', ['trabalhos' => $trabalhos]);

        }else if($request->item == "listarAreas" ){
                $evento = Evento::where('id',$request->evento_id )->first();
                $trabalhos = $evento->trabalhos;
            return view('coordenadorComissao.gerenciarEdital.listarAreas', ['trabalhos' => $trabalhos]);

        }else if($request->item == "cadastrarRevisores" ){

            return view('coordenadorComissao.gerenciarEdital.cadastrarRevisores', ['trabalhos' => $trabalhos]);

        }else if($request->item == "listarRevisores" ){

            $avaliadores = Avaliador::all();
 
            return view('coordenadorComissao.gerenciarEdital.listarRevisores', ['avaliadores' => $avaliadores]);

        }else if($request->item == "definirCoordenador" ){

            return view('coordenadorComissao.gerenciarEdital.definirCoordenador', ['trabalhos' => $trabalhos]);

        }else if($request->item == "listarComissao" ){

            return view('coordenadorComissao.gerenciarEdital.listarComissao', ['trabalhos' => $trabalhos]);

        }
        
        
        
    }

    public function respostaDesligamento(Request $request)
    {
        $desligamento = Desligamento::find($request->desligamento);
        $desligamento->status = intval($request->opcao); 
        $desligamento->update();

        if($desligamento->status == Desligamento::STATUS_ENUM['aceito']){
            $desligamento->participante->delete();
        }

        $notificacao = Notificacao::create([
            'remetente_id' => Auth::user()->id,
            'destinatario_id' => $desligamento->trabalho->proponente_id,
            'trabalho_id' => $desligamento->trabalho->id,
            'lido' => false,
            'tipo' => 6,
        ]);
        $notificacao->save();

        Mail::to($desligamento->trabalho->proponente->user->email)->send(new SolicitacaoDesligamento($desligamento->trabalho->evento, $desligamento->trabalho, "resultado"));

        return redirect()->back()->with(['sucesso' => 'Desligamento '.$desligamento->getStatus().' com sucesso.']);

    }

}
