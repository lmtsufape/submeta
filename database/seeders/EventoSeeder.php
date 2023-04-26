<?php

use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{

/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('eventos')->insert([
        'id' => 1,
        'created_at' => '2023-04-24',
        'updated_at' => '2023-04-24',
        'nome' => 'Evento 1',
        'descricao' => 'Descrição do evento 1',
        'tipo' => 'PIBIC',
        'natureza_id' => 3,
        'inicioSubmissao' => '2023-04-24',
        'fimSubmissao' => '2023-04-24',
        'inicioRevisao' => '2023-04-24',
        'fimRevisao' => '2023-04-24',
        'resultado_final' => '2023-04-24',
        'resultado_preliminar' => '2023-04-24',
        'inicio_recurso' => '2023-04-24',
        'fim_recurso' => '2023-04-24',
        'numParticipantes' => 1,
        'criador_id' => 6,
        'coordenadorId' => 1,
        'pdfEdital' => 'pdfEdital.pdf',
        'anexosStatus' => 'final',
        'consu' => false,
        'dt_inicioRelatorioParcial' => '2023-04-24',
        'dt_fimRelatorioParcial' => '2023-04-24',
        'dt_inicioRelatorioFinal' => '2023-04-24',
        'dt_fimRelatorioFinal' => '2023-04-24',
        'cotaDoutor' => false,
        'inicioProjeto' => '2023-04-25',
        'fimProjeto' => '2023-05-01',
        'obrigatoriedade_docExtra' => false,
        'tipoAvaliacao' => 'form',
        'formAvaliacaoExterno' => 'formAvaliacao.pdf',
       ]);
    }
}