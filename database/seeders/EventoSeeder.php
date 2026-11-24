<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    public function run()
    {
        $base = Carbon::now();

        DB::table('eventos')->insert([

            [
                'id' => 1,
                'nome' => '[EVENTO][COMPLETO][ABERTO]',
                'descricao' => 'Fluxo completo válido',
                'tipo' => 'PIBIC',
                'natureza_id' => 2,
                'coordenadorId' => 1,
                'criador_id' => 1,
                'numParticipantes' => 1,
                'tipoAvaliacao' => 'form',

                'inicioSubmissao' => $base->copy()->subDays(2),
                'fimSubmissao' => $base->copy()->addDays(5),

                'inicioRevisao' => $base->copy()->addDays(6),
                'fimRevisao' => $base->copy()->addDays(10),

                'resultado_preliminar' => $base->copy()->addDays(11),

                'inicio_recurso' => $base->copy()->addDays(12),
                'fim_recurso' => $base->copy()->addDays(14),

                'resultado_final' => $base->copy()->addDays(15),

                'dt_inicioRelatorioParcial' => $base->copy()->addDays(20),
                'dt_fimRelatorioParcial' => $base->copy()->addDays(25),

                'dt_inicioRelatorioFinal' => $base->copy()->addDays(30),
                'dt_fimRelatorioFinal' => $base->copy()->addDays(35),

                'inicioProjeto' => $base->copy()->addDays(16),
                'fimProjeto' => $base->copy()->addDays(60),

                'pdfEdital' => 'edital1.pdf',

                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 2,
                'nome' => '[EVENTO][CONTINUO]',
                'descricao' => 'Fluxo contínuo',
                'tipo' => 'CONTINUO',
                'natureza_id' => 3,//extensao
                'coordenadorId' => 3,
                'criador_id' => 1,
                'numParticipantes' => 3,
                'tipoAvaliacao' => 'form',

                'inicioSubmissao' => $base->copy()->subDays(5),
                'fimSubmissao' => $base->copy()->addDays(30),

                'inicioRevisao' => null,
                'fimRevisao' => null,
                'resultado_preliminar' => null,
                'inicio_recurso' => null,
                'fim_recurso' => null,
                'resultado_final' => null,

                'dt_inicioRelatorioParcial' => null,
                'dt_fimRelatorioParcial' => null,

                'dt_inicioRelatorioFinal' => $base->copy()->addDays(40),
                'dt_fimRelatorioFinal' => $base->copy()->addDays(60),

                'inicioProjeto' => null,
                'fimProjeto' => null,

                'pdfEdital' => 'edital2.pdf',

                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 3,
                'nome' => '[EVENTO][POS_REVISAO]',
                'descricao' => 'Já passou da revisão',
                'tipo' => 'PIBIC',
                'natureza_id' => 2,
                'coordenadorId' => 2,
                'criador_id' => 1,
                'numParticipantes' => 2,
                'tipoAvaliacao' => 'form',

                'inicioSubmissao' => $base->copy()->subDays(20),
                'fimSubmissao' => $base->copy()->subDays(15),

                'inicioRevisao' => $base->copy()->subDays(14),
                'fimRevisao' => $base->copy()->subDays(10),

                'resultado_preliminar' => $base->copy()->subDays(9),

                'inicio_recurso' => $base->copy()->subDays(8),
                'fim_recurso' => $base->copy()->subDays(6),

                'resultado_final' => $base->copy()->subDays(5),

                'dt_inicioRelatorioParcial' => $base->copy()->addDays(5),
                'dt_fimRelatorioParcial' => $base->copy()->addDays(10),

                'dt_inicioRelatorioFinal' => $base->copy()->addDays(15),
                'dt_fimRelatorioFinal' => $base->copy()->addDays(20),

                'inicioProjeto' => $base->copy()->subDays(4),
                'fimProjeto' => $base->copy()->addDays(40),

                'pdfEdital' => 'edital3.pdf',

                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

        foreach (['edital1.pdf' => 'Edital 1 - [EVENTO][COMPLETO][ABERTO]', 'edital2.pdf' => 'Edital 2 - [EVENTO][CONTINUO]', 'edital3.pdf' => 'Edital 3 - [EVENTO][POS_REVISAO]'] as $arquivo => $titulo) {
            if (!Storage::disk()->exists($arquivo)) {
                Storage::disk()->put($arquivo, $this->gerarPdfExemplo($titulo));
            }
        }
    }

    private function gerarPdfExemplo(string $titulo): string
    {
        $texto = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $titulo);
        $stream = "BT /F1 14 Tf 50 750 Td ({$texto}) Tj ET";
        $len = strlen($stream);

        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>\nendobj\n",
            "4 0 obj\n<< /Length {$len} >>\nstream\n{$stream}\nendstream\nendobj\n",
            "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $obj) {
            $offsets[] = strlen($pdf);
            $pdf .= $obj;
        }

        $xrefOffset = strlen($pdf);
        $count = count($offsets);
        $pdf .= "xref\n0 {$count}\n0000000000 65535 f \n";
        for ($i = 1; $i < $count; $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer\n<< /Size {$count} /Root 1 0 R >>\nstartxref\n{$xrefOffset}\n%%EOF\n";

        return $pdf;
    }
}