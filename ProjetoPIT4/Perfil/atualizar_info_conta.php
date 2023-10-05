<?php
session_start();

ini_set('display_errors', 0);

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    // Redireciona para a página de login ou exibe uma mensagem de erro
    header('Location: ../login/index.php');
    exit();
}

// Recupera o ID do usuário da sessão
$idUsuario = $_SESSION['id_usuario'];

if (isset($_SESSION['patente'])) {
    $patente = $_SESSION['patente'];
} else if (isset($_SESSION['elo'])) {
    $elo = $_SESSION['elo'];
}


if (isset($patente)) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Recupera os dados enviados pelo formulário
        $novoNivel = $_POST['nivel-input'];
        $novaPatente = $_POST['patente-select'];

        // Realize a validação dos dados
        $errors = [];

        // Validação do nome
        if (empty($novoNivel)) {
            $errors[] = 'O nível é obrigatório.';
        } elseif ($novoNivel > 40) {
            $errors[] = 'O nível não pode ser maior que 40.';
        }

        if (empty($novaPatente)) {
            $errors[] = 'A patente é obrigatória.';
        }

        // Verifica se há erros
        if (count($errors) === 0) {
            // Realize a conexão com o banco de dados e execute a consulta para atualizar as informações da conta

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

            // Substitua 'seu_campo_nome' e 'seu_campo_patente_elo' com os nomes corretos dos campos na tabela do banco de dados
            $sql = "UPDATE usuario SET nivel = ?, patente = ? WHERE id = ?";

            // Prepare a consulta
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isi', $novoNivel, $novaPatente, $idUsuario);

            // Execute a consulta
            if ($stmt->execute()) {

                $_SESSION['nivel'] = $novoNivel;
                $_SESSION['patente'] = $novaPatente;

                // Redireciona o usuário de volta à página de perfil
                header('Location: index.php');
                exit();
            } else {
                // Trate o erro na atualização do banco de dados
                $errors[] = 'Ocorreu um erro ao atualizar as informações da conta. Por favor, tente novamente mais tarde.';
            }

            // Feche a conexão com o banco de dados
            $stmt->close();
            $conn->close();
        }
    }
} elseif (isset($elo)) {

    echo "Entrei aqui";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        echo "Entrei aqui tbm";

        // Recupera os dados enviados pelo formulário
        $novoNivel = $_POST['nivel-input'];
        $novoElo = $_POST['elo-select'];

        // Realize a validação dos dados
        $errors = [];

        // Validação do nome
        if (empty($novoNivel)) {
            $errors[] = 'O nível é obrigatório.';
        } elseif ($novoNivel > 1000) {
            $errors[] = 'O nível não pode ser maior que 1000.';
        }

        if (empty($novoElo)) {
            $errors[] = 'O elo é obrigatório.';
        }

        // Verifica se há erros
        if (count($errors) === 0) {

            // Realize a conexão com o banco de dados e execute a consulta para atualizar as informações da conta

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

            // Substitua 'seu_campo_nome' e 'seu_campo_patente_elo' com os nomes corretos dos campos na tabela do banco de dados
            $sql = "UPDATE usuario SET nivel = ?, elo = ? WHERE id = ?";

            // Prepare a consulta
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('isi', $novoNivel, $novoElo, $idUsuario);

            // Execute a consulta
            if ($stmt->execute()) {

                $_SESSION['nivel'] = $novoNivel;
                $_SESSION['elo'] = $novoElo;

                // Redireciona o usuário de volta à página de perfil
                header('Location: index.php');
                exit();
            } else {
                // Trate o erro na atualização do banco de dados
                $errors[] = 'Ocorreu um erro ao atualizar as informações da conta. Por favor, tente novamente mais tarde.';
            }

            // Feche a conexão com o banco de dados
            $stmt->close();
            $conn->close();
        }
    }
} else {
    echo 'Erro fatal';
}
