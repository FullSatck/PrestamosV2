<?php
session_start();
include("conexion.php");

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena'";
$resultado = mysqli_query($conexion, $consulta);
$filas = mysqli_fetch_array($resultado);

if ($filas) {
    $_SESSION['logged_in'] = true;
    $_SESSION['rol'] = $filas['Rol'];
    $_SESSION['Nombre'] = $filas['Nombre'];

    if ($filas['Rol'] == 0) {
        header("location: /index.html");
    } elseif ($filas['Rol'] == 1) {
        header("location: /index.html");
    } elseif ($filas['Rol'] == 2) {
        header("location: /index.html");
    } elseif ($filas['Rol'] == 3) {
        header("location: /index.html");
    }

    exit();
} else {
    $_SESSION['logged_in'] = false;
    header("location: ##");
    exit();
}



?>