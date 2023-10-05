<?php
function validarEmail($email)
{
    // Expressão regular para verificar o formato do email
    $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return preg_match($regex, $email);
}
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados de conexão com o banco de dados
    $host = "localhost";
    $dbname = "pit";
    $username = "root";
    $password = "";

    // Obtém o e-mail e a nova senha do formulário
    $email = $_POST["email"];
    $novaSenha = $_POST["senha"];

    // Conecta ao banco de dados
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verifica se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifica se o e-mail existe na tabela usuario
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o email já existe no banco de dados
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

    // Variável para armazenar as mensagens de erro
    $mensagensErro = '';
    $temErro = false;

    if (!validarEmail($email)) {
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                O email fornecido é inválido. Por favor, insira um email válido.
            </div>
        ';
    } else if ($emailExiste == false) {
        // E-mail não encontrado
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                Não há nenhuma conta vinculada a esse email.
            </div>
        ';;
    } else if ($result->num_rows > 0) {
        // E-mail encontrado
        // Atualiza a senha do usuário no banco de dados
        $updateSql = "UPDATE usuario SET senha = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $novaSenha, $email);
        $updateStmt->execute();

        if ($updateStmt->affected_rows > 0) {
            // Senha atualizada com sucesso
            echo "<p>A senha foi redefinida com sucesso.</p>";
        } else {
            // Erro ao atualizar a senha
            echo "<p>Ocorreu um erro ao redefinir a senha. Por favor, tente novamente.</p>";
        }

        $updateStmt->close();
    }

    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
}

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados de conexão com o banco de dados
    $host = "localhost";
    $dbname = "pit";
    $username = "root";
    $password = "";

    // Obtém o e-mail e a nova senha do formulário
    $email = $_POST["email"];
    $novaSenha = $_POST["senha"];

    // Conecta ao banco de dados
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $confirmaemail = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $confirmaemail);
    $stmt->execute();
    $emailselecionado = $stmt->get_result();

    echo "<script>console.log(" . $emailselecionado . ")</script>";
}*/
