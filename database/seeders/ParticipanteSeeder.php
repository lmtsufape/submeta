<?php

use Illuminate\Database\Seeder;

class ParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_id = DB::table('users')->where('name', 'Participante1')->pluck('id');

        DB::table('participantes')->insert([
            'user_id' => $user_id[0],
        ]);

        // $participante = App\Participante::find(1);
        // $user = App\User::where('name','Participante1')->first();
        // $user->participantes()->save($participante);

        // $user->save();

        //        $user_id = DB::table('users')->where('name', 'Participante2')->pluck('id');
        //
        //        DB::table('participantes')->insert([
        //            'user_id' => $user_id[0],
        //        ]);
    }
}
