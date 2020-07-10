<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrador;
use App\User;
use App\Avaliador;
use App\AdministradorResponsavel;
use App\Participante;
use App\Proponente;
use App\Natureza;
use App\Trabalho;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Evento;
use App\CoordenadorComissao;
use Illuminate\Validation\Rule;
use App\Mail\EmailParaUsuarioNaoCadastrado;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventoCriado;

class AdministradorController extends Controller
{
    public function index(){

    	return view('administrador.index');
    }
    public function naturezas(){
        $naturezas = Natureza::orderBy('nome')->get();
    	return view('naturezas.index')->with(['naturezas' => $naturezas]);
    }
    public function usuarios(){
        $users = User::orderBy('name')->get();
    	return view('administrador.usersAdmin')->with(['users' => $users]);
    }

    public function editais(){
    	//$admin = Administrador::with('user')->where('user_id', Auth()->user()->id)->first();
    	//$eventos = Evento::where('coordenadorId',$admin->id )->get();
        $eventos = Evento::all();

    	return view('administrador.editais', ['eventos'=> $eventos]);
    }

    public function pareceres(Request $request){
        
        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhos = $evento->trabalhos;

        return view('administrador.projetos')->with(['trabalhos' => $trabalhos, 'evento' => $evento]);
    }

    public function visualizarParecer(Request $request){
        
        $avaliador = Avaliador::find($request->avaliador_id);
        $trabalho = $avaliador->trabalhos->where('id', $request->trabalho_id)->first();
        $parecer = $avaliador->trabalhos->where('id', $request->trabalho_id)->first()->pivot;

        //dd($parecer);
        return view('administrador.visualizarParecer')->with(['trabalho' => $trabalho, 'parecer' => $parecer, 'avaliador' => $avaliador]);
    }

    public function create() {    
        return view('administrador.novo_user');
    }

