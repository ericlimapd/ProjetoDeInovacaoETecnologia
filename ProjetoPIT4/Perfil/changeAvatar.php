<?php
session_start();
$idUsuario = $_SESSION["id_usuario"];

$host = "localhost";
$dbname = "pit";
$username = "root";
$password = "";

// Cria a conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}


if (isset($_POST['remove'])) {
    // Botão "Remover" foi clicado

    // Consulta o caminho atual da foto de perfil no banco de dados
    $sqlSelect = "SELECT foto FROM usuario WHERE id = ?";
    $stmtSelect = $conn->prepare($sqlSelect);
    $stmtSelect->bind_param('i', $idUsuario);
    $stmtSelect->execute();
    $stmtSelect->bind_result($fotoPerfil);
    $stmtSelect->fetch();
    $stmtSelect->close();

    // Remove a foto do banco de dados
    $sqlDelete = "UPDATE usuario SET foto = NULL WHERE id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param('i', $idUsuario);
    $stmtDelete->execute();
    $stmtDelete->close();

    // Remove a foto do diretório de arquivos
    $caminhoFoto = $fotoPerfil;
    if (file_exists($caminhoFoto) && is_file($caminhoFoto)) {
        unlink($caminhoFoto);
    }

    $_SESSION['path'] = null;
} else if (isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];

    if ($arquivo['error'])
        die("Falha ao enviar o arquivo");
    if ($arquivo['size'] > 2097152)
        die("Arquivo muito grande!!! Max: 2MB");

    $pasta = "../perfil/arquivos/";
    $novoNomeDoArquivo = $arquivo['name'];
    $nomeDoArquivo = uniqid();
    $extensao = strtolower(pathinfo($novoNomeDoArquivo, PATHINFO_EXTENSION));

    if ($extensao != "jpg" && $extensao != 'png')
        die("Tipo de arquivo não aceito.");

    $path = $pasta . $novoNomeDoArquivo /*. "."*/;
    $_SESSION['path'] = $path;

    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $pasta . $novoNomeDoArquivo/*. "." . $extensao*/);
    if ($deu_certo)

        $sql = "UPDATE usuario SET foto = ? WHERE id = ?";

    // Prepara a declaração
    $stmt = $conn->prepare($sql);

    // Verifica se houve erro na preparação da consulta
    if (!$stmt) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Vincula os parâmetros à declaração
    $stmt->bind_param('si', $path, $idUsuario);

    // Executa a consulta
    if ($stmt->execute()) {
        // Redireciona o usuário de volta à página de perfil
        $_SESSION['path'] = $path;
    } else {
        // Trata o erro na atualização do banco de dados
        $errors[] = 'Ocorreu um erro ao atualizar os detalhes pessoais. Por favor, tente novamente mais tarde.';
        var_dump($errors);
    }

    // Fecha a declaração
    $stmt->close();

    // Fecha a conexão com o banco de dados
    $conn->close();
}
