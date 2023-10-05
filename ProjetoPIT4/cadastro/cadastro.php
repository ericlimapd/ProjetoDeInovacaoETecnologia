<?php
// Não permite que os erros sejam exibidos ao usuário
ini_set('display_errors', 0);

session_start();
// Obtém os dados armazenados em sessão
$nome = $_SESSION["nome"];
$email = $_SESSION["email"];
$senha = $_SESSION["senha"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se o botão da caixa lol "Finalizar Cadastro" foi clicado
    if (isset($_POST["submitlol"])) {
        // Dados de conexão com o banco de dados
        $host = "localhost";
        $dbname = "pit";
        $username = "root";
        $password = "";

        // Obtém os dados do formulário

        // Conecta ao banco de dados
        $conn = new mysqli($host, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }


        $nivel = $_POST["nivel_lol"];
        $elo = $_POST["elo_lol"];
        $regiao = $_POST["regiao_lol"];

        // Verifica se o nível do jogo "League of Legends" está dentro dos limites permitidos (COSTUMIZAR POPUP DE ERRO)
        if ($nivel < 1 || $nivel > 1000) {
            echo "Erro: O seu nível em jogo do 'League of Legends' deve estar entre 1 e 1000.";
            exit();
        }

        // Prepara a consulta SQL para inserir os dados no banco
        $sql = "INSERT INTO usuario (nome, email, senha, nivel, elo, regiao) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nome, $email, $senha, $nivel, $elo, $regiao);

        if ($stmt->execute()) {

            // Recupera o ID do usuário recém-criado
            $idUsuario = $conn->insert_id;
            // Armazena o ID do usuário na sessão
            $_SESSION["id_usuario"] = $idUsuario;

            //não é necessário: session_start();
            $_SESSION["nome"] = $nome;
            $_SESSION["email"] = $email;
            $_SESSION["nivel_lol"] = $nivel;
            $_SESSION["elo_lol"] = $elo;
            $_SESSION["regiao_lol"] = $regiao;

            $_SESSION["origem"] = "cadastrolol";
            // Cadastro realizado com sucesso
            header("Location: ../login/index.php");
            exit();
        } else {
            // Erro ao realizar o cadastro
            echo "Erro ao cadastrar usuário: " . $stmt->error;
        }
        // Verifica se o botão da caixa csgo "Finalizar Cadastro" foi clicado
    } else if (isset($_POST["submitcsgo"])) {
        // Dados de conexão com o banco de dados
        $host = "localhost";
        $dbname = "pit";
        $username = "root";
        $password = "";

        // Obtém os dados do formulário

        // Conecta ao banco de dados
        $conn = new mysqli($host, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        $nivel = $_POST["nivel_csgo"];
        $patente = $_POST["patente_csgo"];
        $regiao = $_POST["regiao_csgo"];

        // Verifica se o nível do jogo "CS:GO" está dentro dos limites permitidos (COSTUMIZAR POPUP DE ERRO)
        if ($nivel < 1 || $nivel > 40) {
            echo "Erro: O seu nível em jogo do 'CS:GO' deve estar entre 1 e 40.";
            exit();
        }

        // Prepara a consulta SQL para inserir os dados no banco
        $sql = "INSERT INTO usuario (nome, email, senha, nivel, patente, regiao) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nome, $email, $senha, $nivel, $patente, $regiao);

        if ($stmt->execute()) {

            // Recupera o ID do usuário recém-criado
            $idUsuario = $conn->insert_id;
            // Armazena o ID do usuário na sessão
            $_SESSION["id_usuario"] = $idUsuario;

            // não é necessário: session_start();
            $_SESSION["nome"] = $nome;
            $_SESSION["email"] = $email;
            $_SESSION["nivel_csgo"] = $nivel;
            $_SESSION["patente_csgo"] = $patente;
            $_SESSION["regiao_csgo"] = $regiao;

            $_SESSION["origem"] = "cadastrocsgo";
            // Cadastro realizado com sucesso
            header("Location: ../login/index.php");
            exit();
        } else {
            // Erro ao realizar o cadastro
            echo "Erro ao cadastrar usuário: " . $stmt->error;
        }
    }

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
    <link rel="stylesheet" href="style2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Cadastro</title>
</head>

<body>

    <!--Caixa para seleção de jogo-->
    <div id="jogo-box">
        <p>Jogo</p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <select id="jogo" name="jogo[]">
                <option value="" disabled selected>Selecione um jogo</option>
                <option value="lol">League of Legends</option>
                <option value="csgo">Counter Strike: Global Offensive</option>
            </select>
        </form>
    </div>

    <!--Caixa de cadastro para LoL-->
    <div id="cadastro-lol" style="display: none">
        <p>Cadastro LoL</p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="number" name="nivel_lol" min="1" max="1000" oninput="mascaraNivel(this)"
                placeholder="Digite o nível da conta (1-1000)">
            <select name="elo_lol">
                <option value="">Selecione o elo da conta</option>
                <option value="Ferro IV">Ferro IV</option>
                <option value="Ferro III">Ferro III</option>
                <option value="Ferro II">Ferro II</option>
                <option value="Ferro I">Ferro I</option>
                <option value="Bronze IV">Bronze IV</option>
                <option value="Bronze III">Bronze III</option>
                <option value="Bronze II">Bronze II</option>
                <option value="Bronze I">Bronze I</option>
                <option value="Prata IV">Prata IV</option>
                <option value="Prata III">Prata III</option>
                <option value="Prata II">Prata II</option>
                <option value="Prata I">Prata I</option>
                <option value="Ouro IV">Ouro IV</option>
                <option value="Ouro III">Ouro III</option>
                <option value="Ouro II">Ouro II</option>
                <option value="Ouro I">Ouro I</option>
                <option value="Platina IV">Platina IV</option>
                <option value="Platina III">Platina III</option>
                <option value="Platina II">Platina II</option>
                <option value="Platina I">Platina I</option>
                <option value="Diamante IV">Diamante IV</option>
                <option value="Diamante III">Diamante III</option>
                <option value="Diamante II">Diamante II</option>
                <option value="Diamante I">Diamante I</option>
                <option value="Mestre">Mestre</option>
                <option value="Grão-Mestre">Grão-Mestre</option>
                <option value="Desafiante">Desafiante</option>
            </select>
            <select name="regiao_lol">
                <option value="">Selecione a região da conta</option>
                <option value="Brasil">Brasil</option>
                <option value="América Latina do Sul">América Latina do Sul (LAS)</option>
            </select>
            <button type="submit" name="submitlol">Finalizar Cadastro</button>
        </form>
    </div>

    <!--Caixa de cadastro para CS:GO-->
    <div id="cadastro-csgo" style="display: none">
        <p>Cadastro CS:GO</p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="number" name="nivel_csgo" min="1" max="40" oninput="mascaraNivel(this)"
                placeholder="Digite o nível da conta (1-40)">
            <select name="patente_csgo">
                <option value="">Selecione a patente da conta</option>
                <option value="Prata I">Prata I</option>
                <option value="Prata II">Prata II</option>
                <option value="Prata III">Prata III</option>
                <option value="Prata IV">Prata IV</option>
                <option value="Prata de Elite">Prata de Elite</option>
                <option value="Prata de Elite Mestre">Prata de Elite Mestre</option>
                <option value="Ouro I">Ouro I</option>
                <option value="Ouro II">Ouro II</option>
                <option value="Ouro III">Ouro III</option>
                <option value="Ouro IV">Ouro IV</option>
                <option value="Mestre Guardião I">Mestre Guardião I (AK I)</option>
                <option value="Mestre Guardião II">Mestre Guardião II (AK II)</option>
                <option value="Mestre Guardião Elite">Mestre Guardião Elite (AK Cruzada)</option>
                <option value="Distinto Mestre Guardião">Distinto Mestre Guardião (Xerife)</option>
                <option value="Águia Lendaria I">Águia Lendaria I (Águia I)</option>
                <option value="Águia Lendaria II">Águia Lendaria II (Águia II)</option>
                <option value="Mestre Supremo de Primeira Classe">Mestre Supremo de Primeira Classe (Supremo)</option>
                <option value="Global Elite">Global Elite (Global)</option>
            </select>
            <select name="regiao_csgo">
                <option value="">Selecione a região da conta</option>
                <option value="Brasil">Brasil</option>
                <option value="Argentina">Argentina</option>
                <option value="Chile">Chile</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Paraguai">Paraguai</option>
            </select>
            <button type="submit" name="submitcsgo">Finalizar Cadastro</button>
        </form>
    </div>

    <!--Créditos-->
    <footer>
        <div id="vortex">
            <p id="vortex-title">VORTEX</p>
            <p id="direitos">Vortex® | Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="script.js"></script>

</body>

</html>