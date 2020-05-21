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
          'password'=>Hash::make('123456'),
          'tipo'=>'administrador',
          'email_verified_at'=>'2020-01-01'
        ]);
    }
}
