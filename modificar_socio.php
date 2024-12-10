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
// Verifica se o nome foi enviado via GET
if (isset($_GET['nome']) && !empty($_GET['nome'])) {
    $nome = $_GET['nome']; // Obtém o nome da query string

    // Verifica se o formulário foi enviado (se há dados no POST)
    if (!empty($_POST)) {
        // Obtém os dados do sócio com base no nome fornecido na URL
        $socio = obtemSocio($nome);

        // Verifica se o sócio existe
        if ($socio === false) {
            // Sócio não encontrado
            $message = 'Não existe o sócio';
            $class = "danger";
        } else {
            // Tenta modificar o sócio com os dados fornecidos no formulário
            $retro = modificarSocio(
                $nome,
                $_POST['sexo'],
                $_POST['email'],
                $_POST['data_nascimento'],
                $_POST['codigo_postal'],
                $_POST['morada'],
                $_POST['localidade']
            );

            // Verifica se a modificação foi bem-sucedida
            if ($retro === false) {
                // Se falhar, define uma mensagem de erro
                $message = 'Não foi possível modificar o sócio';
                $class = "danger";
            } else {
                // Se for bem-sucedido, define uma mensagem de sucesso
                $message = "Sócio modificado com sucesso";
                $class = "success";

                // Atualiza os dados do sócio após a modificação
                $socio = obtemSocio($nome);
            }
        }
    } else {
        // Se o formulário não foi enviado, tenta obter os dados do sócio
        $socio = obtemSocio($nome);

        // Verifica se o sócio existe
        if ($socio === false) {
            // Sócio não encontrado
            $message = 'Não existe o sócio';
            $class = "danger";
        }
    }
} else {
    // Nome não foi enviado na query string
    $message = 'Nome do sócio não foi fornecido na URL';
    $class = "danger";
}
?>

<?php
// Inicializa as variáveis com valores padrão para evitar erros de variáveis indefinidas
$nome = $morada = $codigo_postal = $localidade = $email = $data_nascimento = $sexo = '';

// Se o sócio for encontrado (por exemplo, via GET ou função), preencha os valores das variáveis
if (isset($_GET['nome']) && !empty($_GET['nome'])) {
    $socio = obtemSocio($_GET['nome']); // Função que retorna os dados do sócio com base no nome

    if ($socio !== false) {
        $nome = $socio['nome'];
        $morada = $socio['morada'];
        $codigo_postal = $socio['codigo_postal'];
        $localidade = $socio['localidade'];
        $email = $socio['email'];
        $data_nascimento = $socio['data_nascimento'];
        $sexo = $socio['sexo'];
    } else {
        // Mensagem caso o sócio não seja encontrado
        echo "<div class='alert alert-danger'>Sócio não encontrado!</div>";
    }
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

<div class="container mt-5" class="row justify-content-center">
    <h2>Modificar Ficha de Sócio</h2>

    <!-- Formulário para modificar a ficha do sócio -->
    <form action="modificar_socio.php" method="post" class="text-center">
        <div class="form-group">
            <label for="nome">Nome de Sócio</label>
            <!-- Campo de entrada para o nome do sócio -->
            <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>" required>
        </div>
        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento</label>
            <!-- Campo de entrada para a data de nascimento -->
            <input type="date" class="form-control" name="data_nascimento" value="<?php echo $data_nascimento; ?>" required>
        </div>
        <div class="form-group">
            <label for="morada">Morada</label>
            <!-- Campo de entrada para a morada do sócio -->
            <input type="text" class="form-control" name="morada" value="<?php echo $morada; ?>" required>
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <!-- Campo de entrada para o código postal com validação de formato -->
            <input type="text" class="form-control" name="codigo_postal" value="<?php echo $codigo_postal; ?>" pattern="\d{4}-\d{3}" title="Formato: XXXX-YYY" required>
        </div>
        <div class="form-group">
            <label for="localidade">Localidade</label>
            <!-- Campo de entrada para a localidade do sócio -->
            <input type="text" class="form-control" name="localidade" value="<?php echo $localidade; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <!-- Campo de entrada para o email do sócio -->
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="sexo">Sexo</label>
            <!-- Seleção para o sexo do sócio -->
            <select class="form-control" name="sexo" required>
                <option value="MASCULINO" <?php if ($sexo == "MASCULINO") echo "selecionado"; ?>>Masculino</option>
                <option value="FEMININO" <?php if ($sexo == "FEMININO") echo "selecionado"; ?>>Feminino</option>
            </select>
        </div>
        <!-- Botão para submeter o formulário -->
        <button type="submit" class="btn btn-primary">Modificar Sócio</button>
    </form>
</div>

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>