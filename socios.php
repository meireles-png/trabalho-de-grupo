<?php
// Inclui as bibliotecas necessárias para funções de utilizadores e sócios
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

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
            <h1>Sócios</h1> <!-- Título da página -->
        </div>
    </div>

    <!-- Formulário para filtrar sócios -->
    <form action="socios.php" method="post" class="mt-3 mb-3">
        <div class="row">
            <div class="col-8">
                <!-- Campo de entrada para pesquisa -->
                <input type="text" name="pesquisa" id="" class="form-control" placeholder="Filtrar resultados">                
            </div>
            <div class="col-2">
                <!-- Seleção para o estado do sócio -->
                <select name="estado" id="" class="form-control">
                    <option value=""></option>
                    <option value="1">Ativo</option>
                    <option value="2">Suspenso</option>
                    <option value="3">Pendente</option>
                </select>
            </div>

            <div class="col-2">
                <!-- Botão para submeter o formulário de filtro -->
                <input type="submit" value="Filtrar" name="search_b" class="btn btn-secondary col-12">
            </div>
        </div>
    </form>

    <hr>

    <div class="row">
        <div class="col text-end">
            <!-- Botão para registrar um novo sócio -->
            <a href="novo_socio.php" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i>Registar Sócios
            </a>
        </div>
    </div>
<style>
    /* Estilo adicional, se necessário */
    .table-responsive {
        margin-top: 20px;
    }
</style>

<div class="container">
    <h1 class="text-center">Lista de Sócios</h1>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Morada</th>
                            <th>Sexo</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Chama a função para ler sócios, passando os parâmetros de pesquisa e estado
                        $socios = lerSocios($_POST['pesquisa'] ?? '');
                        // Itera sobre cada sócio retornado
                        foreach ($socios as $socio) { ?>
                            <tr>
                                <td><?php echo $socio['nome']; ?></td>
                                <td><?php echo $socio['id']; ?></td>
                                <td><?php echo $socio['email']; ?></td>
                                <td><?php echo $socio['morada']; ?></td>
                                <td><?php echo $socio['sexo']; ?></td>
                                <td class="text-end">
                                    <a href="ver_socio.php?nome=<?php echo $socio['nome']; ?>" class="btn btn-secondary">
                                        <i class="fas fa-info"></i>
                                    </a>
                                    <a href="modificar_socio.php?id=<?php echo $socio['id']; ?>" class="btn btn-warning">
                                        <i class="fas fa-user-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>