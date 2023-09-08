<?php
    // session_destroy();
    // header('Location: ../Vista/Login.php');
session_start(); // Iniciar la sesión

// Eliminar todas las variables de sesión
$_SESSION = array();

// Si deseas eliminar la cookie de sesión, debes hacerlo también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Finalizar la sesión
session_destroy();

// Redirigir a la página de inicio de sesión
header("Location: ../Vista/Login.php");
exit;
