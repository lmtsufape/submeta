<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliador extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trabalhos(){
        return $this->belongsToMany('App\Trabalho');
    }
}
