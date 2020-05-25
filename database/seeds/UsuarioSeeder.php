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

          'name'=>'AdministradorResponsavel',
          'email'=>'adminResp@ufrpe.br',
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
    }
}
