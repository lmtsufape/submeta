<?php


namespace App\Services;

//Service para PADRONIZAR entradas do frontend

class InputService
{
    public static function formatarCpf($cpf): string
    {
        if (!$cpf) return $cpf;

        $newCpf = preg_replace('/\D/', '', $cpf);
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $newCpf);

    }

    function formatarTelefone(string $telefone): string
    {
        if (!$telefone) return $telefone;

        $telefone = preg_replace('/\D/', '', $telefone);
        if (strlen($telefone) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
        }
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    }

}