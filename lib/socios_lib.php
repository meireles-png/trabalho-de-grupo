<?php

// Função para ler os sócios a partir de um arquivo
function lerSocios(string $pesquisa = '', string $estado = ''): array
{
    // Abre o arquivo de sócios para leitura
    $fsocios = fopen("data" . DIRECTORY_SEPARATOR . "socios.txt", "r");

    $socios = []; // Inicializa um array para armazenar os sócios
    // Lê o arquivo linha por linha
    while (($linha = fgets($fsocios)) !== false) {
        // Divide a linha em partes usando o delimitador "<SEP>"
        $tempSocios = explode(";", $linha);

        // Cria um array associativo para o sócio
        $socio = [
            'id' => trim($tempSocios[8]), // ID do sócio
            'nome' => trim($tempSocios[0]), // Nome do sócio
            'nif' => trim($tempSocios[1]), // NIF do sócio
            'morada' => trim($tempSocios[3]), // morada do socio
            'sexo' => trim($tempSocios[7]), // codigo postal do socio 
            'email' => trim($tempSocios[6]), // email do socio
        ];
        
        $socios[] = $socio; // Adiciona o sócio ao array de sócios
    }
    fclose($fsocios); // Fecha o arquivo após a leitura
    return $socios; // Retorna o array de sócios
}

// Função para obter o próximo ID disponível para um sócio
function obtemProximoId(): int
{
    $socios = lerSocios(); // Lê os sócios existentes

    // Se não houver sócios, retorna 1 como próximo ID
    if (count($socios) == 0) {
        return 1;
    }

    // Retorna o próximo ID, que é o último ID + 1
    return $socios[count($socios) - 1]['id'] + 1;
}

// Função para sanitizar strings, substituindo caracteres especiais
function sanitizar(string $string, bool $reverter = false): string
{
    // Define as substituições a serem feitas
    if (!$reverter) {
        $substituicoes = [
            "\n" => '<NEWLINEN>', // Substitui nova linha por <NEWLINEN>
            "\r" => '<NEWLINER>', // Substitui retorno de carro por <NEWLINER>
            "<SEP>" => '!!SEP!!' // Substitui o delimitador <SEP> por !!SEP!!
        ];
    } else {
        // Se reverter, inverte as substituições
        $substituicoes = [
            '<NEWLINEN>' => "\n", // Substitui <NEWLINEN> por nova linha
            '<NEWLINER>' => "\r", // Substitui <NEWLINER> por retorno de carro
            '!!SEP!!' => "<SEP>" // Substitui !!SEP!! por <SEP>
        ];
    }
    
    // Realiza as substituições na string
    foreach ($substituicoes as $search => $replace) {
        $string = str_replace($search, $replace, $string);
    }

    return $string; // Retorna a string sanitizada
}

// Função para adicionar um novo sócio
function adicionarSocio($nome, $nif, $email, $morada, $sexo) 
{
    // Defina o caminho do arquivo onde os dados serão armazenados
    $caminho_arquivo = "data" . DIRECTORY_SEPARATOR . "socios.txt";

    // Você pode adicionar lógica aqui para criar o arquivo se ele não existir
    if (!file_exists($caminho_arquivo)) {
        file_put_contents($caminho_arquivo, ""); // Cria o arquivo vazio
    }

    return $caminho_arquivo; // Retorna o caminho do arquivo como string
}

// Função para verificar se o NIF é único
function nifUnico(string $nif): bool
{
    $socios = lerSocios(); // Lê os sócios existentes
    // Verifica se o NIF já existe entre os sócios
    foreach ($socios as $socio) {
        if ($socio['nif'] === $nif) {
            return false; // Retorna false se o NIF já estiver em uso
        }
    }
    return true; // Retorna true se o NIF for único
}

// Função para obter os dados de um sócio pelo nome
function obtemSocio(string $nome): array|bool
{
    $socios = lerSocios(); // Lê os sócios existentes
    // Procura o sócio pelo nome
    foreach ($socios as $socio) {
        if ($socio['nome'] == $nome) {
            return $socio; // Retorna os dados do sócio se encontrado
        }
    }
    return false; // Retorna false se o sócio não for encontrado
}

function modificarSocio(string $nome, string $sexo, string $email, string $data_nascimento, string $localidade, string $morada, string $codigo_postal): bool 
{
    $socios = lerSocios(); // Lê os sócios existentes

    // Percorre os sócios para encontrar o correspondente ao username
    foreach ($socios as $pos => $socio) {
        if ($socio['nome'] == $nome) { // Verifica se o username coincide
            // Atualiza os campos do sócio
            $socios[$pos]['nome'] = $nome;
            $socios[$pos]['sexo'] = $sexo;
            $socios[$pos]['email'] = $email;
            $socios[$pos]['data_nascimento'] = $data_nascimento;
            $socios[$pos]['localidade'] = $localidade;
            $socios[$pos]['morada'] = $morada;
            $socios[$pos]['codigo_postal'] = $codigo_postal;

            // Escreve os sócios atualizados no arquivo
            escreverSocios($socios);
            return true; // Retorna true após a modificação
        }
    }

    return false; // Retorna false se o sócio não for encontrado
}

function escreverSocios(array $socios): bool
{
    // Abre o arquivo de utilizadores para escrita
    $fsocios = fopen("data" . DIRECTORY_SEPARATOR . "socios.txt", "w");

    // Percorre os utilizadores e escreve os dados no arquivo
    foreach ($socios as $socio) {
        fputs(
            $fsocios, $socio['nome'] . ',' . $socio['email'] . ',' . $socio['sexo'] . $socio['localidade'] . $socio['data_nascimento'] . $socio['morada'] . $socio['codigo_postal'] . "\n");
    }

    fclose($fsocios); // Fecha o arquivo após a escrita
    return true; // Retorna true após a escrita
}
