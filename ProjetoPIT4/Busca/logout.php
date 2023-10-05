<?php
session_start();

// Encerra a sessão
$_SESSION = array();
session_destroy();

// Redireciona para a página de login
header("Location: ../login/index.php");
exit();
