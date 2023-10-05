<?php

include 'changeAvatar.php';
include 'transforms.php';

ini_set('display_errors', 0);

session_start();

$path = $_SESSION['path'];

$origem = isset($_SESSION["origem"]) ? $_SESSION["origem"] : "";

if ($origem == "cadastrolol") {

    $idUsuario = $_SESSION["id_usuario"];
    $nome = $_SESSION["nome"];
    $email = $_SESSION["email"];
    $nivel = $_SESSION["nivel_lol"];
    $elo = $_SESSION["elo_lol"];
    $regiao = $_SESSION["regiao_lol"];
} elseif ($origem == "cadastrocsgo") {

    $idUsuario = $_SESSION["id_usuario"];
    $nome = $_SESSION["nome"];
    $email = $_SESSION["email"];
    $nivel = $_SESSION["nivel_csgo"];
    $patente = $_SESSION["patente_csgo"];
    $regiao = $_SESSION["regiao_csgo"];
} else {

    $idUsuario = $_SESSION["id_usuario"];
    $nome = $_SESSION["nome"];
    $email = $_SESSION["email"];
    $nivel = $_SESSION["nivel"];
    if (isset($_SESSION["elo"])) {
        $elo = $_SESSION["elo"];
    } elseif (isset($_SESSION["patente"])) {
        $patente = $_SESSION["patente"];
    }
    $path = $_SESSION['path'];
    $regiao = $_SESSION["regiao"];
};

function imprimeNivel($nivelcsgo, $nivellol, $nivel)
{
    if ($nivelcsgo !== null) {
        echo $nivelcsgo;
    } else if ($nivellol !== null) {
        echo $nivellol;
    } else {
        echo $nivel;
    }
}

function imprimeRankSelect($patente, $elo)
{
    if ($elo !== null) {
        echo "elo-select";
    } else if ($patente !== null) {
        echo "patente-select";
    } else {
        echo "rank-select";
    }
}

