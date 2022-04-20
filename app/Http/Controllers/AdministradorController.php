<?php

namespace App\Http\Controllers;

use App\Notificacao;
use App\Substituicao;
use Illuminate\Http\Request;
use App\Administrador;
use App\User;
use App\ParecerInterno;
use App\Avaliador;
use App\AdministradorResponsavel;
use App\Area;
use App\Participante;
use App\Proponente;
use App\GrandeArea;
use App\Natureza;
use App\Trabalho;
use App\FuncaoParticipantes;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Evento;
use App\CoordenadorComissao;
use Illuminate\Validation\Rule;
use App\Mail\EmailParaUsuarioNaoCadastrado;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventoCriado;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Response;
use App\Mail\EmailLembrete;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AtribuicaoAvaliadorExternoNotification;

class AdministradorController extends Controller
{
    public function index(){

    	return view('administrador.index');
    }
    public function naturezas(){
        $naturezas = Natureza::orderBy('nome')->get();
        $funcoesParticipante = FuncaoParticipantes::orderBy('nome')->get();
    	return view('naturezas.index')->with(['naturezas' => $naturezas, 'funcoes' => $funcoesParticipante]);
    }
    public function usuarios(){
        $users = User::orderBy('name')->get();
    	return view('administrador.usersAdmin')->with(['users' => $users]);
    }

    public function editais(){
    	//$admin = Administrador::with('user')->where('user_id', Auth()->user()->id)->first();
    	//$eventos = Evento::where('coordenadorId',$admin->id )->get();
        $eventos = Evento::all()->sortBy('nome');

    	return view('administrador.editais', ['eventos'=> $eventos]);
    }

    public function pareceres(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhos = $evento->trabalhos->whereNotIn('status', 'rascunho');
       // $trabalhosAvaliados = $evento->trabalhos->Where('status', 'avaliado');
       // $trabalhos = $trabalhosSubmetidos->merge($trabalhosAvaliados);

        return view('administrador.projetos')->with(['trabalhos' => $trabalhos, 'evento' => $evento]);
    }
    public function analisar(Request $request){
        $evento = Evento::find($request->evento_id);
        $status = ['submetido', 'avaliado', 'aprovado', 'reprovado', 'corrigido'];
        $withPath = '/usuarios/analisarProjetos?evento_id='.$evento->id;
        if($request->column != null ) {
            $status = [$request->column];
            $withPath = '/usuarios/analisarProjetos/'.$request->column.'?evento_id='.$evento->id;
        }
        $trabalhos = Trabalho::where('evento_id', $evento->id)
            ->whereIn('status', $status)
            ->orderBy('titulo')
            ->paginate(10)
            ->withPath($withPath);

        $funcaoParticipantes = FuncaoParticipantes::all();
        // $participantes = Participante::where('trabalho_id', $id)->get();
        // $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
        // $participantes = User::whereIn('id', $participantesUsersIds)->get();

        return view('administrador.analisar')->with(['trabalhos' => $trabalhos, 'evento' => $evento, 'funcaoParticipantes' => $funcaoParticipantes, 'column' => $request->column]);
    }

    // Utilizado para paginação de Collection
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::currentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function analisarProposta(Request $request){

        $trabalho = Trabalho::where('id',$request->id)->first();
        $evento = Evento::where('id', $trabalho->evento_id)->first();
        $funcaoParticipantes = FuncaoParticipantes::all();
        $substituicoesProjeto = Substituicao::where('trabalho_id', $trabalho->id)->orderBy('created_at', 'DESC')->get();
        $substituicoesPendentes = Substituicao::where('trabalho_id', $trabalho->id)->where('status', 'Em Aguardo')->orderBy('created_at', 'DESC')->get();

        $avalSelecionadosId = $trabalho->avaliadors->pluck('id');
        $avalProjeto = Avaliador::whereNotIn('id', $avalSelecionadosId)->get();
        $trabalho->aval = $avalProjeto;

        $grandeAreas = GrandeArea::orderBy('nome')->get();

        return view('administrador.analisarProposta')->with(
            [   'trabalho' => $trabalho,
                'funcaoParticipantes' => $funcaoParticipantes,
                'evento' => $evento,
                'substituicoesPendentes' => $substituicoesPendentes,
                'substituicoesProjeto' => $substituicoesProjeto,
                'grandeAreas' => $grandeAreas,]);
    }

