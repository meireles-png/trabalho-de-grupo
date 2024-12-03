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
    $linhas = file('cobrancas.txt', FILE_IGNORE_NEW_LINES);
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

// Receber ID da cobrança via GET
if (isset($_GET['id'])) {
    $id_cobranca = $_GET['id'];
    
    if (registrarPagamento($id_cobranca)) {
        $mensagem = "Pagamento registrado com sucesso!";
    } else {
        $mensagem = "Erro ao registrar pagamento.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pagamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .message {
            padding: 10px;
            background-color: #e7f3fe;
            border-left: 6px solid #2196F3;
            color: #333;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Registrar Pagamento</h1>

    <?php if (isset($mensagem)): ?>
        <div class="message">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>

    <a href="cobrancas.php">Voltar à lista de cobranças</a>
</div>

</body>
</html>