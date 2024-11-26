<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Sócios</h1>
        </div>
    </div>

    <div class="row">
        <div class="col text-end">
            <a href="novo_socio.php" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i>Registar Sócios
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Username</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $socios = lerSocio();
                        foreach ($socios as $socio) { ?>
                            <tr>
                                <td><?php echo $socio['nif'];?></td>
                                <td><?php echo $socio['nome'];?></td>
                                <td class="text-end">
                                    <a href="ver_socio.php?nome=<?php echo $socio['nome'];?>" class="btn btn-secondary">
                                        <i class="fa-solid fa-info fa-fw"></i>
                                    </a>
                                    <a href="modificar_socio.php?nome=<?php echo $socio['nome'];?>" class="btn btn-warning">
                                        <i class="fa-solid fa-user-pen fa-fw"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>