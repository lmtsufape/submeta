<?php

use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cursos')->insert(['nome'=>'Bacharelado em Agronomia']);
        DB::table('cursos')->insert(['nome'=>'Bacharelado em Ciência da Computação']);
        DB::table('cursos')->insert(['nome'=>'Bacharelado em Engenharia de Alimentos']);
        DB::table('cursos')->insert(['nome'=>'Bacharelado em Medicina Veterinária']);
        DB::table('cursos')->insert(['nome'=>'Bacharelado em Zootecnia']);
        DB::table('cursos')->insert(['nome'=>'Licenciatura em Letras']);
        DB::table('cursos')->insert(['nome'=>'Licenciatura em Pedagogia']);
    }
}
