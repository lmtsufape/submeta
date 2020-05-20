<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revisor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'prazo', 'trabalhosCorrigidos', 'correcoesEmAndamento','revisorId', 'eventoId', 'areaId',
    ];

    public function user(){
        return $this->belongsTo('App\User', 'revisorId');
    }

    public function evento(){
        return $this->belongsTo('App\Evento', 'eventoId');
    }

    public function area(){
        return $this->belongsTo('App\Area', 'areaId');
    }
}
