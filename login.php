<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    if (!empty($_POST)) {
        if (($utilizador = validaUtilizador($_POST['email'], $_POST['password'])) !== false){
            // já sei que o utilizador deu credenciais certas
            session_start();
            $_SESSION['nome'] = $utilizador[2];
            header('Location: index.php');
        } else {
            echo "Utilizador ou palavra-passe errada"; 
        }
    } else {
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Banco Universal</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center">Tarefas++</h1>
                <p class="lead text-center mt-2">O seu organizador para mais tarefas e mais produtividade.</p>
                <p class="text-center">
                    <img src="assets/img/icon.png" alt="" style="height: 50px">
                </p>
            </div>
        </div>

        <form action="login.php" method="post" class="">
            <div class="row justify-content-center mt-3">
                <label for="" class="col-2 text-end fw-bold">Email</label>
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
    </body>
    </html>
    <?php
    }

    ?>