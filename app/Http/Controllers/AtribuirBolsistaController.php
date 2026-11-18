<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtribuirBolsistaRequest;
use App\Services\AtribuirBolsistaService;
use App\Trabalho;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AtribuirBolsistaController extends Controller
{
    public function create(AtribuirBolsistaService $service, $id)
    {
        $usuario = null;
        $cpf = session()->getOldInput('cpf');
        if (is_string($cpf) && $cpf !== '') {
            try {
                $usuario = $service->usuarioPorCpf($cpf);
            } catch (ValidationException $e) {
                // Mantém as mensagens da tentativa anterior e permite uma nova busca.
            }
        }
        return view('administrador.atribuirBolsista', [
            'trabalho' => Trabalho::with('evento')->findOrFail($id),
            'usuario' => $usuario,
        ]);
    }

    public function buscar(AtribuirBolsistaRequest $request, AtribuirBolsistaService $service, $id)
    {
        return view('administrador.atribuirBolsista', [
            'trabalho' => Trabalho::with('evento')->findOrFail($id),
            'usuario' => $service->usuarioPorCpf($request->cpf),
        ]);
    }

    public function store(AtribuirBolsistaRequest $request, AtribuirBolsistaService $service, $id)
    {
        Trabalho::findOrFail($id);
        try {
            $participante = $service->atribuir($id, $request->validated(), $request->file('plano'));
        } catch (ValidationException $e) {
            return redirect()->route('admin.bolsista.create', ['id' => $id])
                ->withErrors($e->errors())->withInput($request->except('plano'));
        } catch (\Throwable $e) {
            report($e);
            return redirect()->route('admin.bolsista.create', ['id' => $id])
                ->withErrors(['plano' => 'Não foi possível atribuir o bolsista. Nenhuma participação foi salva. Tente novamente.'])
                ->withInput($request->except('plano'));
        }

        Log::info('Bolsista atribuído por administrador', [
            'administrador_id' => $request->user()->id,
            'trabalho_id' => (int) $id,
            'participante_id' => $participante->id,
        ]);

        return redirect()->route('planos.listar', ['id' => $id])
            ->with('sucesso', 'Bolsista e plano de trabalho vinculados à proposta com sucesso.');
    }
}
