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
use App\Natureza;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Curso;
use App\AreaTematica;

class UserController extends Controller
{

    public function index()
    {
        $eventos = Evento::orderBy('created_at', 'desc')->get();
        if (Auth::check()) {
            Log::debug('UserController check');
            return redirect()->route('home');
        }
        Log::debug('UserController index');
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        return view('index', ['eventos' => $eventos, 'hoje' => $hoje]);
    }
    public function inicial()
    {
        $eventos = Evento::orderBy('created_at', 'desc')->get();
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        return view('index', ['eventos' => $eventos, 'hoje' => $hoje]);
    }


    function perfil()
    {
        $user = Auth::user();
        $cursoPart = null;
        if ($user->participantes()->exists() && $user->participantes()->first()->curso_id)
            $cursoPart = Curso::find($user->participantes()->first()->curso_id);
        $view = 'user.perfilUser';
        if ($user->tipo == 'participante')
            $view = 'user.perfilParticipante';

        $naturezas = Natureza::orderBy('nome')->get();
        $cursos = Curso::orderBy('nome')->get();
        $areaTematica = AreaTematica::orderBy('nome')->get();

        return view($view)
            ->with([
                'user' => $user,
                'cursos' => $cursos,
                'naturezas' => $naturezas,
                'cursoPart' => $cursoPart,
                'areaTematica' => $areaTematica
            ]);
    }

    function editarPerfil(Request $request)
    {
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
                'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'required' : ''],
                'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'link_lattes' : ''],

            ]);
        }

        if ($user->tipo == 'participante') {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['required_if:alterarSenhaCheckBox,on', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                // 'password' => ['required_if:alterarSenhaCheckBox,on', 'string', 'min:8', 'confirmed'],
                'cpf' => ['required', 'cpf', Rule::unique('users')->ignore($user->id)],
                'rg' => ['required', Rule::unique('participantes')->ignore($user->participantes->first()->id)],
                'celular' => ['required', 'string', 'telefone'],
                'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
                'instituicaoSelect' => ['required_without:instituicao'],
                'outroCursoEstudante' => ['required_if:cursoEstudante,Outro', 'max:255'],
                'cursoEstudante' => ['required_without:outroCursoEstudante'],
                'perfil' => ['required'],
                'linkLattes' => ['required', 'url'],
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
            //$avaliador->area_id = $request->area;
            $avaliador->naturezas()->sync($request->natureza);
            $avaliador->update();

        }

        switch ($user->tipo) {
            case "administradorResponsavel":
                $adminResp = AdministradorResponsavel::where('user_id', '=', $id)->first();
                $adminResp->user_id = $user->id;
                $adminResp->update();
                break;
            case "avaliador":
                $avaliador = Avaliador::where('user_id', '=', $id)->first();
                $avaliador->user_id = $user->id;
                //$avaliador->area_id = $request->area;
                $avaliador->areaTematicas()->sync($request->area);
                if ($user->usuarioTemp == true) {
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
                $proponente->cursos()->sync($request->curso);
                $proponente->update();
                break;
            case "participante":
                $participante = $user->participantes()->first();
                $participante->data_de_nascimento = $request->data_de_nascimento;
                $participante->linkLattes = $request->linkLattes;
                $participante->rg = $request->rg;
                if ($request->outroCursoEstudante != null) {
                    $participante->curso = $request->outroCursoEstudante;
                } else if (isset($request->cursoEstudante) && $request->cursoEstudante != "Outro") {
                    $participante->curso_id = $request->cursoEstudante;
                }
                $user->usuarioTemp = false;
                $endereco = $user->endereco;
                $endereco->cep = $request->cep;
                $endereco->uf = $request->uf;
                $endereco->cidade = $request->cidade;
                $endereco->rua = $request->rua;
                $endereco->numero = $request->numero;
                $endereco->bairro = $request->bairro;
                $endereco->complemento = $request->complemento;
                $endereco->update();
                $participante->update();
                break;
        }

        $user->name = $request->name;
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

        return redirect(route('user.perfil'))->with(['mensagem' => 'Dados atualizados com sucesso.']);
    }


    public function meusTrabalhos()
    {

        //$trabalhos = Trabalho::where('autorId', Auth::user()->id)->get();
        $proponente = Proponente::with('user')->where('user_id', Auth::user()->id)->first();
        $trabalhos = $proponente->trabalhos;
        //dd($trabalhos);

        return view('user.meusTrabalhos', [
            'trabalhos'           => $trabalhos,
            'agora'           => now(),
        ]);
    }

    public function minhaConta()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $cursoPart = null;

        if($user->participantes()->first() == null){
            $participante = Participante::create();
            $user->participantes()->save($participante);
        }

        if($user->endereco()->first() == null){
            $endereco = Endereco::create();
            $endereco->user()->save($user);

        }

        if ($user->participantes()->exists() && $user->participantes()->first()->curso_id)
            $cursoPart = Curso::find($user->participantes()->first()->curso_id);

        $adminResp = AdministradorResponsavel::where('user_id', '=', $id)->first();
        $avaliador = Avaliador::where('user_id', '=', $id)->first();
        $proponente = Proponente::where('user_id', '=', $id)->first();
        $participante = $user->participantes()->first();

        $naturezas = Natureza::orderBy('nome')->get();
        $cursos = Curso::orderBy('nome')->get();
        $areaTematica = AreaTematica::orderBy('nome')->get();

        $view = 'user.perfilUser';
        if ($user->tipo == 'participante')
            $view = 'user.perfilParticipante';

        return view($view)
            ->with([
                'user' => $user,
                'adminResp' => $adminResp,
                'avaliador' => $avaliador,
                'proponente' => $proponente,
                'participante' => $participante,
                'cursos' => $cursos,
                'naturezas' => $naturezas,
                'cursoPart' => $cursoPart,
                'areaTematica' => $areaTematica
            ]);
    }
}
