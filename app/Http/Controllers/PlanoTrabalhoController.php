<?php

namespace App\Http\Controllers;


use App\Evento;
use App\Arquivo;
use App\Avaliador;
use Illuminate\Http\Request;

class PlanoTrabalhoController extends Controller
{
    
    public function index($evento_id)
    {
        $evento = Evento::find($evento_id);
        return view('planosTrabalho.index', compact('evento'));
    }

    public function selecionarPlanos($evento_id)
    {
        $evento = Evento::where('id', $evento_id)->first();
        $planos = Arquivo::all();

        $avaliadores = $evento->avaliadors;

        foreach ($planos as $key => $plano) {


            $avalSelecionadosId = $plano->avaliadors->pluck('id');
            $avalProjeto = Avaliador::whereNotIn('id', $avalSelecionadosId)->get();
            $plano->aval = $avalProjeto;

        }
        
        return view('planosTrabalho.selecionarPlanos', [
                                                         'evento'=> $evento,
                                                         'planos'=>$planos,
                                                         'avaliadores'=>$avaliadores
                                                        ]);
    }
    
    public function atribuicao(Request $request)
    {
        $plano = Arquivo::where('id', $request->plano_id)->first();
        
        $evento = Evento::where('id', $request->evento_id)->first();
        $avaliadores = Avaliador::whereIn('id', $request->avaliadores_id)->get();
        $plano->avaliadors()->attach($avaliadores);
        $evento->avaliadors()->syncWithoutDetaching($avaliadores);
        // dd($plano->avaliadors);
        $plano->save();

        return redirect()->back();
    }

    
    public function store(Request $request)
    {
        
    }

    

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