function maskEmail($email)
{
    $parts = explode('@', $email);
    $username = $parts[0];
    $domain = $parts[1];

    $maskedUsername = substr($username, 0, 1) . '***' . substr($username, -1);

    return $maskedUsername . '@' . $domain;
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
    <title>Perfil</title>
</head>

<body>
    <!-- Container de popup para mudança de avatar -->
    <div class="popup-container" id="popup">
        <div class="popup">
            <div id="popup-close">
                <p></p><button onclick="closePopup()">X</button>
            </div>
            <div id="popup-preview"><img id="change-avatar-preview" src="../img/defaultuser.png"></div>
            <div id="popup-main">
                <div id="file-container">
                    <form method="POST" id="form-avatar" enctype="multipart/form-data" action="">
                        <input name="arquivo" id="change-avatar-file" type="file">
                        <button id="send-file-btn">Enviar foto</button>
                    </form>
                </div>
            </div>
            <div id="popup-confirm">
                <button form="form-avatar" name="remove" id="cancel-btn">Remover avatar</button>
                <button form="form-avatar" name="upload" type="submit" id="confirm-btn">Confirmar</button>
            </div>
        </div>
    </div>

    <!-- Tooltips -->
    <div id="tooltip">Alterar avatar</div>

    <div id="logo1">
        <p id="logo">Vortex</p>
        <a href="../Busca/index.php">Encontrar jogadores</a>
        <form action="logout.php" method="post">
            <button type="submit" id="btn-logout">Logout<img id="logout" src="../img/logout.png"></button>
        </form>
    </div>
    <div class="faixa"></div>
    <div id="center">
        <div id="info">
            <div id="center-img">
                <?php if (isset($path) && !empty($path) && $path !== null) : ?>

                    <?php echo "<img src='$path' id='avatar'>"; ?>

                <?php else : ?>

                    <?php echo "<img id='avatar' src='../img/defaultuser.png'>" ?>

                <?php endif; ?>
                <div id="change-avatar-container">
                    <button id="change-avatar-btn" onclick="openPopup()"><img src="../img/changeavatar.png" /></button>
                </div>
            </div>

            <div id="itens">
                <p class="info-item"><?php if ($nome) : ?>
                        <?php echo $nome; ?>
                    <?php else : ?>
                        <?php echo "nome"; ?>
                    <?php endif; ?>
                </p>

                <p id="nivel-label">NÍVEL</p>
                <p class="info-item nivel"><?php if ($nivel_lol) : ?>
                        <?php echo $nivel_lol; ?>
                    <?php elseif ($nivel_csgo) : ?>
                        <?php echo $nivel_csgo; ?>
                    <?php elseif ($nivel) : ?>
                        <?php echo $nivel; ?>
                    <?php else : ?>
                        <?php echo "?"; ?>
                    <?php endif; ?>
                </p>

                <p id="<?php echo transformaId($patente, $elo) ?>">

                    <?php if ($patente) : ?>
                        <?php echo "PATENTE" ?>
                    <?php elseif ($elo) : ?>
                        <?php echo "ELO" ?>
                    <?php else : ?>
                        <?php echo "RANK" ?>
                    <?php endif; ?>
                </p>
                <p class="info-item">
                    <?php if ($patente) : ?>
                        <img id="patente" src="<?php echo transformaImagemRank($patente, 'patente'); ?>" />
                    <?php elseif ($elo) : ?>
                        <img id="elo" src="<?php echo transformaImagemRank($elo, 'elo'); ?>" />
                    <?php else : ?>
                        <?php echo "?" ?>
                    <?php endif; ?>
                </p>

                <p id="region-label">REGIÃO</p>
                <p class="info-item">

                    <?php if ($regiao_lol) : ?>
                        <img id="regiao-flag" src="<?php echo transformaRegiao($regiao_lol); ?>" />
                    <?php elseif ($regiao_csgo) : ?>
                        <img id="regiao-flag" src="<?php echo transformaRegiao($regiao_csgo); ?>" />
                    <?php elseif ($regiao) : ?>
                        <img id="regiao-flag" src="<?php echo transformaRegiao($regiao); ?>" />
                    <?php else : ?>
                        <?php echo "?" ?>
                    <?php endif; ?>
                </p>

            </div>
        </div>

        <div id="ad-info-container">

            <div id="change-info-firsthalf">
                <div id="change-info-container">
                    <div id="change-info-title-container">
                        <p id="change-info-title">Configurações da Conta</p>

                        <p id="change-info-subtitle">Gerencie as informações da sua conta.</p>

                        <p id="change-info-subtitle">Detalhes pessoais</p>
                    </div>

                    <div id="change-info-form-container">
                        <form id="det-form" action="atualizar_detalhes_pessoais.php" method="POST">
                            <p class="change-info-form-labels">Nome de usuário</p>
                            <input name="change-det-nome" type="text" value="<?php echo $nome ?>">

                            <p class="change-info-form-labels">Email</p>
                            <input name="change-det-email" type="email" value="<?php echo $email; //maskEmail($email) 
                                                                                ?>">

                            <button id="btn-change-det" type="submit">Atualizar detalhes</button>
                        </form>
                    </div>
                </div>
            </div>

            <div id="change-info-secondhalf">
                <div id="change-info-form-container">
                    <p id="change-info-subtitle2">Informações da conta</p>
                    <form id="info-form" action="atualizar_info_conta.php" method="POST">

                        <p class="change-info-form-labels2"><?php if ($patente) : ?>
                                <?php echo "Patente" ?>
                            <?php elseif ($elo) : ?>
                                <?php echo "Elo" ?>
                            <?php else : ?>
                                <?php echo "Rank" ?>
                            <?php endif; ?>
                        </p>

                        <?php if ($patente) : ?>
                            <select name="patente-select">
                            <?php elseif ($elo) : ?>
                                <select name="elo-select">
                                <?php else : ?>
                                    <select name="rank-select">
                                    <?php endif; ?>

                                    <?php if ($patente) : ?>
                                        <?php echo '<option value="Prata I">Prata I</option>
                                            <option value="Prata II">Prata II</option>
                                            <option value="Prata III">Prata III</option>
                                            <option value="Prata IV">Prata IV</option>
                                            <option value="Prata de Elite">Prata de Elite</option>
                                            <option value="Prata de Elite Mestre">Prata de Elite Mestre</option>
                                            <option value="Ouro I">Ouro I</option>
                                            <option value="Ouro II">Ouro II</option>
                                            <option value="Ouro III">Ouro III</option>
                                            <option value="Ouro IV">Ouro IV</option>
                                            <option value="Mestre Guardião I">Mestre Guardião I</option>
                                            <option value="Mestre Guardião II">Mestre Guardião II</option>
                                            <option value="Mestre Guardião Elite">Mestre Guardião Elite</option>
                                            <option value="Distinto Mestre Guardião">Distinto Mestre Guardião</option>
                                            <option value="Águia Lendaria I">Águia Lendaria I</option>
                                            <option value="Águia Lendaria II">Águia Lendaria II</option>
                                            <option value="Mestre Supremo de Primeira Classe">Mestre Supremo</option>
                                            <option value="Global Elite">Global Elite</option>' ?>
                                    <?php elseif ($elo) : ?>
                                        <?php echo '<option value="Ferro IV">Ferro IV</option>
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
                                            <option value="Desafiante">Desafiante</option>' ?>
                                    <?php else : ?>
                                        <?php echo 'erro' ?>
                                    <?php endif; ?>

                                    </select>


                                    <p class="change-info-form-labels2">Nível</p>
                                    <?php if ($patente) : ?>
                                        <input id="nivel-input" type="number" name="nivel-input" min="1" max="40" oninput="mascaraNivel(this)">
                                    <?php elseif ($elo) : ?>
                                        <input id="nivel-input" type="number" name="nivel-input" min="<?php echo $nivel_lol; ?>" max="1000" oninput="mascaraNivel(this)">
                                    <?php else : ?>
                                        '<input id="nivel-input" type="number">
                                    <?php endif; ?>

                                    <button id="btn-change-info" type="submit">Atualizar informações</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>

<?php
// Limpa a origem da sessão
unset($_SESSION["origem"]);
?>