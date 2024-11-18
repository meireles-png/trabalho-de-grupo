<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $ret = adicionarUtilizador($_POST['username'], $_POST['name'], $_POST['password']);
        if ($ret === false) {
            $message = 'Não foi possivel adicionar o utilizador';
            $class = "danger";
        } else {
            $message = "Utilizador adicionado com sucesso";
            $class = "success";
        }
    }
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Registar utilizador</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?> 
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="novo_utilizador.php" method="post" class="">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Username</label>
            <div class="col-4">
                <input type="text" name="username" id="">
            </div>
        </div>
        
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <input type="text" name="name" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Password</label>
            <div class="col-4">
                <input type="password" name="password" id="">
            </div>
        </div>
        
        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Registar Utilizador" name="form_b">
            </div>
        </div>
    </form>
</div>
