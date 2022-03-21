<?php

namespace App\Http\Controllers;

use App\Certificado;
use App\Notificacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Notificacao $notificacao
     * @return \Illuminate\Http\Response
     */
    public function show(Notificacao $notificacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Notificacao $notificacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Notificacao $notificacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Notificacao $notificacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notificacao $notificacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Notificacao $notificacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notificacao $notificacao)
    {
        //
    }

    public function listar()
    {
        $notificacoes = Notificacao::all()->sortByDesc('created_at');
        return view('notificacao.listar', ['notificacoes' => $notificacoes]);
    }

    public function listarTrab()
    {
        $notificacoes = Notificacao::where('destinatario_id', Auth()->user()->id)->get()->sortByDesc('created_at');

        return view('notificacao.listar', ['notificacoes' => $notificacoes]);
    }

    public function ler($id)
    {
        $notificacao = Notificacao::find($id);
        if (!$notificacao->lido) {
            $notificacao->lido = true;
            $notificacao->update();
        }
        if ($notificacao->tipo == 1) {
            if ($notificacao->destinatario_id == Auth()->user()->id && Auth()->user()->tipo != 'proponente') {
                return redirect()->route('admin.analisarProposta', ['id' => $notificacao->trabalho->id]);
            } else {
                return redirect()->route('trabalho.show', ['id' => $notificacao->trabalho->id]);
            }
        } elseif ($notificacao->tipo == 2) {
            if ($notificacao->destinatario_id == Auth()->user()->id && Auth()->user()->tipo != 'proponente') {
                return redirect()->route('admin.analisarProposta', ['id' => $notificacao->trabalho->id]);
            } else {
                return redirect()->route('trabalho.trocaParticipante', ['evento_id' => $notificacao->trabalho->evento->id, 'projeto_id' => $notificacao->trabalho->id]);
            }
        } elseif ($notificacao->tipo == 3 || $notificacao->tipo == 4) {
            return redirect()->route('planos.listar', ['id' => $notificacao->trabalho->id]);
        } elseif ($notificacao->tipo == 5) {
            if (!is_null(Auth::user()->avaliadors->eventos->where('id', $notificacao->trabalho->evento->id)->first()->pivot->convite)
                && Auth::user()->avaliadors->eventos->where('id', $notificacao->trabalho->evento->id)->first()->pivot->convite == true) {
                return redirect()->route('avaliador.visualizarTrabalho', ['evento_id' => $notificacao->trabalho->evento->id]);
            } else {
                return redirect()->route('avaliador.editais');
            }
        } elseif ($notificacao->tipo == 6) {
            $trabalho = $notificacao->trabalho;
            return view('administrador.visualizarSolicitacaoCertificado', compact('notificacao', 'trabalho'));
        }
    }


}
