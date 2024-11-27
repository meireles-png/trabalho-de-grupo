<?php

function lerUtilizadores(): array
{
    // abrir o ficheiro no directorio superior data/utilizadores
    $futilizadores = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        "r"
    );

    $utilizadores = [];
    while(($linha = fgets($futilizadores)) !== false) {
        $tempUtilizador = explode(",", $linha);

        $utilizadores[] = [
            'nome' => trim($tempUtilizador[2]),
            'username' => $tempUtilizador[0],
            'password' => $tempUtilizador[1],
        ];
    }
    fclose($futilizadores);
    return $utilizadores;
}

function validaUtilizador(string $username, string $password): array|bool
{
    // abrir o ficheiro no directorio superior data/utilizadores
    $utilizadores = lerUtilizadores();
    
    foreach ($utilizadores as $utilizador) {
        if ($username == $utilizador['username']) {
            if (password_verify($password, $utilizador['password'])) {
                @session_start();
                $_SESSION['nome'] = $utilizador['nome'];
                setcookie('gestaologin', json_encode([
                    'utilizador' => $username,
                    'password' => $password,
                ]), time()+ 60);
                return $utilizador;
            } else {
                return false;
            }
        }
    }

    return false;
}

function validaSessao(): bool
{
    @session_start();
    if (empty($_SESSION) || empty($_SESSION['nome'])) {
        if (isset($_COOKIE['gestaologin'])) {
            $dadosCookie = json_decode($_COOKIE['gestaologin'], true);
            $utilizador = validaUtilizador($dadosCookie['utilizador'], $dadosCookie['password']);
            return is_array($utilizador) ? true : $utilizador;
        } else {
            return false;
        }
    }

    return true;
}

function terminaSessao(): bool
{
    if (!validaSessao()) {
        return true;
    }

    setcookie('gestaologin', '', time()-1);

    $_SESSION = [];
    session_destroy();
    return true;
}

function obtemUtilizador(string $username): array|bool
{
    $utilizadores = lerUtilizadores();
    foreach ($utilizadores as $utilizador) {
        if ($utilizador['username'] == $username) {
            return $utilizador;
        }
    }
    return false;
}

function adicionarUtilizador(string $username, string $nome, string $password): array|bool
{
    if (obtemUtilizador($username) !== false) {
        return false;
    }

    $futilizadores = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        'a'
    );

    $resultado = fputs($futilizadores, $username . ',' . password_hash($password, PASSWORD_DEFAULT) . ',' . $nome . "\n");
    fclose($futilizadores);
    
    if ($resultado === false) {
        return false;
    }

    return [
        $username,
        password_hash($password, PASSWORD_DEFAULT),
        $nome
    ];
}

function modificarUtilizador(string $username, string $nome, string $password): bool
{
    $utilizadores = lerUtilizadores();
    foreach ($utilizadores as $pos => $utilizador) {
        if ($utilizador['username'] == $username) {
            $utilizadores[$pos]['nome'] = $nome;
            if ($password != '') {
                $utilizadores[$pos]['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            escreverUtilizadores($utilizadores);
            return true;
        }
    }

    return false;
}

function escreverUtilizadores(array $utilizadores): bool
{
    $futilizadores = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        "w"
    );

    foreach($utilizadores as $utilizador) {
        fputs(
            $futilizadores,
            $utilizador['username'] . ','
            . $utilizador['password'] . ','
            . $utilizador['nome'] . "\n"
        );
    }

    fclose($futilizadores);
    return true;
}