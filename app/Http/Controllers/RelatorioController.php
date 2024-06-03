<?php

namespace App\Http\Controllers;

use App\AreaTematica;
use App\Http\Requests\StoreRelatorioRequest;
use App\ObjetivoDeDesenvolvimentoSustentavel;
use App\ProdutosExtensaoGerados;
use App\Relatorio;
use App\RelatorioCoordenadorViceCoordenador;
use App\RelatorioIntegranteExterno;
use App\RelatorioIntegranteInterno;
use App\RelatorioParticipante;
use App\Trabalho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
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
        DB::beginTransaction();

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

            DB::commit();
        } catch (\Exception $e)
        {
            DB::rollback();

            return redirect()->back()->with(['erro' => 'Ocorreu um erro ao enviar o relatório.']);
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

            $integrante_externo->nome = $nome;
            $integrante_externo->cpf = $cpfs[$indice];
            $integrante_externo->instituicao_vinculo = $instituicoes[$indice];
            $integrante_externo->ch_total_atuacao = $cargas_horarias[$indice];
            $integrante_externo->ingresso_proposta = $datas_ingresso[$indice];
            $integrante_externo->conclusao_proposta = $datas_conclusao[$indice];
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
}
