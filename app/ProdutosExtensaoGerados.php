<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutosExtensaoGerados extends Model
{
    protected $table = 'produtos_extensao_gerados';

    protected $fillable = [
        'tecnico_cientifico',
        'qtd_tecnico_cientifico',
        'divulgacao',
        'qtd_divulgacao',
        'didatico_instrucional',
        'qtd_didatico_instrucional',
        'multimidia',
        'qtd_multimidia',
        'artistico_cultural',
        'qtd_artistico_cultural',
        'relatorio_id',
    ];

    public function setAttributes($request, $relatorio_id)
    {
        $this->tecnico_cientifico = $request['tecnico_cientifico'];
        $this->qtd_tecnico_cientifico = $request['qtd_tecnico_cientifico'];
        $this->divulgacao = $request['divulgacao'];
        $this->qtd_divulgacao = $request['qtd_divulgacao'];
        $this->didatico_instrucional = $request['didatico_instrucional'];
        $this->qtd_didatico_instrucional = $request['qtd_didatico_instrucional'];
        $this->multimidia = $request['multimidia'];
        $this->qtd_multimidia = $request['qtd_multimidia'];
        $this->artistico_cultural = $request['artistico_cultural'];
        $this->qtd_artistico_cultural = $request['qtd_artistico_cultural'];
        $this->relatorio_id = $relatorio_id;
    }
}
