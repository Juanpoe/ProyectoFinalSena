<?php
session_start();
session_destroy();
?><!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Assets/Css/Login.css">
</head>

<body>
    <div class="container-form">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido</h2>
                <p>Para ingresar al aplicativo, por favor inicia sesión con tus datos</p>
            </div>
        </div>
        <div class="form-information">
            <form action="../Controlador/Login.php" method="post">
                <div class="contenedor-logo">
                    <img src="Assets/Img/MaxiwifiLogo.png" alt="">
                </div>
                <label>
                    <img src="Assets/Img/Iconos/correo.svg" alt="">
                    <input id="Correo" name="Correo" type="email" placeholder="CORREO ELECTRONICO" required />
                </label>
                <label>
                <img src="Assets/Img/Iconos/contrasena.svg" alt="">
                <input id="Contrasena" name="Contrasena" type="password" placeholder="CONTRASEÑA" required />
                </label>
                <button type="submit" name="Login" id="Login" class="BotonEntrar">Iniciar sesión</button>
                <br><br><br>
                <p>¿Olvidaste tu contraseña? <br> Ingresa <a class="a-formulario" href="RecuperarContrasena.php">aquí</a> para recuperarla</p>
                <br><br>
                <?php if (isset($mensaje_error)) { ?>
                    <p style="color: red;">
                        <?php echo $mensaje_error; ?>
                    </p>
                <?php } ?>
            </form>

        </div>
    </div>

</body>

</html>