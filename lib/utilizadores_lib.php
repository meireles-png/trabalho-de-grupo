<?php

function validaUtilizador(string $username, string $password): array|bool
{
    // abrir o ficheiro no directorio superior ../data
    $futilizadores = fopen(
            ".."
            . DIRECTORY_SEPARATOR
            . "data"
            . DIRECTORY_SEPARATOR
            . "utilizadores.txt",
        "r"
    );
    while(($linha = fgets($futilizadores)) !== false) {
        $utilizador = explode(",", $linha);

        if ($username == $utilizador[0]) {
            if (password_verify($password, $utilizador[1])) {
                return $utilizador;
            } else {
                return false;
            }
        }
    }

    return false;
}

function validaSessao(): void
{
    session_start();
    if (empty($_SESSION)) {
        echo "Não podes estar aqui sem iniciar uma sessão<br>";
        echo '<a href="login.php">Inciar Sessão</a>';
        exit;
    }
}

function terminaSessao(): void
{
    validaSessao();
    $_SESSION = [];
    session_destroy();
    header('Location: login.php');
}