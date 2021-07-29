<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proponente extends Model
{
    protected $fillable = ['SIAPE', 'cargo','vinculo','titulacaoMaxima','anoTitulacao','areaFormacao','bolsistaProdutividade','nivel','linkLattes'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function trabalhos(){
      return $this->hasMany('App\Trabalho');
  	}
}
