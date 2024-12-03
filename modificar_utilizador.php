<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $utilizador = obtemUtilizador($_GET['username']);
        $ret = modificarUtilizador($_GET['username'], $_POST['name'], $_POST['password']);
        if ($ret === false) {
            $message = 'Não foi possivel modificar o utilizador';
            $class = "danger";
        } else {
            $message = "Utilizador modificado com sucesso";
            $class = "success";
            $utilizador = obtemUtilizador($_GET['username']);
        }
    } else {
        $utilizador = obtemUtilizador($_GET['username']);
        if ($utilizador === false) {
            $message = 'Não existe o utilizador';
            $class = "danger";
        }
    }
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Modificar utilizador</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?> 
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="modificar_utilizador.php?username=<?php echo $_GET['username'];?>" method="post" class="" autocomplete="off">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <input type="text" name="name" id="" autocomplete="name" value="<?php echo $utilizador['nome'];?>">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Password</label>
            <div class="col-4">
                <input type="password" name="password" id="" autocomplete="new-password">
            </div>
        </div>
        
        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Modificar Utilizador" name="form_b">
            </div>
        </div>
    </form>
</div>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
