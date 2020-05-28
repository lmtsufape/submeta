<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrador;
use App\User;
use App\GrandeArea;
use App\Avaliador;
use App\AdministradorResponsavel;
use App\Participante;
use App\Proponente;
use Illuminate\Support\Facades\Hash;
use App\Evento;

class AdministradorController extends Controller
{
    public function index(){

    	return view('administrador.index');
    }
    public function naturezas(){

    	return view('naturezas.index');
    }
    public function usuarios(){
        $users = User::orderBy('name')->get();
    	return view('administrador.usersAdmin')->with(['users' => $users]);
    }

    public function editais(){
    	//$admin = Administrador::with('user')->where('user_id', Auth()->user()->id)->first();
    	//$eventos = Evento::where('coordenadorId',$admin->id )->get();
        $eventos = Evento::where('criador_id',Auth()->user()->id )->get();

    	return view('administrador.editais', ['eventos'=> $eventos]);
    }

    public function create() {
        $grandesAreas = GrandeArea::orderBy('nome')->get();
        return view('administrador.novo_user')->with(['grandeAreas' => $grandesAreas]);
    }

    public function salvar(Request $request) {
        if ($request->tipo != "proponente") {
            $validated = $request->validate([
                'nome' => 'required',
                'tipo' => 'required',
                'email' => 'required|unique:users',
                'senha' => 'required',
                'confirmar_senha' => 'required',
                'cpf' => 'required|cpf|unique:users',
            ]);
        } else {
            $validated = $request->validate([
                'nome' => 'required',
                'tipo' => 'required',
                'email' => 'required|unique:users',
                'senha' => 'required',
                'confirmar_senha' => 'required',
                'cpf' => 'required|cpf|unique:users',
                'cargo' => 'required',
                'titulacaoMaxima' => 'required',
                'anoTitulacao' => 'required',
                'area' => 'required',
                'bolsistaProdutividade' => 'required',
                'nivel' => 'required',
                'linkLattes' => 'required',
            ]);
        }

        if (!($request->senha === $request->confirmar_senha)) {
            return redirect()->back()->withErrors(['senha' => 'Senhas diferentes']);
        }
        
        $user = new User();
        $user->name = $request->nome;
        $user->tipo = $request->tipo;
        $user->cpf = $request->cpf;
        $user->email = $request->email;
        $user->password = bcrypt($request->senha);
        $user->save();
        

        switch ($request->tipo) {
            case "administradorResponsavel": 
                $adminResp = new AdministradorResponsavel();
                $adminResp->user_id = $user->id;
                $adminResp->save();
                break;
            case "avaliador": 
                $avaliador = new Avaliador();
                $avaliador->user_id = $user->id;
                $avaliador->save();
                break;
            case "proponente": 
                $proponente = new Proponente();
                $proponente->SIAPE = $request->SIAPE;
                $proponente->cargo = $request->cargo;
                $proponente->vinculo = $request->vinculo;
                $proponente->titulacaoMaxima = $request->titulacaoMaxima;
                $proponente->anoTitulacao = $request->anoTitulacao;
                $proponente->grandeArea = $request->area;
                $proponente->area = "teste";
                $proponente->subArea = "teste";
                $proponente->bolsistaProdutividade = $request->bolsistaProdutividade;
                $proponente->nivel = $request->nivel;
                $proponente->linkLattes = $request->linkLattes;
                $proponente->user_id = $user->id;
                $proponente->save();
                break;
            case "participante":
                $participante = new Participante();
                $participante->user_id = $user->id;
                $participante->save();
                break;
        }

        return redirect( route('admin.usuarios') )->with(['mensagem' => 'Usuário cadastrado com sucesso']);
    }

    public function edit($id) {
        $user = User::find($id);
        return view ('administrador.editar_user')->with(['user' => $user]);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        $validated = $request->validate([
            'nome' => 'required',
            'tipo' => 'required',
            'email' => 'required',
            'nova_senha' => 'required',
            'senha_atual' => 'required',
            'confirmar_senha' => 'required',
        ]);

        if (!(Hash::check($request->senha_atual, $user->password))) {
            return redirect()->back()->withErrors(['senha_atual' => 'Senha atual não correspondente']);
        }

        if (!($request->nova_senha === $request->confirmar_senha)) {
            return redirect()->back()->withErrors(['nova_senha' => 'Senhas diferentes']);
        }

        $user->name = $request->nome;
        $user->tipo = $request->tipo;
        $user->email = $request->email;
        $user->password = bcrypt($request->nova_senha);
        $user->update();

        return redirect( route('admin.usuarios') )->with(['mensagem' => 'Usuário atualizado com sucesso']);
    }

    public function destroy($id) {
        $user = User::find($id);

        $adminResp = AdministradorResponsavel::where('user_id', '=', $id)->first();
        $avaliador = Avaliador::where('user_id', '=', $id)->first();
        $proponente = Proponente::where('user_id', '=', $id)->first();
        $participante = Participante::where('user_id', '=', $id)->first();

        if (!(is_null($adminResp))) {
            $adminResp->delete();
        } else if (!(is_null($avaliador))) {
            $avaliador->delete();
        } else if (!(is_null($proponente))) {
            $proponente->delete();
        } else if (!(is_null($participante))) {
            $participante->delete();
        }

        $user->delete();
        return redirect( route('admin.usuarios') )->with(['mensagem' => 'Usuário deletado com sucesso']);
    }
}
