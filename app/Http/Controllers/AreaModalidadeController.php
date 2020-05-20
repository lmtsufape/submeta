<?php

namespace App\Http\Controllers;

use App\AreaModalidade;
use Illuminate\Http\Request;

class AreaModalidadeController extends Controller
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
      
      $validatedData = $request->validate([
        'modalidadeId' => ['required', 'integer',],
        'areaId' => ['required', 'integer',],
      ]);

      $modalidade = AreaModalidade::create([
        'areaId'              => $request->areaId,
        'modalidadeId'              => $request->modalidadeId,
      ]);

      return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AreaModalidade  $areaModalidade
     * @return \Illuminate\Http\Response
     */
    public function show(AreaModalidade $areaModalidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AreaModalidade  $areaModalidade
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaModalidade $areaModalidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AreaModalidade  $areaModalidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AreaModalidade $areaModalidade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AreaModalidade  $areaModalidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaModalidade $areaModalidade)
    {
        //
    }
}
