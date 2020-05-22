<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProponenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user_id = DB::table('users')->where('name','Proponente')->pluck('id');

      DB::table('proponentes')->insert([
        'user_id' => $user_id[0],

      ]);
    }
}
