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
           // El usuario es un supervisor de Aguascalientes
           header("Location: /resources/views/zonas/1-aguascalientes/supervisor/inicio/inicio.php");
        } else if (preg_match("/2/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona2
            header("Location: /resources/views/zonas/2-baja_california/supervisor/inicio/inicio.php");
        } else if (preg_match("/03/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona3
            header("Location: /resources/views/zonas/3-BajaCaliforniaSur/supervisor/inicio/inicio.php");
        } else if (preg_match("/04/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona4
            header("Location: /resources/views/zonas/4-Campeche/supervisor/inicio/inicio.php");
        } else if (preg_match("/5/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona5
            header("Location: /resources/views/zonas/5-Chiapas/supervisor/inicio/inicio.php");
        } else if (preg_match("/6/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona6
            header("Location: /resources/views/zonas/6-Chihuahua/supervisor/inicio/inicio.php");
        } else if (preg_match("/7/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona7
            header("Location: /resources/views/zonas/7-Coahuila/supervisor/inicio/inicio.php");
        } else if (preg_match("/8/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona8
            header("Location: /resources/views/zonas/8-Colima/supervisor/inicio/inicio.php");
        } else if (preg_match("/9/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona9
            header("Location: /resources/views/zonas/9-Durango/supervisor/inicio/inicio.php");
        } else if (preg_match("/10/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona10
            header("Location: /resources/views/zonas/10-Guanajuato/supervisor/inicio/inicio.php");
        } else if (preg_match("/11/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona11
            header("Location: /resources/views/zonas/11-Guerrero/supervisor/inicio/inicio.php");
        } else if (preg_match("/12/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona12
            header("Location: /resources/views/zonas/12-Hidalgo/supervisor/inicio/inicio.php");
        } else if (preg_match("/13/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona13
            header("Location: /resources/views/zonas/13-Jalisco/supervisor/inicio/inicio.php");
        } else if (preg_match("/14/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona14
            header("Location: /resources/views/zonas/13-Jalisco/supervisor/inicio/inicio.php");
        } else if (preg_match("/15/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona14
            header("Location: /resources/views/zonas/14-EstadoDeMexico/supervisor/inicio/inicio.php");
        } else if (preg_match("/16/", $_SESSION['user_zone'])) {
             // El usuario es un supervisor de Zona15
             header("Location: /resources/views/zonas/15-Michoacan/supervisor/inicio/inicio.php");
            } else if (preg_match("/17/", $_SESSION['user_zone'])) {
                 // El usuario es un supervisor de Zona16
            header("Location: /resources/views/zonas/16-Morelos/supervisor/inicio/inicio.php");
        } else if (preg_match("/18/", $_SESSION['user_zone'])) {
             // El usuario es un supervisor de Zona17
             header("Location: /resources/views/zonas/17-Nayarit/supervisor/inicio/inicio.php");
            } else if (preg_match("/18/", $_SESSION['user_zone'])) {
                 // El usuario es un supervisor de Zona18
            header("Location: /resources/views/zonas/17-Nayarit/supervisor/inicio/inicio.php");
        } else if (preg_match("/19/", $_SESSION['user_zone'])) {
             // El usuario es un supervisor de Zona19
             header("Location: /resources/views/zonas/18-NuevoLeon/supervisor/inicio/inicio.php");
            } else if (preg_match("/20/", $_SESSION['user_zone'])) {
                 // El usuario es un supervisor de Zona20
            header("Location: /resources/views/zonas/19-Oaxaca/supervisor/inicio/inicio.php");
        } else if (preg_match("/21/", $_SESSION['user_zone'])) {
             // El usuario es un supervisor de Zona21
             header("Location: /resources/views/zonas/20-Puebla/supervisor/inicio/inicio.php");
            } else if (preg_match("/22/", $_SESSION['user_zone'])) {
                // El usuario es un supervisor de Zona22
             header("Location: /resources/views/zonas/21-Queretaroo/supervisor/inicio/inicio.php");
            } else if (preg_match("/23/", $_SESSION['user_zone'])) {
                // El usuario es un supervisor de Zona23
             header("Location: /resources/views/zonas/23-SanLuisPotosi/supervisor/inicio/inicio.php");
            } else if (preg_match("/24/", $_SESSION['user_zone'])) {
                // El usuario es un supervisor de Zona24
             header("Location: /resources/views/zonas/24-Sinaloa/supervisor/inicio/inicio.php");
            } else if (preg_match("/25/", $_SESSION['user_zone'])) {
            // El usuario es un supervisor de Zona25
            header("Location: /resources/views/zonas/25-Sonora/supervisor/inicio/inicio.php");

      
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
            header("Location: /resources/views/zonas/2-baja_california/cobrador/inicio/inicio.php");
        } else if (preg_match("/3/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona3
            header("Location: /resources/views/zonas/3-BajaCaliforniaSur/cobrador/inicio/inicio.php");
        } else if (preg_match("/4/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona4
            header("Location: /resources/views/zonas/4-Campeche/cobrador/inicio/inicio.php");
        } else if (preg_match("/5/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona5
            header("Location: /resources/views/zonas/5-Chiapas/cobrador/inicio/inicio.php");
        } else if (preg_match("/6/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona6
            header("Location: /resources/views/zonas/6-Chihuahua/cobrador/inicio/inicio.php");
        } else if (preg_match("/7/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona7
            header("Location: /resources/views/zonas/7-Coahuila/cobrador/inicio/inicio.php");
        } else if (preg_match("/8/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona8
            header("Location: /resources/views/zonas/8-Colima/cobrador/inicio/inicio.php");
        } else if (preg_match("/9/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona9
            header("Location: /resources/views/zonas/9-Durango/cobrador/inicio/inicio.php");
        } else if (preg_match("/10/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona10
            header("Location: /resources/views/zonas/10-Guanajuato/cobrador/inicio/inicio.php");
        } else if (preg_match("/11/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona11
            header("Location: /resources/views/zonas/11-Guerrero/cobrador/inicio/inicio.php");
        } else if (preg_match("/12/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona12
            header("Location: /resources/views/zonas/12-Hidalgo/cobrador/inicio/inicio.php");
        } else if (preg_match("/13/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona13
            header("Location: /resources/views/zonas/13-Jalisco/cobrador/inicio/inicio.php");
        } else if (preg_match("/14/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona14
            header("Location: /resources/views/zonas/13-Jalisco/cobrador/inicio/inicio.php");
        } else if (preg_match("/15/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona14
            header("Location: /resources/views/zonas/14-EstadoDeMexico/cobrador/inicio/inicio.php");
        } else if (preg_match("/16/", $_SESSION['user_zone'])) {
             // El usuario es un cobrador de Zona15
             header("Location: /resources/views/zonas/15-Michoacan/cobrador/inicio/inicio.php");
            } else if (preg_match("/17/", $_SESSION['user_zone'])) {
                 // El usuario es un cobrador de Zona16
            header("Location: /resources/views/zonas/16-Morelos/cobrador/inicio/inicio.php");
        } else if (preg_match("/18/", $_SESSION['user_zone'])) {
             // El usuario es un cobrador de Zona17
             header("Location: /resources/views/zonas/17-Nayarit/cobrador/inicio/inicio.php");
            } else if (preg_match("/18/", $_SESSION['user_zone'])) {
                 // El usuario es un cobrador de Zona18
            header("Location: /resources/views/zonas/17-Nayarit/cobrador/inicio/inicio.php");
        } else if (preg_match("/19/", $_SESSION['user_zone'])) {
             // El usuario es un cobrador de Zona19
             header("Location: /resources/views/zonas/18-NuevoLeon/cobrador/inicio/inicio.php");
            } else if (preg_match("/20/", $_SESSION['user_zone'])) {
                 // El usuario es un cobrador de Zona20
            header("Location: /resources/views/zonas/19-Oaxaca/cobrador/inicio/inicio.php");
        } else if (preg_match("/21/", $_SESSION['user_zone'])) {
             // El usuario es un cobrador de Zona21
             header("Location: /resources/views/zonas/20-Puebla/cobrador/inicio/inicio.php");
            } else if (preg_match("/22/", $_SESSION['user_zone'])) {
                // El usuario es un cobrador de Zona22
             header("Location: /resources/views/zonas/21-Queretaroo/cobrador/inicio/inicio.php");
            } else if (preg_match("/23/", $_SESSION['user_zone'])) {
                // El usuario es un cobrador de Zona23
             header("Location: /resources/views/zonas/23-SanLuisPotosi/cobrador/inicio/inicio.php");
            } else if (preg_match("/24/", $_SESSION['user_zone'])) {
                // El usuario es un cobrador de Zona24
             header("Location: /resources/views/zonas/24-Sinaloa/cobrador/inicio/inicio.php");
            } else if (preg_match("/25/", $_SESSION['user_zone'])) {
            // El usuario es un cobrador de Zona25
            header("Location: /resources/views/zonas/25-Sonora/cobrador/inicio/inicio.php");



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