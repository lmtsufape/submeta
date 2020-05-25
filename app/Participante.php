<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
	protected $fillable = ['name', 'user_id', 'trabalho_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trabalhos(){
      return $this->belongsToMany('App\Trabalho', 'trabalho_participante');
  	}
}
