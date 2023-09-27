<?php
session_start();
include("../..//conexion/conexion.php");

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

$consulta = "SELECT * FROM usuarios WHERE correo = '$correo' AND contraseña = '$contraseña'";
$resultado = mysqli_query($conexion, $consulta);
$filas = mysqli_fetch_array($resultado);

if ($filas) {
    $_SESSION['logged_in'] = true;
    $_SESSION['rol'] = $filas['Rol'];
    $_SESSION['Nombre'] = $filas['Nombre'];

    if ($filas['Rol'] == 0) {
        header("location: /lognprin/user/user.php");
    } elseif ($filas['Rol'] == 1) {
        header("location: /lognprin/admi/index.php");
    } elseif ($filas['Rol'] == 2) {
        header("location: /lognprin/instrutor/instrutor.php");
    } elseif ($filas['Rol'] == 3) {
        header("location: /lognprin/estudiante/inicio/inicio.php");
    }

    exit();
} else {
    $_SESSION['logged_in'] = false;
    header("location: login.php");
    exit();
}



?>