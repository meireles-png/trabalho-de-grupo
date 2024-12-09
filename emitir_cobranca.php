<<<<<<< HEAD
<?php
    // Inclui as bibliotecas necessárias para a validação de sessão e manipulação de sócios
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

    // Verifica se a sessão do usuário é válida
    if (!validaSessao()) {
        // Se a sessão não for válida, redireciona para a página de login
        header('Location: login.php');
        exit; // Encerra a execução do script
    }
?>

<style>
    /* Estilos CSS para a página */
    body {
        font-family: Arial, sans-serif; /* Define a fonte do corpo */
        background-color: #f4f4f4; /* Define a cor de fundo */
        margin: 0; /* Remove margens */
        padding: 20px; /* Adiciona preenchimento */
    }
    h1 {
        color: #333; /* Define a cor do título */
    }
    form {
        background: #fff; /* Cor de fundo do formulário */
        padding: 20px; /* Preenchimento interno do formulário */
        margin-bottom: 20px; /* Margem inferior do formulário */
        border-radius: 5px; /* Bordas arredondadas */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra do formulário */
    }
    label {
        display: block; /* Exibe o rótulo como bloco */
        margin: 10px 0 5px; /* Margens do rótulo */
    }
    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
        width: 100%; /* Largura total do campo */
        padding: 10px; /* Preenchimento interno do campo */
        margin-bottom: 10px; /* Margem inferior do campo */
        border: 1px solid #ccc; /* Borda do campo */
        border-radius: 4px; /* Bordas arredondadas */
    }
    button {
        background-color: blue; /* Cor de fundo do botão */
        color: white; /* Cor do texto do botão */
        padding: 10px 15px; /* Preenchimento interno do botão */
        border: none; /* Remove a borda do botão */
        border-radius: 4px; /* Bordas arredondadas do botão */
        cursor: pointer; /* Muda o cursor ao passar sobre o botão */
    }
    button:hover {
        background-color: #4cae4c; /* Cor de fundo do botão ao passar o mouse */
    }
    #resultados {
        margin-top: 20px; /* Margem superior para a seção de resultados */
    }
    table {
        width: 100%; /* Largura total da tabela */
        border-collapse: collapse; /* Colapsa as bordas da tabela */
        margin-top: 10px; /* Margem superior da tabela */
    }
    table, th, td {
        border: 1px solid #ccc; /* Borda da tabela e células */
    }
    th, td {
        padding: 10px; /* Preenchimento interno das células */
        text-align: left; /* Alinhamento do texto à esquerda */
    }
    th {
        background-color: #f2f2f2; /* Cor de fundo do cabeçalho da tabela */
    }
    .botao {
        display: inline-block; /* Exibe o botão como bloco em linha */
        padding: 10px 20px; /* Preenchimento interno do botão */
        font-size: 16px; /* Tamanho da fonte do botão */
        color: white; /* Cor do texto do botão */
        background-color: blue; /* Cor de fundo do botão */
        text-align: center; /* Alinhamento do texto no centro */
        text-decoration: none; /* Remove sublinhado do texto */
        border-radius: 5px; /* Bordas arredondadas do botão */
        cursor: pointer; /* Muda o cursor ao passar sobre o botão */
    }
    .botao:hover {
        background-color: red; /* Cor de fundo do botão ao passar o mouse */
    }
</style>

<div>
    <h1>Emitir Cobrança</h1> <!-- Título da página -->
    <form method="post"> <!-- Início do formulário, enviando dados via POST -->
        <a href="home.php" class="botao">Voltar ao início</a> <!-- Link para voltar à página inicial -->
        <label for="numero_socio">Número de Sócio:</label> <!-- Rót ulo para o campo de número de sócio -->
        <input type="number" id="numero_socio" name="numero_socio" required> <!-- Campo para inserir o número de sócio, obrigatório -->
        
        <label for="valor">Valor:</label> <!-- Rótulo para o campo de valor -->
        <input type="number" step="0.01" id="valor" name="valor" required> <!-- Campo para inserir o valor, obrigatório, com duas casas decimais -->
        
        <label for="tipo">Tipo:</label> <!-- Rótulo para o campo de tipo -->
        <select id="tipo" name="tipo" required> <!-- Campo de seleção para o tipo de cobrança, obrigatório -->
            <option value="JOIA">Joia</option> <!-- Opção para 'Joia' -->
            <option value="QUOTA">Quota</option> <!-- Opção para 'Quota' -->
        </select>
        
        <button type="submit">Emitir Cobrança</button> <!-- Botão para enviar o formulário -->
    </form>

    <?php
    // Função para emitir cobrança
    function emitirCobranca($numero_socio, $valor, $tipo) {
        // Verifica se o tipo é válido
        if ($tipo !== 'JOIA' && $tipo !== 'QUOTA') {
            return false; // Retorna falso se o tipo não for válido
        }
    
        // Verifica se o valor é um número
        if (!is_numeric($valor)) {
            return false; // Retorna falso se o valor não for numérico
        }
    
        // Obtém o próximo número de cobrança
        $numero_cobranca = obterProximoNumeroCobranca();
        $data_emissao = date('Y-m-d H:i:s'); // Obtém a data e hora atuais
    
        // Cria a linha de cobrança com os dados
        $linha_cobranca = implode(';', [
            $numero_cobranca,
            $data_emissao,
            $numero_socio,
            number_format($valor, 2, '.', ''), // Formata o valor para duas casas decimais
            'PENDENTE', // Status da cobrança
            $tipo, // Tipo de cobrança
            '' // Campo vazio para futuras informações
        ]);
    
        // Tenta abrir o arquivo para escrita
        $fcobrancas = fopen("data" . DIRECTORY_SEPARATOR . "cobrancas.txt", 'a');
        
        // Verifica se o arquivo foi aberto com sucesso
        if ($fcobrancas === false) {
            return false; // Retorna falso se não conseguiu abrir o arquivo
        }
    
        // Escreve a linha de cobrança no arquivo
        $resultado = fputs($fcobrancas, $linha_cobranca . "\n");
        fclose($fcobrancas); // Fecha o arquivo
        
        return $resultado !== false; // Retorna verdadeiro se a escrita foi bem-sucedida
    }

    // Função para obter o próximo número de cobrança
    function obterProximoNumeroCobranca() {
        // Verifica se o arquivo de cobranças existe
        if (!file_exists('cobrancas.txt')) {
            return 1; // Retorna 1 se o arquivo não existir
        }

        // Lê as linhas do arquivo
        $linhas = file('cobrancas.txt', FILE_IGNORE_NEW_LINES);
        $ultima_linha = end($linhas); // Obtém a última linha do arquivo
        $dados = explode(';', $ultima_linha); // Divide a linha em partes
        return intval($dados[0]) + 1; // Retorna o próximo número de cobrança
    }

    // Exemplo de uso
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o método de requisição é POST
        $numero_socio = $_POST['numero_socio']; // Obtém o número de sócio do formulário
        $valor = $_POST['valor']; // Obtém o valor do formulário
        $tipo = $_POST['tipo']; // Obtém o tipo do formulário

        // Tenta emitir a cobrança e exibe mensagem de sucesso ou erro
        if (emitirCobranca($numero_socio, $valor, $tipo)) {
            echo "<p>Cobrança emitida com sucesso!</p>"; // Mensagem de sucesso
        } else {
            echo "<p>Erro ao emitir cobrança.</p>"; // Mensagem de erro
        }
    }
    ?>
</div>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; // Inclui o rodapé da página ?>
