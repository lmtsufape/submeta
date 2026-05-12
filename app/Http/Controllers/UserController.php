<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
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

    public function buscarCpf(Request $request, InputService $service)
    {
        $users = User::where('cpf', 'like', '%' . $request->cpf . '%')
            ->orWhere('name', 'like', '%' . $service->clearCpf($request->cpf) . '%')
            ->limit(3)
            ->get();

        return response()->json($users);
    }
}
