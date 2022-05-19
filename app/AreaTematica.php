<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaTematica extends Model
{
    protected $fillable = [
        'nome',
    ];

    public function trabalho(){
        return $this->hasMany('App\Trabalho', 'area_tematica_id');
    }

}
