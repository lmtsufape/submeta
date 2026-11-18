<?php

namespace App\Http\Controllers;

use App\Arquivo;
use App\Desligamento;
use App\FuncaoParticipantes;
use App\Substituicao;
use App\Trabalho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GerenciarParticipantesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'checkAdministrador']);
    }

    public function index($id)
    {
        return view('administrador.gerenciarParticipantes', [
            'trabalho' => Trabalho::with('evento', 'participantes.user', 'participantes.funcao', 'participantes.planoTrabalho')->findOrFail($id),
            'funcoes' => FuncaoParticipantes::orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, $id, $participanteId)
    {
        $dados = $request->validate([
            'funcao_participante_id' => 'required|integer|exists:funcao_participantes,id',
            'titulo' => 'nullable|string|max:255',
            'plano' => 'nullable|file|mimes:pdf|max:6144',
        ]);
        $path = null;
        $disk = Storage::disk();
        try {
        $this->alterar($id, $participanteId, function ($participante, $trabalho) use ($dados, $request, $disk, &$path) {
            $funcao = FuncaoParticipantes::findOrFail($dados['funcao_participante_id']);
            if ($funcao->nome === 'Bolsista') {
                $arquivo = Arquivo::where('trabalhoId', $participante->trabalho_id)
                    ->where('participanteId', $participante->id)->lockForUpdate()->first();
                if ($arquivo && $arquivo->arquivado) {
                    throw ValidationException::withMessages(['plano' => 'O plano deste participante está arquivado. Regularize o arquivamento antes de alterar o plano.']);
                }
                $precisaPdf = !$arquivo || !$arquivo->nome || !$disk->exists($arquivo->nome);
                $request->validate([
                    'titulo' => 'required|string|max:255',
                    'plano' => ($precisaPdf ? 'required' : 'nullable').'|file|mimes:pdf|max:6144',
                ], ['plano.required' => 'Anexe o PDF do plano de trabalho para vincular o participante como bolsista.']);

                if (!$arquivo) {
                    $arquivo = new Arquivo();
                    $arquivo->trabalhoId = $participante->trabalho_id;
                    $arquivo->participanteId = $participante->id;
                    $arquivo->data = now();
                    $arquivo->versaoFinal = true;
                }
                if ($request->hasFile('plano')) {
                    $path = $disk->putFile('trabalhos/'.$trabalho->evento_id.'/'.$trabalho->id.'/planos', $request->file('plano'));
                    if (!$path) {
                        throw new \RuntimeException('Não foi possível armazenar o plano de trabalho.');
                    }
                    // Não apaga o PDF anterior e mantém o ID usado por relatórios/avaliações.
                    $arquivo->nome = $path;
                }
                $arquivo->titulo = $dados['titulo'];
                $arquivo->save();
            }
            if ($participante->funcao_participante_id != $funcao->id) {
                if ($funcao->nome !== 'Bolsista' && optional($participante->funcao)->nome === 'Bolsista') {
                    // Soft delete: preserva PDFs, relatórios e IDs históricos.
                    Arquivo::where('trabalhoId', $participante->trabalho_id)
                        ->where('participanteId', $participante->id)->delete();
                }
                $participante->funcao_participante_id = $funcao->id;
                $participante->tipoBolsa = $funcao->nome === 'Bolsista' ? 'Bolsista'
                    : ($funcao->nome === 'Voluntário' ? 'Voluntario' : null);
                $participante->save();
            }
        });
        } catch (\Throwable $e) {
            if ($path) {
                $disk->delete($path);
            }
            throw $e;
        }
        Log::info('Função de participante alterada por administrador', [
            'administrador_id' => $request->user()->id, 'trabalho_id' => $id,
            'participante_id' => $participanteId, 'funcao_participante_id' => $dados['funcao_participante_id'],
        ]);
        return redirect()->route('admin.participantes.index', $id)->with('sucesso', 'Participante atualizado com sucesso.');
    }

    public function destroy(Request $request, $id, $participanteId)
    {
        $request->validate(['confirmar_remocao' => 'accepted']);
        $this->alterar($id, $participanteId, function ($participante) {
            // Arquivos e relatórios permanecem disponíveis ao histórico, sem apagar PDFs.
            Arquivo::where('trabalhoId', $participante->trabalho_id)
                ->where('participanteId', $participante->id)->update(['arquivado' => true]);
            $participante->data_saida = now()->format('Y-m-d H:i:s');
            $participante->save();
            $participante->delete();
        });
        Log::info('Participante removido da proposta por administrador', [
            'administrador_id' => $request->user()->id, 'trabalho_id' => $id, 'participante_id' => $participanteId,
        ]);
        return redirect()->route('admin.participantes.index', $id)->with('sucesso', 'Participante removido da proposta. O cadastro e os arquivos históricos foram preservados.');
    }

    private function alterar($id, $participanteId, callable $operacao)
    {
        DB::transaction(function () use ($id, $participanteId, $operacao) {
            $trabalho = Trabalho::whereKey($id)->lockForUpdate()->firstOrFail();
            // Impede manipular participante de outra proposta por troca de ID na URL.
            $participante = $trabalho->participantes()->whereKey($participanteId)->lockForUpdate()->firstOrFail();
            $substituicao = Substituicao::where('trabalho_id', $id)->where('status', 'Em Aguardo')->exists();
            $desligamento = Desligamento::where('trabalho_id', $id)->where('participante_id', $participanteId)
                ->where('status', Desligamento::STATUS_ENUM['solicitado'])->exists();
            if ($substituicao || $desligamento) {
                throw ValidationException::withMessages(['participante' => 'Resolva a substituição ou o desligamento pendente antes de alterar este participante.']);
            }
            $operacao($participante, $trabalho);
        });
    }
}
