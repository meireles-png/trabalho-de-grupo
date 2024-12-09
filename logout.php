<?php

// Inclui a biblioteca de funções relacionadas a utilizadores
include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

// Chama a função terminaSessao() para encerrar a sessão do utilizador
terminaSessao();

// Redireciona o utilizador para a página de login
header('Location: login.php');

// Inclui o rodapé da página (este código nunca será executado devido ao redirecionamento anterior)
include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php';
