<?php


namespace App\Services;

//Service para limpar entradas do frontend
use InvalidArgumentException;

class InputService
{
    public static function clearCpf($cpf): string
    {
        return preg_replace('/\D/', '', $cpf);
    }

    public static function clearPhone($phone): string
    {
        if (!$phone) throw new InvalidArgumentException('numero de celular vazio');
        return preg_replace('/\D/', '', $phone);
    }

}