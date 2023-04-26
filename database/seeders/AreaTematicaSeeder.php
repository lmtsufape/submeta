<?php

use Illuminate\Database\Seeder;

class AreaTematicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('area_tematicas')->insert([
            'nome' => 'Comunicação'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Cultura'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Direitos Humanos e Justiça'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Educação'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Meio Ambiente'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Saúde'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Tecnologia e Produção'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Trabalho'
        ]);
    }
}
