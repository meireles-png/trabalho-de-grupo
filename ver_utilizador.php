<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>


<div class="container pt-5">
    <?php
        $utilizador = obtemUtilizador($_GET['username']);
        if ($utilizador === false) { ?>
            <div class="row">
                <div class="col">
                    <p class="alert alert-danger">Utilizador não encontrado!!!</p>
                </div>
            </div>
        <?php } else { ?> 
            <div class="card">
                <h5 class="card-header">Dados de Utilizador</h5>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $utilizador['nome'];?></h5>
                    <p class="text-center">
                    <a href="modificar_utilizador.php?username=<?php echo $utilizador['username'];?>" class="btn btn-primary">Modificar</a>
                    </p>
                </div>
            </div>
    <?php } ?>
</div>
