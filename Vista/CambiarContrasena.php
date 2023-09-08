<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Maxisoft</title>
    <link rel="stylesheet" href="Assets/css/Login.css">
    <link rel="shortcut icon" href="Assets/Img/MaxiwifiLogo.png" />
</head>

<body>
    <div class="container-form">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido</h2>
                <p>Para recuperar su contraseña por favor ingresa los siguientes datos</p>
                <a class="btn-regresar-login" href="index.php">Regresar</a>
            </div>
        </div>
        <div class="form-information">
            <form class="formRecuperar" action="../Controlador/RecuperarContrasena.php" method="POST">
                <label>
                <img src="Assets/Img/Iconos/contrasena.svg" alt="">
                    <input type="password" name="Contrasena" id="Contrasena" placeholder="Nueva Contraseña" required />
                </label>
                <label>
                <img src="Assets/Img/Iconos/contrasena.svg" alt="">
                    <input type="password" name="Contrasena2" id="Contrasena2" placeholder="Confirmar Contraseña" required />
                </label>
                <button class="BotonEntrar" name="CambiarContrasena" type="submit">Cambiar contraseña</button>
            </form>
            <br>
        </div>
    </div>
    <script src="Assets/js/RecuperarContrasena.js"></script>
    <script type="text/javascript" src="Assets/js/jquery-3.3.1.min.js"></script>
</body>

</html>