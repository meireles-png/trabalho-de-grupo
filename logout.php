<?php

include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';

terminaSessao();
header('Location: login.php');

include_once 'parciais' . DIRECTORY_SEPARATOR . 'footer.php';
