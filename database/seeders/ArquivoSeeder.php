<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArquivoSeeder extends Seeder
{
    public function run()
    {
        $participantes = DB::table('participantes')
            ->pluck('id')
            ->toArray();

        $trabalhos = DB::table('trabalhos')
            ->select('id', 'proponente_id')
            ->get();

        if (count($participantes) === 0 || $trabalhos->count() === 0) {
            return;
        }

        $pick = function ($list, $i) {
            return $list[$i % count($list)];
        };

        $insert = [];

        foreach ($trabalhos as $index => $trab) {

            $insert[] = [
                'nome' => 'arquivo teste',
                'titulo' => 'titulo teste '.$trab->id,
                'versao' => 1,
                'versaoFinal' => true,
                'data' => now(),
                'participanteId' => $pick($participantes, $index),
                'trabalhoId' => $trab->id,
                'proponenteId' => $trab->proponente_id,
                'relatorioParcial' => 'relatorioParcial.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('arquivos')->insert($insert);
    }
}