<?php

use Illuminate\Database\Seeder;

class CoordenadorComissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = DB::table('users')->where('name', 'Coordenador1')->pluck('id');

        DB::table('coordenador_comissaos')->insert([
            'user_id' => $user_id[0],
        ]);

        $user_id = DB::table('users')->where('name', 'Coordenador2')->pluck('id');

        DB::table('coordenador_comissaos')->insert([
            'user_id' => $user_id[0],
        ]);

        $user_id = DB::table('users')->where('email', 'planejamento.prec@ufape.edu.br')->pluck('id');

        DB::table('coordenador_comissaos')->insert([
            'user_id' => $user_id[0],
        ]);

        $user_id = DB::table('users')->where('email', 'coorplan.prec@ufape.edu.br')->pluck('id');

        DB::table('coordenador_comissaos')->insert([
            'user_id' => $user_id[0],
        ]);

        $user_id = DB::table('users')->where('email', 'nite@ufape.edu.br')->pluck('id');

        DB::table('coordenador_comissaos')->insert([
            'user_id' => $user_id[0],
        ]);
    }
}