    public function salvar(Request $request) {
        
        if ($request->tipo != "proponente") {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'tipo' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
                'instituicaoSelect' => ['required_without:instituicao'],
                'celular' => ['required', 'string', 'telefone'],
                'senha' => ['required', 'string', 'min:8', 'confirmed'],
                'cpf' => ['required', 'cpf', 'unique:users'],
            ]);
        } else {
            $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tipo' => ['required'],
            'cpf' => ['required', 'cpf', 'unique:users'],
            'celular' => ['required', 'string', 'telefone'],
            'senha' => ['required', 'string', 'min:8', 'confirmed'],
            'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
            'instituicaoSelect' => ['required_without:instituicao'],
            'cargo' => ['required'],
            'vinculo' => ['required'],
            'outro' => ['required_if:vinculo,Outro'],
            'titulacaoMaxima' => ['required_with:anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'titulacaoMaxima' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'anoTitulacao' => ['required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes'],
            'anoTitulacao' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'areaFormacao' => ['required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes'],
            'areaFormacao' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'bolsistaProdutividade' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes'],
            'bolsistaProdutividade' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'nivel' => ['required_if:bolsistaProdutividade,sim'],
            //'nivel' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],            
                'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],            
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],            
            'linkLattes' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'link_lattes':''],
            ]);
        }
        
        $user = new User();
        $user->name = $request->name;
        $user->tipo = $request->tipo;
        $user->cpf = $request->cpf;
        $user->celular = $request->celular;
        $user->email = $request->email;
        $user->password = bcrypt($request->senha);
        if ($request->instituicao != null) {
            $user->instituicao = $request->instituicao;
        } else if (isset($request->instituicaoSelect) && $request->instituicaoSelect != "Outra") {
            $user->instituicao = $request->instituicaoSelect;
        }
        $user->save();
        

        switch ($request->tipo) {
            case "administradorResponsavel": 
                $adminResp = new AdministradorResponsavel();
                $adminResp->user_id = $user->id;
                $adminResp->save();
                break;
            case "coordenador":
                $coordenador = new CoordenadorComissao();
                $coordenador->user_id = $user->id;
                $coordenador->save();
                break;
            case "avaliador": 
                $avaliador = new Avaliador();
                $avaliador->user_id = $user->id;
                $avaliador->save();
                break;
            case "proponente": 
                $proponente = new Proponente();
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

        $adminResp = AdministradorResponsavel::where('user_id', '=', $id)->first();
        $avaliador = Avaliador::where('user_id', '=', $id)->first();
        $proponente = Proponente::where('user_id', '=', $id)->first();
        $participante = Participante::where('user_id', '=', $id)->first();

        return view ('administrador.editar_user')->with(['user' => $user,
                                                         'adminResp' => $adminResp,
                                                         'proponente' => $proponente,
                                                         'participante' => $participante,]);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        
        if ($request->tipo != "proponente") {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'tipo' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
                'instituicaoSelect' => ['required_without:instituicao'],
                'celular' => ['required', 'string', 'telefone'],
                'cpf' => ['required', 'cpf'],
            ]);
        } else {
            $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'tipo' => ['required'],
            'cpf' => ['required', 'cpf',],
            'celular' => ['required', 'string', 'telefone'],
            'instituicao' => ['required_if:instituicaoSelect,Outra', 'max:255'],
            'instituicaoSelect' => ['required_without:instituicao'],
            'cargo' => ['required'],
            'vinculo' => ['required'],
            'outro' => ['required_if:vinculo,Outro'],
            'titulacaoMaxima' => ['required_with:anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'titulacaoMaxima' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'anoTitulacao' => ['required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes'],
            'anoTitulacao' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'areaFormacao' => ['required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes'],
            'areaFormacao' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'bolsistaProdutividade' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes'],
            'bolsistaProdutividade' => Rule::requiredIf((isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando')),
            'nivel' => ['required_if:bolsistaProdutividade,sim'],
            //'nivel' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],            
                'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],            
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],            
            'linkLattes' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'link_lattes':''],
            ]);
        }
        
        // if (!(Hash::check($request->senha_atual, $user->password))) {
        //     return redirect()->back()->withErrors(['senha_atual' => 'Senha atual não correspondente']);
        // }

        // if (!($request->nova_senha === $request->confirmar_senha)) {
        //     return redirect()->back()->withErrors(['nova_senha' => 'Senhas diferentes']);
        // }

        switch ($request->tipo) {
            case "administradorResponsavel": 
                $adminResp = AdministradorResponsavel::where('user_id', '=', $id)->first();
                $adminResp->user_id = $user->id;
                $adminResp->update();
                break;
            case "coordenador":
                $coordenador = CoordenadorComissao::where('user_id', '=', $id)->first();
                $coordenador->user_id = $user->id;
                $coordenador->update();
                break;
            case "avaliador": 
                $avaliador = Avaliador::where('user_id', '=', $id)->first();
                $avaliador->user_id = $user->id;
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
                $participante->user_id = $user->id;
                $participante->update();
                break;
        }

        $user->name = $request->name;
        $user->tipo = $request->tipo;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        $user->celular = $request->celular;
        if ($request->instituicao != null) {
            $user->instituicao = $request->instituicao;
        } else if (isset($request->instituicaoSelect) && $request->instituicaoSelect != "Outra") {
            $user->instituicao = $request->instituicaoSelect;
        }
        // $user->password = bcrypt($request->nova_senha);
        $user->update();

        return redirect( route('admin.usuarios') )->with(['mensagem' => 'Usuário atualizado com sucesso']);
    }

    public function destroy($id) {
        $user = User::find($id);
        
        $adminResp = AdministradorResponsavel::where('user_id', $id)->first();
        $coordenador = CoordenadorComissao::where('user_id', $id)->first();
        $avaliador = Avaliador::where('user_id', $id)->first();
        $proponente = Proponente::where('user_id', $id)->first();
        $participantes = Participante::where('user_id', $id)->get();

        if (!(is_null($adminResp))) {
            $adminResp->delete();
        }
        if (!(is_null($coordenador))) {
            $evento = Evento::where('coordenadorId', $coordenador->id)->get();
            if (isset($evento) && $evento->count() > 0) {
                return redirect()->back()->withErrors(['error' => 'Esse coordenador está ligado a um edital']);
            } else {
                $coordenador->delete();
            }
        }
        if (!(is_null($avaliador))) {
            $avaliador->delete();
        }
        
        if (!(is_null($proponente))) {
            $proponente->delete();
        }
        if (isset($participantes) && $participantes->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Esse participante está ligado a um projeto que só pode ser deletado por seu proponente']);
        }
    
        $user->delete();

        return redirect( route('admin.usuarios') )->with(['mensagem' => 'Usuário deletado com sucesso']);
    }

    public function atribuir(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        //dd($request->all());
        return view('administrador.atribuirAvaliadores', ['evento'=> $evento]);
    }
    public function selecionar(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();

        $avalSelecionados = $evento->avaliadors;
        $avalNaoSelecionadosId = $evento->avaliadors->pluck('id');
        $avaliadores = Avaliador::whereNotIn('id', $avalNaoSelecionadosId)->get();
        //dd($avaliadores);
        return view('administrador.selecionarAvaliadores', [
                                                            'evento'=> $evento,
                                                            'avaliadores'=>$avaliadores, 
                                                            'avalSelecionados'=>$avalSelecionados
                                                           ]);
    }
    public function projetos(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhos = $evento->trabalhos;
        
        $avaliadores = $evento->avaliadors;
        foreach ($trabalhos as $key => $trabalho) {

            
            $avalSelecionadosId = $trabalho->avaliadors->pluck('id');
            $avalProjeto = Avaliador::whereNotIn('id', $avalSelecionadosId)->get();
            $trabalho->aval = $avalProjeto;

        }
        
        //dd($avaliadores->teste);


        return view('administrador.selecionarProjetos', [
                                                         'evento'=> $evento,
                                                         'trabalhos'=>$trabalhos,
                                                         'avaliadores'=>$avaliadores
                                                        ]);
    }

    public function adicionar(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $aval = Avaliador::where('id', $request->avaliador_id)->first();
        $aval->eventos()->attach($evento);
        $aval->save();


        return redirect()->back();

    }

    public function remover(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $aval = Avaliador::where('id', $request->avaliador_id)->first();
        $aval->eventos()->detach($evento);
        $aval->trabalhos()->detach();
        $aval->save();


        return redirect()->back();


    }
    public function buscar(Request $request){

        $trabalho = Trabalho::where('id', $request->item)->first();
        $avalSelecionadosId = $trabalho->avaliadors->pluck('id');
        $avalProjeto = Avaliador::whereNotIn('id', $avalSelecionadosId)->get();

        //dd($avaliadores);

        return response()->json($avalProjeto);

    }

    public function atribuicao(Request $request){

        $trabalho = Trabalho::where('id', $request->trabalho_id)->first();
        $evento = Evento::where('id', $request->evento_id)->first();
        $avaliadores = Avaliador::whereIn('id', $request->avaliadores_id)->get();
        $trabalho->avaliadors()->attach($avaliadores);
        $evento->avaliadors()->syncWithoutDetaching($avaliadores);
        $trabalho->save();

        return redirect()->back();

    }

    public function enviarConvite(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $nomeAvaliador = $request->nomeAvaliador;
        $emailAvaliador = $request->emailAvaliador;
        $tipo = $request->tipo;
        $user = User::where('email', $emailAvaliador )->first();

        //existe o caso de enviar o convite de novo para um mesmo usuário
        // if(isset($user->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite) ){
        //     return redirect()->back()->with(['mensagem' => 'Usuário já recebeu um convite e está pendente']);
        // }

        if(isset($user)){
            $passwordTemporario = Str::random(8);
            $subject = "Convite para avaliar projetos da UFAPE";
            Mail::to($emailAvaliador)
                ->send(new EmailParaUsuarioNaoCadastrado($nomeAvaliador, '  ', 'Avaliador-Cadastrado', $evento->nome, $passwordTemporario, $subject));

        }else{
            $passwordTemporario = Str::random(8);
            $subject = "Convite para avaliar projetos da UFAPE";
            Mail::to($emailAvaliador)
                ->send(new EmailParaUsuarioNaoCadastrado($nomeAvaliador, '  ', 'Avaliador', $evento->nome, $passwordTemporario, $subject));
            $user = User::create([
              'email' => $emailAvaliador,
              'password' => bcrypt($passwordTemporario),
              'usuarioTemp' => true,
              'name' => $nomeAvaliador,
              'tipo' => 'avaliador',
            ]);
        }
        

        $avaliador = new Avaliador();
        $avaliador->save();
        $avaliador->user()->associate($user);        
        $avaliador->eventos()->attach($evento);

        $user->save();
        $avaliador->save();

        return redirect()->back();
    }

    // public function baixarAnexo(Request $request) {
    //   return Storage::download($request->anexo);
    // }

}
