<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

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

    <form action="socios.php" method="post" class="mt-3 mb-3">
        <div class="row">
            <div class="col-8">
                <input type="text" name="pesquisa" id="" class="form-control" placeholder="Filtrar resultados">                
            </div>
            <div class="col-2">
                <select name="estado" id="" class="form-control">
                    <option value=""></option>
                    <option value="1">Ativo</option>
                    <option value="2">Suspenso</option>
                    <option value="3">Pendente</option>
                </select>
            </div>

            <div class="col-2">
                <input type="submit" value="Filtrar" name="search_b" class="btn btn-secondary col-12">
            </div>
        </div>
        
    </form>

    <hr>

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
                        <th>ID</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $socios = lerSocios($_POST['pesquisa'] ?? '', $_POST['estado'] ?? '');
                        foreach ($socios as $socio) { ?>
                            <tr>
                                <td><?php echo $socio['nome'];?></td>
                                <td><?php echo $socio['id'];?></td>
                                <td class="text-end">
                                    
                                    <a href="ver_socio.php?id=<?php echo $socio['id'];?>" class="btn btn-secondary">
                                        <i class="fa-solid fa-info fa-fw"></i>
                                    </a>
                                    <a href="modificar_socio.php?id=<?php echo $socio['id'];?>" class="btn btn-warning">
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