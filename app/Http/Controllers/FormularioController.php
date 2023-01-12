<?php

namespace App\Http\Controllers;

use App\Evento;
use App\Formulario;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $formularios = Formulario::where('evento_id', $id)->orderByDesc('titulo');
        $edital = Evento::find($id);
        return view('formularios.index', compact('formularios', 'edital'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $edital = Evento::find($id);
        return view('formularios.create', compact('edital'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formulario = new Formulario();
        $formulario->setAtributes($request);
        $formulario->save();

        return redirect(route('formularios.index'))->with(['success' => 'Formulário criado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function show(Formulario $formulario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formulario = Formulario::find($id);
        return view('formularios.edit', compact('formulario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('isSecretario', User::class);

        $formulario = Formulario::find($id);

        $formulario->setAtributes($request);
        $formulario->update();

        return redirect(route('formularios.index'))->with(['success' => 'Formulário editado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $formulario = Formulario::find($id);
        $formulario->delete();

        return redirect(route('formularios.index'))->with(['success' => 'Formulário deletado com sucesso!']);
    }
}
