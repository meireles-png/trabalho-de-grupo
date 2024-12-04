<?php
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

if (!validaSessao()) {
    header('Location: login.php');
    exit;
}

include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php';
include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php';

function registrarPagamento($id_cobranca) {
    $linhas = fopen("data" . DIRECTORY_SEPARATOR . "socios.txt", "r");
    $cobrancas_atualizadas = [];
    $cobranca_encontrada = false;

    foreach ($linhas as $linha) {
        $dados = explode(';', $linha);
        
        if ($dados[0] == $id_cobranca) {
            $dados[4] = 'PAGO';
            $dados[6] = date('Y-m-d');
            
            if ($dados[5] == 'JOIA') {
                atualizarEstadoSocio($dados[2], 'ACTIVO');
            }
            
            $cobranca_encontrada = true;
        }
        
        $cobrancas_atualizadas[] = implode(';', $dados);
    }

    if ($cobranca_encontrada) {
        file_put_contents('cobrancas.txt', implode(PHP_EOL, $cobrancas_atualizadas) . PHP_EOL);
        return true;
    }

    return false;
}

function atualizarEstadoSocio($numero_socio, $novo_estado) {
    // Lógica para atualizar estado do sócio
}

function listarCobrancasPendentes() {
    $cobrancas = [];
    $file = fopen("data" . DIRECTORY_SEPARATOR . 'cobrancas.txt', 'r');

    if ($file) {
        while (($line = fgets($file)) !== false) {
            $data = explode(';', trim($line));
            if (count($data) === 7 && $data[4] === 'PENDENTE') { // Verifica se o estado é PENDENTE
                $cobrancas[] = $data;
            }
        }
        fclose($file);
    } else {
        // Tratar erro ao abrir o arquivo
        echo "Erro ao abrir o arquivo.";
    }

    return $cobrancas;
}

// Receber ID da cobrança via GET
if (isset($_GET['id'])) {
    $id_cobranca = $_GET['id'];
    
    if (registrarPagamento($id_cobranca)) {
        $mensagem = "Pagamento registrado com sucesso!";
    } else {
        $mensagem = "Erro ao registrar pagamento.";
    }
}

$cobrancas_pendentes = listarCobrancasPendentes();
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="color: #333;">Registrar Pagamento</h1>

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
            $cobrancas_pendentes = listarCobrancasPendentes();

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
if (isset($_POST['registrar_pagamento'])) {
    $id_cobranca = $_POST['cobranca_id'];
    
    if (registrarPagamento($id_cobranca)) {
        $mensagem = "Pagamento registrado com sucesso!";
    } else {
        $mensagem = "Erro ao registrar pagamento.";
    }
}
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>