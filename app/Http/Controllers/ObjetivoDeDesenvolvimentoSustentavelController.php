<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\ObjetivoDeDesenvolvimentoSustentavel;

class ObjetivoDeDesenvolvimentoSustentavelController extends Controller
{
    public function create() {
        return view('objetivoDeDesenvolvimentoSustentavel.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'nome'  =>  'required',
        ]);

        $ODS = new ObjetivoDeDesenvolvimentoSustentavel();
        $ODS->nome = $request->nome;
        $ODS->save();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'ODS cadastrado com sucesso']);
    }

    public function edit($id){
        $ODS = ObjetivoDeDesenvolvimentoSustentavel::find($id);
        return view('objetivoDeDesenvolvimentoSustentavel.editar')->with(['ods' => $ODS]);
    }

    public function update(Request $request, $id){
        $ODS = ObjetivoDeDesenvolvimentoSustentavel::find($id);
        $ODS->nome = $request->nome;
        $ODS->update();

        return redirect( route('grandearea.index') )->with(['mensagem' => 'ODS editado com sucesso']);
    }

    public function destroy($id)
    {
        $ODS = ObjetivoDeDesenvolvimentoSustentavel::find($id);

        if ($ODS->trabalhos()->first()){
            return redirect( route('grandearea.index') )->with(['error' => 'Não foi possível excluir a ODS. Existe um ou mais trabalhos vinculados a ODS']);
        }
        
        $ODS->delete();
        return redirect( route('grandearea.index') )->with(['mensagem' => 'ODS excluido com sucesso']);
    }
}
