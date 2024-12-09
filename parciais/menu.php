<!-- Declaração do tipo de documento -->
<!DOCTYPE html>
<html lang="pt"> <!-- Define a linguagem do documento como português -->
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura a visualização para dispositivos móveis -->
    <title>Página Inicial - GestaDAW</title> <!-- Título da página exibido na aba do navegador -->
    
    <!-- Link para o arquivo CSS do Bootstrap, uma biblioteca de front-end -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Estilos personalizados para a página */
        body {
            background-color: #f4f4f4; /* Cor de fundo da página */
            font-family: Arial, sans-serif; /* Fonte padrão da página */
        }
        .hero {
            background-color: #007bff; /* Cor de fundo da seção hero */
            color: white; /* Cor do texto na seção hero */
            padding: 60px 20px; /* Espaçamento interno da seção hero */
            text-align: center; /* Centraliza o texto na seção hero */
        }
        .hero h1 {
            font-size: 2.5rem; /* Tamanho da fonte do título na seção hero */
            margin-bottom: 20px; /* Margem inferior do título */
        }
        .card {
            margin: 20px 0; /* Margem superior e inferior das cartas */
        }
    </style>
</head>
<body>

<!-- Navegação principal da página -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">GestaDAW</a> <!-- Nome da marca que redireciona para a página inicial -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <!-- Ícone do botão de alternância para dispositivos móveis -->
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Itens de navegação -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Início</a> <!-- Link para a página inicial -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="utilizadores.php">Utilizadores</a> <!-- Link para a página de utilizadores -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="socios.php">Sócios</a> <!-- Link para a página de sócios -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="emitir_cobranca.php">Cobranças</a> <!-- Link para a página de cobranças -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registar_pagamentos.php">Pagamentos</a> <!-- Link para a página de pagamentos -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Terminar Sessão</a> <!-- Link para terminar a sessão -->
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Seção hero da página -->
<div class="hero">
    <h1>Bem-vindo ao GestaDAW!</h1> <!-- Título da seção hero -->
    <p>O sistema de gestão de sócios e cobranças que facilita a administração da sua associação.</p> <!-- Descrição da seção hero -->
</div>

<!-- Container principal da página -->
<div class="container">
    <h2 class="mt-3">Funcionalidades Principais</h2> <!-- Título da seção de funcionalidades -->
    <div class="row">
        <!-- Cartão para gerir utilizadores -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerir Utilizadores</h5> <!-- Título do cartão -->
                    <p class="card-text">Adicione, edite ou remova utilizadores do sistema de forma simples e rápida.</p> <!-- Descrição do cartão -->
                    <a href="utilizadores.php" class="btn btn-primary">Acessar</ a> <!-- Botão para acessar a página de utilizadores -->
                </div>
            </div>
        </div>
        <!-- Cartão para gerir sócios -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerir Sócios</h5> <!-- Título do cartão -->
                    <p class="card-text">Mantenha o registo dos sócios atualizado com facilidade.</p> <!-- Descrição do cartão -->
                    <a href="socios.php" class="btn btn-primary">Acessar</a> <!-- Botão para acessar a página de sócios -->
                </div>
            </div>
        </div>
        <!-- Cartão para emitir cobranças -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Emitir Cobranças</h5> <!-- Título do cartão -->
                    <p class="card-text">Emita cobranças de quotas e joias rapidamente.</p> <!-- Descrição do cartão -->
                    <a href="emitir_cobranca.php" class="btn btn-primary">Acessar</a> <!-- Botão para acessar a página de cobranças -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para confirmar a saída do usuário -->
<script>
    function confirmarSaida() {
        if (confirm('Tem a certeza que deseja sair?')) { // Pergunta de confirmação
            window.location.href = 'logout.php'; // Redireciona para a página de logout
        }
    }
</script>

<!-- Inclusão do rodapé da página -->
<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>