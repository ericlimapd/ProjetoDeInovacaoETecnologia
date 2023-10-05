<?php

ini_set('display_errors', 0);

session_start();

// Verifica se o usuário já está logado, redireciona para a página de perfil
if ($_SESSION["origem"] == "cadastrolol") {

    session_start();
    $idUsuario = $_SESSION["id_usuario"];
    $nome = $_SESSION["nome"];
    $email = $_SESSION["email"];
    $nivel = $_SESSION["nivel_lol"];
    $elo = $_SESSION["elo_lol"];
    $regiao = $_SESSION["regiao_lol"];
    $origem = $_SESSION["origem"];

    header("Location: ../Perfil/index.php");
    exit();
} else if ($_SESSION["origem"] == "cadastrocsgo") {

    session_start();
    $idUsuario = $_SESSION["id_usuario"];
    $nome = $_SESSION["nome"];
    $email = $_SESSION["email"];
    $nivel = $_SESSION["nivel_csgo"];
    $patente = $_SESSION["patente_csgo"];
    $regiao = $_SESSION["regiao_csgo"];
    $origem = $_SESSION["origem"];

    header("Location: ../Perfil/index.php");
    exit();
} else if (isset($_SESSION["nome"])) {

    header("Location: ../Perfil/index.php");
    exit();
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados de conexão com o banco de dados
    $host = "localhost";
    $dbname = "pit";
    $username = "root";
    $password = "";

    // Conecta ao banco de dados
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verifica se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtém os dados do formulário
    $nome = $_POST["nome"];
    $senha = $_POST["senha"];

    // Prepara a consulta SQL para buscar o usuário na tabela usuario
    $sql = "SELECT id, email, nivel, patente, elo, regiao, foto FROM usuario WHERE nome = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $senha);

    // Executa a consulta
    $stmt->execute();

    // Verifica se encontrou o usuário
    $result = $stmt->get_result();

    $mensagensErro = '';
    $temErro = false;

    if ($result->num_rows == 1) {
        // Obtém os dados do usuário
        $row = $result->fetch_assoc();
        $idUsuario = $row['id'];
        $email = $row['email'];
        $nivel = $row['nivel'];
        $patente = $row['patente'];
        $elo = $row['elo'];
        $regiao = $row['regiao'];
        $foto = $row['foto'];

        // Inicia a sessão e armazena os dados do usuário na $_SESSION
        session_start();
        $_SESSION["id_usuario"] = $idUsuario;
        $_SESSION["nome"] = $nome;
        $_SESSION["email"] = $email;
        $_SESSION["nivel"] = $nivel;
        $_SESSION["regiao"] = $regiao;
        $_SESSION["path"] = $foto;

        if ($patente !== '' && $patente !== null) {
            $_SESSION["patente"] = $patente;
        } elseif ($elo !== '' && $elo !== null) {
            $_SESSION["elo"] = $elo;
        }

        $_SESSION["origem"] = "login";

        // Redireciona para a página de perfil
        header("Location: ../Perfil/index.php");
        exit();
    } else if (empty($nome) || empty($senha)) {
        $temErro = true;
        $mensagensErro .= '
        <div id="popup-erro">
            <p>ERRO!</p>
            Por favor, preencha todos os campos.
        </div>
        ';
    } else {
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                Nome de usuário ou senha inválidos.
            </div>
        ';
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
    <title>Login</title>
</head>

<body>

    <div>
        <?php if (isset($temErro) && $temErro) : ?>
            <?php echo $mensagensErro; ?>
        <?php endif; ?>
    </div>


    <div id="login-box">
        <p>Login</p>
        <form method="POST">
            <input class="input" type="text" name="nome" placeholder="Nome de usuário">
            <input class="input" type="password" name="senha" placeholder="Senha">
            <button type="submit">Enviar</button>
            <a href="../EsqueciMinhaSenha/index.php">Esqueci minha senha</a>
            <a href="../cadastro/index.php">Criar uma conta</a>
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