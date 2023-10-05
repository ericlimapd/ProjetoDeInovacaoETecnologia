<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>teste</title>
</head>

<body>
    <form action="changeAvatar.php" method="post" enctype="multipart/form-data">
        <input type="file" name="foto_perfil" id="input-foto-perfil">
        <img src="" alt="Pré-visualização" id="img-preview" style="display: none;">
        <button type="button" id="btn-confirmar" style="display: none;">Confirmar</button>
        <input type="submit" value="Upload" style="display: none;">
    </form>
    <script src="scriptteste.js"></script>
</body>

</html>