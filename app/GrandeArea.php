<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrandeArea extends Model
{
    public function areas() {
        return $this->hasMany('App\Area');
    }

    public function trabalhos(){
        return $this->belongsToMany('App/Trabalho');
    }
}
