<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Natureza extends Model
{
    public function projetos() {
        return $this->hasMany('App\Evento');
    }
}
