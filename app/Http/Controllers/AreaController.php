<?php

namespace App\Http\Controllers;

use App\Area;
use App\GrandeArea;
use App\SubArea;
use App\AreaModalidade;
use App\Pertence;
use App\Revisor;
use App\Trabalho;
use Illuminate\Http\Request;

class AreaController extends Controller
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
    public function create($grandeAreaid)
    {
        return view('naturezas.area.nova_area')->with(['grandeAreaid' => $grandeAreaid]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
          'nome'  => 'required',
        ]);

        $area = new Area();
        $area->nome = $request->nome;
        $area->grande_area_id = $id;
        $area->save();

        return redirect( route('grandearea.show', ['id' => $id]) )->with(['mensagem' => 'Nova área cadastrada com sucesso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = Area::find($id);
        $subAreas = SubArea::where('area_id', '=', $id)->orderBy('nome')->get();

        return view('naturezas.area.detalhes')->with(['area' => $area, 'subAreas' => $subAreas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::find($id);
        return view('naturezas.area.editar_area')->with(['area' => $area]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $area = Area::find($id);
        $grandeArea = GrandeArea::find($area->grande_area_id);
        $area->nome = $request->nome;
        $area->update();

        return redirect( route('grandearea.show', ['id' => $area->grande_area_id]) )->with(['grandeArea' => $grandeArea,'mensagem' => 'Área atualizada com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Area::find($id);
        $id = $area->grande_area_id;
        $area->delete();
        //ver a questão de chave estrangeira para a tabela sub-áreas

        $grandeArea = GrandeArea::find($id);
        return redirect( route('grandearea.show', ['id' => $id]) )->with(['grandeArea' => $grandeArea,'mensagem' => 'Área deletada com sucesso']);
    }
}
