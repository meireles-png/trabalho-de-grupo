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
    // Obtém os dados do utilizador com base no nome de utilizador fornecido na URL
    $utilizador = obtemUtilizador($_GET['username']);
    
    // Tenta modificar o utilizador com os dados fornecidos no formulário
    $ret = modificarUtilizador($_GET['username'], $_POST['name'], $_POST['password']);
    
    // Verifica se a modificação foi bem-sucedida
    if ($ret === false) {
        // Se falhar, define uma mensagem de erro
        $message = 'Não foi possivel modificar o utilizador';
        $class = "danger"; // Classe para exibir a mensagem de erro
    } else {
        // Se for bem-sucedido, define uma mensagem de sucesso
        $message = "Utilizador modificado com sucesso";
        $class = "success"; // Classe para exibir a mensagem de sucesso
        // Atualiza os dados do utilizador após a modificação
        $utilizador = obtemUtilizador($_GET['username']);
    }
} else {
    // Se o formulário não foi enviado, tenta obter os dados do utilizador
    $utilizador = obtemUtilizador($_GET['username']);
    // Verifica se o utilizador existe
    if ($utilizador === false) {
        // Se não existir, define uma mensagem de erro
        $message = 'Não existe o utilizador';
        $class = "danger"; // Classe para exibir a mensagem de erro
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
            <h1>Modificar utilizador</h1>
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

    <!-- Formulário para modificar o utilizador -->
    <form action="modificar_utilizador.php?username=<?php echo $_GET['username'];?>" method="post" class="" autocomplete="off">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <!-- Campo de entrada para o nome do utilizador, preenchido com o valor atual -->
                <input type="text" name="name" id="" autocomplete="name" value="<?php echo $utilizador['nome'];?>">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Password</label>
            <div class="col-4">
                <!-- Campo de entrada para a nova password do utilizador -->
                <input type="password" name="password" id="" autocomplete="new-password">
            </div>
        </div>
        
        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <!-- Botão para submeter o formulário -->
                <input class="btn btn-success btn-large" type="submit" value="Modificar Utilizador" name="form_b">
            </div>
        </div>
    </form>
</div>

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>