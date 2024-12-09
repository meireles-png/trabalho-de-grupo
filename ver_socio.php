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
    // Obtém os dados do sócio com base no nome passado via GET
    $socio = obtemSocio($_GET['nome']);
    
    // Verifica se o sócio foi encontrado
    if ($socio === false) { ?>
        <div class="row">
            <div class="col">
                <!-- Mensagem de erro se o sócio não for encontrado -->
                <p class="alert alert-danger">Sócio não encontrado!</p>
            </div>
        </div>
    <?php } else { ?> 
        <div class="card">
            <h5 class="card-header">Dados do Sócio</h5>
            <div class="card-body">
                <h5 class="card-title"><?php echo $socio['nome'];?></h5> <!-- Exibe o nome do sócio -->
                <p class="text-center">
                    <!-- Botão para modificar os dados do sócio -->
                    <a href="modificar_socio.php?id=<?php echo $socio['nome'];?>" class="btn btn-primary">Modificar</a>
                </p>
            </div>
        </div>
    <?php } ?>
</div>

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>