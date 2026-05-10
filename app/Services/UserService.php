<?php
namespace App\Services;

use App\AdministradorResponsavel;
use App\Avaliador;
use App\Participante;
use App\Proponente;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function updateProfile(User $user, array $data): void
    {
        DB::transaction(function () use ($user, $data) {
            $this->updateBaseUser($user, $data);
            $this->updateByType($user, $data);
            $this->updatePassword($user, $data);

            $user->save();
        });
    }

    private function updateByType(User $user, array $data): void
    {
        switch ($user->tipo) {
            case 'administradorResponsavel':
                $this->updateAdministradorResponsavel($user, $data);
                break;

            case 'avaliador':
                $this->updateAvaliador($user, $data);
                break;

            case 'proponente':
                $this->updateProponente($user, $data);
                break;

            case 'participante':
                $this->updateParticipante($user, $data);
                break;

            default:
                throw new ModelNotFoundException('Usuário não encontrado para o usuário com ID '. $user->id);

        }
    }

    private function updateBaseUser(User $user, array $data): void
    {
        $user->name = $data['name'];
        $user->cpf = InputService::clearCpf($data['cpf']);
        $user->celular = InputService::clearPhone($data['celular']);

        if (!empty($data['instituicao'])) {
            $user->instituicao = $data['instituicao'];
        } elseif (!empty($data['instituicaoSelect'])) {
            $user->instituicao = $data['instituicaoSelect'];
        }
    }

    private function updateAdministradorResponsavel(User $user, array $data): void
    {
        $admin = AdministradorResponsavel::where('user_id', $user->id)->first();

        if (!$admin) throw new ModelNotFoundException('Admin não encontrado para o usuário com ID '. $user->id);

        $admin->save();
    }

    private function updateAvaliador(User $user, array $data): void
    {
        $avaliador = Avaliador::where('user_id', $user->id)->first();

        if (!$avaliador) throw new ModelNotFoundException('Avaliador não encontrado para o usuário com ID '. $user->id);

        if (!empty($data['natureza'])) {
            $avaliador->naturezas()->sync($data['natureza']);
        }

        if (!empty($data['area'])) {
            $avaliador->areaTematicas()->sync($data['area']);
        }

        if ($user->usuarioTemp) {
            $user->usuarioTemp = false;
        }

        $avaliador->user_id = $user->id;

        $avaliador->save();
    }

    private function updateProponente(User $user, array $data): void
    {
        $proponente = Proponente::where('user_id', $user->id)->first();

        if (!$proponente) throw new ModelNotFoundException('Proponente não encontrado para o usuário com ID '. $user->id);



        $proponente->SIAPE = $data['SIAPE'] ?? $proponente->SIAPE;
        $proponente->cargo = $data['cargo'] ?? $proponente->cargo;

        if (($data['vinculo'] ?? null) !== 'Outro') {
            $proponente->vinculo = $data['vinculo'] ?? $proponente->vinculo;
        } else {
            $proponente->vinculo = $data['outro'] ?? $proponente->vinculo;
        }

        $proponente->titulacaoMaxima = $data['titulacaoMaxima'] ?? $proponente->titulacaoMaxima;
        $proponente->anoTitulacao = $data['anoTitulacao'] ?? $proponente->anoTitulacao;
        $proponente->areaFormacao = $data['areaFormacao'] ?? $proponente->areaFormacao;
        $proponente->bolsistaProdutividade = $data['bolsistaProdutividade'] ?? $proponente->bolsistaProdutividade;

        if (($data['bolsistaProdutividade'] ?? null) === 'sim') {
            $proponente->nivel = $data['nivel'] ?? $proponente->nivel;
        }

        $proponente->linkLattes = $data['linkLattes'] ?? $proponente->linkLattes;

        if (!empty($data['curso'])) {
            $proponente->cursos()->sync($data['curso']);
        }

        $proponente->save();
    }

    private function updateParticipante(User $user, array $data): void
    {
        $participante = Participante::where('user_id','=', $user->id)->first();

        if (!$participante) throw new ModelNotFoundException('Participante não encontrado para o usuário com ID '. $user->id);


        $participante->data_de_nascimento = $data['data_de_nascimento'];
        $participante->linkLattes = $data['linkLattes'];
        $participante->rg = $data['rg'];

        if (!empty($data['outroCursoEstudante'])) {
            $participante->curso = $data['outroCursoEstudante'];
            $participante->curso_id = null;
        } elseif (!empty($data['cursoEstudante']) && $data['cursoEstudante'] !== 'Outro') {
            $participante->curso_id = $data['cursoEstudante'];
            $participante->curso = null;
        }

        $user->usuarioTemp = false;

        $participante->save();

        if ($user->endereco) {
            $endereco = $user->endereco;
            $endereco->cep = $data['cep'];
            $endereco->uf = $data['uf'];
            $endereco->cidade = $data['cidade'];
            $endereco->rua = $data['rua'];
            $endereco->numero = $data['numero'];
            $endereco->bairro = $data['bairro'];
            $endereco->complemento = $data['complemento'];
            $endereco->save();
        }

    }
    private function updatePassword(User $user, array $data): void
    {
        if (!empty($data['nova_senha'])) {
            $user->password = bcrypt($data['nova_senha']);
        }
    }
}