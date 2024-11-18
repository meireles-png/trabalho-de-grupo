<?php

function lerUtilizadores(): array
{
    $futilizadores = fopen(
            "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        "r"
    );

    $utilizadores = [];
    while(($linha = fgets($futilizadores)) !== false) {
        $utilizadores[] = explode(",", $linha);
    }

    return $utilizadores;
}

function validaUtilizador(string $username, string $password): array|bool
{
    // abrir o ficheiro no directorio superior data/utilizadores
    $utilizadores = lerUtilizadores();
    
    foreach ($utilizadores as $utilizador) {
        if ($username == $utilizador[0]) {
            if (password_verify($password, $utilizador[1])) {
                @session_start();
                $_SESSION['nome'] = $utilizador[2];
                setcookie('tarefaslogin', json_encode([
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
        if (isset($_COOKIE['tarefaslogin'])) {
            $dadosCookie = json_decode($_COOKIE['tarefaslogin'], true);
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

    setcookie('tarefaslogin', '', time()-1);

    $_SESSION = [];
    session_destroy();
    return true;
}

function adicionarUtilizador(string $username, string $nome, string $password): array|bool
{
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
