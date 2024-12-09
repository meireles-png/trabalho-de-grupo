<?php

// Função para ler os utilizadores a partir de um arquivo
function lerUtilizadores(): array
{
    // Abre o arquivo de utilizadores para leitura
    $futilizadores = fopen(
        "data" . DIRECTORY_SEPARATOR . "utilizadores.txt",
        "r"
    );

    $utilizadores = []; // Inicializa um array para armazenar os utilizadores
    // Lê o arquivo linha por linha
    while (($linha = fgets($futilizadores)) !== false) {
        // Divide a linha em partes usando a vírgula como delimitador
        $tempUtilizador = explode(",", $linha);

        // Cria um array associativo para o utilizador
        $utilizadores[] = [
            'nome' => trim($tempUtilizador[2]), // Nome do utilizador
            'username' => $tempUtilizador[0], // Username do utilizador
            'password' => $tempUtilizador[1], // Password do utilizador (hash)
        ];
    }
    fclose($futilizadores); // Fecha o arquivo após a leitura
    return $utilizadores; // Retorna o array de utilizadores
}

// Função para validar um utilizador com base no username e password
function validaUtilizador(string $username, string $password): array|bool
{
    // Lê os utilizadores existentes
    $utilizadores = lerUtilizadores();
    
    // Percorre os utilizadores para encontrar o correspondente ao username
    foreach ($utilizadores as $utilizador) {
        if ($username == $utilizador['username']) {
            // Verifica se a password fornecida corresponde à password armazenada
            if (password_verify($password, $utilizador['password'])) {
                @session_start(); // Inicia a sessão
                $_SESSION['nome'] = $utilizador['nome']; // Armazena o nome do utilizador na sessão
                // Define um cookie para manter o login por 60 segundos
                setcookie('gestaologin', json_encode([
                    'utilizador' => $username,
                    'password' => $password,
                ]), time() + 60);
                return $utilizador; // Retorna os dados do utilizador
            } else {
                return false; // Retorna false se a password estiver incorreta
            }
        }
    }

    return false; // Retorna false se o username não for encontrado
}

// Função para validar a sessão do utilizador
function validaSessao(): bool
{
    @session_start(); // Inicia a sessão
    // Verifica se a sessão está vazia ou se o nome do utilizador não está definido
    if (empty($_SESSION) || empty($_SESSION['nome'])) {
        // Verifica se o cookie de login está definido
        if (isset($_COOKIE['gestaologin'])) {
            $dadosCookie = json_decode($_COOKIE['gestaologin'], true); // Decodifica os dados do cookie
            // Valida o utilizador com os dados do cookie
            $utilizador = validaUtilizador($dadosCookie['utilizador'], $dadosCookie['password']);
            return is_array($utilizador) ? true : $utilizador; // Retorna true se o utilizador for válido
        } else {
            return false; // Retorna false se não houver cookie
        }
    }

    return true; // Retorna true se a sessão for válida
}

// Função para terminar a sessão do utilizador
function terminaSessao(): bool
{
    // Verifica se a sessão é válida
    if (!validaSessao()) {
        return true; // Retorna true se a sessão não for válida
    }

    // Remove o cookie de login
    setcookie('gestaologin', '', time() - 1);

    $_SESSION = []; // Limpa a sessão
    session_destroy(); // Destrói a sessão
    return true; // Retorna true após terminar a sessão
}

// Função para obter os dados de um utilizador pelo username
function obtemUtilizador(string $username): array|bool
{
    $utilizadores = lerUtilizadores(); // Lê os utilizadores existentes
    // Percorre os utilizadores para encontrar o correspondente ao username
    foreach ($utilizadores as $utilizador) {
        if ($utilizador['username'] == $username) {
            return $utilizador; // Retorna os dados do utilizador se encontrado
        }
    }
    return false; // Retorna false se o utilizador não for encontrado
}

// Função para adicionar um novo utilizador
function adicionarUtilizador(string $username, string $nome, string $password): array|bool
{
    // Verifica se o utilizador já existe
    if (obtemUtilizador($username) !== false) {
        return false; // Retorna false se o utilizador já existir
    }
    
    // Abre o arquivo de utilizadores para adicionar um novo utilizador
    $futilizadores = fopen(
        "data" . DIRECTORY_SEPARATOR . "utilizadores.txt",
        'a'
    );

    // Escreve os dados do novo utilizador no arquivo, com a password hashada
    $resultado = fputs($futilizadores, $username . ',' . password_hash($password, PASSWORD_DEFAULT) . ',' . $nome . "\n");
    fclose($futilizadores); // Fecha o arquivo após a escrita
    
    // Verifica se a escrita foi bem-sucedida
    if ($resultado === false) {
        return false; // Retorna false se houve erro na escrita
    }

    return [
        $username, // Retorna o username do utilizador
        password_hash($password, PASSWORD_DEFAULT), // Retorna a password hashada
        $nome // Retorna o nome do utilizador
    ];
}

// Função para modificar os dados de um utilizador existente
function modificarUtilizador(string $username, string $nome, string $password): bool
{
    $utilizadores = lerUtilizadores(); // Lê os utilizadores existentes
    // Percorre os utilizadores para encontrar o correspondente ao username
    foreach ($utilizadores as $pos => $utilizador) {
        if ($utilizador['username'] == $username) {
            $utilizadores[$pos]['nome'] = $nome; // Atualiza o nome do utilizador
            // Se a password não estiver vazia, atualiza a password
            if ($password != '') {
                $utilizadores[$pos]['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            escreverUtilizadores($utilizadores); // Escreve os utilizadores atualizados no arquivo
            return true; // Retorna true após a modificação
        }
    }

    return false; // Retorna false se o utilizador não for encontrado
}

// Função para escrever os dados dos utilizadores no arquivo
function escreverUtilizadores(array $utilizadores): bool
{
    // Abre o arquivo de utilizadores para escrita
    $futilizadores = fopen(
        "data" . DIRECTORY_SEPARATOR . "utilizadores.txt",
        "w"
    );

    // Percorre os utilizadores e escreve os dados no arquivo
    foreach ($utilizadores as $utilizador) {
        fputs(
            $futilizadores,
            $utilizador['username'] . ',' // Username do utilizador
            . $utilizador['password'] . ',' // Password do utilizador (hash)
            . $utilizador['nome'] . "\n" // Nome do utilizador
        );
    }

    fclose($futilizadores); // Fecha o arquivo após a escrita
    return true; // Retorna true após a escrita
}

// Função para obter o próximo ID disponível a partir de um arquivo
function obterProximoId($ficheiro) {
    $id = 1; // Começa no 1
    // Verifica se o arquivo existe
    if (file_exists($ficheiro)) {
        $linha = file($ficheiro); // Lê o arquivo
        $ultimaLinha = end($linha); // Obtém a última linha do arquivo
        // Se a última linha existir, aumenta o ID
        if ($ultimaLinha) {
            $partes = explode(';', $ultimaLinha); // Divide a última linha em partes
            $id = (int)$partes[0] + 1; // Aumenta o ID
        }
    }
    return $id; // Retorna o próximo ID
}