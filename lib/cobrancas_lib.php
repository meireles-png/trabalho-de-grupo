<?php

function lerCobrancas(): array
{
    $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt", "r");

    if (!$fcobrancas) {
        return [];
    }

    $cobrancas = [];
    while (($linha = fgets($fcobrancas)) !== false) {

        $linha = trim($linha);
        if ($linha === '') {
            continue;
        }
        $tempcobranca = explode(";", $linha);

        $cobrancas [] = [
            "ID" => trim($tempcobranca[3]),
            "data_emissao" => trim($tempcobranca[1]),
            "valor" => trim($tempcobranca[2]),
            "id_cobranca" => trim($tempcobranca[0]),
            "tipo" => trim($tempcobranca[4]),
        ];
    }

    fclose($fcobrancas);
    return $cobrancas;
}

function obtemCobranca(string $id_cobranca): array|bool
{
    $cobrancas = lerCobrancas();

    foreach ($cobrancas as $cobranca) {
        if ($cobranca['id_cobranca'] == $id_cobranca) {
            return $cobranca;
        }
    }
    return false;
}

function escreverCobrancas(array $cobrancas): bool
{
    $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt" , "w");

    foreach ($cobrancas as $cobranca) {

        // Verifica se todos os campos necessários estão presentes
        if (!isset($cobranca['ID'], $cobranca['data_emissao'], $cobranca['valor'], $cobranca['id_cobranca'], $cobranca['tipo'])) {
            continue;
        }

        fputs (
            $fcobrancas ,
            $cobranca['id_cobranca'] . ";" .
            $cobranca['data_emissao'] . ";" .
            $cobranca['valor'] . ";" .
            $cobranca['ID'] . ";" .
            $cobranca['tipo'] . "\n"
        );
    }

    fclose($fcobrancas);
    return true;
}

function proximoIdCobranca(): int
{
    $cobrancas = lerCobrancas();

    if(count($cobrancas) === 0) {
        return 1;
    }

    $ultimoIdCobranca = (int)$cobrancas[count($cobrancas) - 1]['id_cobranca'];

    return $ultimoIdCobranca + 1;
}

function emitirCobranca(string $ID, string $valor, string $tipo): array|bool
{
    $id_cobranca = proximoIdCobranca();

    $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt" , "a");

    $cobranca = [
        $id_cobranca,
        date('Y-m-d H:i:s'),
        $valor,
        $ID,
        $tipo,
        ''
    ];

    $resultado = fputs($fcobrancas, implode(';' , $cobranca) . "\n");
    fclose($fcobrancas);

    if($resultado === false) {
        return false;
    }

    return $cobranca;
}