
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão de Cobranças</title>
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
        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        #resultados {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div>
    <h1>Emitir Cobrança</h1>
    <form method="post">
        <label for="numero_socio">Número de Sócio:</label>
        <input type="number" id="numero_socio" name="numero_socio" required>
        
        <label for="valor">Valor:</label>
        <input type="number" step="0.01" id="valor" name="valor" required>
        
        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="JOIA">Joia</option>
            <option value="QUOTA">Quota</option>
        </select>
        
        <button type="submit">Emitir Cobrança</button>
    </form>

    <?php

    // Função para emitir cobrança
    function emitirCobranca($numero_socio, $valor, $tipo) {
        if ($tipo !== 'JOIA' && $tipo !== 'QUOTA') {
            return false;
        }
    
        // Verifica se o valor é um número
        if (!is_numeric($valor)) {
            return false;
        }
    
        $numero_cobranca = obterProximoNumeroCobranca();
        $data_emissao = date('Y-m-d H:i:s');
    
        $linha_cobranca = implode(';', [
            $numero_cobranca,
            $data_emissao,
            $numero_socio,
            number_format($valor, 2, '.', ''),
            'PENDENTE',
            $tipo,
            ''
        ]);
    
        // Tenta abrir o arquivo para escrita
        $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt", 'a');
        
        // Verifica se o arquivo foi aberto com sucesso
        if ($fcobrancas === false) {
            return false;
        }
    
        // Escreve a linha de cobrança no arquivo
        $resultado = fputs($fcobrancas, $linha_cobranca . "\n");
        fclose($fcobrancas);
        
        return $resultado !== false;
    }

    function obterProximoNumeroCobranca() {
        if (!file_exists('cobrancas.txt')) {
            return 1;
        }

        $linhas = file('cobrancas.txt', FILE_IGNORE_NEW_LINES);
        $ultima_linha = end($linhas);
        $dados = explode(';', $ultima_linha);
        return intval($dados[0]) + 1;
    }

    // Exemplo de uso
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numero_socio = $_POST['numero_socio'];
        $valor = $_POST['valor'];
        $tipo = $_POST['tipo'];

        if (emitirCobranca($numero_socio, $valor, $tipo)) {
            echo "<p>Cobrança emitida com sucesso!</p>";
        } else {
            echo "<p>Erro ao emitir cobrança.</p>";
        }
    }
    ?>
</div>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
