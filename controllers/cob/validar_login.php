<?php
// Asegúrate de que la sesión esté iniciada
session_start();

// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Obtiene los datos del formulario
$email = $_POST["email"];
$contrasena = $_POST["contrasena"];

// Realiza la consulta a la base de datos
$query = "SELECT * FROM usuarios WHERE Email = '$email' AND Password = '$contrasena'";
$result = mysqli_query($conexion, $query);

// Comprueba si la consulta devuelve algún registro
if (mysqli_num_rows($result) > 0) {
    // La consulta devuelve un registro
    $row = mysqli_fetch_assoc($result);

    // Comprueba si el usuario existe
    if ($row) {
        // Guarda los datos del usuario en la sesión
        $_SESSION["usuario_id"] = $row["ID"];
        $_SESSION["nombre"] = $row["Nombre"];
        $_SESSION["rol"] = $row["RolID"];

        // Redirige a la página correspondiente según el rol del usuario
        switch ($_SESSION["rol"]) {
            case 1: // Rol de administrador
                header("Location: /resources/views/admin/inicio/inicio.php");
                break;
            case 2: // Rol de supervisor
                header("Location: /resources/views/supervisor/inicio/inicio.php");
                break;
            case 3: // Rol de cobrador
                header("Location: /resources/cobrador/admin/inicio/inicio.php");
                break;
            default:
                // Redirige a una página por defecto si el rol no se encuentra
                header("Location: default_dashboard.php");
                break;
        }
    } else {
        // Mensaje de error si el usuario no existe
        $error_message = "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
    }
} else {
    // La consulta no devuelve ningún registro
    $error_message = "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);

// Muestra el mensaje de error
if (isset($error_message)) {
    echo $error_message;
}
?>
