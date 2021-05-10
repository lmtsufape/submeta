<?php

use Illuminate\Database\Seeder;

class AvaliadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
      $user_id = DB::table('users')->where('name','Avaliador1')->pluck('id');

      DB::table('avaliadors')->insert([
        'user_id' => $user_id[0],
        'area_id' => 1,
      ]);
      
      // $aval = App\Avaliador::find(1);
      // $evento = App\Evento::find(1);
      // $trabalho = App\Trabalho::find(1);
      // $trabalho2 = App\Trabalho::find(2);

      // $aval->eventos()->attach($evento);
      // $aval->trabalhos()->attach($trabalho);
      // $aval->trabalhos()->attach($trabalho2);
      // $aval->trabalhos->first()->pivot->status = 1;

      // $aval->save();
  

      $user_id = DB::table('users')->where('name','Avaliador2')->pluck('id');

      DB::table('avaliadors')->insert([
        'user_id' => $user_id[0],
        'area_id' => 1,
      ]);
      // $aval = App\Avaliador::find(2);
      // $evento = App\Evento::find(1);
      // $trabalho = App\Trabalho::find(1);
      // $aval->trabalhos()->attach($trabalho);
      // $aval->trabalhos->first()->pivot->status = 1;

      // $aval->eventos()->attach($evento);
      // $aval->save();

      $user_id = DB::table('users')->where('name','Avaliador3')->pluck('id');

      DB::table('avaliadors')->insert([
        'user_id' => $user_id[0],
        'area_id' => 1,
      ]);

      // $aval = App\Avaliador::find(2);
      // $evento = App\Evento::find(1);

      // $aval->eventos()->attach($evento);
      // $aval->save();

      $user_id = DB::table('users')->where('name','Avaliador4')->pluck('id');

      DB::table('avaliadors')->insert([
        'user_id' => $user_id[0],
        'area_id' => 1,
      ]);
    }
}
