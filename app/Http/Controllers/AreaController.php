<?php

namespace App\Http\Controllers;

use App\Area;
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
          'nome'  =>  ['required', 'string'],
        ]);

        Area::create([
          'nome'      => $request->nome,
          'eventoId'  => $request->eventoId,
        ]);

        return redirect()->route('coord.detalhesEvento', ['eventoId' => $request->eventoId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        //
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
        $area_modalidade = AreaModalidade::where('areaId', $id);
        $pertence = Pertence::where('areaId', $id);
        $revisores = Revisor::where('areaId', $id);
        $trabalhos = Trabalho::where('areaId', $id);
        
        if(isset($area_modalidade)){
            $area_modalidade->delete();
        }
        if(isset($pertence)){
            $pertence->delete();
        }
        if(isset($revisores)){
            $revisores->delete();
        }
        if(isset($trabalhos)){
            $trabalhos->delete();    
        }

        $area->delete();

        return redirect()->back();
    }
}
