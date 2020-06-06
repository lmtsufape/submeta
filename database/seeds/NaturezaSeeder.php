<?php

use Illuminate\Database\Seeder;

class NaturezaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('naturezas')->insert([
            'nome' => 'Ensino',
        ]);

        DB::table('naturezas')->insert([
            'nome' => 'Pesquisa',
        ]);

        DB::table('naturezas')->insert([
            'nome' => 'Extensão',
        ]);
    }
}
