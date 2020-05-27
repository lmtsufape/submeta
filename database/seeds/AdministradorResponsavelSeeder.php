<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministradorResponsavelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user_id = DB::table('users')->where('name','AdministradorResponsavel1')->pluck('id');

    	DB::table('administrador_responsavels')->insert([
	        'user_id' => $user_id[0],

	    ]);

        $user_id = DB::table('users')->where('name','AdministradorResponsavel2')->pluck('id');

        DB::table('administrador_responsavels')->insert([
            'user_id' => $user_id[0],

        ]);
    }
}
