<?php namespace App\Utils;

class LattesValidation
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
        
        // Validate url
        // if (!filter_var($url, FILTER_VALIDATE_URL)) {
        //     dd('1');
        //     return false;
        // } 

        //If url doesn't have a protocol
        if(substr($url, 0, 4) != 'http'){
            $url = 'http://' . $url;
        }
        
       //dd(parse_url($url)['host'] != 'lattes.cnpq.br');
        if(parse_url($url)['host'] != 'buscatextual.cnpq.br' && parse_url($url)['host'] != 'lattes.cnpq.br'){
             return false;
        }
        
        if($this->getHttpResponseCode_using_getheaders($url) != 200){ 
            return false;
        }
        
        return true;
    }

    function getHttpResponseCode_using_getheaders($url, $followredirects = true)
    {        
        if (!$url || !is_string($url)) {
            return false;
        }
        $headers = @get_headers($url);
        if ($headers && is_array($headers)) {
            if ($followredirects) {                
                $headers = array_reverse($headers);
            }
            foreach ($headers as $hline) {               
                if (preg_match('/^HTTP\/\S+\s+([1-9][0-9][0-9])\s+.*/', $hline, $matches)) { 
                    $code = $matches[1];
                    return $code;
                }
            }           
            return false;
        }        
        return false;
    }
}