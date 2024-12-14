<?php

// Função para ler cobranças de um arquivo e retornar como um array
function lerCobrancas(): array
{
    // Abre o arquivo de cobranças para leitura
    $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt", "r");

    // Verifica se o arquivo foi aberto corretamente
    if (!$fcobrancas) {
        return []; // Retorna um array vazio se não conseguir abrir o arquivo
    }

    $cobrancas = []; // Array para armazenar as cobranças
    // Lê o arquivo linha por linha
    while (($linha = fgets($fcobrancas)) !== false) {
        $linha = trim($linha); // Remove espaços em branco do início e do fim
        if ($linha === '') {
            continue; // Ignora linhas vazias
        }
        // Divide a linha em partes usando o delimitador ";"
        $tempcobranca = explode(";", $linha);

        // Adiciona a cobrança ao array com os campos apropriados
        $cobrancas [] = [
            "ID" => trim($tempcobranca[3]), // ID do sócio
            "data_emissao" => trim($tempcobranca[1]), // Data de emissão
            "valor" => trim($tempcobranca[2]), // Valor da cobrança
            "id_cobranca" => trim($tempcobranca[0]), // ID da cobrança
            "tipo" => trim($tempcobranca[4]), // Tipo de cobrança
        ];
    }

    fclose($fcobrancas); // Fecha o arquivo
    return $cobrancas; // Retorna o array de cobranças
}

// Função para obter uma cobrança específica pelo ID
function obtemCobranca(string $id_cobranca): array|bool
{
    $cobrancas = lerCobrancas(); // Lê todas as cobranças

    // Itera sobre as cobranças para encontrar a que corresponde ao ID fornecido
    foreach ($cobrancas as $cobranca) {
        if ($cobranca['id_cobranca'] == $id_cobranca) {
            return $cobranca; // Retorna a cobrança encontrada
        }
    }
    return false; // Retorna false se a cobrança não for encontrada
}

// Função para escrever cobranças de volta no arquivo
function escreverCobrancas(array $cobrancas): bool
{
    // Abre o arquivo de cobranças para escrita (substitui o conteúdo existente)
    $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt" , "w");

    // Itera sobre cada cobrança para escrever no arquivo
    foreach ($cobrancas as $cobranca) {
        // Verifica se todos os campos necessários estão presentes
        if (!isset($cobranca['ID'], $cobranca['data_emissao'], $cobranca['valor'], $cobranca['id_cobranca'], $cobranca['tipo'])) {
            continue; // Ignora cobranças incompletas
        }

        // Escreve a cobrança no formato adequado no arquivo
        fputs (
            $fcobrancas ,
            $cobranca['id_cobranca'] . ";" .
            $cobranca['data_emissao'] . ";" .
            $cobranca['valor'] . ";" .
            $cobranca['ID'] . ";" .
            $cobranca['tipo'] . "\n"
        );
    }

    fclose($fcobrancas); // Fecha o arquivo
    return true; // Retorna true indicando que a operação foi bem-sucedida
}

// Função para obter o próximo ID de cobrança
function proximoIdCobranca(): int
{
    $cobrancas = lerCobrancas(); // Lê todas as cobranças

    // Se não houver cobranças, o próximo ID será 1
    if(count($cobrancas) === 0) {
        return 1;
    }

    // Obtém o último ID de cobrança e incrementa em 1
    $ultimoIdCobranca = (int)$cobrancas[count($cobrancas) - 1]['id_cobranca'];

    return $ultimoIdCobranca + 1; // Retorna o próximo ID
}

// Função para emitir uma nova cobrança
function emitirCobranca(string $ID, string $valor, string $tipo): array|bool
{
    $id_cobranca = proximoIdCobranca(); // Obtém o próximo ID de cobrança

    // Abre o arquivo de cobranças para anexar uma nova cobrança
    $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt" , "a");

    // Cria um array com os dados da nova cobrança
    $cobranca = [
        $id_cobranca,
        date('Y-m-d H:i:s'), // Data e hora atuais
        $valor, // Valor da cobrança
        $ID, // ID do sócio
        $tipo, // Tipo de cobrança
        ''
    ];

    // Escreve a nova cobrança no arquivo
    $resultado = fputs($fcobrancas, implode(';' , $cobranca) . "\n");
    fclose($fcobrancas); // Fecha o arquivo

    // Verifica se a escrita foi bem-sucedida
    if($resultado === false) {
        return false; // Retorna false se houve erro na escrita
    }

    return $cobranca; // Retorna os dados da nova cobrança emitida
}