<?php
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
include_once 'lib' . DIRECTORY_SEPARATOR . 'socios_lib.php';

if (!validaSessao()) {
    header('Location: login.php');
    exit;
}
?>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-5" class="row justify-content-center">
    <h2>Modificar Ficha de Sócio</h2>

    <form action="modificar_socio.php" method="post" class="text-center">
        <div class="form-group">
            <label>Número de Sócio:</label>
            <p class="form-control-static"><?php echo $numero_socio; ?></p>
        </div>
        <div class="form-group">
            <label>NIF:</label>
            <p class="form-control-static"><?php echo $nif; ?></p>
        </div>
        <div class="form-group">
            <label for="nome">Nome de Sócio:</label>
            <input type="text" class="form-control" name="nome" value="<?php echo $nome; ?>" required>
        </div>
        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" class="form-control" name="data_nascimento" value="<?php echo $data_nascimento; ?>" required>
        </div>
        <div class="form-group">
            <label for="morada">Morada:</label>
            <input type="text" class="form-control" name="morada" value="<?php echo $morada; ?>" required>
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" class="form-control" name="codigo_postal" value="<?php echo $codigo_postal; ?>" pattern="\d{4}-\d{3}" title="Formato: XXXX-YYY" required>
        </div>
        <div class="form-group">
            <label for="localidade">Localidade:</label>
            <input type="text" class="form-control" name="localidade" value="<?php echo $localidade; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="sexo">Sexo:</label>
            <select class="form-control" name="sexo" required>
                <option value="MASCULINO" <?php if ($sexo == "MASCULINO") echo "selecionado"; ?>>Masculino</option>
                <option value="FEMININO" <?php if ($sexo == "FEMININO") echo "selecionado"; ?>>Feminino</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Modificar Sócio</button>
    </form>
</div>