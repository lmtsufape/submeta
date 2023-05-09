<?php

namespace App\Http\Controllers;

use App\AreaTematica;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AreaTematicaController extends Controller
{
    public function destroy($id)
    {
        $areaTematica = AreaTematica::find($id);

        if ($areaTematica->trabalho()->first()){
            return redirect( route('grandearea.index') )->with(['error' => 'Não foi possível excluir a Área Temática. Existe um ou mais trabalhos vinculados a essa Área Temática']);
        }

        $areaTematica->delete();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'Área Temática excluida com sucesso']);
    }

    public function update(Request $request, $id)
    {
        $areaTematica = AreaTematica::find($id);
        $areaTematica->nome = $request->nome;
        $areaTematica->update();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'Área Temática editada com sucesso']);
    }

    public function edit($id)
    {
        $areaTematica = AreaTematica::find($id);
        return view('areaTematica.editar')->with(['areaTematica' => $areaTematica]);
    }

    public function create()
    {
        return view('areaTematica.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome'  =>  'required',
        ]);

        $areaTematica = new AreaTematica();
        $areaTematica->nome = $request->nome;
        $areaTematica->save();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'Área Temática cadastrada com sucesso']);
    }
}
