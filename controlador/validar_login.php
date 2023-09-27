<?php
session_start();
include("conexion.php");

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Utiliza consultas preparadas para prevenir ataques de SQL injection
$consulta = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?";
$stmt = mysqli_prepare($conexion, $consulta);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $usuario, $contrasena);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $filas = mysqli_fetch_assoc($resultado);

    if ($filas) {
        $_SESSION['logged_in'] = true;
        $_SESSION['IDrol'] = $filas['IDrol']; // Leer rol de bd
        $_SESSION['Nombre'] = $filas['usuario']; // Ver nombre de usuario

        switch ($filas['IDrol']) {
            case 0:
                header("location: ../#"); // no tiene rol
                break;
            case 1:
                header("location: ../inicio/inicio.php"); //  ir a inicio admin
                break;
            case 2:
                header("location: ../####"); //  ir al inicio supervisor
                break;
            case 3:
                header("location: ../##"); //  ir al inicio cobrador
                break;
            default:
                header("location: ../pagina_error.php"); //  error de pagina
                break;
        }

        exit();
    } else {
        $_SESSION['logged_in'] = false;
        header("location: ../pagina_error.php#"); //  error de pagina
        exit();
    }
} else {
    $_SESSION['logged_in'] = false;
    header("location: ../pagina_error.php##"); //  error de pagina
    exit();
}
?>
