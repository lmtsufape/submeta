<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use App\User;
use App\Trabalho;
use App\Proponente;
use App\Evento;
use Carbon\Carbon;

class ProponenteController extends Controller
{
    public function index(){

    	return view('proponente.index');
    }

    public function create(){
        return view('proponente.cadastro')->with(['mensagem' => 'Preencha o seguinte formulário para poder submeter algum projeto.']);;
    }
    public function editais(){

        $eventos = Evento::all();
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        return view('proponente.editais', ['eventos'=> $eventos, 'hoje'=>$hoje] );
    }

    public function store(Request $request){
        if (Auth()->user()->proponentes == null) {

            $validated = $request->validate([
                'cargo' => 'required',
                'vinculo' => 'required',
                'outro' => ['required_if:vinculo,Outro'],
                'titulacaoMaxima' => ['required_with:anoTitulacao,areaFormacao,bolsistaProdutividade,linkLattes'],
                'titulacaoMaxima' => Rule::requiredIf( (isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo']=== 'Pós-doutorando')),
                'anoTitulacao'=> ['required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes'],
                'anoTitulacao' => Rule::requiredIf( (isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
                'areaFormacao'=> ['required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes'],
                'areaFormacao' => Rule::requiredIf( (isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
                'bolsistaProdutividade'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes'],
                'bolsistaProdutividade' => Rule::requiredIf( (isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
                'nivel' => ['required_if:bolsistaProdutividade,sim'],
                //'nivel' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'required':''],
                'linkLattes'=> ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
                'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'required':''],
                'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'link_lattes':''],
            ]);

            if($request['cargo'] === "Estudante" && $request['vinculo'] !== "Pós-doutorando"){
                return redirect( route('proponente.create'))->with(['mensagem' => 'Operação não permitida para seu perfil']);
            }else{
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
                //$user->tipo = "proponente";
                $user->save();

                $eventos = Evento::all();
                return redirect( route('home'))->with(['mensagem' => 'Cadastro feito com sucesso! Você já pode criar projetos']);
            }
        }else{
            return redirect( route('proponente.create'))->with(['mensagem' => 'Você já é proponente!']);
        }


    }

    public function projetosDoProponente(Request $request) {
        if($request->buscar == null){
            $proponente = Proponente::where('user_id', Auth()->user()->id)->first();

            $projetos = Trabalho::where('proponente_id', $proponente->id)->get();
            $hoje = Carbon::today('America/Recife');
            $hoje = $hoje->toDateString();

            return view('proponente.projetos')->with(['projetos' => $projetos, 'hoje'=>$hoje, 'busca'=>$request->buscar, 'flag'=>'false']);
        }else{
            $proponente = Proponente::where('user_id', Auth()->user()->id)->first();
            
            $projetos = Trabalho::where('proponente_id','=',$proponente->id)->where('titulo','ilike','%'.$request->buscar.'%')->get();
            
            $hoje = Carbon::today('America/Recife');
            $hoje = $hoje->toDateString();

            return view('proponente.projetos')->with(['projetos' => $projetos, 'hoje'=>$hoje, 'busca'=>$request->buscar, 'flag'=>'true']);
        }
        
    }
    public function projetosEdital($id) {
      $edital = Evento::find($id);
      $projetos = Trabalho::where('evento_id', '=', $id)->orderBy('titulo')->get();
      $hoje = Carbon::today('America/Recife');
      $hoje = $hoje->toDateString();

      return view('proponente.projetosEdital')->with(['edital' => $edital, 'projetos' => $projetos, 'hoje'=>$hoje]);
    }
}
