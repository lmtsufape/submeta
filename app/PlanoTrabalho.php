<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanoTrabalho extends Model
{
    public function trabalho()
    {
    	return $this->belongsTo('App\Trabalho');
    }
}
