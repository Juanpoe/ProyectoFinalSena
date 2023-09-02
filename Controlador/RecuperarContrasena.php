<?php
require_once '../Modelo/Conexion.php';

function Recuperar($IdUsuario, $ContraseñaEncryptada)
{
    $Conexion = new PDODB();

    $Conexion->Conectar();

    $Sqly = "UPDATE usuario SET Contrasena = '" . $ContraseñaEncryptada . "'
    WHERE IdUsuario = " . $IdUsuario;

    $Modificado = $Conexion->EjecutarInstruccion($Sqly);

    if ($Modificado == true) {
        echo '
        <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: \'<strong>Contraseña cambiada correctamente</strong>\',
                    icon: \'success\',
                    allowOutsideClick: false, // No permitir clic fuera de la alerta
                    focusConfirm: false,
                    confirmButtonText: \'Ok\',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "CerrarSesion.php";
            }
                });
            });
        </script>';
    } else {
        echo '
        <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: \'<strong>No fue posible cambiar la contraseña</strong>\',
                    icon: \'error\',
                    allowOutsideClick: false, // No permitir clic fuera de la alerta
                    focusConfirm: false,
                    confirmButtonText: \'Ok\',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../Vista/RecuperarContrasena.php";
            }
                });
            });
        </script>';
    }
}

if (isset($_POST["EnviarForm"])) {
    $Nombre = $_POST['Nombre'];
    $Apellido = $_POST["Apellido"];
    $Correo = $_POST['Correo'];
    $Documento = $_POST['Documento'];

    $Conexion = new PDODB();

    $Conexion->Conectar();

    $BuscarSql = "SELECT * FROM usuario WHERE Nombre = '$Nombre' AND Apellido = '$Apellido' AND Correo = '$Correo' AND Documento = $Documento";
    $Buscar = $Conexion->ObtenerDatos($BuscarSql);

    $ResultadoContar = count($Buscar);
    if ($ResultadoContar > 0) {
        session_start();
        foreach ($Buscar as $key => $Datos) {
            $_SESSION["IdUsuario"] = $Datos['IdUsuario'];
        }
        echo '
        <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: \'<strong>Verificado correctamente</strong>\',
                    icon: \'success\',
                    allowOutsideClick: false, // No permitir clic fuera de la alerta
                    focusConfirm: false,
                    confirmButtonText: \'Ok\',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../Vista/CambiarContrasena.php";
            }
                });
            });
        </script>';
      
    } else {
        echo '
        <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: \'<strong>Verifica que todos los datos estén correctos</strong>\',
                    icon: \'error\',
                    allowOutsideClick: false, // No permitir clic fuera de la alerta
                    focusConfirm: false,
                    confirmButtonText: \'Ok\',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../Vista/RecuperarContrasena.php";
            }
                });
            });
        </script>';
    }
}

if (isset($_POST["CambiarContrasena"])) {
    session_start();
    $Contrasena = $_POST['Contrasena'];
    $Contrasena2 = $_POST['Contrasena2'];
    if ($Contrasena != $Contrasena2) {
        echo '
        <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: \'<strong>Las contraseñas ingresadas no son iguales</strong>\',
                    icon: \'error\',
                    allowOutsideClick: false, // No permitir clic fuera de la alerta
                    focusConfirm: false,
                    confirmButtonText: \'Ok\',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../Vista/CambiarContrasena.php";
            }
                });
            });
        </script>';
    } else {
        $Salt = 'MaxiSoft';
        $ContraseñaEncryptada = hash('sha512', $Salt . $Contrasena);

        $Conexion = new PDODB();

        $Conexion->Conectar();

        $BuscarSql = "SELECT * FROM usuario WHERE IdUsuario = " . $_SESSION["IdUsuario"];
        $Buscar = $Conexion->ObtenerDatos($BuscarSql);

        foreach ($Buscar as $key => $Datos) {
            if ($ContraseñaEncryptada == $Datos['Contrasena']) {
                echo '
                <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
                <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            title: \'<strong>La contraseña que ingresaste es la que tienes en estos momentos</strong>\',
                            icon: \'error\',
                            allowOutsideClick: false, // No permitir clic fuera de la alerta
                            focusConfirm: false,
                            confirmButtonText: \'Ok\',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../Vista/Login.php";
                    }
                        });
                    });
                </script>';
                return;
            } else {
                Recuperar($Datos["IdUsuario"], $ContraseñaEncryptada);
            }
        }
    }
}
?>