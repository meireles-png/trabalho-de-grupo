<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $socio = adicionarSocio($_POST['nif'], $_POST['nome'], $_POST['estado']);
        if ($socio === false) {
            $message = 'Não foi possivel adicionar o sócio';
            $class = "danger";
        } else {
            $message = "Sócio adicionado com sucesso";
            $class = "success";
        }
    }
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div>

    <div class="row">
        <div class="col">
            <h1>Adicionar Sócio</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?> 
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="novo_socio.php" method="post" class="">
        <div class="row justify-content-center mt-3">
            <label for="nome" class="col-2 text-end fw-bold">Nome de Sócio</label>
            <div class="col-4">
                <input type="text" id="nome" name="nome" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="nif" class="col-2 text-end fw-bold">Número de Identificação Fiscal</label>
            <div class="col-4">
                <input type="text" id="nif" name="nif" pattern="\d{9}" title="Deve conter 9 Números." required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="data_nascimento" class="col-2 text-end fw-bold">Data de Nascimento (AAAA-MM-DD)</label>
            <div class="col-4">
                <input type="date" id="data_nascimento" name="data_nascimento" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="morada" class="col-2 text-end fw-bold">Morada</label>
            <div class="col-4">
                <input type="text" id="morada" name="morada" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="codigo_postal" class="col-2 text-end fw-bold">Código Postal (XXXX-YYY)</label>
            <div class="col-4">
                <input type="text" id="codigo_postal" name="codigo_postal" pattern="\d{4}-\d{3}" title="Formato: XXXX-YYY" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="localidade" class="col-2 text-end fw-bold">Localidade</label>
            <div class="col-4">
                <input type="text" id="localidade" name="localidade" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="email" class="col-2 text-end fw-bold">Email</label>
            <div class="col-4">
                <input type="email" id="email" name="email" required>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="sexo" class="col-2 text-end fw-bold">Sexo</label>
            <div class="col-4">
                <select id="sexo" name="sexo" required>
                    <option value="MASCULINO">Masculino</option>
                    <option value="FEMININO">Feminino</option>
                </select>       
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input class="btn btn-success btn-large" type="submit" value="Registar Sócio">
            </div>
        </div>
    </form>
</div>