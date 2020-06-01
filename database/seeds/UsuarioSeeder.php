<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

          'name'=>'Administrador',
          'email'=>'admin@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'administrador',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'AdministradorResponsavel1',
          'email'=>'adminResp1@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'administradorResponsavel',
          'email_verified_at'=>'2020-01-01'
        ]);
        DB::table('users')->insert([

          'name'=>'AdministradorResponsavel2',
          'email'=>'adminResp2@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'administradorResponsavel',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'Proponente',
          'email'=>'usuario@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'proponente',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'Coordenador1',
          'email'=>'coordenador1@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'coordenador',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'Coordenador2',
          'email'=>'coordenador2@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'coordenador',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'Participante1',
          'email'=>'part1@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'participante',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'Participante2',
          'email'=>'part2@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'participante',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'Avaliador1',
          'email'=>'aval1@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'avaliador',
          'email_verified_at'=>'2020-01-01'
        ]);

        DB::table('users')->insert([

          'name'=>'Avaliador2',
          'email'=>'aval2@ufrpe.br',
          'password'=>Hash::make('12345678'),
          'tipo'=>'avaliador',
          'email_verified_at'=>'2020-01-01'
        ]);

    }
}
