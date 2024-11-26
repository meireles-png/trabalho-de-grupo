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
        $socio = obtemsocio($_GET['username']);
        if ($socio === false) { ?>
            <div class="row">
                <div class="col">
                    <p class="alert alert-danger">Sócio não encontrado!!!</p>
                </div>
            </div>
        <?php } else { ?> 
            <div class="card">
                <h5 class="card-header">Dados do Sócio</h5>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $socio['nome'];?></h5>
                    <p class="text-center">
                    <a href="modificar_socio.php?username=<?php echo $socio['username'];?>" class="btn btn-primary">Modificar</a>
                    </p>
                </div>
            </div>
    <?php } ?>
</div>
