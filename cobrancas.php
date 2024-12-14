<?php
// Inclui as bibliotecas necessárias para funções de utilizadores e sócios
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';
include_once 'lib' . DIRECTORY_SEPARATOR . 'cobrancas_lib.php';

// Verifica se a sessão do utilizador é válida
if (!validaSessao()) {
    // Se a sessão não for válida, redireciona o utilizador para a página de login
    header('Location: login.php');
    exit;
}
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Tabela de Pagamentos</h1> <!-- Título da tabela de pagamentos -->
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table"> <!-- Início da tabela -->
                <thead>
                    <tr>
                        <th>ID da cobrança</th> <!-- Cabeçalho da coluna para ID da cobrança -->
                        <th>Data de emissão</th> <!-- Cabeçalho da coluna para data de emissão -->
                        <th>ID do sócio</th> <!-- Cabeçalho da coluna para ID do sócio -->
                        <th>Valor</th> <!-- Cabeçalho da coluna para valor -->
                        <th>Tipo</th> <!-- Cabeçalho da coluna para tipo de cobrança -->
                        <th>Ação</th> <!-- Cabeçalho da coluna para ações -->
                    </tr>
                </thead>
                <tbody>
                <?php
                        // Chama a função para ler as cobranças
                        $cobrancas = lerCobrancas();
                        // Verifica se a lista de cobranças está vazia
                        if (empty($cobrancas)) {
                            // Se não houver cobranças, exibe uma mensagem na tabela
                            echo '<tr><td colspan="5">Nenhuma cobrança encontrada.</td></tr>';
                        } else {
                            foreach ($cobrancas as $cobranca) { ?>
                                <tr>
                                    <td><?php echo $cobranca['id_cobranca']; ?></td> <!-- Exibe o ID da cobrança -->
                                    <td><?php echo $cobranca['data_emissao']; ?></td> <!-- Exibe a data de emissão -->
                                    <td><?php echo $cobranca['ID']; ?></td> <!-- Exibe o ID do sócio -->
                                    <td><?php echo $cobranca['valor']; ?></td> <!-- Exibe o valor da cobrança -->
                                    <td><?php echo $cobranca['tipo']; ?></td> <!-- Exibe o tipo de cobrança -->
                                    <td>
                                        <button >Pagar</button> <!-- Botão para realizar a ação de pagamento -->
                                    </td>
                                </tr>
                            <?php }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
    include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; // Inclui o rodapé da página
?>