    public function showProjetos(Request $request){

        $projetos = Trabalho::all()->where('status','<>','rascunho');
        $funcaoParticipantes = FuncaoParticipantes::all();

        return view('administrador.listaProjetos')->with(['projetos'=>$projetos,'funcaoParticipantes'=>$funcaoParticipantes]);
    }

    public function showResultados(Request $request){
        //dd($request);
        $evento = Evento::where('id', $request->evento_id)->first();
        // Com cotas
        if ($evento->cotaDoutor) {
            // Ampla Concorrencia
            $trabalhosAmpla = Trabalho::where('evento_id',$evento->id)
                ->where('modalidade','AmplaConcorrencia')->get();
            foreach($trabalhosAmpla as $trabalho){
                $trabalho->pontuacao = 0;
                foreach($trabalho->avaliadors as $avaliador){
                    if($avaliador->tipo == "Interno"){
                        $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                        if($parecerInterno != null){
                            $trabalho->pontuacao += $parecerInterno->statusAnexoPlanilhaPontuacao;
                        }
                    }
                }
            }
            $trabalhosAmpla = $trabalhosAmpla->sort(function ($item, $next) {
                return $item->pontuacao >= $next->pontuacao ? -1 : 1;
            });

            // Recém Doutor
            $trabalhosDoutor = Trabalho::where('evento_id',$evento->id)
                ->where('modalidade','RecemDoutor')->get();
            foreach($trabalhosDoutor as $trabalho){
                $trabalho->pontuacao = 0;
                foreach($trabalho->avaliadors as $avaliador){
                    if($avaliador->tipo == "Interno"){
                        $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                        if($parecerInterno != null){
                            $trabalho->pontuacao += $parecerInterno->statusAnexoPlanilhaPontuacao;
                        }
                    }
                }
            }
            $trabalhosDoutor = $trabalhosDoutor->sort(function ($item, $next) {
                return $item->pontuacao >= $next->pontuacao ? -1 : 1;
            });

            return view('administrador.resultadosProjetosCotas')->with(['evento' => $evento, 'trabalhosAmpla' => $trabalhosAmpla, 'trabalhosDoutor' => $trabalhosDoutor]);
        }

        // Sem Cotas
        $trabalhos = $evento->trabalhos;
        foreach($trabalhos as $trabalho){
            $trabalho->pontuacao = 0;
            foreach($trabalho->avaliadors as $avaliador){
                if($avaliador->tipo == "Interno"){
                    $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                    if($parecerInterno != null){
                        $trabalho->pontuacao += $parecerInterno->statusAnexoPlanilhaPontuacao;
                    }
                }
            }
        }

        $trabalhos = $trabalhos->sort(function ($item, $next) {
            return $item->pontuacao >= $next->pontuacao ? -1 : 1;
        });

        return view('administrador.resultadosProjetos')->with(['evento' => $evento, 'trabalhos' => $trabalhos]);
    }

    public function visualizarParecer(Request $request){

        $avaliador = Avaliador::find($request->avaliador_id);
        $trabalho = $avaliador->trabalhos->where('id', $request->trabalho_id)->first();
        $parecer = $avaliador->trabalhos->where('id', $request->trabalho_id)->first()->pivot;

        //dd($parecer);
        return view('administrador.visualizarParecer')->with(['trabalho' => $trabalho, 'parecer' => $parecer, 'avaliador' => $avaliador]);
    }

