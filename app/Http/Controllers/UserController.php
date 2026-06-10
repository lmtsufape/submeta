<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\InputService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\AdministradorResponsavel;
use App\Avaliador;
use App\Proponente;
use App\Participante;
use App\Endereco;
use App\Evento;
use App\Natureza;
use Carbon\Carbon;
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

    function editarPerfil(UpdateProfileRequest $request, UserService $service)
    {
        $service->updateProfile($request->user(), $request->validated());

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

    //busca cpf para mostrar user na substituicao
    public function buscarCpf(Request $request)//coisa de service mas fica pra depois
    {
        $user = User::where('cpf', 'like', '%' . InputService::formatarCpf($request->cpf) . '%')
            ->limit(1)
            ->first();

        if($user){
            if($request->excludeId){//usado para evitar sugerir o mesmo cpf do part. a ser substituido para o caso de substituicao
                $participante = Participante::find($request->excludeId);
                if($participante->user_id != $user->id) {//apenas para nao procurar o cpf do usuario atual na substituicao
                    return response()->json($user);
                }
          } else {
                return response()->json($user);
            }
        }

        return response()->json(null); //para ter certeza
    }
}
