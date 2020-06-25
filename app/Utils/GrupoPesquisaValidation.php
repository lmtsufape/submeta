<?php namespace App\Utils;

class GrupoPesquisaValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return $this->isValidUrl($value);
    }

    function isValidUrl($url)
    {
        // first do some quick sanity checks:
        if (!$url || !is_string($url)) {
            return false;
        }

        $url = filter_var($url, FILTER_SANITIZE_URL);

        //If url doesn't have a protocol
        if(substr($url, 0, 4) != 'http'){
            $url = 'http://' . $url;
        }

        if(parse_url($url)['host'] != 'dgp.cnpq.br'){
             return false;
        }
        
        return true;
    }

}