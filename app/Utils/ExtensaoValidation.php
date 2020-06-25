<?php namespace App\Utils;

class ExtensaoValidation
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $extensions = array("xls","xlsx", "pdf");
               
        $result = pathinfo($value)['extension'];
       
        if(!in_array($result, $extensions)){
          return false;
        }
        return true;
    }

}