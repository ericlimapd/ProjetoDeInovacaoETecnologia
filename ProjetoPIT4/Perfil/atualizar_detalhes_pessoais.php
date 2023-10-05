<?php

//if (isset($_POST['btn-change-det'])) 
session_start();

function validarEmail($email)
{
    // Expressão regular para verificar o formato do email
    $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return preg_match($regex, $email);
}


// Recupera o ID do usuário da sessão
$idUsuario = $_SESSION['id_usuario'];

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Configurações de conexão com o banco de dados
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

    // Recupera os dados enviados pelo formulário
    $novoNome = $_POST['change-det-nome'];
    $novoEmail = $_POST['change-det-email'];

    $nomeExiste = false;
    $verificaNomeBanco = "SELECT nome FROM usuario WHERE nome = ?";
    $verificaNome = $conn->prepare($verificaNomeBanco);
    $verificaNome->bind_param("s", $nome);
    $verificaNome->execute();
    $verificaNome->store_result();

    if ($verificaNome->num_rows > 0) {
        $nomeExiste = true;
    }

    $verificaNome->close();

    $emailExiste = false;
    $verificaEmailBanco = "SELECT email FROM usuario WHERE email = ?";
    $verificaEmail = $conn->prepare($verificaEmailBanco);
    $verificaEmail->bind_param("s", $email);
    $verificaEmail->execute();
    $verificaEmail->store_result();

    if ($verificaEmail->num_rows > 0) {
        $emailExiste = true;
    }

    $verificaEmail->close();

    $mensagensErro = '';
    $temErro = false;

    if (empty($novoNome) || empty($novoEmail)) {
        $temErro = true;
        $mensagensErro .= '
        <div id="popup-erro">
            <p>ERRO!</p>
            Por favor, preencha todos os campos.
        </div>
        ';
    } else if ($nomeExiste && $emailExiste) {
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                O nome e email fornecidos já estão em uso. Por favor, escolha outros.
            </div>
        ';
    } else if ($nomeExiste) {
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                O nome fornecido já está em uso. Por favor, escolha outro.
            </div>
        ';
    } else if ($emailExiste) {
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                O email fornecido já está em uso. Por favor, escolha outro.
            </div>
        ';
    } else if (!validarEmail($novoEmail)) {
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                O email fornecido é inválido. Por favor, insira um email válido.
            </div>
        ';
    } else {

        // Prepara a consulta SQL para atualizar os detalhes pessoais
        $sql = "UPDATE usuario SET nome = ?, email = ? WHERE id = ?";

        // Prepara a declaração
        $stmt = $conn->prepare($sql);

        // Verifica se houve erro na preparação da consulta
        if (!$stmt) {
            die('Erro na preparação da consulta: ' . $conn->error);
        }

        // Vincula os parâmetros à declaração
        $stmt->bind_param('ssi', $novoNome, $novoEmail, $idUsuario);

        // Executa a consulta
        if ($stmt->execute()) {
            // Redireciona o usuário de volta à página de perfil
            $_SESSION['nome'] = $novoNome;
            $_SESSION['email'] = $novoEmail;

            header('Location: index.php');
            exit();
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
}
