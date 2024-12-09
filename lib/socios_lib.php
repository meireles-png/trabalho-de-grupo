<?php

// Função para ler os sócios a partir de um arquivo
function lerSocios(string $pesquisa = '', string $estado = ''): array
{
    // Verifica se o arquivo de sócios existe
    if (!file_exists("data" . DIRECTORY_SEPARATOR . "socios.txt")) {
        return []; // Retorna um array vazio se o arquivo não existir
    }
    
    // Abre o arquivo de sócios para leitura
    $fsocios = fopen("data" . DIRECTORY_SEPARATOR . "socios.txt", "r");

    $socios = []; // Inicializa um array para armazenar os sócios
    // Lê o arquivo linha por linha
    while (($linha = fgets($fsocios)) !== false) {
        // Divide a linha em partes usando o delimitador "<SEP>"
        $tempSocios = explode("<SEP>", $linha);

        // Cria um array associativo para o sócio
        $socio = [
            'id' => trim($tempSocios[0]), // ID do sócio
            'nome' => trim($tempSocios[2]), // Nome do sócio
            'nif' => trim($tempSocios[1]), // NIF do sócio
            'data_criacao' => trim($tempSocios[3]), // Data de criação do sócio
            'estado' => trim($tempSocios[4]), // Estado do sócio
        ];

        // Filtra sócios pelo nome se a pesquisa não estiver vazia
        if (!empty($pesquisa) && (strpos($socio['nome'], $pesquisa) === false)) {
            continue; // Pula para a próxima iteração se o nome não corresponder
        }

        // Filtra sócios pelo estado se o estado não estiver vazio
        if (!empty($estado) && $socio['estado'] != $estado) {
            continue; // Pula para a próxima iteração se o estado não corresponder
        }

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
function adicionarSocio(string $nome, string $nif, string $estado): array|bool
{
    $id = obtemProximoId(); // Obtém o próximo ID disponível
    
    $estado = atividadeSocio(); // Obtém o estado atual do sócio

    // Abre o arquivo de sócios para adicionar um novo sócio
    $fsocios = fopen("data" . DIRECTORY_SEPARATOR . "socios.txt", 'a');

    // Cria um array com os dados do novo sócio
    $socio = [
        $id, sanitizar($nome), // Nome do sócio sanitizado
        sanitizar($nif), // NIF do sócio sanitizado
        $estado, // Estado do sócio
        date('Y-m-d H:i:s'), // Data e hora atuais
        '' // Campo adicional vazio (pode ser usado para outros dados)
    ];

    // Escreve os dados do sócio no arquivo, separando por <SEP>
    $resultado = fputs($fsocios, implode('<SEP>', $socio) . "\n");
    fclose($fsocios); // Fecha o arquivo após a escrita
    
    // Verifica se a escrita foi bem-sucedida
    if ($resultado === false) {
        return false; // Retorna false se houve erro na escrita
    }

    return $socio; // Retorna os dados do sócio adicionado
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
        if ($socio['nome'] === $nome) {
            return $socio; // Retorna os dados do sócio se encontrado
        }
    }
    return false; // Retorna false se o sócio não for encontrado
}

// Função para gerenciar a atividade do sócio
function atividadeSocio() {
    // Verifica se o estado do sócio está definido na sessão
    if (!isset($_SESSION['estado'])) {
        $_SESSION['estado'] = 'ATIVO'; // Define o estado como ATIVO se não estiver definido
    }

    // Verifica se a última atividade foi registrada
    if (isset($_SESSION['ultima_atividade'])) {
        $tempo_inativo = time() - $_SESSION['ultima_atividade']; // Calcula o tempo inativo

        // Se o tempo inativo for maior que 300 segundos, muda o estado para SUSPENSO
        if ($tempo_inativo > 300) {
            $_SESSION['estado'] = 'SUSPENSO';
        }
    }

    // Atualiza a última atividade para o tempo atual
    $_SESSION['ultima_atividade'] = time();
}