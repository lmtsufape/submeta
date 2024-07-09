<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaTematicaPibac extends Model
{
    protected $fillable = [
        'nome',
    ];

    public function trabalhos()
    {
        return $this->belongsToMany('App\Trabalho', 'area_tematica_pibac_trabalhos', 'area_tematica_pibac_id');
    }
}
