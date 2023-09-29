<?php
session_start();

// Destruir la sesión
session_destroy();

// Redirigir al inicio
header("location: ../index.php");
exit();
?>
