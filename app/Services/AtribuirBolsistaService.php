<?php

namespace App\Services;

use App\Arquivo;
use App\FuncaoParticipantes;
use App\Participante;
use App\Substituicao;
use App\Trabalho;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AtribuirBolsistaService
{
    public function usuarioPorCpf(string $cpf): User
    {
        // Cadastros antigos podem guardar o CPF com ou sem máscara.
        $usuarios = User::whereIn('cpf', [InputService::formatarCpf($cpf), preg_replace('/\D/', '', $cpf)])
            ->limit(2)->get();

        if ($usuarios->count() !== 1) {
            throw ValidationException::withMessages(['cpf' => $usuarios->isEmpty()
                ? 'Usuário não encontrado. Cadastre o usuário antes de atribuir o bolsista.'
                : 'Há mais de um usuário com este CPF. Regularize os cadastros antes de continuar.']);
        }

        return $usuarios->first();
    }

    public function atribuir($trabalhoId, array $dados, UploadedFile $plano): Participante
    {
        $path = null;
        $disk = Storage::disk();

        try {
            return DB::transaction(function () use ($trabalhoId, $dados, $plano, $disk, &$path) {
                // Serializa atribuições feitas por esta operação para o mesmo trabalho.
                $trabalho = Trabalho::whereKey($trabalhoId)->lockForUpdate()->firstOrFail();
                $usuario = $this->usuarioPorCpf($dados['cpf']);

                if ($trabalho->arquivado || in_array($trabalho->status, ['arquivado', 'reprovado', 'rascunho'])) {
                    throw ValidationException::withMessages(['trabalho' => 'A proposta precisa estar submetida, não reprovada e não arquivada.']);
                }

                if ($trabalho->participantes()->where('user_id', $usuario->id)->exists()) {
                    throw ValidationException::withMessages(['cpf' => 'Este usuário já está vinculado à proposta. Utilize o fluxo de edição ou substituição do participante.']);
                }

                if ($trabalho->participantes()->count() >= (int) $trabalho->evento->numParticipantes) {
                    throw ValidationException::withMessages(['trabalho' => 'O limite de participantes deste edital foi atingido ou o edital não permite participantes.']);
                }

                if (Substituicao::where('trabalho_id', $trabalho->id)->where('status', 'Em Aguardo')->exists()) {
                    throw ValidationException::withMessages(['trabalho' => 'Resolva as substituições pendentes antes de atribuir um bolsista.']);
                }

                $funcao = FuncaoParticipantes::where('nome', 'Bolsista')->first();
                if (!$funcao) {
                    throw ValidationException::withMessages(['trabalho' => 'A função Bolsista não está cadastrada no sistema.']);
                }

                // Copia apenas dados acadêmicos, nunca bolsa, datas, anexos ou vínculos anteriores.
                $cadastro = Participante::where('user_id', $usuario->id)->orderBy('id', 'desc')->first();
                $atributos = $cadastro ? $cadastro->only([
                    'rg', 'data_de_nascimento', 'curso', 'curso_id', 'turno',
                    'periodo_atual', 'total_periodos', 'media_do_curso', 'linkLattes',
                ]) : [];

                $participante = Participante::create(array_merge($atributos, [
                    'user_id' => $usuario->id,
                    'trabalho_id' => $trabalho->id,
                    'funcao_participante_id' => $funcao->id,
                    'tipoBolsa' => 'Bolsista', // Mesmo valor dos formulários de resultados/bolsas.
                    'ordem_prioridade' => ((int) $trabalho->participantes()->max('ordem_prioridade')) + 1,
                    'data_entrada' => $dados['data_entrada'],
                ]));

                // Nome gerado pelo storage evita colisões com planos e anexos já existentes.
                $path = $disk->putFile('trabalhos/'.$trabalho->evento_id.'/'.$trabalho->id.'/planos', $plano);
                if (!$path) {
                    throw new \RuntimeException('Não foi possível armazenar o plano de trabalho.');
                }

                Arquivo::create([
                    'nome' => $path,
                    'titulo' => $dados['titulo'],
                    'trabalhoId' => $trabalho->id,
                    'participanteId' => $participante->id,
                    'data' => now(),
                    'versaoFinal' => true,
                ]);

                return $participante;
            });
        } catch (\Throwable $e) {
            if ($path) {
                $disk->delete($path);
            }
            throw $e;
        }
    }
}
