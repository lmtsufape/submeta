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
            'nome' => 'Recomendação Forte',
        ]);
        DB::table('recomendacaos')->insert([
            'nome' => 'Recomendação Fraca',
        ]);
        DB::table('recomendacaos')->insert([
            'nome' => 'Neutro',
        ]);
        DB::table('recomendacaos')->insert([
            'nome' => 'Rejeição Fraca',
        ]);
        DB::table('recomendacaos')->insert([
            'nome' => 'Rejeição Forte',
        ]);
    }
}
