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
            'nome' => trim($tempSocios[2]),
            'nif' => trim($tempSocios[1]),
            'data_criacao' => trim($tempSocios[3]),
            'estado' => trim($tempSocios[4]),
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

function adicionarSocio(string $nome, string $nif, string $estado): array|bool
{
    $id = obtemProximoId();
    
    $estado = atividadeSocio();

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
        $estado,
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

function nifUnico(string $nif): bool
{
    $socios = lerSocios();
    foreach ($socios as $socio) {
        if ($socio['nif'] === $nif) {
            return false;
        }
    }
    return true;
}

function obtemSocio(string $nome): array|bool
{
    $socios = lerSocios();
    foreach ($socios as $socio) {
        if ($socio['nome'] === $nome) {
            return $socio;
        }
    }
    return false;
}

function atividadeSocio() {
    if (!isset($_SESSION['estado'])) {
        $_SESSION['estado'] = 'ATIVO';
    }

    if (isset($_SESSION['ultima_atividade'])) {
        $tempo_inativo = time() - $_SESSION['ultima_atividade'];

        if ($tempo_inativo > 300) {
            $_SESSION['estado'] = 'SUSPENSO';
        }
    }

    $_SESSION['ultima_atividade'] = time();
}