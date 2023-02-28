<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Curso;

class CursoController extends Controller
{
    public function index(){
        $cursos = Curso::orderby('nome')->get();
        return view('cursos.index')->with(['cursos' => $cursos]);
    }

    public function create(){
        $cursos = Curso::orderby('nome')->get();
        return view('cursos.create')->with(['cursos' => $cursos]);
    }

    public function store(Request $request){
        $curso = new Curso();
        $curso->nome = $request->curso;

        $curso->save();

        return redirect( route('cursos.index'))->with(['mensagem' => "Curso criado com sucesso"]);
    }
    
    public function edit($id){
        $curso = Curso::find($id);
        return view('cursos.edit')->with(['curso' => $curso]);
    }

    public function update(Request $request, $id){
        $curso = Curso::find($id);
        $curso->nome = $request->curso;
        $curso->update();

        return redirect( route('cursos.index'))->with(['mensagem' => "Curso editado com sucesso"]);
    }

    public function destroy($id){
        Curso::destroy($id);
        return redirect( route('cursos.index'))->with(['mensagem' => "Curso excluido com sucesso"]);
    }
}
