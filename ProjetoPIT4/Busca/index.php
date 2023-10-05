<?php

session_start();

include '../perfil/transforms.php';

$host = "localhost";
$dbname = "pit";
$username = "root";
$password = "";

// Conecta ao banco de dados
$mysqli = new mysqli($host, $username, $password, $dbname);

// Verifica se ocorreu algum erro na conexão
if ($mysqli->connect_error) {
    die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Pesquisa</title>
</head>

<body>
    <div id="logo1">
        <p id="logo">Vortex</p>
        <div id="all-menu">
            <div id="menu-container">
                <div class="menu-line"></div>
                <div class="menu-line"></div>
                <div class="menu-line"></div>
            </div>
            <div id="sub-menu">
                <div><a href="../perfil/index.php">Perfil</a></div>
                <div>
                    <form action="logout.php" method="post">
                        <button type="submit" id="btn-logout">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="beatriz">
        <h1 id="title">Buscar jogadores</h1>
        <form id="beatriz2" action="">
            <input id="inputbeatriz" name="busca" value="<?php if (isset($_GET['busca'])) echo $_GET['busca']; ?>" placeholder="Digite aqui" type="text">
            <button id="btndaniel" type="submit">Buscar</button>
        </form>

        <div id="busca-container">
            <?php
            if (!isset($_GET['busca'])) {
            ?>

                <div id="no-result">Nenhum resultado encontrado...</div>

                <?php } else {
                $pesquisa = $mysqli->real_escape_string($_GET['busca']);
                $sql_code = "SELECT * 
                FROM usuario 
                WHERE nome LIKE '%$pesquisa%' 
                OR nivel LIKE '%$pesquisa%'
                OR patente LIKE '%$pesquisa%'
                OR elo LIKE '%$pesquisa%'";
                $sql_query = $mysqli->query($sql_code) or die("ERRO ao consultar! " . $mysqli->error);

                if ($sql_query->num_rows == 0) {
                ?>

                    <div id="no-result">Nenhum resultado encontrado...</div>

                    <?php } else {
                    while ($dados = $sql_query->fetch_assoc()) {
                    ?>

                        <div id="result-container">

                            <div class="popup-container" id="popup">
                                <div class="popup">
                                    <div id="popup-close">
                                        <p></p><button onclick="closePopup()">X</button>
                                    </div>
                                    <?php if ($dados['foto'] !== "") : ?>
                                        <?php
                                        $foto = $dados['foto'];
                                        echo "<img src='$foto' id='avatar'>";
                                        ?>
                                    <?php else : ?>

                                        <?php echo "<img id='avatar' src='../img/defaultuser.png'>" ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                            <button onclick=openPopup()>i</button>

                            <div id="game-img-container">

                                <?php if ($dados['elo'] == "") : ?>
                                    <img id="game-img-csgo" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIT6Si1R7c32nr0o1IaMkRLhFU3-ouACrtbS0E1YmjBNFpdV8mSmWiFCUbTEobAT3pSYU&usqp=CAU" alt="">
                                <?php elseif ($dados['patente'] == "") : ?>
                                    <img id="game-img-lol" src="../img/lol.png" alt="">
                                <?php else : ?>
                                    <img id="game-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIT6Si1R7c32nr0o1IaMkRLhFU3-ouACrtbS0E1YmjBNFpdV8mSmWiFCUbTEobAT3pSYU&usqp=CAU" alt="">
                                <?php endif; ?>

                            </div>
                            <div id="result-first-line">
                                <div id="center-img">
                                    <?php if ($dados['foto'] !== "") : ?>
                                        <?php
                                        $foto = $dados['foto'];
                                        echo "<img src='$foto' id='avatar'>";
                                        ?>
                                    <?php else : ?>

                                        <?php echo "<img id='avatar' src='../img/defaultuser.png'>" ?>

                                    <?php endif; ?>
                                </div>
                                <div id="nome-container">
                                    <p><?php echo $dados['nome']; ?></p>
                                    <img id="regiao-flag" src="../img/regiao/brasil.png">
                                </div>
                            </div>
                            <div id="result-last-line">
                                <div id="rank-container">
                                    <p><?php if ($dados['elo'] == "") : ?>
                                            <?php echo "PATENTE" ?>
                                        <?php elseif ($dados['patente'] == "") : ?>
                                            <?php echo "ELO" ?>
                                        <?php else : ?>
                                            <?php echo "RANK" ?>
                                        <?php endif; ?></p>
                                    <?php if ($dados['elo'] == "") : ?>
                                        <img id="patente" src="<?php echo transformaImagemRank($dados['patente'], 'patente'); ?>" />
                                    <?php elseif ($dados['patente'] == "") : ?>
                                        <img id="elo" src="<?php echo transformaImagemRank($dados['elo'], 'elo'); ?>" />
                                    <?php else : ?>
                                        <?php echo "?" ?>
                                    <?php endif; ?>
                                </div>
                                <div id="nivel-container">
                                    <p id="nivel-lbl">NÍVEL</p>
                                    <p id="nivel"><?php echo $dados['nivel']; ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            <?php
            } ?>


        </div>
    </div>

    <script src="script.js"></script>

</body>

</html>