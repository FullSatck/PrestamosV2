<?php
session_start();

// Destruir todas las variables de sesión
session_unset();

// Establecer el tiempo de expiración de la sesión
session_set_cookie_params(300); // 5 minutos en segundos

// Guardar la hora actual en la sesión
$ultimoAcceso = time();
$_SESSION['ultimoAcceso'] = $ultimoAcceso;

// Comprueba si el usuario está inactivo
$ultimoAcceso = $_SESSION['ultimoAcceso'];
$ahora = time();
$tiempo_transcurrido = $ahora - $ultimoAcceso;

if ($tiempo_transcurrido >= $tiempo_expiracion) {
    // Cierra la sesión
    session_unset();
    session_destroy();

    // Redirigir a la página de inicio de sesión
    header("Location: ../index.php");
    exit();
}

// Redirigir a la página anterior
header("Location: ../pagina-anterior.php");
exit();
?>
