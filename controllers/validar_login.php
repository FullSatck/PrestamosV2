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
    } else if ($_SESSION["rol"] == 2) { // supervisor
        switch ($_SESSION['user_zone']) {
            case 'Zona1':
                header("Location: /supervisor_zona1_dashboard.php");
                break;
            case 'Zona2':
                header("Location: /supervisor_zona2_dashboard.php");
                break;
            // ... y así sucesivamente para las demás zonas
            default:
                header("Location: /supervisor_default_dashboard.php");
                break;
        }
    } else if ($_SESSION["rol"] == 3) { // cobrador
        switch ($_SESSION['user_zone']) {
            case 'Zona1':
                header("Location: /cobrador_zona1_dashboard.php");
                break;
            case 'Zona2':
                header("Location: /cobrador_zona2_dashboard.php");
                break;
            // ... y así sucesivamente para las demás zonas
            default:
                header("Location: /cobrador_default_dashboard.php");
                break;
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