    public function visualizarParecerInterno(Request $request){

        $avaliador = Avaliador::find($request->avaliador_id);
        $trabalho = $avaliador->trabalhos->where('id', $request->trabalho_id)->first();
        $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
        $evento = Evento::find($trabalho->evento_id);

        //dd($parecer);
        return view('administrador.visualizarParecerInterno')->with(['parecer' => $parecerInterno, 'avaliador' => $avaliador,'trabalho' => $trabalho,'evento' => $evento]);
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
                'senha' => ['required', 'min:8'],
                'confirmar_senha' => ['required', 'min:8'],
                'cpf' => ['required', 'cpf', 'unique:users'],
            ]);
        } else {
            $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tipo' => ['required'],
            'cpf' => ['required', 'cpf', 'unique:users'],
            'celular' => ['required', 'string', 'telefone'],
            'senha' => ['required', 'min:8'],
            'confirmar_senha' => ['required', 'min:8'],
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
            //'nivel' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'link_lattes':''],
            ]);
        }

        if (!($request->senha === $request->confirmar_senha)) {
            return redirect()->back()->withErrors(['senha' => 'Senhas diferentes']);
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
                $avaliador->tipo = $request->tipoAvaliador;
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
            'titulacaoMaxima' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
            'anoTitulacao' => ['required_with:titulacaoMaxima,areaFormacao,bolsistaProdutividade,linkLattes'],
            'anoTitulacao' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
            'areaFormacao' => ['required_with:titulacaoMaxima,anoTitulacao,bolsistaProdutividade,linkLattes'],
            'areaFormacao' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
            'bolsistaProdutividade' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,linkLattes'],
            'bolsistaProdutividade' => Rule::requiredIf((isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando')),
            'nivel' => ['required_if:bolsistaProdutividade,sim'],
            //'nivel' => [(isset($data['cargo']) && $data['cargo'] !== 'Estudante') || (isset($data['cargo']) && $data['cargo'] === 'Estudante' && isset($data['vinculo']) && $data['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
                'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'linkLattes' => ['required_with:titulacaoMaxima,anoTitulacao,areaFormacao,bolsistaProdutividade'],
            'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'required':''],
            'linkLattes' => [(isset($request['cargo']) && $request['cargo'] !== 'Estudante') || (isset($request['cargo']) && $request['cargo'] === 'Estudante' && isset($request['vinculo']) && $request['vinculo'] === 'Pós-doutorando') ? 'link_lattes':''],
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

    public function atribuir(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        //dd($request->all());
        return view('administrador.atribuirAvaliadores', ['evento'=> $evento]);
    }
    public function selecionar(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $grandeAreas = GrandeArea::orderBy('nome')->get();
        $avalSelecionados = $evento->avaliadors;
        $avalNaoSelecionadosId = $evento->avaliadors->pluck('id');
        $avaliadores = Avaliador::whereNotIn('id', $avalNaoSelecionadosId)->get();
        //dd($avaliadores);
        return view('administrador.selecionarAvaliadores', [
                                                            'evento'=> $evento,
                                                            'avaliadores'=>$avaliadores,
                                                            'avalSelecionados'=>$avalSelecionados,
                                                            'grandeAreas' => $grandeAreas
                                                           ]);
    }
    public function projetos(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $trabalhos = $evento->trabalhos->where('status', 'submetido');

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
        $user = $aval->user()->first();

        $subject = "Convite para avaliar projetos da UFAPE";
            Mail::to($user->email)
                ->send(new EmailParaUsuarioNaoCadastrado($user->name, '  ', 'Avaliador-Cadastrado', $evento->nome, ' ', $subject, $evento->tipo));

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

    public function removerProjAval(Request $request){
        $aval = Avaliador::where('id', $request->avaliador_id)->first();
        $trabalho = Trabalho::where('id', $request->trabalho_id)->first();
        $aval->trabalhos()->detach($trabalho);
        
        if($trabalho->status === 'avaliado'){
            $trabalho->status = 'submetido';
            $trabalho->save();
        }

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

    public function atribuicaoProjeto(Request $request){

        $trabalho = Trabalho::where('id', $request->trabalho_id)->first();
        $evento = Evento::where('id', $request->evento_id)->first();
        
        if($request->avaliadores_internos_id == null){
            $avaliadoresInternos = [];
        }else{
            $avaliadoresInternos = $request->avaliadores_internos_id;
        }

        if($request->avaliadores_externos_id == null){
            $avaliadoresExternos = [];
        }else{
            $avaliadoresExternos = $request->avaliadores_externos_id;
        }
        $idsAvaliadores = array_merge($avaliadoresInternos, $avaliadoresExternos);
        if($idsAvaliadores == null){
            redirect()->back()->with(['error' => 'Selecione ao menos um avaliador.', 'trabalho' => $trabalho->id]);
        }
        $avaliadores = Avaliador::whereIn('id', $idsAvaliadores)->get();
        $trabalho->avaliadors()->attach($avaliadores);
        $evento->avaliadors()->syncWithoutDetaching($avaliadores);
        $trabalho->save();

        foreach ($avaliadores as $avaliador){

            $userTemp = User::find($avaliador->user->id);

            $notificacao = Notificacao::create([
                'remetente_id' => Auth::user()->id,
                'destinatario_id' => $avaliador->user_id,
                'trabalho_id' => $request->trabalho_id,
                'lido' => false,
                'tipo' => 5,
            ]);
            $notificacao->save();
            if($avaliador->tipo == "Externo"){
                Notification::send($userTemp, new AtribuicaoAvaliadorExternoNotification($userTemp,$trabalho));
            }
        }


        return redirect()->back();

    }

    public function enviarConviteEAtribuir(Request $request)
    {
        $evento = Evento::where('id', $request->evento_id)->first();
        $nomeAvaliador = $request->nomeAvaliador;
        $emailAvaliador = $request->emailAvaliador;
        $area = Area::where('id', $request->area_id)->first();
        $user = User::where('email', $emailAvaliador )->first();

        if($request->instituicao == "ufape"){
            $nomeInstituicao = "Universidade Federal do Agreste de Pernambuco";
            $externoInterno = "Interno";
        }else{
            $nomeInstituicao = $request->outra;
            $externoInterno = "Externo";
        }
        if(isset($user)){
            $passwordTemporario = Str::random(8);
            $subject = "Convite para avaliar projetos da UFAPE";
            Mail::to($emailAvaliador)
                ->send(new EmailParaUsuarioNaoCadastrado($nomeAvaliador, '  ', 'Avaliador-Cadastrado', $evento->nome, $passwordTemporario, $subject, $evento->tipo));

        }else{
            $passwordTemporario = Str::random(8);
            $subject = "Convite para avaliar projetos da UFAPE";
            Mail::to($emailAvaliador)
                ->send(new EmailParaUsuarioNaoCadastrado($nomeAvaliador, '  ', 'Avaliador', $evento->nome, $passwordTemporario, $subject, $evento->tipo));
            $user = User::create([
              'email' => $emailAvaliador,
              'password' => bcrypt($passwordTemporario),
              'usuarioTemp' => false,
              'name' => $nomeAvaliador,
              'tipo' => 'avaliador',
              'instituicao' => $nomeInstituicao,
            ]);

            $user->markEmailAsVerified();
        }

        if($user->avaliadors == null){
            $avaliador = new Avaliador();
            $avaliador->tipo = $externoInterno;
            $avaliador->save();
            $avaliador->area()->associate($area);
            $avaliador->user()->associate($user);
            $avaliador->eventos()->attach($evento);
            $user->save();
            $avaliador->save();
        }else{
            $avaliador = $user->avaliadors;
            $avaliador->eventos()->attach($evento);
            $user->save();
            $avaliador->save();
        }

        $trabalho = Trabalho::where('id', $request->trabalho_id)->first();

        $trabalho->avaliadors()->attach($avaliador);
        $evento->avaliadors()->syncWithoutDetaching($avaliador);
        $trabalho->save();

        $notificacao = Notificacao::create([
            'remetente_id' => Auth::user()->id,
            'destinatario_id' => $avaliador->user_id,
            'trabalho_id' => $request->trabalho_id,
            'lido' => false,
            'tipo' => 5,
        ]);
        $notificacao->save();
        return redirect()->back();
    }


    public function reenviarConviteAtribuicaoProjeto(Request $request){
        $evento = Evento::where('id', $request->evento_id)->first();
        $avaliador = Avaliador::where('id', $request->avaliador_id)->first();
        if($avaliador->user->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite != true){
            $avaliador->user->avaliadors->eventos()->updateExistingPivot($evento->id, ['convite'=> null]);
        }

        $notificacao = Notificacao::create([
            'remetente_id' => Auth::user()->id,
            'destinatario_id' => $avaliador->user_id,
            'trabalho_id' => $request->trabalho_id,
            'lido' => false,
            'tipo' => 5,
        ]);
        $notificacao->save();

        $trabalho = Trabalho::where('id', $request->trabalho_id)->first();
        $subject = "Trabalho atribuido";
        $informacoes = $trabalho->titulo;
        //REFAZER EMAIL
        Mail::to($avaliador->user->email)
            ->send(new EmailLembrete($avaliador->user, $subject, $informacoes));

        return redirect()->back();

    }

    public function enviarConvite(Request $request){

        $evento = Evento::where('id', $request->evento_id)->first();
        $nomeAvaliador = $request->nomeAvaliador;
        $emailAvaliador = $request->emailAvaliador;
        $tipo = $request->tipo;
        $area = Area::where('id', $request->area_id)->first();
        $user = User::where('email', $emailAvaliador )->first();

        if($request->instituicao == "ufape"){
            $nomeInstituicao = "Universidade Federal do Agreste de Pernambuco";
            $externoInterno = "Interno";
        }else{
            $nomeInstituicao = $request->outra;
            $externoInterno = "Externo";
        }

        //existe o caso de enviar o convite de novo para um mesmo usuário
        // if(isset($user->avaliadors->eventos->where('id', $evento->id)->first()->pivot->convite) ){
        //     return redirect()->back()->with(['mensagem' => 'Usuário já recebeu um convite e está pendente']);
        // }

        if(isset($user)){
            $passwordTemporario = Str::random(8);
            $subject = "Convite para avaliar projetos da UFAPE";
            Mail::to($emailAvaliador)
                ->send(new EmailParaUsuarioNaoCadastrado($nomeAvaliador, '  ', 'Avaliador-Cadastrado', $evento->nome, $passwordTemporario, $subject, $evento->tipo));

        }else{
            $passwordTemporario = Str::random(8);
            $subject = "Convite para avaliar projetos da UFAPE";
            Mail::to($emailAvaliador)
                ->send(new EmailParaUsuarioNaoCadastrado($nomeAvaliador, '  ', 'Avaliador', $evento->nome, $passwordTemporario, $subject, $evento->tipo));
            $user = User::create([
              'email' => $emailAvaliador,
              'password' => bcrypt($passwordTemporario),
              'usuarioTemp' => false,
              'name' => $nomeAvaliador,
              'tipo' => 'avaliador',
              'instituicao' => $nomeInstituicao,
            ]);

            $user->markEmailAsVerified();
        }

        if($user->avaliadors == null){
            $avaliador = new Avaliador();
            $avaliador->tipo = $externoInterno;
            $avaliador->save();
            $avaliador->area()->associate($area);
            $avaliador->user()->associate($user);
            $avaliador->eventos()->attach($evento);
    
            $user->save();
            $avaliador->save();
        }else{
            $avaliador = $user->avaliadors;
            $avaliador->eventos()->attach($evento);
            $user->save();
            $avaliador->save();
        }

        return redirect()->back();
    }

    public function reenviarConvite(Request $request){
        $evento = Evento::where('id', $request->evento_id)->first();
        $avaliador = Avaliador::where('id', $request->avaliador_id)->first();
        $user = $avaliador->user()->first();

        $subject = "Convite para avaliar projetos da UFAPE - Reenvio";
            Mail::to($user->email)
                ->send(new EmailParaUsuarioNaoCadastrado($user->name, '  ', 'Avaliador-Cadastrado', $evento->nome, '', $subject, $evento->tipo));
        
        
        return redirect()->back();
    }


    // public function baixarAnexo(Request $request) {
    //   return Storage::download($request->anexo);
    // }

    public function baixarModeloAvaliacao(){

        $file = public_path().'/ModeloFormularioAvaliadorExternoPIBIC.docx';
        $headers = array('Content-Type: application/docx',);
        ob_end_clean();
        return response()->download($file, 'ModeloFormularioAvaliadorExternoPIBIC.docx', $headers);
    }

    public function imprimirResultados(Request $request)
    {
        $evento = Evento::where('id', $request->id)->first();
            // Ampla Concorrencia
            $trabalhosAmpla = Trabalho::where('evento_id',$evento->id)
                ->where('modalidade','AmplaConcorrencia')->get();
            foreach($trabalhosAmpla as $trabalho){
                $trabalho->pontuacao = 0;
                foreach($trabalho->avaliadors as $avaliador){
                    if($avaliador->tipo == "Interno"){
                        $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                        if($parecerInterno != null){
                            $trabalho->pontuacao += $parecerInterno->statusAnexoPlanilhaPontuacao;
                        }
                    }
                }
            }
            $trabalhosAmpla = $trabalhosAmpla->sort(function ($item, $next) {
                return $item->pontuacao >= $next->pontuacao ? -1 : 1;
            });

            // Recém Doutor
            $trabalhosDoutor = Trabalho::where('evento_id',$evento->id)
                ->where('modalidade','RecemDoutor')->get();
            foreach($trabalhosDoutor as $trabalho){
                $trabalho->pontuacao = 0;
                foreach($trabalho->avaliadors as $avaliador){
                    if($avaliador->tipo == "Interno"){
                        $parecerInterno = ParecerInterno::where([['avaliador_id',$avaliador->id],['trabalho_id',$trabalho->id]])->first();
                        if($parecerInterno != null){
                            $trabalho->pontuacao += $parecerInterno->statusAnexoPlanilhaPontuacao;
                        }
                    }
                }
            }
            $trabalhosDoutor = $trabalhosDoutor->sort(function ($item, $next) {
                return $item->pontuacao >= $next->pontuacao ? -1 : 1;
            });

            $pdf = PDF::loadView('/administrador/resultadosProjetosCotas', compact('trabalhosDoutor', 'trabalhosAmpla', 'evento'));
            return $pdf->setPaper('a4')->stream('Resultados.pdf');

    }

}
