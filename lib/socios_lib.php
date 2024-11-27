<?php

function lerSocios(string $pesquisa = '', string $estado = ''): array
{
    if (!file_exists( "data" . DIRECTORY_SEPARATOR . "socios.txt")) {
        return [];
    }
    
    // abrir o ficheiro no directorio superior data/utilizadores
    $fsocios = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "socios.txt",
        "r"
    );

    $socios = [];
    while(($linha = fgets($fsocios)) !== false) {
        $tempSocios = explode("<SEP>", $linha);

        $socio = [
            'id' => trim($tempSocios[0]),
            'nome' => trim($tempSocios[1]),
            'NIF' => trim($tempSocios[2]),
            'data_nascimento' => trim($tempSocios[3]),
            'morada' => trim($tempSocios[4]),
            'codigo_postal' => trim($tempSocios[5]),
            'localidade' => trim($tempSocios[6]),
            'email' => trim($tempSocios[7]),
            'sexo' => trim($tempSocios[8]),
            'situação' => trim($tempSocios[9]),
        ];

        if (!empty($pesquisa) && (strpos($socio['nome'], $pesquisa) === false)) {
            continue;
        }

        if (!empty($estado) && $socio['estado'] != $estado) {
            continue;
        }

        $socios[] = $socio;
        

        if (!empty($pesquisa)) {
            if (strpos($socio['nome'], $pesquisa) === false) {
                continue;
            }
        }
        if (!empty($estado)) {
            if ($socio['estado'] != $estado) {
                continue;
            }
        }
        $socios[] = $socio;
    }
    fclose($fsocios);
    return $socios;
}

function obtemProximoId(): int
{
    $socios = lerSocios();

    if (count($socios) == 0) {
        return 1;
    }

    return $socios[count($socios)-1]['id'] + 1;
}

function sanitizar(string $string, bool $reverter = false): string
{
    if (!$reverter) {
        $substituicoes = [
            "\n" => '<NEWLINEN>',
            "\r" => '<NEWLINER>',
            "<SEP>" => '!!SEP!!'
        ];
    } else {
        $substituicoes = [
            '<NEWLINEN>' => "\n",
            '<NEWLINER>' => "\r",
            '!!SEP!!' => "<SEP>"
        ];
    }
    
    foreach ($substituicoes as $search => $replace) {
    	$string = str_replace($search, $replace, $string);
    }

    return $string;
}

function adicionarSocio(string $nome, string $nif): array|bool
{
    $id = obtemProximoId();
    
    $fsocios = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "socios.txt",
        'a'
    );

    $socio = [
        $id,
        sanitizar($nome),
        sanitizar($nif),
        1,
        date('Y-m-d H:i:s'),
        ''
    ];

    $resultado = fputs($fsocios, implode('<SEP>', $socio) . "\n");
    fclose($fsocios);
    
    if ($resultado === false) {
        return false;
    }

    return $socio;
}