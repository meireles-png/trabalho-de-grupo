<?php
// Inclui as bibliotecas necessárias para funções de utilizadores e sócios
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

// Verifica se a sessão do utilizador é válida
if (!validaSessao()) {
    // Se a sessão não for válida, redireciona o utilizador para a página de login
    header('Location: login.php');
    exit; // Encerra a execução do script após o redirecionamento
}

// Inclui o cabeçalho e o menu da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php';
include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php';

// Função para registrar o pagamento de uma cobrança
function registrarPagamento($id_cobranca) {
    // Abre o arquivo de sócios para leitura
    $linhas = fopen("data" . DIRECTORY_SEPARATOR . "socios.txt", "r");
    $cobrancas_atualizadas = []; // Array para armazenar cobranças atualizadas
    $cobranca_encontrada = false; // Flag para verificar se a cobrança foi encontrada

    // Itera sobre cada linha do arquivo
    foreach ($linhas as $linha) {
        $dados = explode(';', $linha); // Divide a linha em dados
        
        // Verifica se o ID da cobrança corresponde ao ID fornecido
        if ($dados[0] == $id_cobranca) {
            $dados[4] = 'PAGO'; // Atualiza o estado da cobrança para 'PAGO'
            $dados[6] = date('Y-m-d'); // Atualiza a data do pagamento
            
            // Se a cobrança for do tipo 'JOIA', atualiza o estado do sócio para 'ACTIVO'
            if ($dados[5] == 'JOIA') {
                atualizarEstadoSocio($dados[2], 'ACTIVO');
            }
            
            $cobranca_encontrada = true; // Marca que a cobrança foi encontrada
        }
        
        // Adiciona os dados atualizados ao array
        $cobrancas_atualizadas[] = implode(';', $dados);
    }

    // Se a cobrança foi encontrada, grava as cobranças atualizadas no arquivo
    if ($cobranca_encontrada) {
        file_put_contents('cobrancas.txt', implode(PHP_EOL, $cobrancas_atualizadas) . PHP_EOL);
        return true; // Retorna verdadeiro indicando sucesso
    }

    return false; // Retorna falso se a cobrança não foi encontrada
}

// Função para atualizar o estado de um sócio
function atualizarEstadoSocio($numero_socio, $novo_estado) {
    // Lógica para atualizar estado do sócio (não implementada aqui)
}

// Função para listar cobranças pendentes
function listarCobrancasPendentes() {
    $cobrancas = []; // Array para armazenar cobranças pendentes
    $file = fopen("data" . DIRECTORY_SEPARATOR . 'cobrancas.txt', 'r'); // Abre o arquivo de cobranças

    if ($file) {
        // Lê cada linha do arquivo
        while (($line = fgets($file)) !== false) {
            $data = explode(';', trim($line)); // Divide a linha em dados
            // Verifica se a linha contém 7 campos e se o estado é 'PENDENTE'
            if (count($data) === 7 && $data[4] === 'PENDENTE') {
                $cobrancas[] = $data; // Adiciona a cobrança ao array
            }
        }
        fclose($file); // Fecha o arquivo
    } else {
        // Trata erro ao abrir o arquivo
        echo "Erro ao abrir o arquivo.";
    }

    return $cobrancas; // Retorna as cobranças pendentes
}

// Recebe o ID da cobrança via GET
if (isset($_GET['id'])) {
    $id_cobranca = $_GET['id']; // Obtém o ID da cobrança
    
    // Tenta registrar o pagamento da cobrança
    if (registrarPagamento($id_cobranca)) {
        $mensagem = "Pagamento registrado com sucesso!"; // Mensagem de sucesso
    } else {
        $mensagem = "Erro ao registrar pagamento."; // Mensagem de erro
    }
}

// Lista as cobranças pendentes
$cobrancas_pendentes = listarCobrancasPendentes();
?>


<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="color : #333;">Registrar Pagamento</h1>

    <?php if (isset($mensagem)): ?>
        <div class="message" style="margin-bottom: 20px; padding: 10px; background-color: #e7f3fe; color: #31708f; border: 1px solid #bce8f1; border-radius: 4px;">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>

    <h2 style="color: #333;">Cobranças Pendentes por Membro</h2>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 12px; background-color: #f2f2f2; color: #333;">Número do Sócio</th>
                <th style="border: 1px solid #ddd; padding: 12px; background-color: #f2f2f2; color: #333;">Nome</th>
                <th style="border: 1px solid #ddd; padding: 12px; background-color: #f2f2f2; color: #333;">Valor</th>
                <th style="border: 1px solid #ddd; padding: 12px; background-color: #f2f2f2; color: #333;">Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cobrancas_pendentes = listarCobrancasPendentes(); // Lista as cobranças pendentes

            if (empty($cobrancas_pendentes)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; font-style: italic; color: #888;">Nenhuma cobrança pendente encontrada.</td>
                </tr>
            <?php else:
                foreach ($cobrancas_pendentes as $cobranca): ?>
                    <tr>
                        <td style="border: 1px solid #ddd; padding: 12px;"><?php echo $cobranca[2]; ?></td> <!-- Número do Sócio -->
                        <td style="border: 1px solid #ddd; padding: 12px;"><?php echo $cobranca[3]; ?></td> <!-- Nome do Sócio -->
                        <td style="border: 1px solid #ddd; padding: 12px;"><?php echo number_format($cobranca[1], 2, ',', '.'); ?>€</td> <!-- Valor da Cobrança -->
                        <td style="border: 1px solid #ddd; padding: 12px;">
                            <a href="registar_pagamentos.php?id=<?php echo $cobranca[0]; ?>" style="display: inline-block; padding: 8px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; transition: background-color 0.3s;">Registrar Pagamento</a>
                        </td>
                    </tr>
                <?php endforeach; 
            endif; ?>
        </tbody>
    </table>
</div>

<?php
// Verifica se o formulário de registro de pagamento foi enviado
if (isset($_POST['registrar_pagamento'])) {
    $id_cobranca = $_POST['cobranca_id']; // Obtém o ID da cobrança do formulário
    
    // Tenta registrar o pagamento da cobrança
    if (registrarPagamento($id_cobranca)) {
        $mensagem = "Pagamento registrado com sucesso!"; // Mensagem de sucesso
    } else {
        $mensagem = "Erro ao registrar pagamento."; // Mensagem de erro
    }
}
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
