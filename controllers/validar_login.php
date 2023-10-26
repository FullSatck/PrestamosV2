<?php
session_start();

// Incluir el archivo de conexión a la base de datos
require_once 'conexion.php';

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['user_id'])) {
    // El usuario ya ha iniciado sesión, redirigir a la página correspondiente
    if ($_SESSION['user_role'] == 1) {
        header("Location: ../resources/views/admin/inicio/inicio.php");
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
    $password = $_POST['Password'];

    // Consulta SQL para buscar al usuario en la base de datos
    $sql = "SELECT ID, Nombre, Password, RolID FROM usuarios WHERE Email = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // Vincula las columnas de resultado
            $stmt->bind_result($userID, $userName, $hashedPassword, $userRole);
            $stmt->fetch();

            // Verifica la contraseña hash
            if (password_verify($password, $hashedPassword)) {
                // Contraseña válida, establece la sesión del usuario
                $_SESSION['user_id'] = $userID;
                $_SESSION['user_name'] = $userName;
                $_SESSION['user_role'] = $userRole;

                // Redirige según el rol del usuario
                if ($userRole == 1) {
                    // Rol 1: Redirige a la página de administrador
                    header("Location: ../resources/views/admin/inicio/inicio.php");
                } elseif ($userRole == 2) {
                    // Rol 2: Redirige a la página de usuario normal
                    header("Location: user_page.php");
                } else {
                    // Otros roles o manejo personalizado
                    header("Location: otro_page.php");
                }
                exit();
            } else {
                $loginError = "Contraseña incorrecta.";
            }
        } else {
            $loginError = "Usuario no encontrado.";
        }

        $stmt->close();
    } else {
        // Error en la consulta preparada
        $loginError = "Error en el inicio de sesión. Por favor, inténtelo de nuevo.";
    }
}
?>
