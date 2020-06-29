<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user_id = DB::table('users')->where('name','Administrador')->pluck('id');

      DB::table('administradors')->insert([
        'user_id' => $user_id[0],
      ]);

      $user_id = DB::table('users')->where('name','Comitê do PIBIC')->pluck('id');

      DB::table('administradors')->insert([
        'user_id' => $user_id[0],
      ]);


    }
}
