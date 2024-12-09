<?php
// Inclui a biblioteca de funções relacionadas a utilizadores
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

// Verifica se a sessão do utilizador é válida
if (!validaSessao()) {
    // Se a sessão não for válida, redireciona o utilizador para a página de login
    header('Location: login.php');
    exit; // Encerra a execução do script após o redirecionamento
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

<div class="container pt-5">
    <?php
    // Obtém os dados do utilizador com base no username passado via GET
    $utilizador = obtemUtilizador($_GET['username']);
    
    // Verifica se o utilizador foi encontrado
    if ($utilizador === false) { ?>
        <div class="row">
            <div class="col">
                <!-- Mensagem de erro se o utilizador não for encontrado -->
                <p class="alert alert-danger">Utilizador não encontrado!!!</p>
            </div>
        </div>
    <?php } else { ?> 
        <div class="card">
            <h5 class="card-header">Dados de Utilizador</h5>
            <div class="card-body">
                <h5 class="card-title"><?php echo $utilizador['nome'];?></h5> <!-- Exibe o nome do utilizador -->
                <p class="text-center">
                    <!-- Botão para modificar os dados do utilizador -->
                    <a href="modificar_utilizador.php?username=<?php echo $utilizador['username'];?>" class="btn btn-primary">Modificar</a>
                </p>
            </div>
        </div>
    <?php } ?>
</div>

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>