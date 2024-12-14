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
            <h1>Tabela de Pagamentos</h1> 
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID da cobrança</th>
                        <th>Data de emissão</th>
                        <th>ID do sócio</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                        $cobrancas = lerCobrancas();
                        if (empty($cobrancas)) {
                            echo '<tr><td colspan="5">Nenhuma cobrança encontrada.</td></tr>';
                        } else {
                            foreach ($cobrancas as $cobranca) { ?>
                                <tr>
                                    <td><?php echo $cobranca['id_cobranca']; ?></td>
                                    <td><?php echo $cobranca['data_emissao']; ?></td>
                                    <td><?php echo $cobranca['ID']; ?></td>
                                    <td><?php echo $cobranca['valor']; ?></td>
                                    <td><?php echo $cobranca['tipo']; ?></td>
                                    <td>
                                        <button >Pagar</button>
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
    include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php';
?>