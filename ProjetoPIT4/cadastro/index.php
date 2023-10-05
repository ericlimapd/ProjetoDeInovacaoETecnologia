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

    // Conecta ao banco de dados
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verifica se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtém os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    //Verifica se o nome já existe no banco de dados
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

    // Verifica se os campos estão em branco
    if (empty($nome) || empty($email) || empty($senha)) {
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
    } else if (!validarEmail($email)) {
        $temErro = true;
        $mensagensErro .= '
            <div id="popup-erro">
                <p>ERRO!</p>
                O email fornecido é inválido. Por favor, insira um email válido.
            </div>
        ';
    } else {

        session_start();
        $_SESSION["nome"] = $nome;
        $_SESSION["email"] = $email;
        $_SESSION["senha"] = $senha;

        // Redireciona para a página de cadastrodois.php
        header("Location: cadastro.php");
        exit();
        // Redireciona para a página de cadastrodois.php
    }

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
    <title>Cadastro</title>
</head>

<body>

    <div>
        <?php if (isset($temErro) && $temErro) : ?>
            <?php echo $mensagensErro; ?>
        <?php endif; ?>
    </div>

    <!--Caixa de login-->
    <div id="cadastro-box">
        <p>Faça seu cadastro</p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="nome" placeholder="Digite um nome de usuário">
            <input type="text" name="email" placeholder="Digite um endereço de email">
            <input type="password" name="senha" placeholder="Digite uma senha">
            <button type="submit">Cadastrar</button>
            <a href="../login/index.php">Já tenho uma conta</a>
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