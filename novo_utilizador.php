<?php
// Inclui a biblioteca de funções relacionadas a utilizadores
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

// Verifica se a sessão do utilizador é válida
if (!validaSessao()) {
    // Se a sessão não for válida, redireciona o utilizador para a página de login
    header('Location: login.php');
    exit; // Encerra a execução do script após o redirecionamento
}

// Verifica se o formulário foi enviado (se há dados no POST)
if (!empty($_POST)) {
    // Tenta adicionar um novo utilizador com os dados fornecidos no formulário
    $ret = adicionarUtilizador($_POST['username'], $_POST['name'], $_POST['password']);
    
    // Verifica se a adição do utilizador foi bem-sucedida
    if ($ret === false) {
        // Se falhar, define uma mensagem de erro
        $message = 'Não foi possivel adicionar o utilizador';
        $class = "danger"; // Classe para exibir a mensagem de erro
    } else {
        // Se for bem-sucedido, define uma mensagem de sucesso
        $message = "Utilizador adicionado com sucesso";
        $class = "success"; // Classe para exibir a mensagem de sucesso
    }
}
?>

<?php 
// Inclui o cabeçalho da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; 
?>

<?php 
// Inclui o menu de navegação da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; 
?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Registar utilizador</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?> 
        <div class="row justify-content-center">
            <div class="col-6">
                <!-- Exibe a mensagem de erro ou sucesso, se houver -->
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <!-- Formulário para registrar um novo utilizador -->
    <form action="novo_utilizador.php" method="post" class="">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Username</label>
            <div class="col-4">
                <!-- Campo de entrada para o nome de utilizador -->
                <input type="text" name="username" id="">
            </div>
        </div>
        
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <!-- Campo de entrada para o nome do utilizador -->
                <input type="text" name="name" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Password</label>
            <div class="col-4">
                <!-- Campo de entrada para a password do utilizador -->
                <input type="password" name="password" id="">
            </div>
        </div>
        
        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <!-- Botão para submeter o formulário -->
                <input class="btn btn-success btn-large" type="submit" value="Registar Utilizador" name="form_b">
            </div>
        </div>
    </form>
</div>

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>