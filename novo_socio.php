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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = $_POST['nome'];
    $nif = $_POST['nif'];
    $data_nascimento = $_POST['data_nascimento'];
    $morada = $_POST['morada'];
    $codigo_postal = $_POST['codigo_postal'];
    $localidade = $_POST['localidade'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $ID = obtemProximoId();
    // Formata a string a ser escrita no arquivo
    $linha = "$nome; $nif; $data_nascimento; $morada; $codigo_postal; $localidade; $email; $sexo; $ID \n";

    // Caminho do arquivo
    $caminho_arquivo = adicionarSocio($nome, $nif, $email, $morada, $sexo);

    // Tenta abrir o arquivo para escrita
    if (file_put_contents($caminho_arquivo, $linha, FILE_APPEND | LOCK_EX) !== false) {
        // Mensagem de sucesso
        $message = "Sócio adicionado com sucesso!";
        $class = "success";
    } else {
        // Mensagem de erro
        $message = "Erro ao adicionar sócio. Tente novamente.";
        $class = "danger";
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

<div>
    <div class="row">
        <div class="col">
            <h1>Adicionar Sócio</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?> 
        <div class="row justify-content-center">
            <div class="col-6">
                <!-- Exibe a mensagem de erro ou sucesso, se houver -->
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <!-- Formulário para adicionar um novo sócio -->
    <form action="novo_socio.php" method="post" class="">
        <div class="row justify-content-center mt-3">
            <label for="nome" class="col-2 text-end fw-bold">Nome de Sócio</label>
            <div class="col-4">
                <!-- Campo de entrada para o nome do sócio -->
                <input type="text" id="nome" name="nome" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="nif" class="col-2 text-end fw-bold">Número de Identificação Fiscal</label>
            <div class="col-4">
                <!-- Campo de entrada para o NIF com validação de formato -->
                <input type="text" id="nif" name="nif" pattern="\d{9}" title="Deve conter 9 Números." required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="data_nascimento" class="col-2 text-end fw-bold">Data de Nascimento (AAAA-MM-DD)</label>
            <div class="col-4">
                <!-- Campo de entrada para a data de nascimento -->
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="morada" class="col-2 text-end fw-bold">Morada</label>
            <div class="col-4">
                <!-- Campo de entrada para a morada do sócio -->
                <input type="text" id="morada" name="morada" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="codigo_postal" class="col-2 text-end fw-bold">Código Postal (XXXX-YYY)</label>
            <div class="col-4">
                <!-- Campo de entrada para o código postal com validação de formato -->
                <input type="text" id="codigo_postal" name="codigo_postal" pattern="\d{4}-\d{3}" title="Formato: XXXX-YYY" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="localidade" class="col-2 text-end fw-bold">Localidade</label>
            <div class="col-4">
                <!-- Campo de entrada para a localidade do sócio -->
                <input type="text" id="localidade" name="localidade" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="email" class="col-2 text-end fw-bold">Email</label>
            <div class="col-4">
                <!-- Campo de entrada para o email do sócio -->
                <input type="email" id="email" name="email" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="sexo" class="col-2 text-end fw-bold">Sexo</label>
            <div class="col-4">
                <!-- Seleção do sexo do sócio -->
                <select id="sexo" name="sexo" required>
                    <option value="MASCULINO">Masculino</option>
                    <option value="FEMININO">Feminino</option>  
                </select>       
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <!-- Botão para submeter o formulário -->
                <input class="btn btn-success btn-large" type="submit" value="Registar Sócio">
            </div>
        </div>
    </form>
</div>

<?php 
// Inclui o rodapé da página
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; 
?>