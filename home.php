<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'partials/header.php'; ?>

<?php include_once 'partials/menu.php'; ?>

lista de tarefas

<?php include_once 'partials/footer.php'; ?>

.gitignore