<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - GestaDAW</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .hero {
            background-color: #007bff;
            color: white;
            padding: 60px 20px;
            text-align: center;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .card {
            margin: 20px 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php">GestaDAW</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="utilizadores.php">Utilizadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="socios.php">Sócios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="emitir_cobranca.php">Cobranças</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registar_pagamentos.php">Pagamentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Terminar Sessão</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="hero">
    <h1>Bem-vindo ao GestaDAW!</h1>
    <p>O sistema de gestão de sócios e cobranças que facilita a administração da sua associação.</p>
</div>

<div class="container">
    <h2>Funcionalidades Principais</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerir Utilizadores</h5>
                    <p class="card-text">Adicione, edite ou remova utilizadores do sistema de forma simples e rápida.</p>
                    <a href="utilizadores.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gerir Sócios</h5>
                    <p class="card-text">Mantenha o registro dos sócios atualizado com facilidade.</p>
                    <a href="socios.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Emitir Cobranças</h5>
                    <p class="card-text">Emita cobranças de quotas e joias rapidamente.</p>
                    <a href="emitir_cobranca.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@pop"></script>

<?php include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
