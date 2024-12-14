<?php
    // Inclui as bibliotecas necessárias para a validação de sessão e manipulação de sócios
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'cobrancas_lib.php';

    // Verifica se a sessão do usuário é válida
    if (!validaSessao()) {
        // Se a sessão não for válida, redireciona para a página de login
        header('Location: login.php');
        exit; // Encerra a execução do script
    }

    if (!empty($_POST)) {
        $ret = emitirCobranca($_POST['ID'], $_POST['valor'], $_POST['tipo']);
        if ($ret === false) {
            $message = "Não foi possivél emitir a cobrança.";
            $class = "danger";
        } else {
            $message = "Cobrança emitida.";
            $class = "success";
        }
    }
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

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
    <div class="container mt-3">
        <div class="row">
            <div class="col">
                <h1>Emitir Cobrança</h1> <!-- Título da página -->
            </div>
        </div>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class; ?>"> <?php echo $message; ?></p> <!-- Mensagem de erro ou de sucesso -->
            </div>
        </div>
    <?php } ?>

    <form action="nova_cobranca.php" method="post" class="">

        <div class="row justify-content-text-center mt-3">
            <label for="" clas="col-2 text-end fw-bold">ID</label>
            <div class="col-4">
                <input type="text" name="ID" id="" required>
            </div>
        </div>

        <div class="row justify-content-text-center mt-3">
            <label for="" clas="col-2 text-end fw-bold">Valor</label>
            <div class="col-4">
                <input type="text" name="valor" id="" required>
            </div>
        </div>

        <div class="row justify-content-text-center mt-3">
            <label for="tipo" clas="col-2 text-end fw-bold">Tipo de cobrança</label>
            <div class="col-4">
                <select name="tipo" id="tipo" required>
                    <option value="Quota">Quota</option>
                    <option value="Joia">Jóia</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-text-center mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary">Emitir Cobrança
            </div>
        </div>

    </form>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; // Inclui o rodapé da página ?>
