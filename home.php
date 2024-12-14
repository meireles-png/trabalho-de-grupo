<?php
    // Inclui a biblioteca necessária para a manipulação de utilizadores
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    // Verifica se a sessão do usuário é válida
    if (!validaSessao()) {
        // Se a sessão não for válida, redireciona para a página de login
        header('Location: login.php');
        exit; // Encerra a execução do script para evitar que o código abaixo seja executado
    }
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; // Inclui o cabeçalho da página ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; // Inclui o menu de navegação ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; // Inclui o rodapé da página ?>