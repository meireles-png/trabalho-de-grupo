<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>


<?php

print_r($_GET);
?>