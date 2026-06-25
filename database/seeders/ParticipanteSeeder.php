<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipanteSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')
            ->where('tipo', 'participante')
            ->pluck('id')
            ->toArray();

        $trabalhos = DB::table('trabalhos')
            ->select('id', 'evento_id')
            ->get();

        $eventos = DB::table('eventos')
            ->pluck('numParticipantes', 'id')
            ->toArray();

        $contador = [];
        foreach ($trabalhos as $trab) {
            $contador[$trab->id] = 0;
        }

        $insertedCount = 0;

        foreach ($users as $userId) {
            foreach ($trabalhos as $trab) {

                $limite = $eventos[$trab->evento_id] ?? 1;

                if ($contador[$trab->id] < $limite) {

                    if ($insertedCount === 0) {
                        // First: bolsista, funcao 4
                        DB::table('participantes')->insert([
                            'confirmacao_convite'       => 1,
                            'rg'                        => '1234567',
                            'data_de_nascimento'        => '2000-05-15',
                            'curso'                     => 'Ciência da Computação',
                            'turno'                     => 'Noturno',
                            'ordem_prioridade'          => 1,
                            'periodo_atual'             => 5,
                            'total_periodos'            => 8,
                            'media_do_curso'            => 8.5,
                            'user_id'                   => $userId,
                            'trabalho_id'               => $trab->id,
                            'funcao_participante_id'    => 4,
                            'deleted_at'                => null,
                            'anexoTermoCompromisso'     => 'uploads/fake_termo.pdf',
                            'anexoComprovanteMatricula' => 'uploads/fake_matricula.pdf',
                            'anexoLattes'               => 'uploads/fake_lattes.pdf',
                            'anexoComprovanteBancario'  => 'uploads/fake_bancario.pdf',
                            'anexoAutorizacaoPais'      => 'uploads/fake_autorizacao.pdf',
                            'linkLattes'                => 'http://lattes.cnpq.br/fake123456',
                            'curso_id'                  => 1,
                            'tipoBolsa'                 => 2,
                            'data_entrada'              => '2024-03-01',
                            'data_saida'                => '2025-02-28',
                            'anexo_cpf_rg'              => 'uploads/fake_cpf_rg.pdf',
                            'created_at'                => now(),
                            'updated_at'                => now(),
                        ]);

                    } elseif ($insertedCount === 1) {
                        // Second: voluntario, funcao 5
                        DB::table('participantes')->insert([
                            'confirmacao_convite'       => 1,
                            'rg'                        => '7654321',
                            'data_de_nascimento'        => '1999-08-22',
                            'curso'                     => 'Sistemas de Informação',
                            'turno'                     => 'Vespertino',
                            'ordem_prioridade'          => 2,
                            'periodo_atual'             => 3,
                            'total_periodos'            => 8,
                            'media_do_curso'            => 7.8,
                            'user_id'                   => $userId,
                            'trabalho_id'               => $trab->id,
                            'funcao_participante_id'    => 5,
                            'deleted_at'                => null,
                            'anexoTermoCompromisso'     => 'uploads/fake_termo2.pdf',
                            'anexoComprovanteMatricula' => 'uploads/fake_matricula2.pdf',
                            'anexoLattes'               => 'uploads/fake_lattes2.pdf',
                            'anexoComprovanteBancario'  => 'uploads/fake_bancario2.pdf',
                            'anexoAutorizacaoPais'      => 'uploads/fake_autorizacao2.pdf',
                            'linkLattes'                => 'http://lattes.cnpq.br/fake654321',
                            'curso_id'                  => 1,
                            'tipoBolsa'                 => 1,
                            'data_entrada'              => '2024-03-01',
                            'data_saida'                => '2025-02-28',
                            'anexo_cpf_rg'              => 'uploads/fake_cpf_rg2.pdf',
                            'created_at'                => now(),
                            'updated_at'                => now(),
                        ]);

                    } else {
                        // Rest: nulls only
                        DB::table('participantes')->insert([
                            'user_id'    => $userId,
                            'trabalho_id' => $trab->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    $insertedCount++;
                    $contador[$trab->id]++;
                    break;
                }
            }
        }
    }
}