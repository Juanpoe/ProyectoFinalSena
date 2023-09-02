<?php
session_start();
if (isset($_SESSION['sesion_iniciada']) == true && $_SESSION['Estado'] == 1 && $_SESSION['EstadoRol'] == 1) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="Assets/Css/style.css">
        <link rel="shortcut icon" href="Assets/Img/MaxiwifiLogo.png" type="image/x-icon">
        <title>Maxisoft</title>
    </head>

    <body class="dark">

        <!-- SIDEBAR -->
        <section id="sidebar">
            <a href="Home.php" class="brand"><img src="Assets/Img/Iconos/happy.svg" alt="" class="icon"> Maxisoft</a>
            <ul class="side-menu">
                <li><a href="Home.php" class="active"><img class='icon2' src="Assets/Img/Iconos/dashboard.svg">Dashboard</a></li>
                <li class="divider" data-text="<?php echo $_SESSION['NombreRol']; ?>">- - - - - - - - - - - - - - - - - - - - - - - - -
                </li>
                <?php if ($_SESSION['Permisos'][0] == 1) {
                ?>
                    <li>
                        <a href="#" onclick='Metodo("Particiones/ListarRoles.php"); ListarRoles(1)'><img class="icon2" title="Roles" src="Assets/Img/Iconos/rol.svg">Roles</a>
                        <ul class="side-dropdown">
                        </ul>
                    </li>
                <?php
                } ?>
                <?php if ($_SESSION['Permisos'][1] == 1) {
                ?>
                    <li>
                        <a href="#" onclick='Metodo("Particiones/ListarUsuarios.php"); ListarUsuario(1);'><img class="icon2" title="Empleados" src="Assets/Img/Iconos/usuario.svg">Empleados</a>
                        <ul class="side-dropdown">
                        </ul>
                    </li>
                <?php
                } ?>
                <?php if ($_SESSION['Permisos'][2] == 1) {
                ?>
                    <li>
                        <a href="#"  onclick='Metodo("Particiones/ListarNovedades.php"); ListarNovedad(1);'><img class='icon2' title="Novedades" src="Assets/Img/Iconos/novedad.svg"> Novedades</a>
                        <ul class="side-dropdown">
                        </ul>
                    </li>
                <?php
                } ?>
                <?php if ($_SESSION['Permisos'][3] == 1) {
                ?>
                    <li>
                        <a href="#" onclick='Metodo("Particiones/MasterHerramientas.php"); ListarHerramienta(1);'><img class="icon2" title="Herramienta / Insumo" src="Assets/Img/Iconos/herramienta.svg"> Herramientas e<br> Insumos</a>
                        <ul class="side-dropdown">
                        </ul>
                    </li>
                <?php
                } ?>
                <?php if ($_SESSION['Permisos'][4] == 1) {
                ?>
                    <li>
                        <a href="#" onclick='Metodo("Particiones/ListarPrestamos.php"); ListarPrestamos(1);'><img class="icon2" src="Assets/Img/Iconos/prestamo.svg" title="Prestamos"> Prestamos</a>
                        <ul class="side-dropdown">
                        </ul>
                    </li>
                <?php
                } ?>
                <?php if ($_SESSION['Permisos'][5] == 1) {
                ?>
                    <li>
                        <a href="#" onclick='Metodo("Particiones/ListarServicios.php"); ListarServicios(1);'><img class="icon2" title="Servicios" src="Assets/Img/Iconos/servicio.svg">Servicios</a>
                        <ul class="side-dropdown">
                        </ul>
                    </li>
                <?php
                } ?>
                <?php if ($_SESSION['Permisos'][6] == 1) {
                ?>
                    <li>
                        <a href="#" onclick='Metodo("Particiones/ListarAgendamientoAdmin.php"); ListarAgendamientoAdministrador(1);'><img class='icon2' title="Agendamientos" src="Assets/Img/Iconos/agendamiento.svg">Agendamientos</a>
                        <ul class="side-dropdown">
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </section>
        <!-- SIDEBAR -->

        <!-- NAVBAR -->
        <section id="content">
            <!-- NAVBAR -->
            <nav>
                <img class='toggle-sidebar' src="Assets/Img/Iconos/menu.svg" alt="">
                <form action="#">
                    <div class="form-group">
                    </div>
                </form>
                <input type="checkbox" id="mode" hidden>
                <label for="mode"></label>
                <div class="profile">
                    <img class="img" src="Assets/Img/Iconos/user.svg" title="Cerrar Sesión" alt="">
                    <ul class="profile-link">
                        <li><a href="../Controlador/CerrarSesion.php"><img src="Assets/Img/Iconos/logout.svg" alt="" class="icon-cs">Cerrar sesion</a></li>
                    </ul>
                </div>
            </nav>
            <!-- NAVBAR -->

            <!-- MAIN -->
            <main id="qCarga">
                <h1 class="title">Dashboard</h1>
                <ul class="breadcrumbs">
                    <li><a href="#">Home</a></li>
                    <li class="divider">/</li>
                    <li><a href="#" class="active">Dashboard</a></li>
                </ul>

                <div class="ContenedorSaludo">
                    <h1 class="texto-bienvenida">Que bueno verte de nuevo,
                        <?php echo $_SESSION["Nombre"] ?>
                    </h1>
                <?php 
                    include("Paginador.php");
                ?>
                </div>
                <input type= "hidden" Id="IdUsuario" value="<?php echo $_SESSION["IdUsuario"] ?>">
               
                
                    
                    <div id="PrestamoAgendamiento">
                    </div>
                    
                    
                    <div id="novedadAgendamiento">
                </div>  
    
            
            </main>
            <!-- MAIN -->
        </section>
        <!-- NAVBAR -->
    </body>
    <!-- SCRIPTS -->
    <script src="Assets/Js/Agendamiento.js"></script>
    <script src="Assets/Js/HerramientaInsumo.js"></script>
    <script type="text/javascript" src="Assets/Js/jquery-3.3.1.min.js"></script>
    <script src="Assets/Js/Main.js"></script>
    <script src="Assets/Js/Novedad.js"></script>
    <script src="Assets/Js/Prestamo.js"></script>
    <script src="Assets/Js/Roles.js"></script>
    <script src="Assets/Js/script.js"></script>
    <script src="Assets/Js/Servicio.js"></script>
    <script src="Assets/Js/Usuario.js"></script>
    <script src="Assets/Js/SolicitarPrestamo.js"></script>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script>
    $(document).ready(function() {
        ModalNovedadAgendamiento();
        ModalPrestamoAgendamiento();

    });
</script>

    <!-- SCRIPTS -->

    </html>
<?php

} else if (isset($_SESSION['sesion_iniciada']) == true && $_SESSION['Estado'] == 0) {
    echo '
    <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: \'<strong>No estás autorizado para usar el software</strong>\',
                icon: \'error\',
                html: \'<h6>Comunícate con el administrador para dar solución</h6>\',
                allowOutsideClick: false, // No permitir clic fuera de la alerta
                focusConfirm: false,
                confirmButtonText: \'Iniciar Sesión\',
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "Login.php";
        }
            });
        });
    </script>';
} else if (isset($_SESSION['sesion_iniciada']) == true && $_SESSION['EstadoRol'] == 0) {
    echo '
    <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: \'<strong>No estas autorizado para Estar aquí</strong>\',
                icon: \'error\',
                html: \'<h6>Comunícate con el administrador para dar solución</h6>\',
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
} else {
    echo '
    <link rel="stylesheet" href="../Vista/Assets/Css/style.css">
    <script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: \'<strong>Se ha cerrado la sesión</strong>\',
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
}
?>

