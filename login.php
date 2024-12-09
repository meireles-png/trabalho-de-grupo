<?php
    // Inclui a biblioteca de funções relacionadas a utilizadores
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

    // Verifica se o formulário foi enviado (se há dados no POST)
    if (!empty($_POST)) {
        // Valida o utilizador com o email e a password fornecidos
        if (($utilizador = validaUtilizador($_POST['email'], $_POST['password'])) !== false){
            // Se a validação for bem-sucedida, redireciona para a página inicial
            header('Location: home.php');
        } else {
            // Se a validação falhar, define uma mensagem de erro
            $message = "Utilizador ou palavra-passe errada";
        }
    } 
?>

<?php 
    // Inclui o cabeçalho da página
    include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; 
?>

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
            <!-- Exibe a mensagem de erro se houver -->
            <p class="alert alert-danger"><?php echo $message;?></p>
        </div>
    </div>
<?php } ?>

<!-- Formulário de login -->
<form action="login.php" method="post" class="">
    <div class="row justify-content-center mt-3">
        <label for="" class="col-2 text-end fw-bold">ID</label>
        <div class="col-4">
            <!-- Campo para o email do utilizador -->
            <input type="text" name="email" id="">
        </div>
    </div>
    
    <div class="row justify-content-center mt-3">
        <label for="" class="col-2 text-end fw-bold">Password</label>
        <div class="col-4">
            <!-- Campo para a password do utilizador -->
            <input type="password" name="password" id="">
        </div>
    </div>
    
    <div class="row justify-content-center mt-3">
        <div class="col text-center">
            <!-- Botão para submeter o formulário -->
            <input class="btn btn-success btn-large" type="submit" value="Iniciar Sessão" name="login_b">
        </div>
    </div>
</form>

<div class="mt-3 text-center">
    <div style="background-color: #f0f0f0; padding: 20px; border-radius: 5px; display: inline-block; margin-top: 20px;">
        <p><strong class="text-danger">Atenção:</strong> Ao fazer login, concorda que os cookies serão utilizados para manter a sua sessão iniciada.</p>
    </div>
</div>
</div>

<?php 
    // Inclui o rodapé da página
    include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>