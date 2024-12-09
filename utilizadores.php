<?php
// Inclui a biblioteca de funções relacionadas a utilizadores
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

// Verifica se a sessão do utilizador é válida
if (!validaSessao()) {
    // Se a sessão não for válida, redireciona o utilizador para a página de login
    header('Location: login.php');
    exit; // Encerra a execução do script após o redirecionamento
}
?>

<?php 
// Inclui o cabeçalho da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; 
?>

<?php 
// Inclui o menu de navegação da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; 
?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Utilizadores</h1> <!-- Título da página -->
        </div>
    </div>

    <div class="row">
        <div class="col text-end">
            <!-- Botão para registrar um novo utilizador -->
            <a href="novo_utilizador.php" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i>Registar Utilizador
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th> <!-- Cabeçalho da coluna para Nome -->
                        <th>Username</th> <!-- Cabeçalho da coluna para Username -->
                        <th class="text-end">Ações</th> <!-- Cabeçalho da coluna para Ações -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Chama a função para ler utilizadores
                    $utilizadores = lerUtilizadores();
                    // Itera sobre cada utilizador retornado
                    foreach ($utilizadores as $utilizador) { ?>
                        <tr>
                            <td><?php echo $utilizador['nome'];?></td> <!-- Exibe o nome do utilizador -->
                            <td><?php echo $utilizador['username'];?></td> <!-- Exibe o username do utilizador -->
                            <td class="text-end">
                                <!-- Botão para visualizar detalhes do utilizador -->
                                <a href="ver_utilizador.php?username=<?php echo $utilizador['username'];?>" class="btn btn-secondary">
                                    <i class="fa-solid fa-info fa-fw"></i>
                                </a>
                                <!-- Botão para modificar os dados do utilizador -->
                                <a href="modificar_utilizador.php?username=<?php echo $utilizador['username'];?>" class="btn btn-warning">
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

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>