<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use App\SubArea;

class SubAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subAreas = SubArea::orderBy('nome')->get();
        return view('naturezas.subArea.index')->with(['subAreas' => $subAreas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($areaId)
    {
        return view('naturezas.subArea.nova_subarea')->with(['areaId' => $areaId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $subarea = new SubArea();
        $subarea->nome = $request->nome;
        $subarea->area_id = $id;
        $subarea->save();

        return redirect( route('area.show', ['id' => $id]) )->with(['mensagem' => 'Subárea cadastrada com sucesso']);
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
        $subarea = SubArea::find($id);
        return view('naturezas.subArea.editar_subarea')->with(['subarea' => $subarea]);
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
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $subarea = SubArea::find($id);
        $subarea->nome = $request->nome;
        $subarea->update();

        return redirect( route('area.show', ['id' => $subarea->area_id]) )->with(['mensagem' => 'Subárea atualizada com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subarea = SubArea::find($id);
        $areaId = $subarea->area_id;
        $subarea->delete();

        return redirect( route('area.show', ['id' => $areaId]) )->with(['mensagem' => 'Subárea deletada com sucesso']);
    }
}
