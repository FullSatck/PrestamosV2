<?php
session_start();

// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Obtiene los datos del formulario
$email = mysqli_real_escape_string($conexion, $_POST["email"]);
$contrasena = mysqli_real_escape_string($conexion, $_POST["contrasena"]);

// Realiza la consulta a la base de datos
$query = "SELECT * FROM usuarios WHERE Email = ? AND Password = ? AND Estado = 'activo'";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ss", $email, $contrasena);
$stmt->execute();
$result = $stmt->get_result();

// Comprueba si la consulta devuelve algún registro
if ($row = $result->fetch_assoc()) {
    // Guarda los datos del usuario en la sesión
    $_SESSION["usuario_id"] = $row["ID"];
    $_SESSION["nombre"] = $row["Nombre"];
    $_SESSION["rol"] = $row["RolID"];
    $_SESSION['user_zone'] = $row['Zona'];

    // Redirige a la página correspondiente según el rol y la zona del usuario
    if ($_SESSION["rol"] == 1) { // admin
        header("Location: /resources/views/admin/inicio/inicio.php");




// SUPERVISOR 

    } else if ($_SESSION["rol"] == 2) { // supervisor
        // Valida la zona del usuario
        if (preg_match("/1/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Aguascalientes
            header("Location: /resources/views/zonas/1-aguascalientes/cobrador/inicio/inicio.php");
        } else if (preg_match("/Zona2/", $_SESSION['user_zone'])) {

            // El usuario es un cobrador de Zona2
            header("Location: /supervisor_zona2_dashboard.php");
        } else if (preg_match("/Zona2/", $_SESSION['user_zone'])) {

            // El usuario es un cobrador de Zona2
            header("Location: /supervisor_zona2_dashboard.php");
        } else if (preg_match("/Zona2/", $_SESSION['user_zone'])) {

            // El usuario es un cobrador de Zona2
            header("Location: /supervisor_zona2_dashboard.php");
        } else {
            // El usuario es un supervisor de otra zona
            header("Location: /supervisor_default_dashboard.php");
        }

// COBRADOR 
    } else if ($_SESSION["rol"] == 3) { 
        // Valida la zona del usuario
        if (preg_match("/1/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Aguascalientes
            header("Location: /resources/views/zonas/1-aguascalientes/cobrador/inicio/inicio.php");
        } else if (preg_match("/2/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona2
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/3/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona3
            header("Location: /cobrador_zona3_dashboard.php");
        } else if (preg_match("/4/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona4
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/5/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona5
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/6/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona6
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/7/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona7
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/8/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona8
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/9/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona9
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/10/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona10
            header("Location: /cobrador_zona2_dashboard.php");
        } else if (preg_match("/11/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona11
            header("Location: /cobrador_zona2_dashboard.php");

        } else if (preg_match("/12/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona13
            header("Location: /cobrador_zona2_dashboard.php");
        } else {
            // El usuario es un cobrador de otra zona
            header("Location: /cobrador_default_dashboard.php");
        }
    } else {
        // Redirige a una página por defecto si el rol no se encuentra
        header("Location: /default_dashboard.php");
    }
    exit();
} else {
    // Credenciales incorrectas o usuario inactivo
    $_SESSION['error_message'] = "Credenciales incorrectas o usuario inactivo.";
    header("Location: /login_page.php");
    exit();
}

// Cierra la declaración y la conexión a la base de datos
$stmt->close();
$conexion->close();
?>