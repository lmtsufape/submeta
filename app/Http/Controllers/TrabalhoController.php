<?php

namespace App\Http\Controllers;

use App\AreaTematicaPibac;
use PDF;
use App;
use App\Administrador;
use Auth;
use App\Area;
use App\User;
use App\Evento;
use App\AreaTematica;
use App\Arquivo;
use App\Coautor;
use App\Revisor;
use App\TrabalhoUser;
use App\SubArea;
use App\Endereco;
use App\Trabalho;
use App\Avaliador;
use Carbon\Carbon;
use App\AnexosTemp;
use App\Atribuicao;
use App\GrandeArea;
use App\Modalidade;
use App\Proponente;
use App\Participante;
use App\AreaModalidade;
use App\Certificado;
use Illuminate\Http\File;
use App\Mail\EventoCriado;
use Illuminate\Support\Str;
use App\CoordenadorComissao;
use App\FuncaoParticipantes;
use Illuminate\Http\Request;
use App\Mail\SubmissaoTrabalho;
use App\OutrasInfoParticipante;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreTrabalho;
use App\Http\Requests\AdicionarIntegranteRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UpdateTrabalho;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\EmailParaUsuarioNaoCadastrado;
use App\Mail\SolicitacaoSubstituicao;
use App\Mail\SolicitacaoDeclaracao;
use App\Notificacao;
use App\Notifications\SolicitacaoCertificadoNotification;
use App\Notifications\SubmissaoNotification;
use App\Notifications\SubmissaoRecebidaNotification;
use App\SolicitacaoParticipante;
use App\Substituicao;
use Illuminate\Support\Facades\Notification;
use App\Desligamento;
use App\ObjetivoDeDesenvolvimentoSustentavel;
use App\AvaliacaoRelatorio;
use App\Curso;
use Illuminate\Support\Facades\Date;

class TrabalhoController extends Controller
{
    public $estados = array(
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espirito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MS' => 'Mato Grosso do Sul',
        'MT' => 'Mato Grosso',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins',
    );

    public function index($id)
    {
        $edital = Evento::find($id);
        $grandeAreas = GrandeArea::orderBy('nome')->get();
        $areaTematicas = AreaTematica::orderBy('nome')->get();
        $ODS = ObjetivoDeDesenvolvimentoSustentavel::orderBy('id')->get();
        $funcaoParticipantes = FuncaoParticipantes::orderBy('nome')->get();
        $proponente = Proponente::where('user_id', Auth::user()->id)->first();
        $areaTematicasPibac = AreaTematicaPibac::orderBy('id')->get();

        if ($proponente == null) {
            return view('proponente.cadastro')->with(['mensagem' => 'Você não possui perfil de Proponente, para submeter algum projeto preencha o formulário.']);;
        }

        $rascunho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id', $edital->id)->where('status', 'Rascunho')
            ->orderByDesc('updated_at')->first();

        // dd($estados);

        return view('evento.submeterTrabalho', [
            // return view('evento.backupForm',[
            'edital'             => $edital,
            'grandeAreas'        => $grandeAreas,
            'funcaoParticipantes' => $funcaoParticipantes,
            'rascunho'           => $rascunho,
            'enum_turno'         => Participante::ENUM_TURNO,
            'estados'            => $this->estados,
            'areaTematicas'        => $areaTematicas,
            'ods'                   => $ODS,
            'areasTematicasPibac' => $areaTematicasPibac
        ]);
    }

    public function solicitarDeclaracao($id)
    {
        $trabalho = Trabalho::find($id);
        $userParticipante = $trabalho->proponente->user;


        $solicitacao = new Notificacao();
        $solicitacao->remetente_id = Auth::user()->id;
        $solicitacao->destinatario_id = $trabalho->evento->coordenadorComissao->user_id;
        $solicitacao->trabalho_id = $trabalho->id;
        $solicitacao->tipo = 6;
        $solicitacao->lido = false;
        $solicitacao->save();

        Mail::to($trabalho->evento->coordenadorComissao->user->email)->send(new SolicitacaoDeclaracao($userParticipante, $trabalho, $trabalho->evento));

        return redirect()->back()->with(['sucesso' => 'Solicitação de declaração enviada com sucesso.']);
    }

    public function arquivar(Request $request)
    {

        $trabalho = Trabalho::find($request->trabalho_id);
        $arquivos = Arquivo::where('trabalhoId', $trabalho->id)->get();
        if ($request->arquivar_tipo == 1) {
            $trabalho->arquivado = true;
            foreach ($arquivos as $arquivo) {
                $arquivo->arquivado = true;
                $arquivo->update();
            }
            $message = "Projeto " . $trabalho->titulo . " arquivado";
        } else {
            $trabalho->arquivado = false;
            foreach ($arquivos as $arquivo) {
                $arquivo->arquivado = false;
                $arquivo->update();
            }
            $message = "Projeto " . $trabalho->titulo . " desarquivado";
        }
        $trabalho->update();
        return redirect()->back()->with(['sucesso' => $message]);
    }

    public function storeParcial(Request $request)
    {
        $mytime = Carbon::now('America/Recife');
        $mytime = $mytime->toDateString();
        $evento = Evento::find($request->editalId);
        $coordenador = CoordenadorComissao::find($evento->coordenadorId);

        //Relaciona o projeto criado com o proponente que criou o projeto
        $proponente = Proponente::where('user_id', Auth::user()->id)->first();

        $trabalho = "trabalho";
        if ($evento->inicioSubmissao > $mytime) {
            if ($mytime >= $evento->fimSubmissao) {
                return redirect()->route('home');
            }
        }

        //--Salvando os dados da submissão temporariamente
        $this->armazenarInfoTemp($request, $proponente);

        return redirect()->route('projetos.edital', ['id' => $request->editalId]);
    }

