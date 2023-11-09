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
        $user_zone = $_SESSION['user_zone'];

        switch ($user_zone) {
            case "01":
                header("Location: /resources/views/zonas/1-aguascalientes/supervisor/inicio/inicio.php");
                break;
            case "02":
                header("Location: /resources/views/zonas/2-baja_california/supervisor/inicio/inicio.php");
                break;
            case "03":
                header("Location: /resources/views/zonas/3-BajaCaliforniaSur/supervisor/inicio/inicio.php");
                break;
            case "04":
                header("Location: /resources/views/zonas/4-Campeche/supervisor/inicio/inicio.php");
                break;
            case "05":
                header("Location: /resources/views/zonas/5-Chiapas/supervisor/inicio/inicio.php");
                break;
            case "06":
                header("Location: /resources/views/zonas/6-Chihuahua/supervisor/inicio/inicio.php");
                break;
            case "07":
                header("Location: /resources/views/zonas/7-Coahuila/supervisor/inicio/inicio.php");
                break;
            case "08":
                header("Location: /resources/views/zonas/8-Colima/supervisor/inicio/inicio.php");
                break;
            case "09":
                header("Location: /resources/views/zonas/9-Durango/supervisor/inicio/inicio.php");
                break;
            case "10":
                header("Location: /resources/views/zonas/10-Guanajuato/supervisor/inicio/inicio.php");
                break;
            case "11":
                header("Location: /resources/views/zonas/11-Guerrero/supervisor/inicio/inicio.php");
                break;
            case "12":
                header("Location: /resources/views/zonas/12-Hidalgo/supervisor/inicio/inicio.php");
                break;
            case "13":
                header("Location: /resources/views/zonas/13-Jalisco/supervisor/inicio/inicio.php");
                break;
            case "14":
                header("Location: /resources/views/zonas/14-EstadoDeMexico/supervisor/inicio/inicio.php");
                break;
            case "15":
                header("Location: /resources/views/zonas/15-Michoacan/supervisor/inicio/inicio.php");
                break;
            case "16":
                header("Location: /resources/views/zonas/16-Morelos/supervisor/inicio/inicio.php");
                break;
            case "17":
                header("Location: /resources/views/zonas/17-Nayarit/supervisor/inicio/inicio.php");
                break;
            case "18":
                header("Location: /resources/views/zonas/18-NuevoLeon/supervisor/inicio/inicio.php");
                break;
            case "19":
                header("Location: /resources/views/zonas/19-Oaxaca/supervisor/inicio/inicio.php");
                break;
            case "20":
                header("Location: /resources/views/zonas/20-Puebla/supervisor/inicio/inicio.php");
                break;
            case "21":
                header("Location: /resources/views/zonas/21-Queretaroo/supervisor/inicio/inicio.php");
                break;
            case "22":
                header("Location: /resources/views/zonas/22-QuintanaRoo/supervisor/inicio/inicio.php");
                break;
            case "23":
                header("Location: /resources/views/zonas/23-SanLuisPotosi/supervisor/inicio/inicio.php");
                break;
            case "24":
                header("Location: /resources/views/zonas/24-Sinaloa/supervisor/inicio/inicio.php");
                break;
            case "25":
                header("Location: /resources/views/zonas/25-Sonora/supervisor/inicio/inicio.php");
                break;
            // Agrega casos para otros números de zona aquí
            default:
                // El usuario es un supervisor de otra zona, agrega el redireccionamiento apropiado aquí
                header("Location: /supervisor_default_dashboard.php");
                break;
        }
    }
    // COBRADOR 
    else if ($_SESSION["rol"] == 3) { 
        $user_zone = $_SESSION['user_zone'];

        switch ($user_zone) {
            case "01":
                header("Location: /resources/views/zonas/1-aguascalientes/cobrador/inicio/inicio.php");
                break;
            case "02":
                header("Location: /resources/views/zonas/2-baja_california/cobrador/inicio/inicio.php");
                break;
            case "03":
                header("Location: /resources/views/zonas/3-BajaCaliforniaSur/cobrador/inicio/inicio.php");
                break;
            case "04":
                header("Location: /resources/views/zonas/4-Campeche/cobrador/inicio/inicio.php");
                break;
            case "05":
                header("Location: /resources/views/zonas/5-Chiapas/cobrador/inicio/inicio.php");
                break;
            case "06":
                header("Location: /resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php");
                break;
            case "07":
                header("Location: /resources/views/zonas/7-Coahuila/cobrador/inicio/inicio.php");
                break;
            case "08":
                header("Location: /resources/views/zonas/8-Colima/cobrador/inicio/inicio.php");
                break;
            case "09":
                header("Location: /resources/views/zonas/9-Durango/cobrador/inicio/inicio.php");
                break;
            case "10":
                header("Location: /resources/views/zonas/10-Guanajuato/cobrador/inicio/inicio.php");
                break;
            case "11":
                header("Location: /resources/views/zonas/11-Guerrero/cobrador/inicio/inicio.php");
                break;
            case "12":
                header("Location: /resources/views/zonas/12-Hidalgo/cobrador/inicio/inicio.php");
                break;
            case "13":
                header("Location: /resources/views/zonas/13-Jalisco/cobrador/inicio/inicio.php");
                break;
            case "14":
                header("Location: /resources/views/zonas/14-EstadoDeMexico/cobrador/inicio/inicio.php");
                break;
            case "15":
                header("Location: /resources/views/zonas/15-Michoacan/cobrador/inicio/inicio.php");
                break;
            case "16":
                header("Location: /resources/views/zonas/16-Morelos/cobrador/inicio/inicio.php");
                break;
            case "17":
                header("Location: /resources/views/zonas/17-Nayarit/cobrador/inicio/inicio.php");
                break;
            case "18":
                header("Location: /resources/views/zonas/18-NuevoLeon/cobrador/inicio/inicio.php");
                break;
            case "19":
                header("Location: /resources/views/zonas/19-Oaxaca/cobrador/inicio/inicio.php");
                break;
            case "20":
                header("Location: /resources/views/zonas/20-Puebla/cobrador/inicio/inicio.php");
                break;
            case "21":
                header("Location: /resources/views/zonas/21-Queretaroo/cobrador/inicio/inicio.php");
                break;
            case "22":
                header("Location: /resources/views/zonas/22-QuintanaRoo/cobrador/inicio/inicio.php");
                break;
            case "23":
                header("Location: /resources/views/zonas/23-SanLuisPotosi/cobrador/inicio/inicio.php");
                break;
            case "24":
                header("Location: /resources/views/zonas/24-Sinaloa/cobrador/inicio/inicio.php");
                break;
            case "25":
                header("Location: /resources/views/zonas/25-Sonora/cobrador/inicio/inicio.php");
                break;
            // Agrega casos para otros números de zona aquí
            default:
                // El usuario es un cobrador de otra zona, agrega el redireccionamiento apropiado aquí
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
    header("Location: /index.php");
    exit();
}

// Cierra la declaración y la conexión a la base de datos
$stmt->close();
$conexion->close();
?>
