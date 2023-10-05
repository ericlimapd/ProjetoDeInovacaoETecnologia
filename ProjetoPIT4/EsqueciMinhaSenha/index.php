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
    $mensagemSucesso = '';
    $sucesso = false;

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
        ';
    } else if ($result->num_rows > 0) {
        // E-mail encontrado
        // Atualiza a senha do usuário no banco de dados
        $updateSql = "UPDATE usuario SET senha = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", $novaSenha, $email);
        $updateStmt->execute();

        if ($updateStmt->affected_rows > 0) {
            // Senha atualizada com sucesso
            $sucesso = true;
            $mensagemSucesso .= '
            <div id="popup-sucesso">
                <p>SUCESSO!</p>
                Sua senha foi redefinida com sucesso.
            </div>
            ';
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Esqueci Minha Senha</title>
</head>

<body>

    <div>
        <?php if (isset($temErro) && $temErro) : ?>
            <?php echo $mensagensErro; ?>
        <?php elseif (isset($sucesso) && $sucesso) : ?>
            <?php echo $mensagemSucesso; ?>
        <?php endif ?>
    </div>

    <div id="login-box">
        <div id="title-arrow">
            <a href="../login/index.php"><img id="seta" src="../img/arrow-left.png"></a>
            <p id="esqueci">Esqueci minha senha</p>
        </div>
        <p id="text-info">Informe o e-mail para o qual deseja redefinir a sua senha.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="email" placeholder="E-mail">
            <p id="text-nova">Digite a nova senha.</p>
            <input type="password" name="senha" placeholder="Senha">
            <button type="submit">Salvar</button>
        </form>
    </div>

    <footer>
        <div id="vortex">
            <p id="vortex-title">VORTEX</p>
            <p id="direitos">Vortex® | Todos os direitos reservados.</p>
        </div>
    </footer>
</body>

</html>