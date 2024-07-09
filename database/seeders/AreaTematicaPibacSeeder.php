<?php

use Illuminate\Database\Seeder;

class AreaTematicaPibacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Memória, patrimônios material e imaterial',
        ]);

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Inclusão de pessoas com deficiência',
        ]);

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Economia criativa',
        ]);

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Sustentabilidade ambiental',
        ]);

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Manifestações artísticas e culturais dos povos e os saberes tradicionais',
        ]);

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Inovação, tecnologia e acessibilidade',
        ]);

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Diversidades e direitos humanos Grupos socio-acêntricos',
        ]);

        DB::table('area_tematica_pibacs')->insert([
            'nome'=>'Grupos socio-acêntricos',
        ]);

    }
}