    //Armazena temporariamente dados da submissão, no banco de dados e no storage
    public function armazenarInfoTemp(Request $request, $proponente)
    {

        //---Dados do Projeto
        $trabalho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id', $request->editalId)->where('status', 'Rascunho')
            ->orderByDesc('updated_at')->first();
        //dd($trabalho);
        if ($trabalho == null) {
            $trabalho = new Trabalho();
            $trabalho->proponente_id = $proponente->id;
            $trabalho->evento_id = $request->editalId;
            $trabalho->status = 'Rascunho';

            $stringKeys = [
                'titulo',
                'linkGrupoPesquisa',
                'linkLattesEstudante',
                'pontuacaoPlanilha',
                'anexoProjeto',
                'anexoPlanilhaPontuacao',
                'anexoLattesCoordenador',
                'conflitosInteresse'
            ];
            $intKeys = ['grande_area_id', 'area_id', 'sub_area_id', 'coordenador_id'];

            $trabalho->fill(
                array_fill_keys($stringKeys, "") + array_fill_keys($intKeys, 1)
            )->save();
            //dd($trabalho);
        }

        if (!(is_null($request->nomeProjeto))) {
            $trabalho->titulo = $request->nomeProjeto;
        }
        if (!(is_null($request->grandeArea))) {
            $trabalho->grande_area_id = $request->grandeArea;
        }
        if (!(is_null($request->area))) {
            $trabalho->area_id = $request->area;
        }
        if (!(is_null($request->subArea))) {
            $trabalho->sub_area_id = $request->subArea;
        }
        if (!(is_null($request->pontuacaoPlanilha))) {
            $trabalho->pontuacaoPlanilha = $request->pontuacaoPlanilha;
        }
        if (!(is_null($request->linkGrupo))) {
            $trabalho->linkGrupoPesquisa = $request->linkGrupo;
        }
        if (!(is_null($request->conflitosInteresse))) {
            $trabalho->conflitosInteresse = $request->conflitosInteresse;
        }

        //Anexos do projeto

        $pasta = 'trabalhos/' . $request->editalId . '/' . $trabalho->id;

        if (!(is_null($request->anexoDecisaoCONSU))) {
            $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoDecisaoCONSU,  "CONSU.pdf");
        }
        if (!(is_null($request->anexoComiteEtica))) {
            $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoComiteEtica,  "Comite_de_etica.pdf");
        }
        if (!(is_null($request->justificativaAutorizacaoEtica))) {
            $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica,  "Justificativa.pdf");
        }
        if (!(is_null($request->anexoProjeto))) {
            $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto,  "Projeto.pdf");
        }
        if (!(is_null($request->anexoLattesCoordenador))) {
            $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador,  "Lattes_Coordenador.pdf");
        }
        if (!(is_null($request->anexoPlanilhaPontuacao))) {
            $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilhaPontuacao,  "Planilha." . $request->file('anexoPlanilhaPontuacao')->getClientOriginalExtension());
        }

        $trabalho->update();

        //---Anexos planos de trabalho

        //dd($trabalho);

        return $trabalho;
    }

    public function validarAnexosRascunho(Request $request, $trabalho)
    {
        $validator = Validator::make($trabalho->getAttributes(), [
            'anexoPlanilhaPontuacao'           => $request->anexoPlanilhaPontuacao == null ? ['planilha'] : [],
        ]);

        if ($validator->fails()) {
            //dd('asdf');
            return back()->withErrors($validator)->withInput();
        }
        return 1;
    }

    public function armazenarAnexosFinais($request, $pasta, $trabalho, $evento)
    {

        // Checando se é um novo trabalho ou uma edição

        if ($trabalho->anexoProjeto != null) {
            // Anexo Projeto
            if (isset($request->anexoProjeto)) {
                if (Storage::disk()->exists($trabalho->anexoProjeto)) {
                    Storage::delete($trabalho->anexoProjeto);
                }
                $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto, 'Projeto.pdf');
            }

            //Anexo Decisão CONSU
            // if ($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM') {
            if (isset($request->anexoDecisaoCONSU)) {
                if (Storage::disk()->exists($trabalho->anexoDecisaoCONSU)) {
                    Storage::delete($trabalho->anexoDecisaoCONSU);
                }
                $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoDecisaoCONSU, 'Decisão_da_Câmara_ou_Conselho_Pertinente.pdf');
            }
            // }

            //Autorização ou Justificativa
            if (isset($request->anexoAutorizacaoComiteEtica)) {
                if (Storage::disk()->exists($trabalho->anexoAutorizacaoComiteEtica)) {
                    Storage::delete($trabalho->anexoAutorizacaoComiteEtica);
                }
                $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoAutorizacaoComiteEtica, 'Comite_de_etica.pdf');
                $trabalho->justificativaAutorizacaoEtica = null;
            } elseif (isset($request->justificativaAutorizacaoEtica)) {
                if (Storage::disk()->exists($trabalho->justificativaAutorizacaoEtica)) {
                    Storage::delete($trabalho->justificativaAutorizacaoEtica);
                }
                $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica, 'Justificativa.pdf');
                $trabalho->anexoAutorizacaoComiteEtica = null;
            }

            //Anexo Lattes
            if (isset($request->anexoLattesCoordenador)) {
                if (Storage::disk()->exists($trabalho->anexoLattesCoordenador)) {
                    Storage::delete($trabalho->anexoLattesCoordenador);
                }
                $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador, 'Lattes_Coordenador.pdf');
            }

            //Anexo Planilha
            if (isset($request->anexoPlanilhaPontuacao)) {
                if (Storage::disk()->exists($trabalho->anexoPlanilhaPontuacao)) {
                    Storage::delete($trabalho->anexoPlanilhaPontuacao);
                }

                $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilhaPontuacao, "Planilha." . $request->file('anexoPlanilhaPontuacao')->getClientOriginalExtension());
            }

            // Anexo grupo pesquisa
            if (isset($request->anexoGrupoPesquisa)) {
                if (Storage::disk()->exists($trabalho->anexoGrupoPesquisa)) {
                    Storage::delete($trabalho->anexoGrupoPesquisa);
                }
                $trabalho->anexoGrupoPesquisa = Storage::putFileAs($pasta, $request->anexoGrupoPesquisa, "Grupo_de_pesquisa." . $request->file('anexoGrupoPesquisa')->extension());
            }

            //Anexo documentro extra
            if (isset($request->anexo_docExtra)) {
                if (Storage::disk()->exists($trabalho->anexo_docExtra)) {
                    Storage::delete($trabalho->anexo_docExtra);
                }
                $trabalho->anexo_docExtra = Storage::putFileAs($pasta, $request->anexo_docExtra, "Documento_Extra." . $request->file('anexo_docExtra')->extension());
            }

            $trabalho->save();
            return $trabalho;
        }

        // Anexo Projeto
        if (isset($request->anexoProjeto)) {
            $trabalho->anexoProjeto = Storage::putFileAs($pasta, $request->anexoProjeto, 'Projeto.pdf');
        }

        //Anexo Decisão CONSU
        //if ($evento->tipo == 'PIBIC' || $evento->tipo == 'PIBIC-EM') {
        if (isset($request->anexoDecisaoCONSU)) {
            $trabalho->anexoDecisaoCONSU = Storage::putFileAs($pasta, $request->anexoDecisaoCONSU, 'Decisão_da_Câmara_ou_Conselho_Pertinente.pdf');
        }
        //}

        //Autorização ou Justificativa
        if (isset($request->anexoAutorizacaoComiteEtica)) {
            $trabalho->anexoAutorizacaoComiteEtica = Storage::putFileAs($pasta, $request->anexoAutorizacaoComiteEtica, 'Comite_de_etica.pdf');
            $trabalho->justificativaAutorizacaoEtica = null;
        } elseif (isset($request->justificativaAutorizacaoEtica)) {
            $trabalho->justificativaAutorizacaoEtica = Storage::putFileAs($pasta, $request->justificativaAutorizacaoEtica, 'Justificativa.pdf');
            $trabalho->anexoAutorizacaoComiteEtica = null;
        }

        //Anexo Lattes
        if (isset($request->anexoLattesCoordenador)) {
            $trabalho->anexoLattesCoordenador = Storage::putFileAs($pasta, $request->anexoLattesCoordenador, 'Lattes_Coordenador.pdf');
        }

        //Anexo Planilha
        if (isset($request->anexoPlanilhaPontuacao)) {
            $trabalho->anexoPlanilhaPontuacao = Storage::putFileAs($pasta, $request->anexoPlanilhaPontuacao, "Planilha." . $request->file('anexoPlanilhaPontuacao')->getClientOriginalExtension());
        }

        // Anexo grupo pesquisa
        if (isset($request->anexoGrupoPesquisa)) {
            $trabalho->anexoGrupoPesquisa = Storage::putFileAs($pasta, $request->anexoGrupoPesquisa, "Grupo_de_pesquisa." . $request->file('anexoGrupoPesquisa')->extension());
        }

        // Anexo documento extra
        if (isset($request->anexo_docExtra)) {
            $trabalho->anexo_docExtra = Storage::putFileAs($pasta, $request->anexo_docExtra, "Documento_Extra." . $request->file('anexo_docExtra')->extension());
        }

        //Anexo SIPAC
        if (isset($request->anexo_SIPAC)) {
            if (Storage::disk()->exists($trabalho->anexo_SIPAC)) {
                Storage::delete($trabalho->anexo_SIPAC);
            }
            $trabalho->anexo_SIPAC = Storage::putFileAs($pasta, $request->anexo_SIPAC, "Anexo_SIPAC." . $request->file('anexo_SIPAC')->extension());
        }

        //Anexo Acao Afirmativa
        if (isset($request->anexo_acao_afirmativa)) {
            $trabalho->anexo_acao_afirmativa = Storage::putFileAs($pasta, $request->anexo_acao_afirmativa, "Anexo_Acao_Afirmativa." . $request->file('anexo_acao_afirmativa')->extension());
        }

        //Anexo Carta de Anuência 
        if (isset($request->anexo_carta_anuencia)) {
            $trabalho->anexo_carta_anuencia = Storage::putFileAs($pasta, $request->anexo_carta_anuencia, "anexo_carta_anuencia." . $request->file('anexo_carta_anuencia')->extension());
        }

        return $trabalho;
    }

    public function show($id)
    {
        $projeto = Trabalho::find($id);
        if (Auth::user()->id != $projeto->proponente->user->id) {
            return redirect()->back();
        }
        $edital = Evento::find($projeto->evento_id);
        $grandeAreas = GrandeArea::all();
        $areas = Area::all();
        $subareas = Subarea::all();
        $areasTematicas = AreaTematica::all();
        $funcaoParticipantes = FuncaoParticipantes::all();
        $participantes = $projeto->participantes;
        $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
        $users = User::whereIn('id', $participantesUsersIds)->get();
        $arquivos = Arquivo::where('trabalhoId', $id)->get();
        $proponente = Proponente::where('user_id', $projeto->proponente->user_id)->first();

        // Verficação de pendencia de substituição
        $aux = count(Substituicao::where('status', 'Em Aguardo')->whereIn('participanteSubstituido_id', $projeto->participantes->pluck('id'))->get());
        $flagSubstituicao = 1;
        if ($aux != 0) {
            $flagSubstituicao = -1;
        }

        $trabalhos_user = TrabalhoUser::where('trabalho_id', $projeto->id)->get();

        $avals_projeto = [];
        $AvalRelatParcial = [];
        $AvalRelatFinal = [];

        if (isset($arquivos)) {
            foreach ($arquivos as $arquivo) {
                array_push($avals_projeto, AvaliacaoRelatorio::where('arquivo_id', $arquivo->id)->get());
            }
        }

        foreach ($avals_projeto as $avals) {
            foreach ($avals as $aval) {
                if ($aval->tipo == 'Parcial') {
                    array_push($AvalRelatParcial, $aval);
                } else {
                    array_push($AvalRelatFinal, $aval);
                }
            }
        }

        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();



        return view('projeto.visualizar')->with([
            'projeto' => $projeto,
            'grandeAreas' => $grandeAreas,
            'areas' => $areas,
            'subAreas' => $subareas,
            'edital' => $edital,
            'users' => $users,
            'funcaoParticipantes' => $funcaoParticipantes,
            'participantes' => $participantes,
            'arquivos' => $arquivos,
            'estados' => $this->estados,
            'visualizar' => true,
            'enum_turno' => Participante::ENUM_TURNO,
            'areasTematicas' => $areasTematicas,
            'flagSubstituicao' => $flagSubstituicao,
            'trabalhos_user' => $trabalhos_user,
            'AvalRelatParcial' => $AvalRelatParcial,
            'AvalRelatFinal' => $AvalRelatFinal,
            'proponente' => $proponente,
            'hoje' => $hoje
        ]);
    }

    public function exportProjeto($id)
    {
        $projeto = Auth::user()->proponentes->trabalhos()->where('id', $id)->first();
        if (!$projeto) {
            return back()->withErrors(['Proposta não encontrada!']);
        }
        $edital = Evento::find($projeto->evento_id);
        $grandeAreas = GrandeArea::all();
        $areas = Area::all();
        $subAreas = Subarea::all();
        $funcaoParticipantes = FuncaoParticipantes::all();
        $participantes = Participante::where('trabalho_id', $id)->get();
        $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
        $users = User::whereIn('id', $participantesUsersIds)->get();
        $arquivos = Arquivo::where('trabalhoId', $id)->get();
        $enum_turno = Participante::ENUM_TURNO;
        view()->share('projeto.visualizar', [$projeto, $grandeAreas, $areas, $subAreas, $edital, $users, $funcaoParticipantes, $participantes, $arquivos, $enum_turno]);

        $pdf = PDF::loadView('projeto.visualizar', compact('projeto', 'grandeAreas', 'areas', 'subAreas', 'edital', 'users', 'funcaoParticipantes', 'participantes', 'arquivos', 'enum_turno'))->setOptions(['defaultFont' => 'sans-serif']);

        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function edit($id)
    {
        if (Auth::user()->tipo == 'administrador') {
            $projeto = Trabalho::find($id);
        } else {
            $projeto = Auth::user()->proponentes->trabalhos()->where('id', $id)->first();
            if ($projeto->status != 'rascunho')
                return redirect()->back()->with('mensagem', 'Não é possível alterar uma proposta já submetida');
        }

        $proponente = Proponente::where('user_id', $projeto->proponente->user_id)->first();
        if (!$projeto) {
            return back()->withErrors(['Proposta não encontrada!']);
        }
        $edital = Evento::find($projeto->evento_id);
        $grandeAreas = GrandeArea::all();
        $areaTematicas = AreaTematica::orderBy('nome')->get();
        $areas = Area::all();
        $subareas = Subarea::all();
        $ODS = ObjetivoDeDesenvolvimentoSustentavel::orderBy('nome')->get();
        $funcaoParticipantes = FuncaoParticipantes::all();
        $participantes = Participante::where('trabalho_id', $id)->get();
        $participantesUsersIds = Participante::where('trabalho_id', $id)->select('user_id')->get();
        $users = User::whereIn('id', $participantesUsersIds)->get();
        $arquivos = Arquivo::where('trabalhoId', $id)->get();
        //dd(Participante::all());
        $rascunho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id', $edital->id)->where('status', 'Rascunho')
            ->orderByDesc('updated_at')->first();

        $trabalhos_user = TrabalhoUser::where('trabalho_id', $projeto->id)->get();

        return view('projeto.editar')->with([
            'projeto' => $projeto,
            'grandeAreas' => $grandeAreas,
            'areas' => $areas,
            'subAreas' => $subareas,
            'edital' => $edital,
            'users' => $users,
            'funcaoParticipantes' => $funcaoParticipantes,
            'participantes' => $participantes,
            'arquivos' => $arquivos,
            'enum_turno' => Participante::ENUM_TURNO,
            'estados' => $this->estados,
            'areaTematicas'        => $areaTematicas,
            'listaOds'                  => $ODS,
            'trabalhos_user' => $trabalhos_user,
            'proponente' => $proponente
        ]);
    }

    public function destroy(Request $request)
    {
        $projeto = Trabalho::find($request->id);
        //dd($trabalho);
        Storage::deleteDirectory('trabalhos/' . $projeto->evento->id . '/' . $projeto->id);

        $participantes = $projeto->participantes;
        foreach ($participantes as $participante) {
            $plano = $participante->planoTrabalho;
            if ($plano)
                $plano->delete();
            $participante->delete();
        }

        $projeto->delete();
        return redirect()->back()->with(['mensagem' => 'Projeto deletado com sucesso!']);
    }

    public function excluirParticipante($id)
    {
        $participante = Participante::where('id', $id)->first();
        //$participante = Participante::where('user_id', Auth()->user()->id)
        //                            ->where('trabalho_id', $id)->first();

        //$participante->trabalhos()->detach($id);
        $participante->delete();

        return redirect()->back();
    }

    public function solicitarCertificado(Trabalho $trabalho, Request $request)
    {
        $users = User::find($request->users);
        $coord = $trabalho->coordenador;
        $SolicitacaoCertificado = SolicitacaoCertificado::create();
        Notificacao::create([
            'remetente_id' => auth()->user()->id,
            'destinatario_id' => $coord->user_id,
            'solicitacao_certificado_id' => $SolicitacaoCertificado->id,
            'trabalho_id' => $trabalho->id,
            'lido' => false,
            'tipo' => 6
        ]);
        foreach ($users as $user) {
            SolicitacaoParticipante::create([
                'user_id' => $user->id,
                'solicitacao_certificado_id' => $SolicitacaoCertificado->id,
            ]);
        }
        $admins = Administrador::all();
        foreach ($admins as $admin) {
            $userTemp = User::find($admin->user_id);
            Notificacao::create([
                'remetente_id' => auth()->user()->id,
                'destinatario_id' => $admin->user_id,
                'solicitacao_certificado_id' => $SolicitacaoCertificado->id,
                'trabalho_id' => $trabalho->id,
                'lido' => false,
                'tipo' => 6,
            ]);
        }
        $destinatarios = $admins->map(function ($admin) {
            return $admin->user;
        })->push($coord->user);
        Notification::send($destinatarios, new SolicitacaoCertificadoNotification($trabalho->proponente, $trabalho, $userTemp, $users));
        return redirect()->route('trabalho.show', ['id' => $trabalho->id])->with('sucesso', 'Solicitação de certificado/declaração efetuada com sucesso!');
    }


    public function novaVersao(Request $request)
    {
        $mytime = Carbon::now('America/Recife');
        $mytime = $mytime->toDateString();
        $evento = Evento::find($request->eventoId);
        if ($evento->inicioSubmissao > $mytime) {
            if ($mytime >= $evento->fimSubmissao) {
                return redirect()->route('home');
            }
        }
        $validatedData = $request->validate([
            'arquivo' => ['required', 'file', 'mimes:pdf'],
            'eventoId' => ['required', 'integer'],
            'trabalhoId' => ['required', 'integer'],
        ]);

        $trabalho = Trabalho::find($request->trabalhoId);

        if (Auth::user()->id != $trabalho->autorId) {
            return redirect()->route('home');
        }

        $arquivos = $trabalho->arquivo;
        $count = 1;
        foreach ($arquivos as $key) {
            $key->versaoFinal = false;
            $key->save();
            $count++;
        }

        $file = $request->arquivo;
        $path = 'trabalhos/' . $request->eventoId . '/' . $trabalho->id . '/';
        $nome = $count . ".pdf";
        Storage::putFileAs($path, $file, $nome);

        $arquivo = Arquivo::create([
            'nome' => $path . $nome,
            'trabalhoId' => $trabalho->id,
            'versaoFinal' => true,
        ]);

        return redirect()->route('evento.visualizar', ['id' => $request->eventoId]);
    }

    public function detalhesAjax(Request $request)
    {
        $validatedData = $request->validate([
            'trabalhoId' => ['required', 'integer']
        ]);

        $trabalho = Trabalho::find($request->trabalhoId);
        $revisores = Atribuicao::where('trabalhoId', $request->trabalhoId)->get();
        $revisoresAux = [];
        foreach ($revisores as $key) {
            if ($key->revisor->user->name != null) {
                array_push($revisoresAux, [
                    'id' => $key->revisor->id,
                    'nomeOuEmail' => $key->revisor->user->name
                ]);
            } else {
                array_push($revisoresAux, [
                    'id' => $key->revisor->id,
                    'nomeOuEmail' => $key->revisor->user->email
                ]);
            }
        }
        $revisoresDisponeis = Revisor::where('eventoId', $trabalho->eventoId)->where('areaId', $trabalho->areaId)->get();
        $revisoresAux1 = [];
        foreach ($revisoresDisponeis as $key) {
            //verificar se ja é um revisor deste trabalhos
            $revisorNaoExiste = true;
            foreach ($revisoresAux as $key1) {
                if ($key->id == $key1['id']) {
                    $revisorNaoExiste = false;
                }
            }
            //
            if ($revisorNaoExiste) {
                if ($key->user->name != null) {
                    array_push($revisoresAux1, [
                        'id' => $key->id,
                        'nomeOuEmail' => $key->user->name
                    ]);
                } else {
                    array_push($revisoresAux1, [
                        'id' => $key->id,
                        'nomeOuEmail' => $key->user->email
                    ]);
                }
            }
        }
        return response()->json([
            'titulo' => $trabalho->titulo,
            'resumo' => $trabalho->resumo,
            'revisores' => $revisoresAux,
            'revisoresDisponiveis' => $revisoresAux1
        ], 200);
    }

    public function atribuirAvaliadorTrabalho(Request $request)
    {

        $request->trabalho_id;
        $trabalho = Trabalho::find($request->trabalho_id);

        $avaliadores = Avaliador::all();


        return view('coordenadorComissao.gerenciarEdital.atribuirAvaliadorTrabalho', ['avaliadores' => $avaliadores, 'trabalho' => $trabalho, 'evento' => $trabalho->evento]);
    }

    public function atribuir(Request $request)
    {

        $trabalho = Trabalho::find($request->trabalho_id);

        $todosAvaliadores = Avaliador::all();

        $avaliadores = Avaliador::whereIn('id', $request->avaliadores)->with('user')->get();

        $trabalho->avaliadors()->sync($request->avaliadores);

        foreach ($avaliadores as $key => $avaliador) {

            $user = $avaliador->user;
            $subject = "Trabalho atribuido";
            Mail::to($user->email)
                ->send(new EventoCriado($user, $subject));
        }

        return view('coordenadorComissao.detalhesEdital', ['evento' => $trabalho->evento]);
    }

    public function projetosDoEdital($id)
    {
        $edital = Evento::find($id);
        $projetos = Trabalho::where('evento_id', '=', $id)->get();
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();

        return view('proponente.projetosEdital')->with(['edital' => $edital, 'projetos' => $projetos, 'hoje' => $hoje]);
    }

    public function baixarAnexoProjeto($id)
    {
        $projeto = Trabalho::find($id);
        //dd($projeto);
        if (Storage::disk()->exists($projeto->anexoProjeto)) {
            ob_end_clean();
            return Storage::download($projeto->anexoProjeto);
        }
        return abort(404);
    }

    public function baixarAcaoAfirmativa($id)
    {
        $projeto = Trabalho::find($id);
        //dd($projeto);
        if (Storage::disk()->exists($projeto->anexo_acao_afirmativa)) {
            ob_end_clean();
            return Storage::download($projeto->anexo_acao_afirmativa);
        }
        return abort(404);
    }

    public function baixarCartaAnuencia($id)
    {
        $projeto = Trabalho::find($id);
        if (Storage::disk()->exists($projeto->anexo_carta_anuencia)) {
            ob_end_clean();
            return Storage::download($projeto->anexo_carta_anuencia);
        }
        return abort(404);
    }

    public function baixarAnexoGrupoPesquisa($id)
    {
        $projeto = Trabalho::find($id);
        if (Storage::disk()->exists($projeto->anexoGrupoPesquisa)) {
            ob_end_clean();
            return Storage::download($projeto->anexoGrupoPesquisa);
        }
        return abort(404);
    }

    public function baixarAnexoConsu($id)
    {
        $projeto = Trabalho::find($id);

        if (Storage::disk()->exists($projeto->anexoDecisaoCONSU)) {
            ob_end_clean();
            return Storage::download($projeto->anexoDecisaoCONSU);
        }
        return abort(404);
    }

    public function baixarAnexoComite($id)
    {
        $projeto = Trabalho::find($id);

        if (Storage::disk()->exists($projeto->anexoAutorizacaoComiteEtica)) {
            ob_end_clean();
            return Storage::download($projeto->anexoAutorizacaoComiteEtica);
        }
        return abort(404);
    }

    public function baixarAnexoLattes($id)
    {
        $projeto = Trabalho::find($id);

        if (Storage::disk()->exists($projeto->anexoLattesCoordenador)) {
            ob_end_clean();
            return Storage::download($projeto->anexoLattesCoordenador);
        }
        return abort(404);
    }

    public function baixarAnexoPlanilha($id)
    {
        $projeto = Trabalho::find($id);

        if (Storage::disk()->exists($projeto->anexoPlanilhaPontuacao)) {
            ob_end_clean();
            $file = $projeto->anexoPlanilhaPontuacao;
            $ext = explode(".", $file);

            switch ($ext[1]) {
                case 'xlsx':
                    $hearder = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    break;
                case 'xls':
                    $hearder = 'application/vnd.ms-excel';
                    break;
                case 'ods':
                    $hearder = 'application/vnd.oasis.opendocument.spreadsheet';
                    break;

                default:
                    $hearder = 'application/vnd.ms-excel';
                    break;
            }

            $headers = array(
                "Content-type: {$hearder}",
            );


            return Storage::download($projeto->anexoPlanilhaPontuacao, "Planilha.{$ext[1]}", $headers);
        }
        return abort(404);
    }

    public function baixarAnexoJustificativa($id)
    {
        $projeto = Trabalho::find($id);

        if (Storage::disk()->exists($projeto->justificativaAutorizacaoEtica)) {
            ob_end_clean();
            return Storage::download($projeto->justificativaAutorizacaoEtica);
        }

        return abort(404);
    }

    public function baixarAnexoDocExtra($id)
    {
        $projeto = Trabalho::find($id);
        if (Storage::disk()->exists($projeto->anexo_docExtra)) {
            ob_end_clean();
            return Storage::download($projeto->anexo_docExtra);
        }
        return abort(404);
    }

    public function baixarAnexoSIPAC($id)
    {
        $projeto = Trabalho::find($id);
        if (Storage::disk()->exists($projeto->anexo_SIPAC)) {
            ob_end_clean();
            return Storage::download($projeto->anexo_SIPAC);
        }
        return abort(404);
    }

    public function baixarAnexoTemp($eventoId, $nomeAnexo)
    {
        $proponente = Proponente::where('user_id', Auth::user()->id)->first();

        $trabalho = Trabalho::where('proponente_id', $proponente->id)->where('evento_id', $eventoId)->where('status', 'Rascunho')
            ->orderByDesc('updated_at')->first();

        if (Storage::disk()->exists($trabalho->$nomeAnexo)) {
            ob_end_clean();
            return Storage::download($trabalho->$nomeAnexo);
        }
        return abort(404);
    }

    public function baixarEventoTemp($nomeAnexo)
    {
        $eventoTemp = Evento::where('criador_id', Auth::user()->id)->where('anexosStatus', 'temporario')
            ->orderByDesc('updated_at')->first();

        return response()->download($eventoTemp->$nomeAnexo);
        if (!is_null($eventoTemp) && Storage::disk()->exists($eventoTemp->$nomeAnexo)) {
            ob_end_clean();
            return Storage::download($eventoTemp->$nomeAnexo);
        }
        return abort(404);
    }

    public function baixarModeloEventoTemp($nomeAnexo)
    {
        $eventoTemp = Evento::where('criador_id', Auth::user()->id)->where('anexosStatus', 'temporario')
            ->orderByDesc('updated_at')->first();

        if (!is_null($eventoTemp)) {
            ob_end_clean();
            return response()->download($eventoTemp->$nomeAnexo);
        }
        return abort(404);
    }

    //xxfa

    public function update(UpdateTrabalho $request, $id)
    {
        try {
            if (!$request->has('rascunho')) {
                $request->merge([
                    'status' => 'submetido'
                ]);
            } else {
                $request->merge([
                    'status' => 'rascunho'
                ]);
            }
            $evento = Evento::find($request->editalId);
            $request->merge([
                'coordenador_id' => $evento->coordenadorComissao->id
            ]);
            $trabalho = Trabalho::find($id);
            $trabalho->ods()->sync($request->ods);
            $proponente = Proponente::where('user_id', Auth::user()->id)->first();

            DB::beginTransaction();
            if (!$trabalho) {
                return back()->withErrors(['Proposta não encontrada']);
            }

            if ($evento->tipo == "PIBEX" || $evento->tipo == "PIBAC") {
                $trabalho->update($request->except([
                    'anexoProjeto',
                    'anexoDecisaoCONSU',
                    'modalidade',
                    'anexo_docExtra'
                ]));
            } else {
                $trabalho->update($request->except([
                    'anexoProjeto',
                    'anexoDecisaoCONSU',
                    'anexoPlanilhaPontuacao',
                    'anexoLattesCoordenador',
                    'anexoGrupoPesquisa',
                    'anexoAutorizacaoComiteEtica',
                    'justificativaAutorizacaoEtica',
                    'modalidade',
                    'anexo_docExtra'
                ]));
            }

            $pasta = 'trabalhos/' . $evento->id . '/' . $trabalho->id;

            $trabalho = $this->armazenarAnexosFinais($request, $pasta, $trabalho, $evento);
            $trabalho->save();


            if ($request->integrantesExistentes == null) {
                $request->integrantesExistentes = [];
            }
            $usuariosRemovidos = TrabalhoUser::where('trabalho_id', $trabalho->id)->whereNotIn('user_id', $request->integrantesExistentes)->get();

            if ($usuariosRemovidos->first() != null) {
                foreach ($usuariosRemovidos as $usuarioRemovido) {
                    $usuarioRemovido->delete();
                }
            }

            if ($evento->natureza_id == 3 && $request->integrantes != null) {
                foreach ($request->integrantes as $integrante) {
                    $integrante = explode(',', $integrante);
                    $trabalho_user = new TrabalhoUser();
                    $trabalho_user->user_id = $integrante[0];
                    $trabalho_user->funcao_participante_id = $integrante[1];
                    $trabalho_user->trabalho_id = $trabalho->id;
                    $trabalho_user->save();
                }
            }

            if ($evento->numParticipantes != 0) {
                if ($request->marcado == null) {
                    $idExcluido = $trabalho->participantes->pluck('id');
                } else {
                    $idExcluido = [];
                }

                foreach ($request->participante_id as $key => $value) {
                    if ($request->marcado != null && array_search($key, $request->marcado) === false) {
                        if ($value !== null)
                            array_push($idExcluido, $value);
                    }
                }


                foreach ($idExcluido as $key => $value) {
                    $trabalho->participantes()->find($value)->delete();
                }
                $trabalho->refresh();
            }

            if ($request->has('marcado')) {
                foreach ($request->marcado as $key => $part) {
                    $part = intval($part);
                    $passwordTemporario = Str::random(8);
                    $data['name'] = $request->name[$part];
                    $data['email'] = $request->email[$part];
                    $data['password'] = bcrypt($passwordTemporario);
                    $data['data_de_nascimento'] = $request->data_de_nascimento[$part];
                    $data['cpf'] = $request->cpf[$part];
                    $data['tipo'] = 'participante';
                    $data['funcao_participante_id'] = 4;
                    $data['rg'] = $request->rg[$part];
                    $data['celular'] = $request->celular[$part];
                    $data['cep'] = $request->cep[$part];
                    $data['uf'] = $request->uf[$part];
                    $data['cidade'] = $request->cidade[$part];
                    $data['rua'] = $request->rua[$part];
                    $data['numero'] = $request->numero[$part];
                    $data['bairro'] = $request->bairro[$part];
                    $data['complemento'] = $request->complemento[$part];

                    if ($request->instituicao[$part] != "Outra") {
                        $data['instituicao'] = $request->instituicao[$part];
                    } else {
                        $data['instituicao'] = $request->outrainstituicao[$part];
                    }

                    if ($request->curso[$part] != "Outro") {
                        $data['curso'] = $request->curso[$part];
                    } else {
                        $data['curso'] = $request->outrocurso[$part];
                    }

                    if ($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC") {
                        $data['turno'] = $request->turno[$part];
                        $data['periodo_atual'] = $request->periodo_atual[$part];
                        $data['ordem_prioridade'] = $request->ordem_prioridade[$part];
                        $data['total_periodos'] = $request->total_periodos[$part];
                        $data['media_do_curso'] = $request->media_do_curso[$part];
                    }
                    $data['nomePlanoTrabalho'] = $request->nomePlanoTrabalho[$part];

                    if ($request->participante_id[$part] != null) {
                        $participante = Participante::find($request->participante_id[$part]);
                        $user = User::where('email', 'ilike', $participante->user->email)->first();
                    } else {
                        $user = User::where('email', 'ilike', $data['email'])->first();
                    }




                    if ($user == null) {
                        $data['usuarioTemp'] = true;
                        $user = User::create($data);
                        $endereco = Endereco::create($data);
                        $endereco->user()->save($user);
                        $participante = Participante::create($data);
                        $participante->data_entrada = $participante->created_at;
                        $user->participantes()->save($participante);
                        $trabalho->participantes()->save($participante);
                        $participante->trabalho_id = $trabalho->id;
                        $participante->save();
                    } else {
                        // $user = $participante->user;
                        $user->update($data);
                        if ($user->endereco == null) {
                            $endereco = Endereco::create($data);
                            $endereco->user()->save($user);
                        } else {
                            $endereco = $user->endereco;
                            $endereco->update($data);
                        }
                        $participante = $user->participantes->where('trabalho_id', $trabalho->id)->where('id', $request->participante_id[$part])->first();
                        // dd($participante);
                        if ($participante == null) {
                            // dd('part null');
                            $participante = Participante::create($data);
                            $user->participantes()->save($participante);
                            $trabalho->participantes()->save($participante);
                        } else {
                            // dd('part update');
                            $participante->update($data);
                        }
                    }

                    if ($request->has('anexoPlanoTrabalho') && array_key_exists($part, $request->anexoPlanoTrabalho) && $request->nomePlanoTrabalho[$part] != null) {
                        if (Arquivo::where('participanteId', $participante->id)->where('trabalhoId', $trabalho->id)->count()) {
                            $arquivo = Arquivo::where('participanteId', $participante->id)->where('trabalhoId', $trabalho->id)->first();
                            $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                            $nome = $data['nomePlanoTrabalho'] . ".pdf";
                            $titulo = $data['nomePlanoTrabalho'];
                            $file = $request->anexoPlanoTrabalho[$part];
                            Storage::putFileAs($path, $file, $nome);
                            $arquivo->update([
                                'titulo' => $titulo,
                                'nome' => $path . $nome,
                                'data' => now(),
                            ]);
                        } else {
                            $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                            $nome = $data['nomePlanoTrabalho'] . ".pdf";
                            $file = $request->anexoPlanoTrabalho[$part];
                            Storage::putFileAs($path, $file, $nome);
                            $arquivo = new Arquivo();
                            $arquivo->titulo = $data['nomePlanoTrabalho'];
                            $arquivo->nome = $path . $nome;
                            $arquivo->trabalhoId = $trabalho->id;
                            $arquivo->data = now();
                            $arquivo->participanteId = $participante->id;
                            $arquivo->versaoFinal = true;
                            $arquivo->save();
                        }
                    }
                }
            } else {
                $data['nomePlanoTrabalho'] = $request->nomePlanoTrabalho;

                if (Arquivo::where('proponenteId', $proponente->id)->where('trabalhoId', $trabalho->id)->count()) {
                    $arquivo = Arquivo::where('proponenteId', $proponente->id)->where('trabalhoId', $trabalho->id)->first();
                    $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                    $nome = $data['nomePlanoTrabalho'] . ".pdf";
                    $titulo = $data['nomePlanoTrabalho'];
                    if ($request->has('anexoPlanoTrabalho')) {
                        $file = $request->anexoPlanoTrabalho;
                        Storage::putFileAs($path, $file, $nome);
                    } else {
                        if ($arquivo->nome != $path . $nome) {
                            Storage::rename($arquivo->nome, $path . $nome);
                        }
                    }
                    $arquivo->update([
                        'titulo' => $titulo,
                        'nome' => $path . $nome,
                        'data' => now(),
                    ]);
                } else {
                    $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                    $nome = $data['nomePlanoTrabalho'] . ".pdf";
                    $file = $request->anexoPlanoTrabalho;
                    Storage::putFileAs($path, $file, $nome);
                    $arquivo = new Arquivo();
                    $arquivo->titulo = $data['nomePlanoTrabalho'];
                    $arquivo->nome = $path . $nome;
                    $arquivo->trabalhoId = $trabalho->id;
                    $arquivo->data = now();
                    $arquivo->proponenteId = $proponente->id;
                    $arquivo->versaoFinal = true;
                    $arquivo->save();
                }
            }

            DB::commit();

            if (Auth::user()->tipo == 'administrador') {
                return redirect(route('admin.analisarProposta', ['id' => $trabalho->id]));
            }

            if (!$request->has('rascunho')) {
                Notification::send($trabalho->proponente->user, new SubmissaoNotification($trabalho));
            }

            return redirect(route('proponente.projetos'))->with(['mensagem' => 'Proposta atualizada!']);
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect(route('proponente.projetos'))->with(['mensagem' => $th->getMessage()]);
        }
    }

    public function adicionarParticipante(AdicionarIntegranteRequest $request, $id)
    {
        $usuario = User::where('cpf', $request->cpf_consulta)->first();

        if (!$this->validarQtdParticipantesEdital($id)) {
            return redirect(route('trabalho.show', ['id' => $id]))->with(['mensagem' => "Número máximo de integrantes do Edital alcançado, não é possivel inserir."]);
        }

        if (!$this->validarParticipanteRepetido($usuario->id, $id)) {
            return redirect(route('trabalho.show', ['id' => $id]))->with(['mensagem' => "Já existe um Integrante com esse CPF."]);
        }

        if (!$this->validarDataResultadoFinalPibex($id)) {
            return redirect(route('trabalho.show', ['id' => $id]))->with(['mensagem' => "Só é possivel adicionar integrantes após a data do Resultado final"]);
        }

        if (!$this->validarDataResultadoFinalPibac($id)) {
            return redirect(route('trabalho.show', ['id' => $id]))->with(['mensagem' => "Só é possivel adicionar integrantes após a data do Resultado final"]);
        }


        $atributos = [
            'user_id' => $usuario->id,
            'funcao_participante_id' => $request->funcao_participante,
            'trabalho_id' => $id,
            'data_entrada' => Date::now()->format('Y-m-d H:i:s')
        ];
        $rg = Participante::where('user_id', $atributos['user_id'])
            ->where('rg', '!=', null)
            ->latest()
            ->first();

        $data_de_nascimento = Participante::where('user_id', $atributos['user_id'])
            ->where('data_de_nascimento', '!=', null)
            ->latest()
            ->first();

        $curso = Participante::where('user_id', $atributos['user_id'])
            ->where('curso', '!=', null)
            ->latest()
            ->first();

        $linkLattes = Participante::where('user_id', $atributos['user_id'])
            ->where('linkLattes', '!=', null)
            ->latest()
            ->first();

        $curso_id = Participante::where('user_id', $atributos['user_id'])
            ->where('curso_id', '!=', null)
            ->latest()
            ->first();

        $atributo['rg'] = $rg ? $rg->rg : null;
        $atributo['data_de_nascimento'] = $data_de_nascimento ? $data_de_nascimento->data_de_nascimento : null;
        $atributo['curso'] = $curso ? $curso->curso : null;
        $atributo['linkLattes'] = $linkLattes ? $linkLattes->linkLattes : null;
        $atributo['curso_id'] = $curso_id ? $curso_id->curso_id : null;

        Participante::create($atributos);

        return redirect(route('trabalho.show', ['id' => $id]));
    }

    private function validarQtdParticipantesEdital($id)
    {
        $num_participantes_edital = Trabalho::where('id', $id)->first()->evento->numParticipantes;
        $num_participantes_projeto = count(Participante::where('trabalho_id', $id)->get());
        if ($num_participantes_projeto >= $num_participantes_edital) {
            return false;
        }

        return true;
    }

    private function validarParticipanteRepetido($usuario_id, $trabalho_id)
    {
        if (Participante::where('user_id', $usuario_id)->where('trabalho_id', $trabalho_id)->first()) {
            return false;
        }

        return true;
    }

    private function validarDataResultadoFinalPibex($id)
    {
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        $edital = Trabalho::where('id', $id)->first()->evento;

        if ($edital->tipo == "PIBEX" && $hoje <= $edital->resultado_final) {
            return false;
        }

        return true;
    }

    private function validarDataResultadoFinalPibac($id)
    {
        $hoje = Carbon::today('America/Recife');
        $hoje = $hoje->toDateString();
        $edital = Trabalho::where('id', $id)->first()->evento;

        if ($edital->tipo == "PIBAC" && $hoje <= $edital->resultado_final) {
            return false;
        }

        return true;
    }

    public function buscarUsuario(Request $request)
    {
        $usuario = User::where('cpf', $request->cpf_consulta)->first();
        $funcao = FuncaoParticipantes::where('id', $request->funcao)->first();

        if ($usuario) {
            $participante = $usuario->participantes()->first();

            if (!$participante)
                return json_encode([$usuario, $funcao]);

            if ($participante->curso == null && $participante->curso_id != null)
                $participante->curso = Curso::find($participante->curso_id)->nome;
            return json_encode([$usuario, $funcao, $participante, $usuario->endereco()->first()]);
        }

        return json_encode('inexistente');
    }


    public function salvar(StoreTrabalho $request)
    {
        //dd($request->all());
        try {
            if (!$request->has('rascunho')) {
                $request->merge([
                    'status' => 'submetido'
                ]);
            }
            $evento = Evento::find($request->editalId);
            $proponente = Proponente::where('user_id', Auth::user()->id)->first();
            $request->merge([
                'coordenador_id' => $evento->coordenadorComissao->id
            ]);


            DB::beginTransaction();

            if ($evento->tipo == "PIBEX" || $evento->tipo == "PIACEX" || $evento->tipo == "PIBAC") {
                if ($evento->tipo == "PIBAC") {
                    $trabalho = Auth::user()->proponentes->trabalhos()
                        ->create($request->except([
                            'anexoProjeto',
                            'anexoDecisaoCONSU',
                            'modalidade',
                            'anexo_docExtra',
                            'anexo_SIPAC',
                            'area_tematica_id'
                        ]));
                } else {
                    $trabalho = Auth::user()->proponentes->trabalhos()
                        ->create($request->except([
                            'anexoProjeto',
                            'anexoDecisaoCONSU',
                            'modalidade',
                            'anexo_docExtra',
                            'anexo_SIPAC'
                        ]));
                }
            } else if ($evento->tipo == "CONTINUO" || $evento->tipo == "CONTINUO-AC" || $evento->tipo == "PROGRAMAS-EXTENSAO") {
                if ($evento->tipo == "CONTINUO-AC") {
                    $trabalho = Auth::user()->proponentes->trabalhos()
                        ->create($request->except([
                            'anexoProjeto',
                            'anexoDecisaoCONSU',
                            'anexoPlanilhaPontuacao',
                            'anexoLattesCoordenador',
                            'anexoGrupoPesquisa',
                            'anexoAutorizacaoComiteEtica',
                            'justificativaAutorizacaoEtica',
                            'modalidade',
                            'anexo_docExtra',
                            'area_tematica_id',
                        ]));
                } else {
                    $trabalho = Auth::user()->proponentes->trabalhos()
                        ->create($request->except([
                            'anexoProjeto',
                            'anexoDecisaoCONSU',
                            'anexoPlanilhaPontuacao',
                            'anexoLattesCoordenador',
                            'anexoGrupoPesquisa',
                            'anexoAutorizacaoComiteEtica',
                            'justificativaAutorizacaoEtica',
                            'modalidade',
                            'anexo_docExtra',
                        ]));
                }
            } else {
                //dd();
                if ($evento->tipo ==  "PICP") {
                    $trabalho = Auth::user()->proponentes->trabalhos()
                        ->create($request->except([
                            'anexoProjeto',
                            'anexoDecisaoCONSU',
                            'anexoAutorizacaoComiteEtica',
                            'justificativaAutorizacaoEtica'
                        ]));
                } else {
                    if ($evento->tipo == "PIBIC" || $evento->tipo == "PIBIC-AF" || $evento->tipo == "PIBIC-EM") {
                        $trabalho = Auth::user()->proponentes->trabalhos()
                            ->create($request->except([
                                'anexoProjeto',
                                'anexoDecisaoCONSU',
                                'anexoPlanilhaPontuacao',
                                'anexoLattesCoordenador',
                                'anexoAutorizacaoComiteEtica',
                                'justificativaAutorizacaoEtica',
                                'modalidade',
                                'anexo_docExtra',
                                'anexo_SIPAC',
                                'anexo_acao_afirmativa',
                                'anexo_carta_anuencia'
                            ]));
                    } else {
                        $trabalho = Auth::user()->proponentes->trabalhos()
                            ->create($request->except([
                                'anexoProjeto',
                                'anexoDecisaoCONSU',
                                'anexoPlanilhaPontuacao',
                                'anexoLattesCoordenador',
                                'anexoGrupoPesquisa',
                                'anexoAutorizacaoComiteEtica',
                                'justificativaAutorizacaoEtica',
                                'modalidade',
                                'anexo_docExtra',
                                'anexo_SIPAC',
                                'anexo_acao_afirmativa',
                                'anexo_carta_anuencia'
                            ]));
                    }
                }
            }

            //adição dos participantes
            if ($request->has('marcado')) {
                foreach ($request->marcado as $key => $part) {
                    $part = intval($part);

                    $data['name'] = $request->name[$part];
                    $data['email'] = $request->email[$part];
                    $data['cpf'] = $request->cpf[$part];
                    //Quando o integrante é um estudante
                    if ($request->estudante[$part] == true) {
                        if ($request->data_de_nascimento[$part] == null) {
                            $data_nascimento = null;
                        } else {
                            $data_nascimento = Carbon::createFromFormat('d/m/Y', $request->data_de_nascimento[$part])->toDateString();
                        }
                        $data['data_de_nascimento'] = $data_nascimento;
                        $data['rg'] = $request->rg[$part];
                        $data['celular'] = $request->celular[$part];
                        $data['cep'] = $request->cep[$part];
                        $data['uf'] = $request->uf[$part];
                        $data['cidade'] = $request->cidade[$part];
                        $data['rua'] = $request->rua[$part];
                        $data['numero'] = $request->numero[$part];
                        $data['bairro'] = $request->bairro[$part];
                        if ($request->complemento[$part] == null) {
                            $data['complemento'] = "";
                        } else {
                            $data['complemento'] = $request->complemento[$part];
                        }

                        if ($request->total_periodos) {
                            $data['total_periodos'] = $request->total_periodos[$part];
                            $data['turno'] = $request->turno[$part];
                            $data['periodo_atual'] = $request->periodo_atual[$part];

                            if ($evento->tipo != "PICP") {
                                $data['ordem_prioridade'] = $request->ordem_prioridade[$part];
                            }
                        }

                        if ($request->curso[$part] != "Outro") {
                            $data['curso'] = $request->curso[$part];
                        } else {
                            $data['curso'] = $request->outrocurso[$part];
                        }

                        if ($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PROGRAMAS-EXTENSAO") {
                            if ($evento->tipo != "PIBEX" && $evento->tipo != "PIACEX" && $evento->tipo != "PIBAC") {
                                $data['media_do_curso'] = $request->media_do_curso[$part];
                            }
                            $data['nomePlanoTrabalho'] = $request->nomePlanoTrabalho[$part];
                        }
                    }

                    //função no projeto
                    if ($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PROGRAMAS-EXTENSAO") {
                        if (FuncaoParticipantes::where('nome', $request->funcaoParticipante[$part])->exists())
                            $data['funcao_participante_id'] = FuncaoParticipantes::where('nome', $request->funcaoParticipante[$part])->first()->id;
                    }

                    //instituição do participante
                    if ($request->instituicao[$part] != "Outra") {
                        $data['instituicao'] = $request->instituicao[$part];
                    } else {
                        $data['instituicao'] = $request->outrainstituicao[$part];
                    }

                    $user = User::where('email', 'ilike', $data['email'])->first();

                    if ($user == null) {
                        $data['usuarioTemp'] = true;
                        $user = User::create($data);
                        $endereco = Endereco::create($data);
                        $endereco->user()->save($user);
                    }
                    // $participante = $user->participantes->where('trabalho_id', $trabalho->id)->first();
                    // if ($participante == null){
                    //   $participante = Participante::create($data);
                    // }
                    $participante = Participante::create($data);
                    $participante->data_entrada = $participante->created_at;
                    $user->participantes()->save($participante);

                    $participante->trabalho_id = $trabalho->id;
                    $participante->save();

                    if ($evento->tipo != "CONTINUO" && $evento->tipo != "CONTINUO-AC" && $evento->tipo != "PROGRAMAS-EXTENSAO") {
                        if ($request->estudante[$part] == true && $request['nomePlanoTrabalho'][$part] != null) {
                            $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                            $nome = $request['nomePlanoTrabalho'][$part] . ".pdf";
                            $file = $request->anexoPlanoTrabalho[$part];
                            Storage::putFileAs($path, $file, $nome);
                            $arquivo = new Arquivo();
                            $arquivo->titulo = $request['nomePlanoTrabalho'][$part];
                            $arquivo->nome = $path . $nome;
                            $arquivo->trabalhoId = $trabalho->id;
                            $arquivo->data = now();
                            $arquivo->participanteId = $participante->id;
                            $arquivo->versaoFinal = true;
                            $arquivo->save();
                        }
                    }

                    if ($evento->tipo == "CONTINUO" || $evento->tipo == "CONTINUO-AC" || $evento->tipo == "PROGRAMAS-EXTENSAO") {
                        $arquivo = new Arquivo();
                        $arquivo->titulo = $request['titulo'];
                        $arquivo->nome = $request['titulo'];
                        $arquivo->trabalhoId = $trabalho->id;
                        $arquivo->data = now();
                        $arquivo->participanteId = $participante->id;
                        $arquivo->versaoFinal = true;
                        $arquivo->save();
                    }
                }
            } else {
                $data['nomePlanoTrabalho'] = $request->nomePlanoTrabalho;
                if ($request->has('anexoPlanoTrabalho')) {
                    $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                    $nome = $data['nomePlanoTrabalho'] . ".pdf";
                    $file = $request->anexoPlanoTrabalho;
                    Storage::putFileAs($path, $file, $nome);
                    $arquivo = new Arquivo();
                    $arquivo->titulo = $data['nomePlanoTrabalho'];
                    $arquivo->nome = $path . $nome;
                    $arquivo->trabalhoId = $trabalho->id;
                    $arquivo->data = now();
                    $arquivo->proponenteId = $proponente->id;
                    $arquivo->versaoFinal = true;
                    $arquivo->save();
                }
            }

            $evento->trabalhos()->save($trabalho);

            $pasta = 'trabalhos/' . $evento->id . '/' . $trabalho->id;
            $trabalho = $this->armazenarAnexosFinais($request, $pasta, $trabalho, $evento);
            $trabalho->modalidade = $request->modalidade;
            $trabalho->save();


            // if($evento->natureza_id == 3){
            //     foreach($request->integrantes as $integrante){
            //         $integrante = explode(',', $integrante); 

            //         $trabalho_user = new TrabalhoUser();
            //         $trabalho_user->user_id = $integrante[0];
            //         $trabalho_user->funcao_participante_id = $integrante[1];
            //         $trabalho_user->trabalho_id = $trabalho->id;
            //         $trabalho_user->save();
            //     }
            // }

            $trabalho->ods()->sync($request->ods);
            if ($evento->tipo == "PIBAC" || $evento->tipo == "CONTINUO-AC") {
                $trabalho->area_tematica_pibac()->sync($request->area_tematica_id);
            }

            DB::commit();
            if (!$request->has('rascunho')) {
                //Notificações
                //Coordenador
                $userTemp = User::find($evento->coordenadorComissao->user_id);
                $notificacao = App\Notificacao::create([
                    'remetente_id' => Auth::user()->id,
                    'destinatario_id' => $evento->coordenadorComissao->user_id,
                    'trabalho_id' => $trabalho->id,
                    'lido' => false,
                    'tipo' => 1,
                ]);
                $notificacao->save();
                // SubmissaoRecebidaNotification.php
                Notification::send($userTemp, new SubmissaoRecebidaNotification($trabalho->id, $trabalho->titulo, $userTemp));
                //Proponente
                $notificacao = App\Notificacao::create([
                    'remetente_id' => Auth::user()->id,
                    'destinatario_id' => Auth::user()->id,
                    'trabalho_id' => $trabalho->id,
                    'lido' => false,
                    'tipo' => 1,
                ]);
                $notificacao->save();
                // submissao e notificação.php  $trabalho->id,$trabalho->titulo
                Notification::send(Auth::user(), new SubmissaoNotification($trabalho));


                return redirect(route('proponente.projetos'))->with(['mensagem' => 'Proposta submetida!']);
            } else {
                return redirect(route('proponente.projetos'))->with(['mensagem' => 'Rascunho salvo!']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            //dd($th);
            return redirect(route('proponente.projetos'))->withErrors(['mensagem' => 'Não foi possível realizar a submissão do Projeto!']);
        }
    }

    public function atribuirDados(Request $request, $edital, Trabalho $projeto = null)
    {
        if ($projeto == null) {
            $projeto = new Trabalho();
        }

        $proponente = User::find(auth()->user()->id)->proponentes;
        $hoje = now();

        $projeto->titulo = $request->nomeProjeto;
        $projeto->coordenador_id = $edital->coordenadorComissao->id;
        $projeto->grande_area_id = $request->grandeArea;
        $projeto->area_id = $request->area;
        $projeto->sub_area_id = $request->subArea;
        $projeto->pontuacaoPlanilha = $request->pontuacaoPlanilha;
        $projeto->linkGrupoPesquisa = $request->linkGrupo;
        $projeto->linkLattesEstudante = $request->linkLattesEstudante;
        $projeto->data = $hoje;
        $projeto->evento_id = $request->editalId;
        $projeto->status = 'submetido';
        $projeto->proponente_id = $proponente->id;
        $projeto->conflitosInteresse = $request->conflitosInteresse;

        // Salvando anexos no storage
        $projeto->save();
        $pasta = 'trabalhos/' . $edital->id . '/' . $projeto->id;

        $projeto = $this->armazenarAnexosFinais($request, $pasta, $projeto, $edital);

        return $projeto;
    }

    public function salvarParticipantes(Request $request, $edital, $projeto, $edicao = false)
    {
        if ($edicao) {

            $participantes = $projeto->participantes;
            $participantesPermanecem = collect();
            // dd($request->all());
            foreach ($request->participante_id as $key => $id) {
                // Novo participante
                if ($id == 0 || $id == null) {
                    $userParticipante = User::where('email', 'ilike', $request->emailParticipante[$key])->first();

                    $participante = new Participante();

                    if ($userParticipante == null) {
                        $passwordTemporario = Str::random(8);

                        $usuario = new User();
                        $usuario->email = $request->emailParticipante[$key];
                        $usuario->password = bcrypt($passwordTemporario);
                        $usuario->usuarioTemp = false;
                        $usuario->name = $request->nomeParticipante[$key];
                        $usuario->tipo = 'participante';
                        $usuario->instituicao = $request->universidade[$key];
                        $usuario->cpf = $request->cpf[$key];
                        $usuario->celular = $request->celular[$key];

                        $endereco = new Endereco();
                        $endereco->rua = $request->rua[$key];
                        $endereco->numero = $request->numero[$key];
                        $endereco->bairro = $request->bairro[$key];
                        $endereco->cidade = $request->cidade[$key];
                        $endereco->uf = $request->uf[$key];
                        $endereco->cep = $request->cep[$key];
                        $endereco->complemento = $request->complemento[$key];
                        $endereco->save();

                        $usuario->enderecoId = $endereco->id;

                        $usuario->save();

                        $participante->user_id = $usuario->id;
                        $participante->trabalho_id = $projeto->id;
                        $participante->funcao_participante_id = $request->funcaoParticipante[$key];
                        $participante->confirmacao_convite = true;
                        $participante->rg = $request->rg[$key];
                        $participante->data_de_nascimento = $request->data_de_nascimento[$key];
                        $participante->curso = $request->curso[$key];
                        $participante->turno = $request->turno[$key];
                        $participante->ordem_prioridade = $request->ordem_prioridade[$key];
                        $participante->periodo_atual = $request->periodo_atual[$key];
                        $participante->total_periodos = $request->total_periodos[$key];
                        if ($edital->tipo != "PIBEX" && $edital->tipo != "PIBAC") {
                            $participante->media_do_curso = $request->media_geral_curso[$key];
                        }
                        $participante->save();


                        $subject = "Participante de Projeto";
                        Mail::to($request->emailParticipante[$key])->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, $projeto->titulo, 'Participante', $edital->nome, $passwordTemporario, $subject, $edital->tipo, $edital->natureza_id));
                    } else {

                        $participante->user_id = $userParticipante->id;
                        $participante->trabalho_id = $projeto->id;
                        $participante->funcao_participante_id = $request->funcaoParticipante[$key];
                        $participante->confirmacao_convite = true;
                        $participante->rg = $request->rg[$key];
                        $participante->data_de_nascimento = $request->data_de_nascimento[$key];
                        $participante->curso = $request->curso[$key];
                        $participante->turno = $request->turno[$key];
                        $participante->ordem_prioridade = $request->ordem_prioridade[$key];
                        $participante->periodo_atual = $request->periodo_atual[$key];
                        $participante->total_periodos = $request->total_periodos[$key];
                        if ($edital->tipo != "PIBEX" && $edital->tipo != "PIBAC") {
                            $participante->media_do_curso = $request->media_geral_curso[$key];
                        }
                        $participante->save();

                        $subject = "Participante de Projeto";
                        Mail::to($request->emailParticipante[$key])
                            ->send(new SubmissaoTrabalho($userParticipante, $subject, $edital, $projeto));
                    }

                    if ($request->nomePlanoTrabalho[$key] != null) {
                        $usuario = User::where('email', 'ilike', $request->emailParticipante[$key])->first();
                        $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $projeto->id]])->first();

                        $path = 'trabalhos/' . $edital->id . '/' . $projeto->id . '/';
                        $nome = $request->nomePlanoTrabalho[$key] . ".pdf";
                        $file = $request->anexoPlanoTrabalho[$key];
                        Storage::putFileAs($path, $file, $nome);

                        $agora = now();
                        $arquivo = new Arquivo();
                        $arquivo->titulo = $request->nomePlanoTrabalho[$key];
                        $arquivo->nome = $path . $nome;
                        $arquivo->trabalhoId = $projeto->id;
                        $arquivo->data = $agora;
                        $arquivo->participanteId = $participante->id;
                        $arquivo->versaoFinal = true;
                        $arquivo->save();
                        // dd($arquivo);
                    }
                    // Editado
                } elseif ($id > 0) {
                    // Removo dos cantidatos excluidos
                    $participante = Participante::find($id);
                    $participantesPermanecem->push($participante);
                    $usuario = $participante->user;
                    $endereco = $usuario->endereco;

                    $usuario->usuarioTemp = false;
                    $usuario->name = $request->nomeParticipante[$key];
                    $usuario->tipo = 'participante';
                    $usuario->instituicao = $request->universidade[$key];
                    $usuario->cpf = $request->cpf[$key];
                    $usuario->celular = $request->celular[$key];

                    $usuario->update();

                    $endereco->rua = $request->rua[$key];
                    $endereco->numero = $request->numero[$key];
                    $endereco->bairro = $request->bairro[$key];
                    $endereco->cidade = $request->cidade[$key];
                    $endereco->uf = $request->uf[$key];
                    $endereco->cep = $request->cep[$key];
                    $endereco->complemento = $request->complemento[$key];
                    $endereco->update();

                    $participante->rg = $request->rg[$key];
                    $participante->data_de_nascimento = $request->data_de_nascimento[$key];
                    $participante->curso = $request->curso[$key];
                    $participante->turno = $request->turno[$key];
                    $participante->ordem_prioridade = $request->ordem_prioridade[$key];
                    $participante->periodo_atual = $request->periodo_atual[$key];
                    $participante->total_periodos = $request->total_periodos[$key];
                    if ($edital->tipo != "PIBEX" && $edital->tipo != "PIBAC") {
                        $participante->media_do_curso = $request->media_geral_curso[$key];
                    }
                    $participante->update();

                    if ($request->anexoPlanoTrabalho != null && array_key_exists($key, $request->anexoPlanoTrabalho) && $request->anexoPlanoTrabalho[$key] != null) {

                        $planoAtual = $participante->planoTrabalho;
                        if (Storage::disk()->exists($planoAtual->nome)) {
                            Storage::delete($planoAtual->nome);
                        }
                        $planoAtual->delete();

                        $path = 'trabalhos/' . $edital->id . '/' . $projeto->id . '/';
                        $nome = $request->nomePlanoTrabalho[$key] . ".pdf";
                        $file = $request->anexoPlanoTrabalho[$key];
                        Storage::putFileAs($path, $file, $nome);

                        $agora = now();
                        $arquivo = new Arquivo();
                        $arquivo->titulo = $request->nomePlanoTrabalho[$key];
                        $arquivo->nome = $path . $nome;
                        $arquivo->trabalhoId = $projeto->id;
                        $arquivo->data = $agora;
                        $arquivo->participanteId = $id;
                        $arquivo->versaoFinal = true;
                        $arquivo->save();
                    }
                }
            }
            // Excluidos
            $participantesExcluidos = $participantes->diff($participantesPermanecem);
            foreach ($participantesExcluidos as $participante) {
                $plano = $participante->planoTrabalho;
                if ($plano)
                    $plano->delete();
                $participante->delete();
            }

            return true;
        }
        if ($request->emailParticipante != null) {
            foreach ($request->emailParticipante as $key => $email) {
                $userParticipante = User::where('email', 'ilike', $email)->first();

                $participante = new Participante();

                if ($userParticipante == null) {
                    $passwordTemporario = Str::random(8);

                    $usuario = new User();
                    $usuario->email = $email;
                    $usuario->password = bcrypt($passwordTemporario);
                    $usuario->usuarioTemp = false;
                    $usuario->name = $request->nomeParticipante[$key];
                    $usuario->tipo = 'participante';
                    $usuario->instituicao = $request->universidade[$key];
                    $usuario->cpf = $request->cpf[$key];
                    $usuario->celular = $request->celular[$key];

                    $endereco = new Endereco();
                    $endereco->rua = $request->rua[$key];
                    $endereco->numero = $request->numero[$key];
                    $endereco->bairro = $request->bairro[$key];
                    $endereco->cidade = $request->cidade[$key];
                    $endereco->uf = $request->uf[$key];
                    $endereco->cep = $request->cep[$key];
                    $endereco->complemento = $request->complemento[$key];
                    $endereco->save();

                    $usuario->enderecoId = $endereco->id;

                    $usuario->save();

                    $participante->user_id = $usuario->id;
                    $participante->trabalho_id = $projeto->id;
                    $participante->funcao_participante_id = $request->funcaoParticipante[$key];
                    $participante->confirmacao_convite = true;
                    $participante->rg = $request->rg[$key];
                    $participante->data_de_nascimento = $request->data_de_nascimento[$key];
                    $participante->curso = $request->curso[$key];
                    $participante->turno = $request->turno[$key];
                    $participante->ordem_prioridade = $request->ordem_prioridade[$key];
                    $participante->periodo_atual = $request->periodo_atual[$key];
                    $participante->total_periodos = $request->total_periodos[$key];
                    if ($edital->tipo != "PIBEX" && $edital->tipo != "PIBAC") {
                        $participante->media_do_curso = $request->media_geral_curso[$key];
                    }
                    $participante->save();

                    $usuario = User::where('email', 'ilike', $email)->first();
                    $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $projeto->id]])->first();

                    $path = 'trabalhos/' . $edital->id . '/' . $projeto->id . '/';
                    $nome = $request->nomePlanoTrabalho[$key] . ".pdf";
                    $file = $request->anexoPlanoTrabalho[$key];
                    Storage::putFileAs($path, $file, $nome);

                    $agora = now();
                    $arquivo = new Arquivo();
                    $arquivo->titulo = $request->nomePlanoTrabalho[$key];
                    $arquivo->nome = $path . $nome;
                    $arquivo->trabalhoId = $projeto->id;
                    $arquivo->data = $agora;
                    $arquivo->participanteId = $participante->id;
                    $arquivo->versaoFinal = true;
                    $arquivo->save();
                    $subject = "Participante de Projeto";
                    Mail::to($email)->send(new EmailParaUsuarioNaoCadastrado(Auth()->user()->name, $projeto->titulo, 'Participante', $edital->nome, $passwordTemporario, $subject, $edital->tipo, $edital->natureza_id));
                } else {

                    $participante->user_id = $userParticipante->id;
                    $participante->trabalho_id = $projeto->id;
                    $participante->funcao_participante_id = $request->funcaoParticipante[$key];
                    $participante->confirmacao_convite = true;
                    $participante->rg = $request->rg[$key];
                    $participante->data_de_nascimento = $request->data_de_nascimento[$key];
                    $participante->curso = $request->curso[$key];
                    $participante->turno = $request->turno[$key];
                    $participante->ordem_prioridade = $request->ordem_prioridade[$key];
                    $participante->periodo_atual = $request->periodo_atual[$key];
                    $participante->total_periodos = $request->total_periodos[$key];
                    if ($edital->tipo != "PIBEX" && $edital->tipo != "PIBAC") {
                        $participante->media_do_curso = $request->media_geral_curso[$key];
                    }
                    $participante->save();


                    if ($request->anexoPlanoTrabalho[$key]) {
                        $path = 'trabalhos/' . $edital->id . '/' . $projeto->id . '/';
                        $nome = $request->nomePlanoTrabalho[$key] . ".pdf";
                        $file = $request->anexoPlanoTrabalho[$key];
                        Storage::putFileAs($path, $file, $nome);

                        $agora = now();
                        $arquivo = new Arquivo();
                        $arquivo->titulo = $request->nomePlanoTrabalho[$key];
                        $arquivo->nome = $path . $nome;
                        $arquivo->trabalhoId = $projeto->id;
                        $arquivo->data = $agora;
                        $arquivo->participanteId = $participante->id;
                        $arquivo->versaoFinal = true;
                        $arquivo->save();
                    }

                    $subject = "Participante de Projeto";
                    $time = Carbon::today('America/Recife');
                    $time = $time->isoFormat('às H:mm, dddd, D/M/YYYY');
                    Mail::to($email)
                        ->send(new SubmissaoTrabalho($userParticipante, $subject, $edital, $projeto));
                }

                // if($request->nomePlanoTrabalho[$key] != null){
                //   $usuario = User::where('email', $email)->first();
                //   $participante = Participante::where([['user_id', '=', $usuario->id], ['trabalho_id', '=', $projeto->id]])->first();

                //   $path = 'trabalhos/' . $edital->id . '/' . $projeto->id .'/';
                //   $nome =  $request->nomePlanoTrabalho[$key] .".pdf";
                //   $file = $request->anexoPlanoTrabalho[$key];
                //   Storage::putFileAs($path, $file, $nome);

                //   $agora = now();
                //   $arquivo = new Arquivo();
                //   $arquivo->titulo = $request->nomePlanoTrabalho[$key];
                //   $arquivo->nome = $path . $nome;
                //   $arquivo->trabalhoId = $projeto->id;
                //   $arquivo->data = $agora;
                //   $arquivo->participanteId = $participante->id;
                //   $arquivo->versaoFinal = true;
                //   $arquivo->save();
                // }
            }
        }

        return true;
    }

    public function atualizar(Request $request, $id)
    {
        $edital = Evento::find($request->editalId);
        $hoje = now();

        $projeto = Trabalho::find($id);

        if (!($edital->inicioSubmissao < $hoje && $edital->fimSubmissao >= $hoje)) {
            return redirect()->route('inicial')->with(['error' => 0, 'mensagem' => 'As submissões para o edital ' . $edital->titulo . ' foram encerradas.']);
        }

        $projeto = $this->atribuirDados($request, $edital, $projeto);
        $projeto->update();

        // dd($request->all());
        // Salvando participantes
        $this->salvarParticipantes($request, $edital, $projeto, true);

        return redirect(route('proponente.projetos'))->with(['mensagem' => 'Projeto atualizado com sucesso!']);
    }


    public function telaTrocaPart(Request $request)
    {
        $funcaoParticipantes = FuncaoParticipantes::orderBy('nome')->get();
        $projeto = Trabalho::find($request->projeto_id);
        $edital = Evento::find($projeto->evento_id);

        if (Auth::user()->id != $projeto->proponente->user->id) {
            return redirect()->back();
        }

        $participantes = $projeto->participantes;
        $substituicoesProjeto = Substituicao::where('trabalho_id', $projeto->id)->orderBy('created_at', 'DESC')->get();
        $desligamentosProjeto = Desligamento::where('trabalho_id', $projeto->id)->orderBy('created_at', 'DESC')->get();

        return view('administrador.substituirParticipante')->with([
            'projeto' => $projeto,
            'edital' => $edital,
            'participantes' => $participantes,
            'substituicoesProjeto' => $substituicoesProjeto,
            'estados' => $this->estados,
            'enum_turno' => Participante::ENUM_TURNO,
            'desligamentosProjeto' => $desligamentosProjeto,
            'funcaoParticipantes' => $funcaoParticipantes
        ]);
    }

    public function trocaParticipante(Request $request)
    {
        //dd($request->all());
        try {
            DB::beginTransaction();
            $trabalho = Trabalho::find($request->projetoId);
            $evento = Evento::find($request->editalId);
            $participanteSubstituido = Participante::where('id', $request->participanteId)->first();
            $usuarioNovo = User::where('id', $request->novoParticianteId)->first();
            $enderecoUsuarioNovo = $usuarioNovo ? $usuarioNovo->endereco : null;
            $participanteNovo = $usuarioNovo ? $usuarioNovo->participantes->first() : null;
            $planoAntigo = Arquivo::where('id', $participanteSubstituido->planoTrabalho->id)->first();

            $passwordTemporario = Str::random(8);
            $data['name'] = $usuarioNovo ? $usuarioNovo->name : null;
            $data['email'] = $usuarioNovo ? $usuarioNovo->email : null;
            $data['password'] = $usuarioNovo ? $usuarioNovo->password : null;
            $data['data_de_nascimento'] = $participanteNovo ? $participanteNovo->data_de_nascimento : null;
            $data['data_entrada'] = $request->data_entrada;
            $data['cpf'] = $usuarioNovo ? $usuarioNovo->cpf : null; //$request->cpf;
            $data['tipo'] = 'participante';
            $data['funcao_participante_id'] = 4;
            $data['rg'] = $participanteNovo ? $participanteNovo->rg : null; //$request->rg;
            $data['celular'] = $usuarioNovo ? $usuarioNovo->celular : null; //$request->celular;
            $data['linkLattes'] = $participanteNovo ? $participanteNovo->linkLattes : null; //$request->linkLattes;
            $data['cep'] = $enderecoUsuarioNovo ? $enderecoUsuarioNovo->cep : null; //$request->cep;
            $data['uf'] = $enderecoUsuarioNovo ? $enderecoUsuarioNovo->uf : null; //$request->uf;
            $data['cidade'] = $enderecoUsuarioNovo ? $enderecoUsuarioNovo->cidade : null; //$request->cidade;
            $data['rua'] = $enderecoUsuarioNovo ? $enderecoUsuarioNovo->rua : null; //$request->rua;
            $data['numero'] = $enderecoUsuarioNovo ? $enderecoUsuarioNovo->numero : null; //$request->numero;
            $data['bairro'] = $enderecoUsuarioNovo ? $enderecoUsuarioNovo->bairro : null; //$request->bairro;
            $data['complemento'] = $enderecoUsuarioNovo ? $enderecoUsuarioNovo->complemento : null; //$request->complemento;
            //dd($request->all());
            if ($request->instituicao != "Outra") {
                $data['instituicao'] = $request->instituicao;
            } else {
                $data['instituicao'] = $request->outrainstituicao;
            }

            $data['total_periodos'] = $request->total_periodos;

            if ($request->curso != "Outro") {
                $data['curso'] = $request->curso;
            } else {
                $data['curso'] = $request->outrocurso;
            }

            $data['turno'] = $request->turno;
            $data['periodo_atual'] = $request->periodo_atual;
            $data['ordem_prioridade'] = $request->ordem_prioridade;
            if ($evento->tipo != "PIBEX" && $evento->tipo != "PIBAC") {
                $data['media_do_curso'] = $request->media_do_curso;
            }
            $data['nomePlanoTrabalho'] = $request->nomePlanoTrabalho;

            if ($request->substituirApenasPlanoCheck == 'check') {
                $substituicao = new Substituicao();

                if ($request->has('anexoPlanoTrabalho')) {
                    $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                    $nome = $data['nomePlanoTrabalho'] . ".pdf";
                    $file = $request->anexoPlanoTrabalho;
                    Storage::putFileAs($path, $file, $nome);
                    $arquivo = new Arquivo();
                    $arquivo->titulo = $data['nomePlanoTrabalho'];
                    $arquivo->nome = $path . $nome;
                    $arquivo->trabalhoId = $trabalho->id;
                    $arquivo->data = now();
                    $arquivo->participanteId = $participanteSubstituido->id;
                    $arquivo->versaoFinal = true;
                    $arquivo->save();

                    $substituicao->status = 'Em Aguardo';
                    $substituicao->tipo = 'TrocarPlano';
                    $substituicao->observacao = $request->textObservacao;
                    $substituicao->participanteSubstituido_id = $participanteSubstituido->id;
                    $substituicao->participanteSubstituto_id = $participanteSubstituido->id;
                    $substituicao->planoSubstituto_id = $arquivo->id;
                    $substituicao->trabalho_id = $trabalho->id;
                    $substituicao->save();
                }
            } else {
                //$participanteSubstituido->delete();
                $substituicao = new Substituicao();
                $substituicao->observacao = $request->textObservacao;
                if ($participanteSubstituido->data_entrada > $request->data_entrada) {
                    return redirect(route('trabalho.trocaParticipante', ['evento_id' => $evento->id, 'projeto_id' => $trabalho->id]))->with(['erro' => "Escolha uma data de entrada posterior a entrada do discente substituído"]);
                }

                $participanteSubstituido->data_saida = $request->data_entrada;
                //\App\Validator\CpfValidator::validate($request->all());
                //dd($data);
                $user = User::where('email', 'ilike', $data['email'])->first();
                if (!$user) {
                    $data['usuarioTemp'] = true;
                    $user = User::create($data);
                    $endereco = Endereco::create($data);
                    $endereco->user()->save($user);
                }
                $participante = $user->participantes->where('trabalho_id', $trabalho->id)->first();
                if (!$participante) {
                    $participante = Participante::create($data);
                    $participanteSubstituido->save();
                }

                // $pasta = 'participantes/' . $participante->id;
                // $participante->anexoTermoCompromisso = Storage::putFileAs($pasta, $request->anexoTermoCompromisso, "Termo_de_Compromisso.pdf");
                // $participante->anexoComprovanteMatricula = Storage::putFileAs($pasta, $request->anexoComprovanteMatricula, "Comprovante_de_Matricula.pdf");
                // $participante->anexoLattes = Storage::putFileAs($pasta, $request->anexoCurriculoLattes, "Curriculo_Lattes.pdf");
                // if ($request->anexoAutorizacaoPais != null) {
                //     $participante->anexoAutorizacaoPais = Storage::putFileAs($pasta, $request->anexoAutorizacaoPais, "Autorização_dos_Pais.pdf");
                // }
                // if ($request->anexoComprovanteBancario != null) {
                //     $participante->anexoComprovanteBancario = Storage::putFileAs($pasta, $request->anexoComprovanteBancario, "Comprovante_Bancario." . $request->file('anexoComprovanteBancario')->getClientOriginalExtension());
                // }

                $user->participantes()->save($participante);
                //$trabalho->participantes()->save($participante);

                if ($request->manterPlanoCheck == 'check') {
                    $substituicao->status = 'Em Aguardo';
                    $substituicao->tipo = 'ManterPlano';
                    $substituicao->observacao = $request->textObservacao;
                    $substituicao->participanteSubstituido_id = $participanteSubstituido->id;
                    $substituicao->participanteSubstituto_id = $participante->id;
                    $substituicao->trabalho_id = $trabalho->id;
                    $substituicao->planoSubstituto_id = $planoAntigo->id;

                    $planoAntigo->participanteId = $participante->id;

                    $substituicao->save();
                    $planoAntigo->save();
                } else {

                    if ($request->has('anexoPlanoTrabalho')) {
                        $path = 'trabalhos/' . $evento->id . '/' . $trabalho->id . '/';
                        $nome = $data['nomePlanoTrabalho'] . ".pdf";
                        $file = $request->anexoPlanoTrabalho;
                        Storage::putFileAs($path, $file, $nome);
                        $arquivo = new Arquivo();
                        $arquivo->titulo = $data['nomePlanoTrabalho'];
                        $arquivo->nome = $path . $nome;
                        $arquivo->trabalhoId = $trabalho->id;
                        $arquivo->data = now();
                        $arquivo->participanteId = $participante->id;
                        $arquivo->versaoFinal = true;
                        $arquivo->save();

                        $substituicao->status = 'Em Aguardo';
                        $substituicao->tipo = 'Completa';
                        $substituicao->observacao = $request->textObservacao;
                        $substituicao->participanteSubstituido_id = $participanteSubstituido->id;
                        $substituicao->participanteSubstituto_id = $participante->id;
                        $substituicao->trabalho_id = $trabalho->id;
                        $substituicao->planoSubstituto_id = $arquivo->id;
                        $substituicao->save();
                    }
                }
            }

            $evento->trabalhos()->save($trabalho);
            $trabalho->save();

            $notificacao = App\Notificacao::create([
                'remetente_id' => Auth::user()->id,
                'destinatario_id' => $evento->coordenadorComissao->user_id,
                'trabalho_id' => $trabalho->id,
                'lido' => false,
                'tipo' => 2,
            ]);
            $notificacao->save();

            DB::commit();

            Mail::to($evento->coordenadorComissao->user->email)->send(new SolicitacaoSubstituicao($evento, $trabalho, '', $substituicao->tipo, $substituicao->status));
            return redirect(route('trabalho.trocaParticipante', ['evento_id' => $evento->id, 'projeto_id' => $trabalho->id]))->with(['sucesso' => 'Pedido de substituição enviado com sucesso!']);
        } catch (\App\Validator\ValidationException $th) {
            DB::rollback();
            return redirect(route('trabalho.trocaParticipante', ['evento_id' => $evento->id, 'projeto_id' => $trabalho->id]))->with(['erro' => "Cpf inválido"]);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect(route('trabalho.trocaParticipante', ['evento_id' => $evento->id, 'projeto_id' => $trabalho->id]))->with(['erro' => $th->getMessage()]);
        }
    }


    public function telaShowSubst(Request $request)
    {
        $trabalho = Trabalho::find($request->trabalho_id);
        $substituicoesProjeto = Substituicao::where('trabalho_id', $trabalho->id)->orderBy('created_at', 'DESC')->get();
        $substituicoesPendentes = Substituicao::where('trabalho_id', $trabalho->id)->where('status', 'Em Aguardo')->orderBy('created_at', 'DESC')->get();

        return view('administrador.analiseSubstituicoes')->with([
            'substituicoesPendentes' => $substituicoesPendentes,
            'substituicoesProjeto' => $substituicoesProjeto,
            'trabalho' => $trabalho
        ]);
    }

    public function aprovarSubstituicao(Request $request)
    {
        $substituicao = Substituicao::find($request->substituicaoID);
        $trabalho = Trabalho::find($substituicao->trabalho->id);

        if ($request->aprovar == 'true') {
            try {
                if ($substituicao->tipo == 'TrocarPlano') {
                    if (!empty($substituicao->participanteSubstituido)) {
                        $substituicao->participanteSubstituido->planoTrabalho()->where('id', '!=', $substituicao->planoSubstituto->id)->delete();
                    }
                    $substituicao->status = 'Finalizada';
                    $substituicao->justificativa = $request->textJustificativa;
                    $substituicao->causa = $request->selectJustificativa;

                    $substituicao->concluida_em = now();
                    $substituicao->save();
                } else {
                    if (!empty($substituicao->participanteSubstituido)) {
                        $substituicao->participanteSubstituido->delete();
                    }

                    $trabalho->participantes()->save($substituicao->participanteSubstituto);

                    $substituicao->status = 'Finalizada';
                    $substituicao->justificativa = $request->textJustificativa;
                    $substituicao->causa = $request->selectJustificativa;
                    $substituicao->concluida_em = now();

                    $substituicao->save();
                }

                Mail::to($trabalho->proponente->user->email)->send(new SolicitacaoSubstituicao($trabalho->evento, $trabalho, 'resultado', $substituicao->tipo, $substituicao->status));
                return redirect()->back()->with(['sucesso' => 'Substituição concluída!']);
            } catch (\Throwable $th) {
                return redirect()->back()->with(['erro' => $th->getMessage()]);
            }
        } else {


            try {


                if ($substituicao->tipo == 'TrocarPlano') {
                    $substituicao->participanteSubstituido->planoTrabalho()->where('id', '=', $substituicao->planoSubstituto->id)->delete();
                    $substituicao->status = 'Negada';
                    $substituicao->justificativa = $request->textJustificativa;
                    $substituicao->causa = $request->selectJustificativa;

                    $substituicao->concluida_em = now();
                    $substituicao->save();
                } elseif ($substituicao->tipo == 'ManterPlano') {
                    $substituicao->planoSubstituto->participanteId = $substituicao->participanteSubstituido->id;
                    $substituicao->planoSubstituto->save();
                    $substituicao->participanteSubstituto->delete();

                    $substituicao->status = 'Negada';
                    $substituicao->justificativa = $request->textJustificativa;
                    $substituicao->causa = $request->selectJustificativa;
                    $substituicao->concluida_em = now();

                    $substituicao->save();
                } else {
                    $substituicao->participanteSubstituto->delete();

                    $substituicao->status = 'Negada';
                    $substituicao->justificativa = $request->textJustificativa;
                    $substituicao->causa = $request->selectJustificativa;
                    $substituicao->concluida_em = now();

                    $substituicao->save();
                }

                $trabalho = Trabalho::find($substituicao->trabalho->id);
                Mail::to($trabalho->proponente->user->email)->send(new SolicitacaoSubstituicao($trabalho->evento, $trabalho, 'resultado', $substituicao->tipo, $substituicao->status));
                return redirect()->back()->with(['sucesso' => 'Substituição cancelada com sucesso!']);
            } catch (\Throwable $th) {

                return redirect()->back()->with(['erro' => $th->getMessage()]);
            }
        }
    }

    public function aprovarProposta(Request $request, $id)
    {
        $trabalho = Trabalho::find($id);
        $trabalho->status = $request->statusProp;
        $trabalho->comentario = $request->comentario;
        $trabalho->save();

        return redirect()->back()->with(['sucesso' => 'Proposta avaliada com sucesso']);
    }
}
