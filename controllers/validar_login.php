<?php
session_start();

// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['user_id'])) {
    // El usuario ya ha iniciado sesión, redirigir a la página correspondiente
    if ($_SESSION['user_role'] == 1) {
        header("Location: admin_page.php");
    } elseif ($_SESSION['user_role'] == 2) {
        header("Location: user_page.php");
    } else {
        header("Location: otro_page.php");
    }
    exit();
}

// Recuperar los datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['contrasena'];

    // Conexión a la base de datos
    include("conexion.php");

    // Consulta para verificar el correo electrónico, obtener la contraseña hash y el ID del rol
    $consultaUsuario = "SELECT ID, Password, RolID FROM usuarios WHERE Email = ?";
    $stmtUsuario = $conexion->prepare($consultaUsuario);

    if ($stmtUsuario) {
        $stmtUsuario->bind_param("s", $email);
        $stmtUsuario->execute();
        $stmtUsuario->store_result();

        if ($stmtUsuario->num_rows == 1) {
            $stmtUsuario->bind_result($userID, $hashedPassword, $userRoleID);
            $stmtUsuario->fetch();

            // Verificar la contraseña ingresada con la contraseña almacenada en la base de datos
            if (password_verify($password, $hashedPassword)) {
                // Inicio de sesión exitoso

                session_start();
                $_SESSION['user_id'] = $userID;
                $_SESSION['user_role_id'] = $userRoleID; // Almacena el ID del rol en la sesión

                // Redirige según el rol del usuario
                if ($userRole == 1) {
                    // Rol 1: Redirige a la página de administrador
                    header("Location: admin_page.php");
                } elseif ($userRole == 2) {
                    // Rol 2: Redirige a la página de usuario normal
                    header("Location: user_page.php");
                } else {
                    echo "Rol desconocido.";
                }
                exit();
            } else {
                echo "La contraseña es incorrecta.";
            }
        } else {
            echo "El correo electrónico no está registrado.";
        }

        $stmtUsuario->close();
    } else {
        echo "Error de consulta preparada: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "Acceso no autorizado.";
}
?>
