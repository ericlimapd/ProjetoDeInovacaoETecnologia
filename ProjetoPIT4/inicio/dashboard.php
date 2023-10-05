<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <?php
    // Verifica se o login foi bem-sucedido
    if (isset($_GET["login_success"]) && $_GET["login_success"] == 1) {
        echo "<p>Login foi um sucesso!</p>";
    }
    ?>
    <h1>Bem-vindo à página de dashboard</h1>

    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    </script>
</body>

</html>