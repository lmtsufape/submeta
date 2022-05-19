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
            'nome' => 'Erradicação da Pobreza'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Fome zero e agricultura sustentável'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Saúde e bem-estar'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Educação de qualidade'
        ]);
        DB::table('area_tematicas')->insert([
            'nome' => 'Igualdade de gênero'
        ]);
    }
}
