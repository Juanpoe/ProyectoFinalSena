<?php
$servername = "localhost";
$username = "root";
$password = "";
$bdname = "maxisoft";
try {
    $connection = new PDO("mysql:host=$servername;dbname=$bdname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "No se establecio la conexion: " . $e->getMessage();
}

function VerificarCorreo($Correo, $Contrasena)
{
    global $connection;

    $consulta = "SELECT *
    FROM usuario
    INNER JOIN rol ON usuario.IdRol = rol.IdRol
    WHERE Correo = :Correo;";
    $stmt = $connection->prepare($consulta);
    $stmt->bindParam(':Correo', $Correo);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado && $Contrasena == $resultado['Contrasena']) {
        return $resultado;
    } else {
        return false;
    }
}

if (isset($_POST["Login"])) {
    $Correo = $_POST['Correo'];
    $ContrasenaEncryptada = $_POST['Contrasena'];

    if (empty($Correo) || empty($ContrasenaEncryptada)) {
        $mensaje_error = 'Por favor, complete todos los campos.';
    } else {
        $Correo = $_POST['Correo'];
        $ContrasenaEncryptada = $_POST['Contrasena'];
        $Salt = 'MaxiSoft';
        $Contrasena = hash('sha512', $Salt . $ContrasenaEncryptada);

        $datos_Correo = VerificarCorreo($Correo, $Contrasena);

        // if ($datos_Correo) {
        //     echo "Ingresaste con exito";
        // }else{
        //     echo "Ups, hubo un error al iniciar sesion";
        // }

        if ($datos_Correo) {
            session_start();
            $_SESSION['sesion_iniciada'] = true;
            $_SESSION['IdUsuario'] = $datos_Correo['IdUsuario'];
            $_SESSION['NombreRol'] = $datos_Correo['NombreRol'];
            $_SESSION['IdRol'] = $datos_Correo['IdRol'];
            $_SESSION['Rol'] = $datos_Correo['Rol'];
            $_SESSION['EstadoRol'] = $datos_Correo['EstadoRol'];
            $_SESSION['Permisos'] = explode(",", $datos_Correo['Permisos']);
            $_SESSION['Nombre'] = $datos_Correo['Nombre'];
            $_SESSION['Apellido'] = $datos_Correo['Apellido'];
            $_SESSION['Documento'] = $datos_Correo['Documento'];
            $_SESSION['Contrasena'] = $datos_Correo['Contrasena'];
            $_SESSION['Telefono'] = $datos_Correo['Telefono'];
            $_SESSION['Correo'] = $datos_Correo['Correo'];
            $_SESSION['Estado'] = $datos_Correo['Estado'];
            header("Location: ../Vista/home.php");
            exit;
        } else {
            echo '
            <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
            <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: \'<strong>Correo o contraseña incorrectos</strong>\',
                        icon: \'error\',
                        allowOutsideClick: false, // No permitir clic fuera de la alerta
                        focusConfirm: false,
                        confirmButtonText: \'Iniciar Sesión\',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../Vista/Login.php";
                }
                    });
                });
            </script>';
            exit;
        }
    }
}
?>