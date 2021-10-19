<?php

namespace App\Validator;


class CpfValidator
{


    public static function validate($data)
    {
        $validator = \Validator::make($data, ['cpf' => 'required'], ['cpf' => 'erro cpf']);

        $cpf = preg_replace('/[^0-9]/', '', (string)$data['cpf']);
        if (strlen($cpf) != 11) {
            $validator->errors()->add('cpf', 'Necessário 11 números em um CPF');
            throw new ValidationException($validator, "Erro");
        }else{
            for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) {
                $soma += $cpf[$i] * $j;
            }
            $resto = $soma % 11;

            if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto)) {
                $validator->errors()->add('cpf', 'CPF Inválido');
            }

            for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--) {
                if (str_repeat($i, 11) == $cpf) {
                    $validator->errors()->add('cpf', 'CPF Inválido');
                }
                $soma += $cpf[$i] * $j;
            }

            $resto = $soma % 11;

            if ($cpf[10] != ($resto < 2 ? 0 : 11 - $resto)) {
                $validator->errors()->add('cpf', 'CPF Inválido');
            }
            if(!$validator->errors()->isEmpty())
                throw new ValidationException($validator, "Erro");

            return true;
        }
    }
}
