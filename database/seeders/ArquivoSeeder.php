<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArquivoSeeder extends Seeder
{

/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('arquivos')->insert([
            'nome' => 'arquivo teste',
            'created_at' => '2023-04-24',
            'updated_at' => '2023-04-24',
            'titulo' => 'titulo teste',
            'versao' => 1,
            'versaoFinal' => true,
            'data' => '2023-04-24',
            'participanteId' => 1,
            'trabalhoId' => 1,
            'relatorioParcial' => 'relatorioParcial.pdf',
            'proponenteId' => 1,
        ]);

        DB::table('arquivos')->insert([
            'nome' => 'arquivo teste',
            'created_at' => '2023-04-24',
            'updated_at' => '2023-04-24',
            'titulo' => 'titulo teste',
            'versao' => 1,
            'versaoFinal' => true,
            'data' => '2023-04-24',
            'participanteId' => 1,
            'trabalhoId' => 2,
            'relatorioParcial' => 'relatorioParcial.pdf',
            'proponenteId' => 1,
        ]);

    }


}