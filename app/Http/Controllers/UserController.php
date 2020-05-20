<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Endereco;
use App\Trabalho;
use App\Coautor;

class UserController extends Controller
{
    //
    function perfil(){
        $user = User::find(Auth::user()->id);
        $end = $user->endereco;
        return view('user.perfilUser',['user'=>$user,'end'=>$end]);
    }
    function editarPerfil(Request $request){
        
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required',
            'celular' => 'required|string',
            'instituicao' => 'required|string| max:255',
            // 'especProfissional' => 'nullable|string',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string',
            'cep' => 'required|integer',
        ]);

        if(Auth()->user()->usuarioTemp == true){
            
            // criar endereço
            $end = new Endereco();
            $end->rua = $request->input('rua');
            $end->numero = $request->input('numero');
            $end->bairro = $request->input('bairro');
            $end->cidade = $request->input('cidade');
            $end->uf = $request->input('uf');
            $end->cep = $request->input('cep');

            $end->save();

            // Atualizar dados não preenchidos de User
            $user = User::find($request->id);
            $user->name = $request->input('name');
            $user->cpf = $request->input('cpf');
            $user->celular = $request->input('celular');
            $user->instituicao = $request->input('instituicao');
            // $user->especProfissional = $request->input('especProfissional');
            $user->usuarioTemp = null;
            $user->enderecoId = $end->id;
            $user->save();

            return redirect(route('home'));
            
        }

        else {
            
            // User
            $user = User::find($request->id);
            $user->name = $request->input('name');
            $user->cpf = $request->input('cpf');
            $user->celular = $request->input('celular');
            $user->instituicao = $request->input('instituicao');
            // $user->especProfissional = $request->input('especProfissional');
            $user->usuarioTemp = null;
            $user->save();

            // endereço
            $end = Endereco::find($user->enderecoId);
            $end->rua = $request->input('rua');
            $end->numero = $request->input('numero');
            $end->bairro = $request->input('bairro');
            $end->cidade = $request->input('cidade');
            $end->uf = $request->input('uf');
            $end->cep = $request->input('cep');

            $end->save();
            // dd([$user,$end]);
            return redirect(route('home'));

        }
    }


    public function meusTrabalhos(){

        $trabalhos = Trabalho::where('autorId', Auth::user()->id)->get();
        return view('user.meusTrabalhos',[
                                            'trabalhos'           => $trabalhos,
                                        ]);
    }
}
