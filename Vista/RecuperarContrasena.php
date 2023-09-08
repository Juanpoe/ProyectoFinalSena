<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="Assets/Css/Login.css">
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
            <form action="../Controlador/RecuperarContrasena.php" method="post">
                <div class="contenedor-logo">
                    <img src="Assets/Img/MaxiwifiLogo.png" alt="">
                </div>
                <label>
                <img src="Assets/Img/Iconos/detail.svg" alt="">
                    <input type="text" name="Nombre" id="Nombre" placeholder="Nombres" required />
                </label>
                <label>
                <img src="Assets/Img/Iconos/badge.svg" alt="">
                    <input type="text" name="Apellido" id="Apellido" placeholder="Apellido" required />
                </label>
                <label>
                <img src="Assets/Img/Iconos/correo.svg" alt="">
                    <input type="email" name="Correo" id="Correo" placeholder="Correo" required />
                </label>
                <label>
                <img src="Assets/Img/Iconos/card.svg" alt="">
                    <input type="number" name="Documento" id="Documento" placeholder="Documento" required />
                </label>
                <button name="EnviarForm" type="submit" placeholder="Recuperar">Recuperar contraseña</button>
            </form>
        </div>
    </div>
</body>

</html>