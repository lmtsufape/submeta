<?php

use Illuminate\Database\Seeder;

class RecomendacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recomendacaos')->insert([
            'nome' => 'Aceitacao Forte',
        ]);
        DB::table('recomendacaos')->insert([
            'nome' => 'Aceitacao Média',
        ]);
        DB::table('recomendacaos')->insert([
            'nome' => 'Aceitacao Fraca',
        ]);
    }
}
