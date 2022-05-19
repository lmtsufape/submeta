<?php

namespace App\Http\Controllers;

use App\Arquivo;
use App\AvaliacaoRelatorio;
use App\Avaliador;
use App\Evento;
use App\Trabalho;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class AvaliacaoRelatorioController extends Controller
{

    public function create()
    {

    }


    public function listarUser(Request $request){

        $planos = Arquivo::where('trabalhoId',$request->trabalho_id)->get();
        $avaliacoes = AvaliacaoRelatorio::where('user_id',$request->user_id)->get();
        $trabalho = Trabalho::find($request->trabalho_id);
        $evento = $trabalho->evento;
        $hoje = \Carbon\Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        if($evento->dt_fimRelatorioParcial < $hoje && $hoje<$evento->dt_inicioRelatorioFinal){
            $tipoRelatorio="Parcial";
        }else{
            $tipoRelatorio="Final";
        }

        return view('avaliacaoRelatorio.listar', ["avaliacoes"=>$avaliacoes,"trabalho"=>$trabalho,"planos"=>$planos,"evento"=>$evento,"tipoRelatorio"=>$tipoRelatorio]);
    }

    public function index(Request $request){

        $avaliacoes = AvaliacaoRelatorio::where('user_id',Auth::user()->id)->get();
        $hoje = \Carbon\Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();

        return view('avaliacaoRelatorio.index', ["avaliacoes"=>$avaliacoes,"hoje"=>$hoje]);
    }

    public function listarProjeto(Request $request){

        $planos = Arquivo::where('trabalhoId',$request->trabalho_id)->get();
        $avaliacoes = AvaliacaoRelatorio::where('user_id',$request->user_id)->get();
        $trabalho = Trabalho::find($request->trabalho_id);

        return view('avaliacaoRelatorio.listar', ["avaliacoes"=>$avaliacoes,"trabalho"=>$trabalho,"planos"=>$planos]);
    }

    public function listarGeral(Request $request){

        $planos = Arquivo::all();
        $avaliacoes = AvaliacaoRelatorio::where('user_id',$request->user_id)->get();

        return view('avaliacaoRelatorio.listar', ["avaliacoes"=>$avaliacoes,"planos"=>$planos]);
    }



    public function criar(Request  $request){
        $validatedData = $request->validate([
            'nota'      => ['required', 'integer',],
            'comentario'     => ['required'],
        ]);
        $avaliacao = AvaliacaoRelatorio::find($request->avaliacao_id);

        if($request->arquivo !=null){
            $pasta = 'planoTrabalho/' . $request->plano_id . 'avaliacao/' . $request->avaliacao_id;
            $avaliacao->arquivoAvaliacao = Storage::putFileAs($pasta, $request->arquivo, "AvaliacaoRelatorio.pdf");

        }
        $plano = Arquivo::find($request->plano_id);
        $avaliacao->nota = $request->nota;
        $avaliacao->comentario = $request->comentario;
        $avaliacao->update();

        $planos = Arquivo::where('trabalhoId',$request->trabalho_id)->get();
        $avaliacoes = AvaliacaoRelatorio::where('user_id',$request->user_id)->get();
        $trabalho = Trabalho::find($request->trabalho_id);
        $evento = $trabalho->evento;
        $hoje = \Carbon\Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        if($evento->dt_fimRelatorioParcial < $hoje && $hoje<$evento->dt_inicioRelatorioFinal){
            $tipoRelatorio="Parcial";
        }else{
            $tipoRelatorio="Final";
        }

        return view('avaliacaoRelatorio.listar', ["avaliacoes"=>$avaliacoes,"trabalho"=>$trabalho,"planos"=>$planos,"evento"=>$evento,"tipoRelatorio"=>$tipoRelatorio,
            'sucesso' => 'Avaliação do relatório '.$tipoRelatorio." do plano ".$plano->titulo.' realizada com sucesso.']);
    }

    public function atribuicaoAvaliador(Request  $request){

        $trabalho = Trabalho::find($request->trabalho_id);
        foreach ($trabalho->participantes as $participante){
            $avaliadoresId= $request->input('avaliadores_'.$participante->planoTrabalho->id.'_id');
            // utilizado desta forma pois a versão do PHP 7.2 é preciso que o $array usado na função count($array) não pode ser um valor NULL.
            $numeroDeItens = is_countable( $avaliadoresId ) ? count( $avaliadoresId ) : 0;

            for ($i = 0; $i < $numeroDeItens; $i++){
                $avaliacao = AvaliacaoRelatorio::create([
                    'tipo'=>$request->tipo_relatorio,
                    'comentario'=>'',
                    'nota'=>null,
                    'user_id'=>$avaliadoresId[$i],
                    'arquivo_id'=>$participante->planoTrabalho->id,
                ]);
                $avaliacao->save();
                if(Avaliador::where('user_id',$avaliadoresId[$i])->get()->count()==0){
                    $userTemp = User::find($avaliadoresId[$i]);
                    if($userTemp->instituicao==null || $userTemp->instituicao == "UFAPE" || $userTemp->instituicao == "Universidade Federal do Agreste de Pernambuco"){
                        $tipoAvaliador = "Interno";
                    }else{
                        $tipoAvaliador = "Externo";
                    }
                    $avaliador = new Avaliador();
                    $avaliador->tipo = $tipoAvaliador;
                    $avaliador->user_id = $avaliadoresId[$i];
                    $avaliador->save();
                }
            }
        }
        return redirect()->back();
    }

}
