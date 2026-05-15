<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrabalhoSeeder extends Seeder
{
    public function run()
    {
        $coordenadores = DB::table('coordenador_comissaos')
            ->orderBy('id')
            ->pluck('id')
            ->toArray();
        $proponentes = DB::table('proponentes')
            ->orderBy('id')->pluck('id')->toArray();
        DB::table('trabalhos')->insert([
            [
                'id' => 1,
                'titulo' => '[APROVADO][EVENTO1][DOUTOR]',
                'status' => 'aprovado',
                'aprovado' => 1,
                'data' => Carbon::now()->subDays(5),

                'evento_id' => 1,
                'coordenador_id' =>  1,
                'proponente_id' =>1,

                'linkGrupoPesquisa' => 'link',
                'linkLattesEstudante' => 'link',
                'pontuacaoPlanilha' => 'link',

                'anexoProjeto' => 'ok',
                'anexoDecisaoCONSU' => 'ok',
                'anexoPlanilhaPontuacao' => 'ok',
                'anexoAutorizacaoComiteEtica' => 'ok',
                'anexoLattesCoordenador' => 'ok',

                'grande_area_id' => 1,
                'area_id' => 1,
                'sub_area_id' => 1,
                'area_tematica_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 2,
                'titulo' => '[REPROVADO][EVENTO1][MESTRE]',
                'status' => 'reprovado',
                'aprovado' => 0,
                'data' => Carbon::now()->subDays(4),

                'evento_id' => 1,
                'coordenador_id' =>   1,
                'proponente_id' => 1,

                'linkGrupoPesquisa' => 'link',
                'linkLattesEstudante' => 'link',
                'pontuacaoPlanilha' => 'link',

                'anexoProjeto' => 'ok',
                'anexoDecisaoCONSU' => 'ok',
                'anexoPlanilhaPontuacao' => 'ok',
                'anexoAutorizacaoComiteEtica' => null,
                'anexoLattesCoordenador' => 'ok',

                'grande_area_id' => 1,
                'area_id' => 1,
                'sub_area_id' => 1,
                'area_tematica_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 3,
                'titulo' => '[APROVADO][EVENTO3][ALTA_PONTUACAO]',
                'status' => 'aprovado',
                'aprovado' => 1,
                'data' => Carbon::now()->subDays(2),

                'evento_id' => 3,
                'coordenador_id' =>  2,
                'proponente_id' => 3,

                'linkGrupoPesquisa' => 'link',
                'linkLattesEstudante' => 'link',
                'pontuacaoPlanilha' => 'link',

                'anexoProjeto' => 'ok',
                'anexoDecisaoCONSU' => 'ok',
                'anexoPlanilhaPontuacao' => 'ok',
                'anexoAutorizacaoComiteEtica' => 'ok',
                'anexoLattesCoordenador' => 'ok',

                'grande_area_id' => 2,
                'area_id' => 2,
                'sub_area_id' => 2,
                'area_tematica_id' => 2,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'titulo' => '[APROVADO][EVENTO1][DOUTOR][SEM-PARTICIPANTES]',
                'status' => 'aprovado',
                'aprovado' => 1,
                'data' => Carbon::now()->subDays(5),

                'evento_id' => 1,
                'coordenador_id' =>  2,
                'proponente_id' => 2,

                'linkGrupoPesquisa' => 'link',
                'linkLattesEstudante' => 'link',
                'pontuacaoPlanilha' => 'link',

                'anexoProjeto' => 'ok',
                'anexoDecisaoCONSU' => 'ok',
                'anexoPlanilhaPontuacao' => 'ok',
                'anexoAutorizacaoComiteEtica' => 'ok',
                'anexoLattesCoordenador' => 'ok',

                'grande_area_id' => 1,
                'area_id' => 1,
                'sub_area_id' => 1,
                'area_tematica_id' => 1,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}