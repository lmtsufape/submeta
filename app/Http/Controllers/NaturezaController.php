<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Natureza;

class NaturezaController extends Controller
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
        $validated = $request->validate([
            'nome' => 'required'
        ]);

        $natureza = new Natureza();
        $natureza->nome = $request->nome;
        $natureza->save();

        return redirect( route('admin.naturezas') )->with(['mensagem' => 'Natureza salva com sucesso']);
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
        $validated = $request->validate([
            'nomeEditavel' => 'required',
        ]);

        $natureza = Natureza::find($id);
        $natureza->nome = $request->nomeEditavel;
        $natureza->update();

        return redirect( route('admin.naturezas') )->with(['mensagem' => "Natureza editada com sucesso"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $natureza = Natureza::find($id);
        $natureza->delete();

        return redirect( route('admin.naturezas') )->with(['mensagem' => "Natureza deletada com sucesso"]);
    }
}
