<?php

function validaUtilizador(string $username, string $password): array|bool
{
    // abrir o ficheiro no directorio superior data/utilizadores

    $futilizadores = fopen('data' . DIRECTORY_SEPARATOR . 'utilizadores.txt', 'r');

    while(($linha = fgets($futilizadores)) !== false) {
        $utilizador = explode(",", $linha);

        if ($username == $utilizador[0]) {
            if (password_verify($password, $utilizador[1])) {
                session_start();
                $_SESSION['nome'] = $utilizador[2];
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
    session_start();
    if (empty($_SESSION) || empty($_SESSION['nome'])) {
        return false;
    }

    return true;
}

function terminaSessao(): bool
{
    if (!validaSessao()) {
        return true;
    } 

    $_SESSION = [];
    session_destroy();
    return true;
}