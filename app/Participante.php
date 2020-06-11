<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participante extends Model
{
    use SoftDeletes;

	protected $fillable = ['name', 'user_id', 'trabalho_id', 'participante_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trabalhos(){
      return $this->belongsToMany('App\Trabalho', 'trabalho_participante');
  	}
}
