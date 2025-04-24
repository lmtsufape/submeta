<?php

namespace App\Http\Controllers;

use App\AreaTematica;
use App\Http\Requests\StoreRelatorioRequest;
use App\Notificacao;
use App\Notifications\RelatorioRecebimentoNotification;
use App\Notifications\RelatorioRecebimentoNotificationPibex;
use App\ObjetivoDeDesenvolvimentoSustentavel;
use App\ProdutosExtensaoGerados;
use App\Relatorio;
use App\RelatorioCoordenadorViceCoordenador;
use App\RelatorioIntegranteExterno;
use App\RelatorioIntegranteInterno;
use App\RelatorioParticipante;
use App\Trabalho;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function formRelatorioFinalPibex($trabalho_id)
    {
        $trabalho = Trabalho::findOrFail($trabalho_id);

        $relatorio = Relatorio::where('trabalho_id', $trabalho->id)->get();

        if($relatorio->isNotEmpty())
        {
            return redirect()->route('planos.listar', [$trabalho->id])->with(['erro' => 'O relatório já foi enviado']);
        }

        $ods = ObjetivoDeDesenvolvimentoSustentavel::all()->sortBy('id');
        $areas_tematicas = AreaTematica::all()->sortBy('id');

        return view('relatorio.relatorioFinalPibex', compact('trabalho', 'ods', 'areas_tematicas'));
    }

    public function salvarRelatorioFinalPibex(StoreRelatorioRequest $request)
    {
        if($request['select_area_tematica'] == null)
        {
            return redirect()->back()->with(['erro' => 'Selecione pelo menos uma área temática']);
        }
        elseif($request['select_ods'] == null)
        {
            return redirect()->back()->with(['erro' => 'Selecione pelo menos uma ODS']);
        }

        try
        {
            $relatorio = new Relatorio();
            $coordenador = new RelatorioCoordenadorViceCoordenador();
            $vice_coordenador = new RelatorioCoordenadorViceCoordenador();
            $produtos_extensao_gerados = new ProdutosExtensaoGerados();

            if ($request->hasFile('anexo_relatorio'))
            {
                $arquivo = $request->file('anexo_relatorio');
                $path = $arquivo->store('anexoRelatorio', 'public');
            }

            $relatorio->setAttributes($request);
            $relatorio->anexo = $path;
            $relatorio->save();

            $coordenador->setAttributesCoordenador($request, $relatorio->id);
            $coordenador->save();

            if($request['nome_vice_coord'])
            {
                $vice_coordenador->setAttributesViceCoordenador($request, $relatorio->id);
                $vice_coordenador->save();
            }

            $produtos_extensao_gerados->setAttributes($request, $relatorio->id);
            $produtos_extensao_gerados->save();

            $integrantes_internos = $this->integrantesInternosParaObjeto($request, $relatorio->id);

            foreach($integrantes_internos as $integrante_interno)
            {
                $integrante_interno->save();
            }

            if($request->nome_externo[0] != null)
            {
                $integrantes_externos = $this->integrantesExternosParaObjeto($request, $relatorio->id);

                foreach ($integrantes_externos as $integrante_externo)
                {
                    $integrante_externo->save();
                }
            }

            if($request->nome_participante[0] != null)
            {
                $participantes = $this->participantesParaObjeto($request, $relatorio->id);

                foreach($participantes as $participante)
                {
                    $participante->save();
                }
            }

        } catch (\Exception $e)
        {
            return redirect()->route('planos.listar', [$request['trabalho_id']])->with(['erro' => 'Ocorreu um erro ao enviar o relatório.']);
        }

        return redirect()->route('planos.listar', [$request['trabalho_id']])->with(['sucesso' => 'Relatório enviado com sucesso']);
    }

    public function analisarRelatorioFinalPibex($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);

        $trabalho = Trabalho::findOrFail($relatorio->trabalho_id);
        $coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Coordenador/a')->first();
        $vice_coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Vice-Coordenador/a')->first();
        $internos = RelatorioIntegranteInterno::where('relatorio_id', $relatorio->id)->get();
        $externos = RelatorioIntegranteExterno::where('relatorio_id', $relatorio->id)->get();
        $produtos_extensao_gerados = ProdutosExtensaoGerados::where('relatorio_id', $relatorio->id)->first();
        $participantes = RelatorioParticipante::where('relatorio_id', $relatorio->id)->get();

        $ods = [];
        foreach(json_decode($relatorio->ods) as $ods_id)
        {
            $ods[] = ObjetivoDeDesenvolvimentoSustentavel::findOrFail($ods_id);
        }

        $areas_tematicas = [];
        foreach(json_decode($relatorio->area_tematica_principal) as $area_tematica_id)
        {
            $areas_tematicas[] = AreaTematica::findOrFail($area_tematica_id);
        }



        return view('relatorio.visualizarRelatorioPibex', compact('relatorio', 'coordenador', 'vice_coordenador', 'trabalho',
            'areas_tematicas', 'ods', 'internos', 'externos', 'produtos_extensao_gerados', 'participantes'));
    }

    public function parecerRelatorioFinalPibex(Request $request)
    {
        $relatorio = Relatorio::findOrFail($request->relatorio_id);

        if($request->parecer == 'aprovar')
        {
            $relatorio->status = 'aprovado';
        } elseif($request->parecer == 'devolver')
        {
            $relatorio->status = 'devolvido para correções';
        }

        $relatorio->update();

        return redirect(route('admin.analisar', ['evento_id' => $relatorio->trabalho->evento->id]))->with('sucesso', 'Relatório avaliado!');
    }

    public function participantesParaObjeto($request, $relatorio_id)
    {
        $nomes = $request->input('nome_participante');
        $cpfs = $request->input('cpf_participante');
        $cargasHorarias = $request->input('carga_horaria_participante');

        $participantes = [];

        foreach ($nomes as $indice => $nome)
        {
            $participante = new RelatorioParticipante();

            $participante->nome = $nome;
            $participante->cpf = $cpfs[$indice];
            $participante->carga_horaria = $cargasHorarias[$indice];
            $participante->relatorio_id = $relatorio_id;

            $participantes[] = $participante;
        }

        return $participantes;
    }

    public function integrantesInternosParaObjeto($request, $relatorio_id)
    {
        $nomes = $request->input('nome_interno');
        $cpfs = $request->input('cpf_interno');
        $tipos = $request->input('tipo');
        $tipos_vinculo = $request->input('tipo_vinculo');
        $cursos_setores = $request->input('curso_setor');
        $cursos = $request->input('curso_interno');
        $datas_ingresso = $request->input('data_ingresso_interno');
        $datas_conclusao = $request->input('data_conclusao_interno');
        $cargas_horarias = $request->input('carga_horaria_interno');

        $integrantes_internos = [];

        foreach ($nomes as $indice => $nome)
        {
            $integrante_interno = new RelatorioIntegranteInterno();

            $integrante_interno->tipo = $tipos[$indice];
            $integrante_interno->tipo_vinculo = isset($tipos_vinculo[$indice]) ? $tipos_vinculo[$indice] : null;
            $integrante_interno->nome = $nome;
            $integrante_interno->cpf = $cpfs[$indice];
            $integrante_interno->curso_graduacao = isset($cursos[$indice]) ? $cursos[$indice] : null;
            $integrante_interno->curso_setor = isset($cursos_setores[$indice]) ? $cursos_setores[$indice] : null;
            $integrante_interno->ingresso_proposta = $datas_ingresso[$indice];
            $integrante_interno->conclusao_proposta = $datas_conclusao[$indice];
            $integrante_interno->ch_total_atuacao = $cargas_horarias[$indice];
            $integrante_interno->relatorio_id = $relatorio_id;

            $integrantes_internos[] = $integrante_interno;
        }

        return $integrantes_internos;
    }

    public function integrantesExternosParaObjeto($request, $relatorio_id)
    {
        $nomes = $request->input('nome_externo');
        $cpfs = $request->input('cpf_externo');
        $instituicoes = $request->input('instituicao_vinculo');
        $cargas_horarias = $request->input('carga_horaria_externo');
        $datas_ingresso = $request->input('data_ingresso_externo');
        $datas_conclusao = $request->input('data_conclusao_externo');

        $integrantes_externos = [];

        foreach ($nomes as $indice => $nome)
        {
            $integrante_externo = new RelatorioIntegranteExterno();

            $integrante_externo->nome = $nome ?? 'Nome não preenchido';
            $integrante_externo->cpf = $cpfs[$indice] ?? 'CPF não informado';
            $integrante_externo->instituicao_vinculo = $instituicoes[$indice] ?? 'Instituição não informada';
            $integrante_externo->ch_total_atuacao = $cargas_horarias[$indice] ?? 0;
            $integrante_externo->ingresso_proposta = $datas_ingresso[$indice] ?? date('Y-m-d');
            $integrante_externo->conclusao_proposta = $datas_conclusao[$indice] ?? date('Y-m-d');
            $integrante_externo->relatorio_id = $relatorio_id;

            $integrantes_externos[] = $integrante_externo;
        }

        return $integrantes_externos;
    }

    public function gerarPDF($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);

        $trabalho = Trabalho::findOrFail($relatorio->trabalho_id);
        $coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Coordenador/a')->first();
        $vice_coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Vice-Coordenador/a')->first();
        $internos = RelatorioIntegranteInterno::where('relatorio_id', $relatorio->id)->get();
        $externos = RelatorioIntegranteExterno::where('relatorio_id', $relatorio->id)->get();
        $produtos_extensao_gerados = ProdutosExtensaoGerados::where('relatorio_id', $relatorio->id)->first();
        $participantes = RelatorioParticipante::where('relatorio_id', $relatorio->id)->get();

        $ods = [];
        foreach(json_decode($relatorio->ods) as $ods_id)
        {
            $ods[] = ObjetivoDeDesenvolvimentoSustentavel::findOrFail($ods_id);
        }

        $areas_tematicas = [];
        foreach(json_decode($relatorio->area_tematica_principal) as $area_tematica_id)
        {
            $areas_tematicas[] = AreaTematica::findOrFail($area_tematica_id);
        }


        $pdf = PDF::loadView('relatorio.relatorioPDF', compact('relatorio', 'coordenador', 'vice_coordenador', 'trabalho',
            'areas_tematicas', 'ods', 'internos', 'externos', 'produtos_extensao_gerados', 'participantes'));

        $pdf->setPaper('a4');

        $nomePdf = 'RelatórioTeste.pdf';

        return $pdf->stream($nomePdf);
    }

    public function downloadAnexo($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);

        if ($relatorio && Storage::disk('public')->exists($relatorio->anexo))
        {
            return Storage::disk('public')->download($relatorio->anexo);
        }

        return redirect()->back()->with('error', 'Arquivo não encontrado.');
    }

    public function editRelatorioParte1($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);

        $trabalho = Trabalho::findOrFail($relatorio->trabalho_id);
        $coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Coordenador/a')->first();
        $vice_coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Vice-Coordenador/a')->first();

        $ods_selecionadas = [];
        foreach(json_decode($relatorio->ods) as $ods_id)
        {
            $ods_selecionadas[] = ObjetivoDeDesenvolvimentoSustentavel::findOrFail($ods_id);
        }

        $id_ods = collect($ods_selecionadas)->pluck('id')->toArray();
        $ods = ObjetivoDeDesenvolvimentoSustentavel::whereNotIn('id', $id_ods)->get();

        $areas_selecionadas = [];
        foreach(json_decode($relatorio->area_tematica_principal) as $area_tematica_id)
        {
            $areas_selecionadas[] = AreaTematica::findOrFail($area_tematica_id);
        }

        $id_areas = collect($areas_selecionadas)->pluck('id')->toArray();
        $areas_tematicas = AreaTematica::whereNotIn('id', $id_areas)->get();

        return view('relatorio.editar.identificacaoProjeto', compact('relatorio', 'coordenador', 'vice_coordenador', 'trabalho',
            'areas_selecionadas', 'areas_tematicas', 'ods_selecionadas', 'ods'));
    }

    public function updateRelatorioParte1(Request $request)
    {
        
        if($request['select_area_tematica'] == null)
        {
            return redirect()->back()->with(['erro' => 'Selecione pelo menos uma área temática']);
        }
        elseif($request['select_ods'] == null)
        {
            return redirect()->back()->with(['erro' => 'Selecione pelo menos uma ODS']);
        }

        DB::beginTransaction();

        try
        {
            $relatorio = Relatorio::findOrFail($request['relatorio_id']);
            $coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Coordenador/a')->first();
            $vice_coordenador = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->where('tipo', 'Vice-Coordenador/a')->first();

            $relatorio->fill([
                'processo_sipac' => $request->input('processo_sipac'),
                'inicio_projeto' => $request->input('inicio_projeto'),
                'conclusao_projeto' => $request->input('conclusao_projeto'),
                'titulo_projeto' => $request->input('titulo_projeto'),
                'area_tematica_principal' => json_encode($request->input('select_area_tematica')),
                'ods' => json_encode($request->input('select_ods')),
            ])->update();

            $coordenador->setAttributesCoordenador($request, $relatorio->id);
            $coordenador->update();

            if($request['nome_vice_coord'])
            {
                if(!$vice_coordenador)
                {
                    $vice_coordenador = new RelatorioCoordenadorViceCoordenador();

                    $vice_coordenador->setAttributesViceCoordenador($request, $relatorio->id);
                    $vice_coordenador->save();
                }
                else
                {
                    $vice_coordenador->setAttributesViceCoordenador($request, $relatorio->id);
                    $vice_coordenador->update();
                }
            }

            DB::commit();
        }

        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao atualizar a parte 1']);
        }

        return redirect(route('relatorioFinalPibex.editarParte2', ['relatorio_id' => $relatorio->id]))->with(['sucesso' => 'Parte 1 atualizada!']);
    }

    public function editRelatorioParte2($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);
        $trabalho = Trabalho::findOrFail($relatorio->trabalho_id);
        $internos = RelatorioIntegranteInterno::where('relatorio_id', $relatorio->id)->get();
        $externos = RelatorioIntegranteExterno::where('relatorio_id', $relatorio->id)->get();


        return view('relatorio.editar.identificacaoEquipe', compact('relatorio', 'trabalho', 'internos', 'externos'));
    }

    public function updateRelatorioParte2(Request $request)
    {
        $relatorio = Relatorio::findOrFail($request['relatorio_id']);
        $integrantes_internos = $this->integrantesInternosParaObjeto($request, $relatorio->id);

        $internos = RelatorioIntegranteInterno::where('relatorio_id', $relatorio->id)->get();
        $externos = RelatorioIntegranteExterno::where('relatorio_id', $relatorio->id)->get();

        try
        {
            foreach ($internos as $interno)
            {
                $interno->delete();
            }

            foreach ($externos as $externo)
            {
                $externo->delete();
            }

            foreach($integrantes_internos as $integrante_interno)
            {
                $integrante_interno->save();
            }

            if($request->nome_externo[0] != null)
            {
                $integrantes_externos = $this->integrantesExternosParaObjeto($request, $relatorio->id);

                foreach ($integrantes_externos as $integrante_externo)
                {
                    $integrante_externo->save();
                }
            }

            $relatorio->fill([
                'captacao_recursos' => $request->input('captacao_recursos'),
                ])->update();

            DB::commit();
        }

        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao atualizar a parte 2']);
        }


        return redirect(route('relatorioFinalPibex.editarParte3', ['relatorio_id' => $relatorio->id]))->with(['sucesso' => 'Parte 2 atualizada!']);
    }

    public function editRelatorioParte3($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);
        $trabalho = Trabalho::findOrFail($relatorio->trabalho_id);
        $produtos_extensao_gerados = ProdutosExtensaoGerados::where('relatorio_id', $relatorio->id)->first();


        return view('relatorio.editar.resultadosAlcancados', compact('relatorio', 'trabalho', 'produtos_extensao_gerados'));
    }

    public function updateRelatorioParte3(Request $request)
    {
        $relatorio = Relatorio::findOrFail($request['relatorio_id']);

        $produtos_extensao_gerados = ProdutosExtensaoGerados::where('relatorio_id', $relatorio->id)->first();

        try
        {
            $relatorio->fill([
                'resumo' => $request['resumo'],
                'objetivos_alcancados' => $request['objetivos_alcancados'],
                'justificativa_objetivos_alcancados' => $request['justificativa_objetivos_alcancados'],
                'pessoas_beneficiadas' => $request['pessoas_beneficiadas'],
                'alcance_publico_estimado' => $request['alcance_publico_estimado'],
                'justificativa_publico_estimado' => $request['justificativa_publico_estimado'],
                'beneficios_publico_atendido' => $request['beneficios_publico_atendido'],
                'impactos_tecnologicos_cientificos' => $request['impactos_tecnologicos_cientificos'],
                'desafios_encontrados' => $request['desafios_encontrados'],
                'avaliacao_projeto_executado' => $request['avaliacao_projeto_executado'],
            ])->update();
    
            $produtos_extensao_gerados->setAttributes($request, $relatorio->id);
            $produtos_extensao_gerados->update();

            DB::commit();
        }

        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao atualizar a parte 3']);
        }

        return redirect(route('relatorioFinalPibex.editarParte4', ['relatorio_id' => $relatorio->id]))->with(['sucesso' => 'Parte 3 atualizada!']);
    }

    public function editRelatorioParte4($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);
        $trabalho = Trabalho::findOrFail($relatorio->trabalho_id);
        $participantes = RelatorioParticipante::where('relatorio_id', $relatorio->id)->get();


        return view('relatorio.editar.estatisticasAcaoEParticipantesBeneficiados', compact('relatorio', 'trabalho', 'participantes'));
    }

    public function updateRelatorioParte4(Request $request)
    {
        $relatorio = Relatorio::findOrFail($request['relatorio_id']);

        try
        {
            $relatorio->fill([
                'formulario_indicadores' => $request['formulario_indicadores'],
                'certificacao_adicinonal' => $request['certificacao_adicinonal'],
            ])->update();
    
            $participantes = RelatorioParticipante::where('relatorio_id', $relatorio->id)->get();
    
            foreach ($participantes as $participante)
            {
                $participante->delete();
            }
    
            if($request->nome_participante[0] != null)
            {
                $participantes = $this->participantesParaObjeto($request, $relatorio->id);
    
                foreach($participantes as $participante)
                {
                    $participante->save();
                }
            }
    
            if ($request->hasFile('anexo'))
            {
                if ($relatorio->anexo)
                {
                    Storage::disk('public')->delete($relatorio->anexo);
                }
    
                $arquivo = $request->file('anexo');
                $path = $arquivo->store('anexoRelatorio', 'public');
    
                $relatorio->anexo = $path;
    
                $relatorio->update();
            }

            $relatorio->status = "em análise";

            $relatorio->update();
            
            $userTemp = User::find($relatorio->trabalho->evento->coordenadorComissao->user_id);

            $notificacao = Notificacao::create([
                'remetente_id' => Auth::user()->id,
                'destinatario_id' => $relatorio->trabalho->evento->coordenadorComissao->user_id,
                'trabalho_id' => $relatorio->trabalho->id,
                'lido' => false,
                'tipo' => 4,
            ]);

            $notificacao->save();

            Notification::send($userTemp, new RelatorioRecebimentoNotificationPibex($relatorio->id,$userTemp,
                $relatorio->trabalho->evento->nome, $relatorio->trabalho->titulo,'Final'));

            DB::commit();
        }

        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao atualizar a parte 1']);
        }


        return redirect()->route('planos.listar', [$relatorio->trabalho_id])->with(['sucesso' => 'Relatório atualizado com sucesso']);
    }

    public function createRelatorioParte1($trabalho_id)
    {
        $trabalho = Trabalho::findOrFail($trabalho_id);
        $relatorio = Relatorio::where('trabalho_id', $trabalho->id)->first();
        
        if($relatorio)
        {
            if($relatorio->progresso == 'finalizado')
            {
                return redirect()->route('planos.listar', [$trabalho->id])->with(['erro' => 'O relatório já foi enviado']);
            }
            else
            {
                $caminho = $this->etapaRelatorio($relatorio);

                return redirect()->route($caminho, ['relatorio_id' => $relatorio->id])->with(['sucesso' => 'Continue o preenchimento do relatório']);
            }
        }

        $ods = ObjetivoDeDesenvolvimentoSustentavel::all()->sortBy('id');
        $areas_tematicas = AreaTematica::all()->sortBy('id');
        

        return view('relatorio.criar.1-identificacaoProjeto', compact('trabalho', 'ods', 'areas_tematicas', 'relatorio'));
    }


    public function storeRelatorioParte1(StoreRelatorioRequest $request)
    {
        if($request['select_area_tematica'] == null)
        {
            return redirect()->back()->with(['erro' => 'Selecione pelo menos uma área temática']);
        }
        elseif($request['select_ods'] == null)
        {
            return redirect()->back()->with(['erro' => 'Selecione pelo menos uma ODS']);
        }

        DB::beginTransaction();

        try
        {
            $relatorio = new Relatorio();
            $coordenador = new RelatorioCoordenadorViceCoordenador();
            $vice_coordenador = new RelatorioCoordenadorViceCoordenador();

            $relatorio->setAttributes($request);
            $relatorio->save();

            $coordenador->setAttributesCoordenador($request, $relatorio->id);
            $coordenador->save();

            if($request['nome_vice_coord'])
            {
                $vice_coordenador->setAttributesViceCoordenador($request, $relatorio->id);
                $vice_coordenador->save();
            }

            DB::commit();

        } catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao salvar a parte 1']);
        }

        return redirect()->route('relatorioFinalPibex.criarParte2', ['relatorio_id' => $relatorio->id])->with(['sucesso' => 'Parte 1 salva com sucesso!']);
    }

    public function createRelatorioParte2($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);
        
        if($relatorio->progresso != 'parte 1')
        {
            if($relatorio->progresso == 'finalizado')
            {
                return redirect()->route('planos.listar', [$relatorio->trabalho->id])->with(['erro' => 'O relatório já foi enviado']);
            }
            else
            {
                $caminho = $this->etapaRelatorio($relatorio);

                return redirect()->route($caminho, ['relatorio_id' => $relatorio->id])->with(['sucesso' => 'Continue o preenchimento do relatório']);
            }
        }

        return view('relatorio.criar.2-identificacaoEquipe', compact('relatorio'));
    }

    public function storeRelatorioParte2(StoreRelatorioRequest $request)
    {
        $relatorio = Relatorio::findOrFail($request->relatorio_id);

        DB::beginTransaction();

        try
        {
            $integrantes_internos = $this->integrantesInternosParaObjeto($request, $relatorio->id);

            foreach($integrantes_internos as $integrante_interno)
            {
                $integrante_interno->save();
            }

            if($request->nome_externo[0] != null)
            {
                $integrantes_externos = $this->integrantesExternosParaObjeto($request, $relatorio->id);

                foreach ($integrantes_externos as $integrante_externo)
                {
                    $integrante_externo->save();
                }
            }

            $relatorio->captacao_recursos = $request['captacao_recursos'];
            $relatorio->progresso = 'parte 2';

            $relatorio->update();

            DB::commit();

        } catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao salvar a parte 2']);
        }

        return redirect()->route('relatorioFinalPibex.criarParte3', ['relatorio_id' => $relatorio->id])->with(['sucesso' => 'Parte 2 salva com sucesso!']);
    }

    public function createRelatorioParte3($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);

        if($relatorio->progresso != 'parte 2')
        {
            if($relatorio->progresso == 'finalizado')
            {
                return redirect()->route('planos.listar', [$relatorio->trabalho->id])->with(['erro' => 'O relatório já foi enviado']);
            }
            else
            {
                $caminho = $this->etapaRelatorio($relatorio);

                return redirect()->route($caminho, ['relatorio_id' => $relatorio->id])->with(['sucesso' => 'Continue o preenchimento do relatório']);
            }
        }

        return view('relatorio.criar.3-resultadosAlcancados', compact('relatorio'));
    }

    public function storeRelatorioParte3(StoreRelatorioRequest $request)
    {
        $relatorio = Relatorio::findOrFail($request->relatorio_id);

        DB::beginTransaction();

        try
        {
            $produtos_extensao_gerados = new ProdutosExtensaoGerados();

            $produtos_extensao_gerados->setAttributes($request, $relatorio->id);
            $produtos_extensao_gerados->save();

            $relatorio->setAttributesParte3($request);
            $relatorio->progresso = 'parte 3';

            $relatorio->update();

            DB::commit();
        } catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao salvar a parte 3']);
        }

        return redirect()->route('relatorioFinalPibex.criarParte4', ['relatorio_id' => $relatorio->id])->with(['sucesso' => 'Parte 3 salva com sucesso!']);
    }

    public function createRelatorioParte4($relatorio_id)
    {
        $relatorio = Relatorio::findOrFail($relatorio_id);

        if($relatorio->progresso != 'parte 3')
        {
            if($relatorio->progresso == 'finalizado')
            {
                return redirect()->route('planos.listar', [$relatorio->trabalho->id])->with(['erro' => 'O relatório já foi enviado']);
            }
            else
            {
                $caminho = $this->etapaRelatorio($relatorio);

                return redirect()->route($caminho, ['relatorio_id' => $relatorio->id])->with(['sucesso' => 'Continue o preenchimento do relatório']);
            }
        }

        return view('relatorio.criar.4-estatisticasAcaoEParticipantesBeneficiados', compact('relatorio'));
    }

    public function storeRelatorioParte4(StoreRelatorioRequest $request)
    {
        $relatorio = Relatorio::findOrFail($request->relatorio_id);

        DB::beginTransaction();

        try
        {
            if($request->nome_participante[0] != null)
            {
                $participantes = $this->participantesParaObjeto($request, $relatorio->id);

                foreach($participantes as $participante)
                {
                    $participante->save();
                }
            }

            if ($request->hasFile('anexo')) 
            {
                $arquivo = $request->file('anexo');
        
                $nomeArquivo = 'AnexoRelatorioFinal_' . Str::slug($relatorio->titulo_projeto) . '.' . $arquivo->getClientOriginalExtension();
        
                $path = $arquivo->storeAs('anexoRelatorio', $nomeArquivo, 'public');
            } 
            else 
            {
                $path = null;
            }

            $relatorio->formulario_indicadores = $request->formulario_indicadores;
            $relatorio->certificacao_adicinonal = $request->certificacao_adicinonal;
            $relatorio->anexo = $path;
            $relatorio->progresso = 'finalizado';

            $relatorio->update();

            $userTemp = User::find($relatorio->trabalho->evento->coordenadorComissao->user_id);

            $notificacao = Notificacao::create([
                'remetente_id' => Auth::user()->id,
                'destinatario_id' => $relatorio->trabalho->evento->coordenadorComissao->user_id,
                'trabalho_id' => $relatorio->trabalho->id,
                'lido' => false,
                'tipo' => 4,
            ]);
            $notificacao->save();

            Notification::send($userTemp, new RelatorioRecebimentoNotificationPibex($relatorio->id,$userTemp,
                $relatorio->trabalho->evento->nome, $relatorio->trabalho->titulo,'Final'));

            DB::commit();

        } catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->withInput()->with(['erro' => 'Ocorreu um erro ao salvar a parte 4']);
        }

        return redirect()->route('planos.listar', [$relatorio->trabalho->id])->with(['sucesso' => 'Relatório enviado com sucesso!']);
    }

    public function etapaRelatorio($relatorio)
    {
        if($relatorio->progresso == 'parte 1')
        {
            return 'relatorioFinalPibex.criarParte2';
        }
        elseif($relatorio->progresso == 'parte 2')
        {
            return 'relatorioFinalPibex.criarParte3';
        }
        elseif($relatorio->progresso == 'parte 3')
        {
            return 'relatorioFinalPibex.criarParte4';
        }
    }

    public function exportarRelatorio(Relatorio $relatorio)
    {
        $integrantesInternos = RelatorioIntegranteInterno::where('relatorio_id', $relatorio->id)->get();
        $coordenadores = RelatorioCoordenadorViceCoordenador::where('relatorio_id', $relatorio->id)->get();

        $data = [
            'acao' => [
                'titulo' => $relatorio->titulo_projeto,
                'data_inicio' => $relatorio->inicio_projeto,
                'data_termino' => $relatorio->conclusao_projeto,
                'tipo' => $relatorio->trabalho->evento->tipo,
            ],

            'integrantes' => $integrantesInternos->map(function ($integrante) {
                return [
                    'cpf' => $integrante->cpf,
                    'tipo_vinculo' => $integrante->tipo_vinculo,
                    'data_ingresso' => $integrante->ingresso_proposta,
                    'data_conclusao' => $integrante->conclusao_proposta,
                    'carga_horaria' => $integrante->ch_total_atuacao,
                ];
            }),

            'coordenadores' => $coordenadores->map(function ($coordenador) {
                return [
                    'cpf' => $coordenador->cpf,
                    'tipo' => $coordenador->tipo,
                    'carga_horaria' => $coordenador->ch_total_atuacao,
                ];
            }),
        ];

        // Nome do arquivo para o download
        $fileName = 'exemplo_' . now()->format('Ymd_His') . '.json';

        // Retorna o JSON como um download direto com codificação UTF-8
        return response()->streamDownload(function () use ($data) {
            // Garante que json_encode use UTF-8 e escape corretamente
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $fileName, [
            'Content-Type' => 'application/json; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
