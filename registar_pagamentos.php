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

// Função para listar cobranças pendentes
function listarCobrancasPendentes() {
    $cobrancas = []; // Array para armazenar cobranças pendentes
    $file = fopen("data" . DIRECTORY_SEPARATOR . 'cobrancas.txt', 'r'); // Abre o arquivo de cobranças

    if ($file) {
        // Lê cada linha do arquivo
        while (($line = fgets($file)) !== false) {
            $data = explode(';', trim($line)); // Divide a linha em dados
            // Verifica se a linha contém 7 campos e se o estado é 'PENDENTE'
            if (count($data) === 6 && trim($data[3]) === 'PENDENTE') {
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

// Lista as cobranças pendentes
$cobrancas_pendentes = listarCobrancasPendentes();
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
    <!-- Cria um contêiner centralizado com largura máxima de 800px, margem automática e padding de 20px, usando a fonte Arial. -->

    <?php if (isset($mensagem)): ?>
        <!-- Verifica se a variável $mensagem está definida. -->
        <div class="message" style="margin-bottom: 20px; padding: 10px; background-color: #e7f3fe; color: #31708f; border: 1px solid #bce8f1; border-radius: 4px;">
            <!-- Cria uma caixa de mensagem com estilo, incluindo margem, padding, cor de fundo, cor do texto, borda e borda arredondada. -->
            <?php echo $mensagem; ?>
            <!-- Exibe a mensagem se estiver definida. -->
        </div>
    <?php endif; ?>

    <h2 style="color: #333;">Cobranças Pendentes por Membro</h2>
    <!-- Título da seção, estilizado com uma cor escura. -->
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <!-- Cria uma tabela que ocupa 100% da largura disponível, com colapsamento de bordas e margem superior de 20px. -->
        <thead>
            <tr>
                <!-- Início do cabeçalho da tabela. -->
                <th style="border: 1px solid #ddd; padding: 12px; background-color: #f2f2f2; color: #333;">Nome</th>
                <!-- Cabeçalho da coluna "Nome", com borda, padding, cor de fundo e cor do texto. -->
                <th style="border: 1px solid #ddd; padding: 12px; background-color: #f2f2f2; color: #333;">Valor</th>
                <!-- Cabeçalho da coluna "Valor", com estilo semelhante ao anterior. -->
                <th style="border: 1px solid #ddd; padding: 12px; background-color: #f2f2f2; color: #333;">Ação</th>
                <!-- Cabeçalho da coluna "Ação", com estilo semelhante ao anterior. -->
            </tr>
        </thead>
        <tbody>
            <!-- Início do corpo da tabela. -->
            <?php
            if (empty($cobrancas_pendentes)): ?>
                <!-- Verifica se a lista de cobranças pendentes está vazia. -->
                <tr> 
                    <td colspan="4" style="text-align: center; font-style: italic; color: #888;">Nenhuma cobrança pendente encontrada.</td>
                    <!-- Se estiver vazia, exibe uma mensagem centralizada em itálico e com cor cinza. -->
                </tr>
            <?php else:
                // Se houver cobranças pendentes, itera sobre cada uma delas.
                foreach ($cobrancas_pendentes as $cobranca): ?>
                    <tr>
                        <!-- Início de uma nova linha para cada cobrança pendente. -->
                        <td style="border: 1px solid #ddd; padding: 12px;"><?php echo htmlspecialchars($cobranca[2]); ?></td>
                        <!-- Exibe o nome do sócio, escapando caracteres especiais para evitar XSS. -->
                        <td style="border: 1px solid #ddd; padding: 12px;"><?php echo number_format($cobranca[1], 2, ',', '.'); ?>€</td>
                        <!-- Exibe o valor da cobrança formatado como moeda, com duas casas decimais e símbolo de euro. -->
                        <td style="border: 1px solid #ddd; padding: 12px;">
                            <a href="registar_pagamentos.php?id=<?php echo htmlspecialchars($cobranca[0]); ?>" style="display: inline-block; padding: 8px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; transition: background-color 0.3s;">Fazer Pagamento</a>
                        </td>
                    </tr>
                <?php endforeach; 
            endif; ?>
        </tbody>
    </table>
</div>

<?php 
    include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php';
?>