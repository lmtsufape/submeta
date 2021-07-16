<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\AdministradorResponsavel;
use App\Avaliador;
use App\Proponente;
use App\Participante;
use App\Endereco;
use App\Trabalho;
use App\Coautor;
use App\Evento;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
      $eventos = Evento::orderBy('created_at', 'desc')->get();
      dd($eventos);
      if(Auth::check()){
        Log::debug('UserController check');
        return redirect()->route('home');
      }
      Log::debug('UserController index');
      $hoje = Carbon::today('America/Recife');
      $hoje = $hoje->toDateString();
      return view('index', ['eventos' => $eventos, 'hoje' => $hoje]);
      //return view('auth.login');
    }
    public function inicial()
    {
      $eventos = Evento::orderBy('created_at', 'desc')->get();
      $hoje = Carbon::today('America/Recife');
      $hoje = $hoje->toDateString();
      return view('index', ['eventos' => $eventos, 'hoje' => $hoje]);
      //return view('auth.login');
    }


    function perfil(){
        $user = User::find(Auth::user()->id);

        return view('user.perfilUser',['user'=>$user]);
    }
    
    function editarPerfil(Request $request){
        $id = Auth()->user()->id;
        $user = User::find($id);
        if ($request->tipo != "proponente") {
            
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
                'instituicaoSelect' => ['required_without:instituicao'],
                'celular' =>  ['required', 'string'],
                'cpf' => ['required', 'cpf'],
            ]);
        } else {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                //'email' => ['required', 'string', 'email', 'max:255'],
                'cpf' => ['required', 'cpf'],
                'celular' => ['required', 'string'],
                'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
                'instituicaoSelect' => ['required_without:instituicao'],
                'cargo' => ['required'],
                'vinculo' => ['required'],
                'outro' => ['required_if:vinculo,Outro'],
                'titulacaoMaxima' => ['required_with:anoTitulacao,areaFormacao,bolsistaProdutividade'],
                'titulacaoMaxima' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
                'anoTitulacao' => ['required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes'],
                'anoTitulacao' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
                'areaFormacao' => ['required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes'],
                'areaFormacao' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
                'bolsistaProdutividade' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes'],
                'bolsistaProdutividade' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
                'nivel' => ['required_if:bolsistaProdutividade,sim'],
                // 'nivel' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'required':''],
                'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
                'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'required':''],
                'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'link_lattes':''],
            
                ]);
        }

        if ($request->alterarSenhaCheckBox != null) {
            if (!(Hash::check($request->senha_atual, $user->password))) {
                return redirect()->back()->withErrors(['senha_atual' => 'Senha atual não correspondente']);
            }

            if (!($request->nova_senha === $request->confirmar_senha)) {
                return redirect()->back()->withErrors(['nova_senha' => 'Senhas diferentes']);
            }
        
        }
        if($user->avaliadors != null && $request->area != null && $user->tipo == "avaliador"){
          $avaliador = Avaliador::where('user_id', '=', $id)->first();
          $avaliador->user_id = $user->id;
          $avaliador->area_id = $request->area;
          $avaliador->update();
        }

        switch ($request->tipo) {
            case "administradorResponsavel":
                $adminResp = AdministradorResponsavel::where('user_id', '=', $id)->first();
                $adminResp->user_id = $user->id;
                $adminResp->update();
                break;
            case "avaliador":
                $avaliador = Avaliador::where('user_id', '=', $id)->first();
                $avaliador->user_id = $user->id;
                $avaliador->area_id = $request->area;
                if($user->usuarioTemp == true){
                    $user->usuarioTemp = false;
                  }
                $avaliador->update();
                break;
            case "proponente":
                $proponente = Proponente::where('user_id', '=', $id)->first();
                if ($request->SIAPE != null) {
                    $proponente->SIAPE = $request->SIAPE;
                }
                $proponente->cargo = $request->cargo;

                if ($request->vinculo != 'Outro') {
                    $proponente->vinculo = $request->vinculo;
                } else {
                    $proponente->vinculo = $request->outro;
                }

                $proponente->titulacaoMaxima = $request->titulacaoMaxima;
                $proponente->anoTitulacao = $request->anoTitulacao;
                $proponente->areaFormacao = $request->areaFormacao;
                $proponente->bolsistaProdutividade = $request->bolsistaProdutividade;
                if ($request->bolsistaProdutividade == 'sim') {
                    $proponente->nivel = $request->nivel;
                }
                $proponente->linkLattes = $request->linkLattes;

                $proponente->user_id = $user->id;
                $proponente->update();
                break;
            case "participante":
                $participante = Participante::where('user_id', '=', $id)->first();
                //$participante = $user->participantes->where('user_id', Auth::user()->id)->first();
                $participante->user_id = $user->id;
                //dd($participante);
                if($user->usuarioTemp == true){
                    $user->usuarioTemp = false;
                }

                $participante->update();

                break;
        }

        $user->name = $request->name;
        $user->tipo = $request->tipo;
       // $user->email = $request->email;
        $user->cpf = $request->cpf;
        $user->celular = $request->celular;
        if ($request->instituicao != null) {
            $user->instituicao = $request->instituicao;
        } else if (isset($request->instituicaoSelect) && $request->instituicaoSelect != "Outra") {
            $user->instituicao = $request->instituicaoSelect;
        }

        if ($request->alterarSenhaCheckBox != null) {
            $user->password = bcrypt($request->nova_senha);
        }


        $user->update();

        return redirect( route('user.perfil') )->with(['mensagem' => 'Dados atualizados com sucesso.']);
    }


    public function meusTrabalhos(){

        //$trabalhos = Trabalho::where('autorId', Auth::user()->id)->get();
        $proponente = Proponente::with('user')->where('user_id', Auth::user()->id)->first();
        $trabalhos = $proponente->trabalhos;
        //dd($trabalhos);

        return view('user.meusTrabalhos',[
                                           'trabalhos'           => $trabalhos,
                                        ]);
    }

    public function minhaConta() {
        $id = Auth::user()->id;
        $user = User::find($id);

        $adminResp = AdministradorResponsavel::where('user_id', '=', $id)->first();
        $avaliador = Avaliador::where('user_id', '=', $id)->first();
        $proponente = Proponente::where('user_id', '=', $id)->first();
        $participante = Participante::where('user_id', '=', $id)->first();

        return view('user.perfilUser')->with(['user' => $user,
                                              'adminResp' => $adminResp,
                                              'avaliador' => $avaliador,
                                              'proponente' => $proponente,
                                              'participante' => $participante]);
    }
}
