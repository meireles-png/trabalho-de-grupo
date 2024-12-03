<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!empty($_POST)) {
        if (($utilizador = validaUtilizador($_POST['email'], $_POST['password'])) !== false){
            header('Location: home.php');
        } else {
            $message = "Utilizador ou palavra-passe errada";
        }
    } 
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>

        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center">GestaDAW</h1>
                <p class="lead text-center mt-2">A melhor gestão de sócios do mercado.</p>
                <p class="text-center">
                    <i class="fa-solid fa-list-check"></i>
                </p>
            </div>
        </div>

        <?php if (!empty($message)) { ?> 
            <div class="row justify-content-center">
                <div class="col-6">
                    <p class="alert alert-danger"><?php echo $message;?></p>
                </div>
            </div>
        <?php } ?>

        <form action="login.php" method="post" class="">
            <div class="row justify-content-center mt-3">
                <label for="" class="col-2 text-end fw-bold">ID</label>
                <div class="col-4">
                    <input type="text" name="email" id="">
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
                    <input  class="btn btn-success btn-large" type="submit" value="Iniciar Sessão" name="login_b">
                </div>
            </div>
        </form>
    <div class="mt-3 text-center">
        <p><strong class="text-danger">Atenção:</strong> Ao fazer login, concorda que os cookies serão utilizados para manter a sua sessão iniciada.</p>
    </div>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>