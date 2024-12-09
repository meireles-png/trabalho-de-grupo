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

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th> <!-- Cabeçalho da coluna para Nome -->
                        <th>ID</th> <!-- Cabeçalho da coluna para ID -->
                        <th class="text-end">Ações</th> <!-- Cabeçalho da coluna para Ações -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Chama a função para ler sócios, passando os parâmetros de pesquisa e estado
                    $socios = lerSocios($_POST['pesquisa'] ?? '', $_POST['estado'] ?? '');
                    // Itera sobre cada sócio retornado
                    foreach ($socios as $socio) { ?>
                        <tr>
                            <td><?php echo $socio['nome'];?></td> <!-- Exibe o nome do sócio -->
                            <td><?php echo $socio['id'];?></td> <!-- Exibe o ID do sócio -->
                            <td class="text-end">
                                <!-- Botão para visualizar detalhes do sócio -->
                                <a href="ver_socio.php?id=<?php echo $socio['id'];?>" class="btn btn-secondary">
                                    <i class="fa-solid fa-info fa-fw"></i>
                                </a>
                                <!-- Botão para modificar os dados do sócio -->
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

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>