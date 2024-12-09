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

<?php 
    // Inclui o rodapé da página
    include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>